<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietHoaDon;
use backend\models\ChiTietOCung;
use backend\models\DanhMuc;
use backend\models\GiaDien;
use backend\models\GiaNuoc;
use backend\models\GiaoDich;
use backend\models\NguoiOCung;
use backend\models\PhongKhach;
use backend\models\QuanLyHoaDon;
use backend\models\QuanLyOCung;
use backend\models\search\QuanLyHoaDonSearch;
use backend\models\ThietLapGia;
use common\models\myAPI;
use common\models\User;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Yii;
use backend\models\HoaDon;
use backend\models\search\HoaDonSearch;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use function Complex\add;
use function React\Promise\all;

/**
 * HoaDonController implements the CRUD actions for HoaDon model.
 */
class HoaDonController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index','create','view','update','get-hoa-don','lap-hoa-don','print','in-theo-thang','thanh-toan','lap-giao-dich','get-list-hoa-don','delete',
            'cap-nhap-dich-vu','get-o-cung','save-o-cung','get-ngan-han','chon-anh','xoa-anh','cong-no','thong-ke'
        ];
        $rules = [];
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        if(isset($this->contentAPI->uid)){
            $this->enableCsrfValidation = false;
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('HoaDon', $action_name, $this->contentAPI->uid);
                    }
                ];
            }
        }else
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
//                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return myAPI::isAccess2('HoaDon', $action_name);
                    }
                ];
            }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' =>$rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all HoaDon models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new QuanLyHoaDonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HoaDon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = HoaDon::findOne($id);
        $phongKhach = \backend\models\PhongKhach::findOne($model->phong_khach_id);
        $phong = DanhMuc::findOne($phongKhach->phong_id);
        $toaNha = DanhMuc::findOne($phong->parent_id);
        $giaoDichs = GiaoDich::find()
            ->andWhere(['or',
                ['hoa_don_id' => $id],
                ['and',
                    ['hoa_don_id' => null],
                    ['phong_khach_id' => $model->phong_khach_id]
                ]
            ])
            ->all();
        $thucHiens = [];
        foreach ($giaoDichs as $giaoDich){
            $thucHiens[] = User::findOne($giaoDich->user_id)->hoten ?? 'Không rõ người dùng';

        }
        $khach = \common\models\User::findOne($phongKhach->khach_hang_id);
        $chiTietHoaDons = ChiTietHoaDon::findAll(['hoa_don_id'=>$id]);
        $dichVus = [];
        foreach ($chiTietHoaDons as $chiTietHoaDon){
            $thietLapGia = ThietLapGia::findone($chiTietHoaDon->dich_vu_id);
            $dichVus[$thietLapGia->name] = $chiTietHoaDon->thanh_tien;
        }
        $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
        $anhDien = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$id])
            ->andFilterWhere(['dich_vu_id'=>2])->one()->anh;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "Hóa đơn khách ".$khach->hoten,
            'content'=>$this->renderAjax('view', [
                'model' => $model,
                'khach'=>$khach,
                'phong'=>$phong,
                'toaNha' => $toaNha,
                'dichVus' => $dichVus,
                'giaoDichs' => $giaoDichs,
                'thucHiens' => $thucHiens,
                'anhDien' => $domain.'/hinh-anh/'.$anhDien
            ]),
//            'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
//                Html::a('Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
        ];
    }

    /**
     * Creates a new HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $giaDienIDs = ArrayHelper::map(
            \backend\models\GiaDien::find()->all(),
            'id',
            function ($model) {
                return Yii::$app->formatter->asDate($model->ngay_bat_dau, 'php:d/m/Y');
            }
        );
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active=1')->all(),
            'id',
            'name'
        );
        $giaNuocs = ArrayHelper::map(
            \backend\models\GiaNuoc::find()->all(),
            'id',
            'name'
        );
        $dichVus = ThietLapGia::find()->all();

        return $this->render('create', [
            'toanhaids'=>$toanhaids,
            'dichVus'=>$dichVus,
            'giaDienIDs' => $giaDienIDs,
            'giaNuocs' => $giaNuocs
        ]);
    }

    /**
     * Updates an existing HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update HoaDon #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "HoaDon #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update HoaDon #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $model = HoaDon::findOne($_POST['ID']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model->updateAttributes([
            'chi_phi_dich_vu' => 0,
            'tong_tien' => $model->tien_phong,
            'chot_hoa_don' => 0,
            'active' => 0,
        ]);
        $hopDong = PhongKhach::findOne($model->phong_khach_id);
        $daThanhToan = $hopDong->da_thanh_toan;
        $dichVus = ChiTietHoaDon::findAll(['hoa_don_id' => $model->id]);
        if (count($dichVus)>0){
            foreach ($dichVus as $dichVu)
                $dichVu->delete();
        }
        $giaoDichs = GiaoDich::findAll(['hoa_don_id'=>$model->id]);
        if (count($giaoDichs)>0){
            foreach ($giaoDichs as $giaoDich) {
                $giaoDich->updateAttributes([
                    'trang_thai_giao_dich' => GiaoDich::KHONG_THANH_CONG,
                    'active' => 0
                ]);
            }
        }
        $hopDong->updateAttributes([
            'da_thanh_toan' => $daThanhToan - $model->da_thanh_toan
        ]);
        return [
            'success' => true,
            'content' => 'Hủy hóa đơn thành công!'
        ];
    }

     /**
     * Delete multiple existing HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the HoaDon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HoaDon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HoaDon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //get-ngan-han
    public function actionGetNganHan()
    {
        $loai = $_POST['loai'];
        $thang = $_POST['thang'];
        $nam = $_POST['nam'];
        $toa_nha_id = $_POST['toa_nha_id'];

        $hoaDons = QuanLyHoaDon::findAll([
            'thang' => $thang,
            'nam' => $nam,
            'active' => 1,
            'parent_id'=> $toa_nha_id,
            'loai_hop_dong' => $loai
        ]);
        $result = [];
        $doanhThu = 0;
        foreach ($hoaDons as $hoaDon){
            $hang = [];
            $hang['id'] = $hoaDon->id;
            $hang['phong'] = $hoaDon->ten_phong;
            $hang['khach'] = $hoaDon->hoten.'<br/><i class="fa fa-phone"></i> '.$hoaDon->dien_thoai;

            $hopDong = PhongKhach::findOne($hoaDon->phong_khach_id);
            $dateFrom = \DateTime::createFromFormat('Y-m-d H:i:s',$hopDong->thoi_gian_hop_dong_tu);
            $dateTo = \DateTime::createFromFormat('Y-m-d H:i:s',$hopDong->thoi_gian_hop_dong_den);
            $hang['thoi_gian_tu'] = $dateFrom->format('d/m/Y H:i:s');
            $hang['thoi_gian_den'] = $dateTo->format('d/m/Y H:i:s');
            $hang['don_gia'] = number_format($hopDong->don_gia, 0, ',', '.');
            $hang['da_thanh_toan'] = number_format($hoaDon->da_thanh_toan, 0, ',', '.');
            $hang['chiet_khau'] = number_format($hopDong->so_tien_chiet_khau, 0, ',', '.');
            $hang['tong_tien'] = number_format($hoaDon->tong_tien, 0, ',', '.');
            $trangThai = 'Chưa tạo QR';
            $giaoDichs = GiaoDich::findAll(['hoa_don_id'=>$hoaDon->id]);
            if (count($giaoDichs)>0){
                $trangThai = 'QR đã thanh toán';
                foreach ($giaoDichs as $giaoDich){
                    if($giaoDich->tong_tien > $giaoDich->so_tien_giao_dich){
                        $trangThai = 'QR chưa thanh toán';
                    }
                }
            }
            $hang['trang_thai'] = $trangThai;
            $doanhThu += $hoaDon->tong_tien;
            $result[] = $hang;
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $this->renderPartial('_form', [
                'results' => $result,
            ]),
            'doanhThu' => $doanhThu,
        ];
    }
    //get-hoa-don
    public function actionGetHoaDon()
    {
        $thang = intval($_POST['thang']);
        $nam = intval($_POST['nam']);
        $kieuTienNuoc = $_POST['kieuTienNuoc'];
        $typeHienThi = 'hien_thi';

        if (intval($thang) == (int)date('m')-1 && intval($nam) == (int)date('Y') ||
            (intval($thang) == 12 && intval($nam) == (int)date('Y') - 1 && (int)date('m') == 1) ||
            intval($thang) == (int)date('m') && intval($nam) == (int)date('Y') ||
            intval($thang) == (int)date('m') + 1 && intval($nam) == (int)date('Y') ||
            intval($thang) == 1 && intval($nam) == (int)date('Y') + 1){
            $typeHienThi = 'so_nuoc';
            if ($kieuTienNuoc == 'so_nguoi'){
                $typeHienThi = 'so_nguoi';
            }
        }

        $toa_nha_id = $_POST['toa_nha_id'];
        $hoaDons = QuanLyHoaDon::find()
            ->andFilterWhere(['!=', 'trang_thai', HoaDon::HOAN_THANH])
            ->andFilterWhere(['thang' => $thang])
            ->andFilterWhere(['nam' => $nam])
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['parent_id'=> $toa_nha_id])
            ->andFilterWhere(['loai_hop_dong' => 'thang'])->all();
//        $hoaDons = QuanLyHoaDon::findAll([
//            'thang' => $thang,
//            'nam' => $nam,
//            'active' => 1,
//            'parent_id'=> $toa_nha_id,
//            'loai_hop_dong' => 'thang'
//        ]);
        $result = [];
        $doanhThu = 0;
        foreach ($hoaDons as $hoaDon){
            $hang = [];
            $tongTien = $hoaDon->tien_phong;
            $phong = DanhMuc::findOne($hoaDon->phong_id);

            $hang['id'] = $hoaDon->id;
            $hang['khach'] = $hoaDon->hoten.'<br/><i class="fa fa-phone"></i> '.$hoaDon->dien_thoai;
            $hang['tien_phong'] = number_format($hoaDon->tien_phong, 0, ',', '.');
            $hang['so_nguoi'] = $hoaDon->so_nguoi;
            $hang['phong'] = $phong->name;

            $hang['anhDien'] = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>2])->one()->anh;

            $chiTiets = ChiTietHoaDon::findAll(['hoa_don_id'=>$hoaDon->id]);
            foreach ($chiTiets as $chiTiet){
                $name = ThietLapGia::findOne($chiTiet->dich_vu_id)->name;
                $hang[$name] = number_format($chiTiet->thanh_tien, 0, ',', '.');
                if ($chiTiet->dich_vu_id == 2){
                    if($thang == (int)date('m') + 1 && $nam == (int)date('Y') ||
                        $thang == 1 && $nam == ((int)date('Y') + 1)){
                        if($chiTiet->so_luong == 0 || $chiTiet->so_luong == null){
                            $chiTiet->updateAttributes([
                                'chi_so_cu' => $phong->so_dien,
                            ]);
                        }
                    }
                    $hang['dien_dau'] = number_format($chiTiet->chi_so_cu, 0, ',', '.');
                    $hang['dien_cuoi'] = number_format($chiTiet->so_luong, 0, ',', '.');
                }elseif ($name == 'Nước'){
                    if($thang == date('m') + 1 && $nam == date('Y') ||
                        $thang == 1 && $nam == (date('Y') + 1)){
                        $chiTiet->updateAttributes([
                            'chi_so_cu' => $phong->so_nuoc,
                        ]);
                    }
                    $hang['nuoc_dau'] = number_format($chiTiet->chi_so_cu, 0, ',', '.');
                    $hang['nuoc_cuoi'] = number_format($chiTiet->so_luong, 0, ',', '.');
                }
                $tongTien += $chiTiet->thanh_tien;
            }
            $hang['tong_tien'] = number_format($tongTien, 0, ',', '.');
            $hang['da_thanh_toan'] = number_format($hoaDon->da_thanh_toan, 0, ',', '.');
            $hang['tien_nuoc'] = number_format($hoaDon->so_nguoi * $phong->gia_nuoc_nguoi, 0, ',', '.');
            $trangThai = 'Chưa tạo giao dịch';
            $giaoDichs = GiaoDich::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])->all();
            if (count($giaoDichs)>0){
                $trangThai = 'GD đã thanh toán';
                foreach ($giaoDichs as $giaoDich){
                    if($giaoDich->tong_tien > $giaoDich->so_tien_giao_dich){
                        $trangThai = 'GD chưa thanh toán';
                    }
                }
            }
            $hang['trang_thai'] = $trangThai;
            $doanhThu += $tongTien;
            $result[] = $hang;
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $this->renderPartial('danh-sach', [
                'dichVus' => ThietLapGia::find()->all(),
                'results' => $result,
                'typeHienThi' => $typeHienThi
            ]),
            'doanhThu' => $doanhThu,
        ];
    }

    public function getTienDien($soDau, $soCuoi, $bangGiaID)
    {
        $toiDa = CauHinh::findOne(['ghi_chu'=>'so_dien_toi_da'])->content;
        $soTieuThu = 0;
        $tienDien = 0;
        if ($soCuoi < $soDau){
            $soTieuThu = ($toiDa - $soDau) + $soCuoi;
        }else{
            $soTieuThu = $soCuoi - $soDau;
        }
        $bangGia = GiaDien::findOne($bangGiaID);

        if ($soTieuThu <= 50) {
            $tienDien = $soTieuThu * $bangGia->bac_1;
        } elseif ($soTieuThu <= 100) {
            $tienDien = (50 * $bangGia->bac_1) + (($soTieuThu - 50) * $bangGia->bac_2);
        } elseif ($soTieuThu <= 200) {
            $tienDien = (50 * $bangGia->bac_1) + (50 * $bangGia->bac_2) + (($soTieuThu - 100) * $bangGia->bac_3);
        } elseif ($soTieuThu <= 300) {
            $tienDien = (50 * $bangGia->bac_1) + (50 * $bangGia->bac_2) + (100 * $bangGia->bac_3) + (($soTieuThu - 200) * $bangGia->bac_4);
        } elseif ($soTieuThu <= 400) {
            $tienDien = (50 * $bangGia->bac_1) + (50 * $bangGia->bac_2) + (100 * $bangGia->bac_3) + (100 * $bangGia->bac_4) + (($soTieuThu - 300) * $bangGia->bac_5);
        } else {
            $tienDien = (50 * $bangGia->bac_1) + (50 * $bangGia->bac_2) + (100 * $bangGia->bac_3) + (100 * $bangGia->bac_4) + (100 * $bangGia->bac_5) + (($soTieuThu - 400) * $bangGia->bac_6);
        }
        return (int)((float)$tienDien * 1.08);
    }

    public function getTienNuoc($soDau, $soCuoi, $bangGiaID)
    {
        $toiDa = CauHinh::findOne(['ghi_chu' => 'so_nuoc_toi_da'])->content;
        $soTieuThu = 0;
        $soNguoi = 1;
        $tienNuoc = 0;
        if ($soCuoi < $soDau){
            $soTieuThu = ($toiDa - $soDau) + $soCuoi;
        }else{
            $soTieuThu = $soCuoi - $soDau;
        }
        $bangGia = GiaNuoc::findOne($bangGiaID);
        $mucSuDungs =  explode('-',$bangGia->luong_nuoc);
        $donGias = explode('-',$bangGia->don_gia);
        foreach ($mucSuDungs as $index => $mucSuDung){
            if ($index < count($mucSuDungs)-1){
                $soNuoc = (intval($mucSuDungs[$index+1])-intval($mucSuDung)) * $soNguoi;
                $tienNuoc += $donGias[$index] * min($soNuoc, $soTieuThu);
                if($soNuoc < $soTieuThu)
                    $soTieuThu -= $soNuoc;
                else
                    $soTieuThu = 0;
            }else
                $tienNuoc += $donGias[$index] * $soTieuThu;
        }
        return (int)((float)$tienNuoc * (100 + $bangGia->thue)/100);
    }

    public function actionCapNhapDichVu()
    {
        $hoaDon = HoaDon::findOne($_POST['hoaDonID']);
        $hopDong = PhongKhach::findOne($hoaDon->phong_khach_id);
        $phong = DanhMuc::findOne($hopDong->phong_id);

        $dienDau = intval(str_replace('.','',$_POST['dienDau']));
        $dienCuoi = intval(str_replace('.','',$_POST['dienCuoi']));
        $nuocDau = intval(str_replace('.','',$_POST['nuocDau']));
        $nuocCuoi = intval(str_replace('.','',$_POST['nuocCuoi']));
        $phuPhi = intval(str_replace('.','',$_POST['phuPhi']));

        $thang = intval($_POST['thang']);
        $nam = intval($_POST['nam']);

        $chiTietDien = ChiTietHoaDon::findOne(['hoa_don_id'=>$hoaDon->id,'dich_vu_id'=>2]);

        $giaDien = $phong->gia_dien;
        $giaNuoc = $phong->gia_nuoc;
        $tienNuoc = 0;
        $chenhLech = 0;
        $tienDien = 0;

        if($dienCuoi >= $dienDau){
            $tienDien =  ($dienCuoi -  $dienDau) * $giaDien;
            $chenhLech = $tienDien - $chiTietDien->thanh_tien;
            $chiTietDien->updateAttributes([
                'chi_so_cu' => $dienDau,
                'so_luong' => $dienCuoi,
                'thanh_tien' => $tienDien
            ]);
            if($thang == date('m') && $nam == date('Y')){
                $phong->updateAttributes([
                    'so_dien' => $dienCuoi,
                ]);
            }
        }

        if($hoaDon->tien_phong != 0){
            $chiTietNuoc = ChiTietHoaDon::findOne(['hoa_don_id'=>$hoaDon->id,'dich_vu_id'=>3]);
            if ($nuocDau == -1){
                $tienNuoc = $hoaDon->so_nguoi * $phong->gia_nuoc_nguoi;
            }else{
                $tienNuoc = ($nuocCuoi - $nuocDau) * $giaNuoc;
                $chiTietNuoc->updateAttributes([
                    'chi_so_cu' => $nuocDau,
                    'so_luong' => $nuocCuoi
                ]);
                if($thang == date('m') && $nam == date('Y')){
                    $phong->updateAttributes([
                        'so_nuoc' => $nuocCuoi,
                    ]);
                }
            }
            $chenhLech += ($tienNuoc - $chiTietNuoc->thanh_tien);
            $chiTietNuoc->updateAttributes([
                'thanh_tien' => $tienNuoc
            ]);
        }

        //Cập nhật phụ phí
        $chiTietPhu = ChiTietHoaDon::findOne(['hoa_don_id'=>$hoaDon->id,'dich_vu_id'=>7]);
        if (!is_null($chiTietPhu)){
            $chenhLech += ($phuPhi - $chiTietPhu->thanh_tien);
            $chiTietPhu->updateAttributes([
                'thanh_tien' => $phuPhi
            ]);
        }

        $hoaDon->updateAttributes([
            'tong_tien' => $hoaDon->tong_tien + $chenhLech,
            'chi_phi_dich_vu' => $hoaDon->chi_phi_dich_vu + $chenhLech,
            'chot_hoa_don' => 1
        ]);

        $hopDong->updateAttributes([
            'thanh_tien' => $hopDong->thanh_tien + $chenhLech
        ]);

        //Cap nhat trang thai hoa don
        if ($hoaDon->tong_tien > $hoaDon->da_thanh_toan){
            $hoaDon->updateAttributes([
                'trang_thai' => HoaDon::CHUA_THANH_TOAN
            ]);
        }else{
            $hoaDon->updateAttributes([
                'trang_thai' => HoaDon::DA_THANH_TOAN
            ]);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'thanh_tien' => number_format($hoaDon->tong_tien, 0, ',', '.'),
            'chenhLech' => $chenhLech,
            'tienDien' => number_format($tienDien, 0, ',', '.'),
            'tienNuoc' => number_format($tienNuoc, 0, ',', '.')
        ];
    }

    //print
    public function actionPrint()
    {
        $hoaDons = [];
        if($_POST['loaiIn'] == 'mot')
            $hoaDons[] = HoaDon::findOne($_POST['hoaDon']);
        else
        {
            $thang = intval($_POST['thang']);
            $nam = intval($_POST['nam']);
            $toaNhaID = $_POST['toaNha'];
            $hoaDons = QuanLyHoaDon::findAll([
                'thang' => $thang,
                'nam' => $nam,
                'active' => 1,
                'parent_id'=> $toaNhaID,
                'chot_hoa_don' => 1
            ]);
        }
        $printPart = [];
        foreach ($hoaDons as $quanLyHoaDon){
            $params = [
                'thang' => 0,
                'nam' => 0,
                'ten_khach_hang' => '',
                'so_dien_thoai' => '',
                'phong' => '',
                'toa_nha' => '',
                'da_thanh_toan' => '',
                'bang'=>'',
                'so_tien_no' => '',
                'so_tien_phai_tra' => '',
                'tong_cong' => '',
            ];
            $hoaDon = HoaDon::findOne($quanLyHoaDon->id);
            $phongKhach = PhongKhach::findOne($hoaDon->phong_khach_id);
            $khach = User::findOne($phongKhach->khach_hang_id);
            $phong = DanhMuc::findOne($phongKhach->phong_id);
            $toaNha = DanhMuc::findOne($phong->parent_id);

            $params['thang'] = $hoaDon->thang;
            $params['ten_khach_hang'] = $khach->hoten;
            $params['nam'] = $hoaDon->nam;
            $params['so_dien_thoai'] = $khach->dien_thoai;
            $params['phong'] = $phong->name;
            $params['toa_nha'] = $toaNha->name;

            $HDs = HoaDon::findAll(['phong_khach_id'=>$hoaDon->phong_khach_id]);
            $tienNo = 0;
            foreach ($HDs as $HD){
                if ($HD->thang == $hoaDon->thang && $HD->nam == $hoaDon->nam)
                    break;
                $tienNo += ($HD->tong_tien - $HD->da_thanh_toan);
            }
            $params['so_tien_no'] = '<div class="pull-right">'.number_format($tienNo, 0, ',', '.').'</div>';
            $soTienPhaiTra = $hoaDon->tong_tien - $hoaDon->da_thanh_toan;
            $params['so_tien_phai_tra'] = '<div class="pull-right">'.number_format($soTienPhaiTra, 0, ',', '.').'</div>';
            $params['da_thanh_toan'] = '<div class="pull-right">'.number_format($hoaDon->da_thanh_toan, 0, ',', '.').'</div>';
            $params['tong_cong'] =  '<strong><div class="pull-right">'.number_format($soTienPhaiTra + $tienNo, 0, ',', '.').'</div></strong>';

            $params['bang'] = '
            <center><table class="table text-nowrap table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%" style="padding: 5px">STT</th>
                        <th style="padding: 5px">Tên chi phí</th>
                        <th width="1%" style="padding: 5px">Số tiền</th>
                    </tr>
                </thead>
                <tbody>';
            $stt = 1;
            $tienPhong = '<span class="pull-right">'.number_format($hoaDon->tien_phong, 0, ',', '.').'</span>';
            $params['bang'] .= '<tr><td style="padding: 5px">'.$stt.'</td><td style="padding: 5px">Tiền phòng</td><td style="padding: 5px">'.$tienPhong.'</td></tr>';
            $dichVus = ChiTietHoaDon::findAll(['hoa_don_id'=>$hoaDon->id]);
            foreach ($dichVus as $dichVu){
                $stt++;
                $thanhTien = '<span class="pull-right">'.number_format($dichVu->thanh_tien, 0, ',', '.').'</span>';
                $thietLapGia = ThietLapGia::findOne($dichVu->dich_vu_id);
                $params['bang'] .= '<tr><td style="padding: 5px">'.$stt.'</td><td style="padding: 5px">'.$thietLapGia->name.'</td><td style="padding: 5px">'.$thanhTien.'</td></tr>';
            }

            $tongCong = '<strong>'.number_format($hoaDon->tong_tien, 0, ',', '.').'</strong>';
            $params['bang'] .= '<tr><td></td><td style="padding: 5px"><center><strong>Tổng cộng:</strong></center></td><td style="padding: 5px">'.$tongCong.'</td></tr></tbody></table></center>';

            $printPart[] = $params;
//            $printPart = (new \backend\models\HoaDon())->printBill($params);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $ressult = $this->renderAjax('_printBill',['hoaDons'=>$printPart]);
        return [
            'hoaDon' => $ressult
        ];
    }

    //in-theo-thang
    public function actionInTheoThang()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active=1')->all(),
            'id',
            'name'
        );
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'content' => $this->renderAjax('in-theo-thang',[
                'toanhaids' => $toanhaids
            ]),
            'title' => 'In hóa đơn theo tháng'
        ];
    }

    //thanh-toan
    public function actionThanhToan()
    {
        $ids = $_POST['thanhToan'];
        $phongs = [];
        $conNos = [];
        $phaiTras = [];
        $khachs = [];
        foreach ($ids as $index => $id){
            $hoaDons[] = QuanLyHoaDon::findOne(['id' => $id]);
            $phongs[] = DanhMuc::findOne($hoaDons[$index]->phong_id);
            $HDs = HoaDon::findAll(['phong_khach_id'=>$hoaDons[$index]->phong_khach_id]);
            $conNos[] = 0;
            foreach ($HDs as $HD){
                if ($HD->thang == $hoaDons[$index]->thang && $HD->nam == $hoaDons[$index]->nam)
                    break;
                $conNos[$index] += ($HD->tong_tien - $HD->da_thanh_toan);
            }
            $khachs[] = User::findOne($hoaDons[$index]->khach_hang_id);
            $phaiTras[] = number_format($hoaDons[$index]->tong_tien-$hoaDons[$index]->da_thanh_toan+$conNos[$index], 0, ',', '.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = $this->renderAjax('thanh-toan',[
            'IDs' => $ids,
            'phongs' => $phongs,
            'conNos' => $conNos,
            'phaiTras' => $phaiTras,
            'khachs' => $khachs
        ]);
        return [
            'content' => $content,
            'success' => true,
            'title' => 'Lập giao dịch'
        ];
    }

    public function GetAccessToken()
    {
        $reToken = CauHinh::findOne(['ghi_chu'=>'refresh_token']);
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token']);
        $url = 'https://oauth.zaloapp.com/v4/oa/access_token';
        $secretKey = 'szpDdhiKLTr3fYZSWW56';
        $appId = '3433189854621494610';

        $postData = [
            'refresh_token' => $reToken->content,
            'app_id' => $appId,
            'grant_type' => 'refresh_token'
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'secret_key: ' . $secretKey
        ]);

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        $data = json_decode($response, true);
        if (isset($data['access_token']) && isset($data['refresh_token'])) {
            $acToken->updateAttributes([
                'content' => $data['access_token']
            ]);

            $reToken->updateAttributes([
                'content' => $data['refresh_token']
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function SendZNS($hoaDonID, $giaoDichID)
    {
        $url = 'https://business.openapi.zalo.me/message/template';
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token'])->content;
        $templateID = CauHinh::findOne(['ghi_chu'=>'template_id']);
        $tracking = CauHinh::findOne(['ghi_chu'=>'tracking_id']);
        $trackingID = intval($tracking->content);
        $hoaDon = QuanLyHoaDon::findOne(['id'=>$hoaDonID]);

        $giaoDich = GiaoDich::findOne($giaoDichID);
        $phone = $hoaDon->dien_thoai;
        if (substr($phone, 0, 1) === '0') {
            $phone = '84' . substr($phone, 1);
        }
        $HDs = HoaDon::findAll(['phong_khach_id'=>$hoaDon->phong_khach_id]);
        $tienNo = 0;
        foreach ($HDs as $HD){
            if ($HD->thang == $hoaDon->thang && $HD->nam == $hoaDon->nam)
                break;
            $tienNo += ($HD->tong_tien - $HD->da_thanh_toan);
        }
        $tienDien = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>2])->one();
        $tienNuoc = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>3])->one();
        $tienInternet = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>5])->one();
        $tienRac = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>4])->one();
        $tienGiat = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>6])->one();

        $templateData = [
            'thang' => $hoaDon->thang,
            'tien_phong' => number_format($hoaDon->tien_phong,0,',','.'),
            'tien_dien' => number_format($tienDien->thanh_tien,0,',','.'),
            'tien_nuoc' => number_format($tienNuoc->thanh_tien,0,',','.'),
            'tien_internet' => number_format($tienInternet->thanh_tien,0,',','.'),
            'tien_rac' => number_format($tienRac->thanh_tien,0,',','.'),
            'tien_giat' => number_format($tienGiat->thanh_tien,0,',','.'),
            'tien_no' => number_format($tienNo,0,',','.'),
            'tong_tien' => number_format($tienNo + $hoaDon->tong_tien,0,',','.'),
            'noi_dung_chuyen_khoan' => 'GD '.$giaoDichID.' HD '.$hoaDonID,
            'so_tien' => $giaoDich->tong_tien,
            'ho_ten' => $hoaDon->hoten,
            'dien_thoai' => $hoaDon->dien_thoai,
            'phong' => $hoaDon->ten_phong
        ];
        $postData = [
            'phone' => $phone,
            'template_id' => $templateID->content,
            'template_data' => $templateData,
            'tracking_id' => 'TID'.sprintf('%07d',$trackingID)
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'access_token: ' . $acToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        $data = json_decode($response, true);
        if (isset($data['message'])) {
            $tracking->updateAttributes([
                'content' => $trackingID+1
            ]);
            if ($data['message'] != 'noi_dung_chuyen_khoan has invalid format')
                return true;
            else
                return false;
        } else {
            return false;
        }
    }
    //lap-giao-dich
    public function actionLapGiaoDich()
    {
        //Lay ma accessToken cho lan gui
        $this->GetAccessToken();

        $hoaDonIDs = $_POST['hoaDonIDs'];
        $phaiTras = $_POST['phai_tra'];
        $cauHinh = CauHinh::findOne(['ghi_chu'=>'Link QR'])->content;
        $user = User::findOne(1);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $loi = [];
        foreach ($hoaDonIDs as $index => $hoaDonID){
            $phaiTra = str_replace('.','',$phaiTras[$index]);
            $model = new GiaoDich();
            $hoaDon = QuanLyHoaDon::findOne(['id'=>$hoaDonID]);
            $maQR = str_replace('{bank_id}',$user->te_ngan_hang,$cauHinh);
            $maQR = str_replace('{so_tai_khoan}',$user->so_tai_khoan,$maQR);
            $maQR = str_replace('{so_tien}',$phaiTra,$maQR);
            $ten = explode(' ',$user->ho_ten_tai_khoan);
            $maQR = str_replace('{ten_nguoi_nhan}',implode('%20',$ten),$maQR);
            $model->hoa_don_id = $hoaDon->id;
            $model->tong_tien = intval($phaiTra);
            $model->phong_khach_id = $hoaDon->phong_khach_id;
            $model->so_tien_giao_dich = 0;
            $model->trang_thai_giao_dich = GiaoDich::KHOI_TAO;
            $model->khach_hang_id = $hoaDon->khach_hang_id;
            $model->loai_giao_dich = GiaoDich::THANH_TOAN_HOP_DONG;
            $model->ma_qr = '';
            $model->noi_dung_chuyen_khoan = '';
            if ($model->save()){
                $noiDung = 'GD%20'.$model->id.'%20HD%20'.$hoaDon->id;
                $maQR = str_replace('{noi_dung}',$noiDung,$maQR);
                $model->updateAttributes([
                    'ma_qr' => $maQR
                ]);
                if(trim($_POST['gui_thong_bao']) == 'gui_zalo'){
                    $this->SendZNS($hoaDonID, $model->id);
                }
            }else
                $loi[] = $model->errors;
        }
        if (count($loi) == 0) {
            return [
                'success' => true,
                'content' => 'Tạo giao dịch thành công!',
                'title' => 'Thành công',
                'count' => $loi
            ];
        }
        return [
                'success' => false,
                'content' => 'Thử tạo lại giao dịch!',
                'title' => 'Tạo giao dịch không thành công',
                'count' => $loi
            ];
    }

    //get-list-hoa-don
    public function actionGetListHoaDon()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $quanLyHoaDons = QuanLyHoaDon::findAll([
                'khach_hang_id' => $content->uid,
                'active' => 1
            ]);
            return [
                'success' => true,
                'content' => $quanLyHoaDons,
            ];
        }else
            return $check;
    }

    private function sendZaloMessage($phoneNumber, $message)
    {
        // Access Token từ Zalo OA
        $accessToken = 'YOUR_ACCESS_TOKEN';

        // API URL
        $url = 'https://openapi.zalo.me/v2.0/oa/message';

        // Dữ liệu cần gửi
        $data = [
            'recipient' => [
                'user_id_by_phone' => $phoneNumber
            ],
            'message' => [
                'text' => $message
            ]
        ];

        // Cấu hình cURL để gọi API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);

        // Thực hiện gọi API
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý phản hồi từ API
        $responseData = json_decode($response, true);
        if (isset($responseData['error']) && $responseData['error'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function actionGetOCung()
    {
        $chiTiet = QuanLyOCung::find()
            ->andFilterWhere(['hoa_don_id'=>$_POST['id']])->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'title'=> "Danh sách người ở cùng",
            'content'=>$this->renderAjax('form-o-cung', [
                'chiTiets' => $chiTiet,
                'hoaDonID' => $_POST['id']
            ])
        ];
    }

    public function actionSaveOCung()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Tìm hóa đơn
        $hoaDon = HoaDon::findOne($_POST['hoaDonID']);
        if (!$hoaDon) {
            return [
                'success' => false,
                'content' => 'Hóa đơn không hợp lệ!'
            ];
        }

        // Tìm hợp đồng và phòng
        $hopDong = PhongKhach::findOne($hoaDon->phong_khach_id);
        if (!$hopDong) {
            return [
                'success' => false,
                'content' => 'Hợp đồng không hợp lệ!'
            ];
        }
        $phong = DanhMuc::findOne($hopDong->phong_id);
        if (!$phong) {
            return [
                'success' => false,
                'content' => 'Phòng không hợp lệ!'
            ];
        }

        // Xóa toàn bộ người ở cùng cũ
        $nguoiOCungCu = NguoiOCung::findAll(['hop_dong_id' => $hopDong->id]);
        foreach ($nguoiOCungCu as $nguoi) {
            ChiTietOCung::deleteAll(['nguoi_o_cung_id' => $nguoi->id]);
            $nguoi->delete();
        }

        // Thêm người ở cùng mới từ form
        $soNguoiOCung = 0; // Đếm số người ở cùng mới
        if (isset($_POST['ho_ten']) && is_array($_POST['ho_ten'])) {
            $hoTens = $_POST['ho_ten'];
            $dienThoais = $_POST['dien_thoai'] ?? [];

            foreach ($hoTens as $index => $hoTen) {
                if (trim($hoTen) == '') {
                    continue;
                }

                $oCung = new NguoiOCung();
                $oCung->ho_ten = $hoTen;
                $oCung->dien_thoai = $dienThoais[$index] ?? '';
                $oCung->hop_dong_id = $hopDong->id;

                if ($oCung->save()) {
                    $detail = new ChiTietOCung();
                    $detail->hoa_don_id = $hoaDon->id;
                    $detail->nguoi_o_cung_id = $oCung->id;
                    $detail->save();
                    $soNguoiOCung++;
                }
            }
        }

        // Cập nhật số người: số người ở cùng + 1 (người chính)
        $hoaDon->so_nguoi = $soNguoiOCung + 1;
        $hoaDon->save(false); // Lưu không validate để đảm bảo cập nhật

        // Cập nhật chi tiết nước
        $chiTietNuoc = ChiTietHoaDon::find()
            ->andWhere(['hoa_don_id' => $hoaDon->id])
            ->andWhere(['dich_vu_id' => 3])
            ->one();

        if ($chiTietNuoc) {
            $thanhTienCu = $chiTietNuoc->thanh_tien;
            $thanhTienMoi = $hoaDon->so_nguoi * $phong->gia_nuoc_nguoi;
            $chenhLech = $thanhTienMoi - $thanhTienCu;

            $chiTietNuoc->updateAttributes(['thanh_tien' => $thanhTienMoi]);

            // Cập nhật tổng tiền và chi phí dịch vụ của hóa đơn
            $hoaDon->updateAttributes([
                'tong_tien' => $hoaDon->tong_tien + $chenhLech,
                'chi_phi_dich_vu' => $hoaDon->chi_phi_dich_vu + $chenhLech
            ]);
        } else {
            return [
                'success' => false,
                'content' => 'Không tìm thấy chi tiết hóa đơn dịch vụ nước!'
            ];
        }

        return [
            'success' => true,
            'so_nguoi' => $hoaDon->so_nguoi,
            'tong_tien' => $hoaDon->tong_tien,
            'thanh_tien' => number_format($thanhTienMoi, 0, ',', '.'),
            'content' => 'Cập nhật người ở cùng thành công!'
        ];
    }


    public function xoaAnh($id)
    {
        $chiTiet = ChiTietHoaDon::findOne($id);
        if($chiTiet->anh != 'no-image.jpg'){
            $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$chiTiet->anh;
            if(is_file($path)){
                unlink($path);
                $chiTiet->updateAttributes([
                    'anh' => 'no-image.jpg'
                ]);
            }
        }
    }
    public function actionChonAnh()
    {
        $hoaDon = HoaDon::findOne($_POST['id']);
        $file = UploadedFile::getInstanceByName('file');
        $path = '';
        $chiTiet = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>2])->one();

        if(!is_null($file)){
            $this->xoaAnh($chiTiet->id);
            $chiTiet->updateAttributes([
                'anh' => myAPI::createCode(time().$file->name)
            ]);
            $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$chiTiet->anh;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($path != ''){
            $file->saveAs($path);
//            $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
            return [
                'success' => true,
                'content' => 'Thêm ảnh số điện thành công',
                'anh' => Yii::getAlias('@web').'/hinh-anh/'.$chiTiet->anh
            ];
        }
        return [
            'success' => false,
            'content' => 'File ảnh không hợp lệ'
        ];
    }
    public function actionXoaAnh()
    {
        $hoaDon = HoaDon::findOne($_POST['id']);
        $chiTiet = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>2])->one();
        $this->xoaAnh($chiTiet->id);
        $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => 'Xóa ảnh số điện thành oông!',
            'anh' => $domain.'/hinh-anh/no-image.jpg'
        ];
    }
    public function actionCongNo()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );

        $thangs = array_combine(range(1, 12), range(1, 12));
        $nams = array_combine(range(2000, 2050), range(2000, 2050));

        $toaNhaID = DanhMuc::find()
            ->andFilterWhere(['active' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        $thangTruoc = date('n');
        $namHienTai = date('Y');

        $hoaDons = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['parent_id' => $toaNhaID])
            ->andFilterWhere(['thang' => $thangTruoc])
            ->andFilterWhere(['nam' => $namHienTai])
            ->andFilterWhere(['<', 'da_thanh_toan', 'tong_tien'])
            ->all();
        $conNo = 0;
        $daThanhToan = 0;
        foreach ($hoaDons as $hoaDon){
            $conNo += $hoaDon->tong_tien - $hoaDon->da_thanh_toan;
            $daThanhToan += $hoaDon->da_thanh_toan;
        }
        $hoaDonDaTT = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['parent_id' => $toaNhaID])
            ->andFilterWhere(['thang' => $thangTruoc])
            ->andFilterWhere(['nam' => $namHienTai])
            ->andFilterWhere(['>=', 'da_thanh_toan', 'tong_tien'])
            ->all();
        foreach ($hoaDonDaTT as $hoaDon){
            $daThanhToan += $hoaDon->da_thanh_toan;
        }
        return $this->render('cong-no', [
            'thangs' => $thangs,
            'nams' => $nams,
            'toanhaids' => $toanhaids,
            'toaNhaID' => $toaNhaID->id,
            'hoaDons' => $hoaDons,
            'hoanThanh' => count($hoaDonDaTT),
            'congNo' => count($hoaDons),
            'conNo' => number_format($conNo, 0, ',', '.'),
            'daThanhToan' => number_format($daThanhToan, 0, ',', '.'),
        ]);
    }
    public function actionThongKe()
    {
        $toaNhaID = $_POST['toaNhaID'];
        $phongID = $_POST['phongID'];
        $thang = intval($_POST['thang']);
        $nam = intval($_POST['nam']);
        $loai = $_POST['loai'];

        $operator = ($loai == 'con no') ? '>=' : '<';

        $query = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['parent_id' => $toaNhaID])
            ->andFilterWhere(['thang' => $thang])
            ->andFilterWhere(['nam' => $nam]);
        if (!empty($phongID)) {
            $query->andFilterWhere(['phong_id' => $phongID]);
        }

        $hoanThanhQuery = clone $query;
        $conNoQuery = clone $query;
        $tongTienQuery = clone $query;
        $daThanhToanQuery = clone $query;
        $hoaDonsQuery = clone $query;

        $hoanThanh = $hoanThanhQuery->andFilterWhere(['>=', 'da_thanh_toan', new Expression('tong_tien')])->count();
        $conNo = $conNoQuery->andFilterWhere(['<', 'da_thanh_toan', new Expression('tong_tien')])->count();

        $tongTien = $tongTienQuery->sum('tong_tien');
        $daThanhToan = $daThanhToanQuery->sum('da_thanh_toan');

        $hoaDons = $hoaDonsQuery->andFilterWhere([$operator, 'da_thanh_toan', new Expression('tong_tien')])->all();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $this->renderPartial('thong-ke', [
                'hoaDons' => $hoaDons,
            ]),
            'hoanThanh' => $hoanThanh,
            'daHoanThanh' => number_format($daThanhToan, 0, ',', '.'),
            'congNo' => $conNo,
            'conNo' => number_format($tongTien - $daThanhToan, 0, ',', '.'),
        ];
    }
}
