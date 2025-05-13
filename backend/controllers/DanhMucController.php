<?php

namespace backend\controllers;

use backend\models\ChiPhi;
use backend\models\ChiTietChiPhi;
use backend\models\ChucNang;
use backend\models\DanhMuc;
use backend\models\HoaDon;
use backend\models\PhieuChi;
use backend\models\PhongKhach;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyHoaDon;
use backend\models\QuanLyPhong;
use backend\models\QuanLyPhongKhach;
use backend\models\search\DanhMucSearch;
use backend\models\search\QuanLyDiaChiNhanHangSearch;
use backend\models\search\QuanLyPhongSearch;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use common\models\exportThuChi;
use common\models\myAPI;
use common\models\User;
use DateTime;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use \yii\web\Response;

//
/**
 * QuanLyDonHangController implements the CRUD actions for ThucHienCongViec model.
 */
class DanhMucController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'toa-nha-phong-o', 'create-toa-nha-phong-o', 'update-toa-nha-phong-o','tim-phong-o','don-gia','get-don-gia-phong','get-gia-nuoc-khoi',
            'view','get-chi-phi','luu-chi-phi','xoa-chi-phi','get-bang-gia','get-ngay-thang','get-lich-dat','save-phong','update-phong','xoa-phong',
            'thong-ke-phong','moi-gioi','thong-ke-moi-gioi','update-moi-gioi','chi-phi','tong-hop','get-chart-data', 'thong-ke-thu-chi'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('DanhMuc', $action_name, $this->contentAPI->uid);
                    }
                ];
            }
        }else{
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return \Yii::$app->user->id == 1 || myAPI::isAccess2('DanhMuc', $action_name);
                    }
                ];
            }
        }
        //
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    //toa-nha-phong-o
    public function actionToaNhaPhongO()
    {
        $content = json_decode(file_get_contents('php://input'));

        if(isset($content->uid)){

        }
        else{
            $searchModel = new DanhMucSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, [DanhMuc::TOA_NHA, DanhMuc::PHONG_O]);

            return $this->render('toa-nha-phong-o/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    //create-toa-nha-phong-o
    public function actionCreateToaNhaPhongO()
    {
        $request = Yii::$app->request;
        $model = new DanhMuc();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm toà nhà / phòng ở",
                    'content'=>$this->renderAjax('toa-nha-phong-o/create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('<i class="fa fa-save"></i> Lưu','#',['class'=>'btn btn-primary save-phong'])

                ];
            }else if($model->load($request->post())){
                $model->don_gia = intval(str_replace('.','',$_POST['thang']));
                $donGia = [];
                $donGia['3_gio'] = intval(str_replace('.','',$_POST['3_gio']));
                $donGia['6_gio'] = intval(str_replace('.','',$_POST['6_gio']));
                $donGia['ngay'] = intval(str_replace('.','',$_POST['ngay']));
                $model->gia_thue_ngan = json_encode($donGia);
                if ($model->save()){
                    return [
                        'success' => true,
                        'content' => 'Thêm tòa nhà/phòng ở '.$model->name.' thành công!'
                    ];
                }
                return [
                    'success' => false,
                    'content' => 'Thông tin tòa nhà/phòng ở không hợp lệ!'
                ];
            }else{
                return [
                    'title'=> "Thêm toà nhà / phòng ở",
                    'content'=>$this->renderAjax('toa-nha-phong-o/create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }
    public function actionSavePhong()
    {
        $request = Yii::$app->request;
        $model = new DanhMuc();
        $model->load($request->post());
        $model->don_gia = intval(str_replace('.','',$_POST['thang']));
        $donGia = [];
        $donGia['3_gio'] = intval(str_replace('.','',$_POST['3_gio']));
        $donGia['6_gio'] = intval(str_replace('.','',$_POST['6_gio']));
        $donGia['ngay'] = intval(str_replace('.','',$_POST['ngay']));
        $model->gia_thue_ngan = json_encode($donGia);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->save()){
            return [
                'success' => true,
                'content' => 'Thêm tòa nhà/phòng ở '.$model->name.' thành công!'
            ];
        }
        return [
            'success' => false,
            'content' => 'Thông tin tòa nhà/phòng ở không hợp lệ!'
        ];
    }
    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    //update-toa-nha-phong-o
    public function actionUpdateToaNhaPhongO($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $donGia = json_decode($model->gia_thue_ngan, true);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật thông tin toà nhà / phòng ở",
                    'content'=>$this->renderAjax('toa-nha-phong-o/update', [
                        'model' => $model,
                        'donGia'=>$donGia,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('<i class="fa fa-save"></i> Lưu','#',['class'=>'btn btn-primary update-phong'])
                ];
            }else if($model->load($request->post())){
                $model->don_gia = intval(str_replace('.','',$_POST['thang']));
                $donGia = [];
                $donGia['3_gio'] = intval(str_replace('.','',$_POST['3_gio']));
                $donGia['6_gio'] = intval(str_replace('.','',$_POST['6_gio']));
                $donGia['ngay'] = intval(str_replace('.','',$_POST['ngay']));
                $model->gia_thue_ngan = json_encode($donGia);
                if ($model->save()){
                    return [
                        'success' => true,
                        'content' => 'Cập nhật tòa nhà/phòng ở '.$model->name.' thành công!'
                    ];
                }
                return [
                    'success' => false,
                    'content' => 'Thông tin tòa nhà/phòng ở không hợp lệ!'
                ];
            }else{
                return [
                    'title'=> "Cập nhật vai trò",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
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
    public function actionUpdatePhong()
    {
        $request = Yii::$app->request;
        $model = new DanhMuc();
        $model->load($request->post());
        $model->don_gia = intval(str_replace('.','',$_POST['thang']));
        $donGia = [];
        $donGia['3_gio'] = intval(str_replace('.','',$_POST['3_gio']));
        $donGia['6_gio'] = intval(str_replace('.','',$_POST['6_gio']));
        $donGia['ngay'] = intval(str_replace('.','',$_POST['ngay']));
        $model->gia_thue_ngan = json_encode($donGia);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phong = DanhMuc::findOne($_POST['id']);
        if (!is_null($phong)){
            $phong->updateAttributes([
                'name' => $model->name,
                'parent_id' => $model->parent_id,
                'type' => $model->type,
                'gia_thue_ngan' => $model->gia_thue_ngan,
                'don_gia' => $model->don_gia,
            ]);
            return [
                'success' => true,
                'content' => 'Cập nhật tòa nhà/phòng ở '.$model->name.' thành công!'
            ];
        }
        return [
            'success' => false,
            'content' => 'Tòa nhà/phòng ở không tồn tại!'
        ];
    }
    public function actionXoaPhong()
    {
        $model = DanhMuc::findOne($_POST['id']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($model)){
            $model->updateAttributes([
                'active' => 0
            ]);
            return [
                'success' => true,
                'content' => 'Xóa tòa nhà/phòng ở '.$model->name.' thành công!'
            ];
        }
        return [
            'success' => false,
            'content' => 'Tòa nhà/phòng ở không tồn tại!'
        ];
    }
    protected function findModel($id)
    {
        if (($model = DanhMuc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //tim-phong-o
    public function actionTimPhongO()
    {
        if(!isset($_POST['ngayTu'])){
            $phongos = DanhMuc::findAll(['active' => 1, 'parent_id' => $_POST['idToaNha']]);
        }else{
            $ngayTu = DateTime::createFromFormat('d/m/Y H:i', $_POST['ngayTu'])->format('Y-m-d H:i:s');
            $ngayDen = DateTime::createFromFormat('d/m/Y H:i', $_POST['ngayDen'])->format('Y-m-d H:i:s');

            $phongos = \backend\models\DanhMuc::find()
                ->alias('dm')
                ->andFilterWhere(['dm.parent_id' => $_POST['idToaNha']])
                ->andFilterWhere(['dm.active' => 1])
                ->leftJoin('qlcvsd_phong_khach qlpk', 'qlpk.phong_id = dm.id')
                ->andWhere([
                    'or',
                    ['qlpk.phong_id' => null],
                    [
                        'and',
                        ['or',
                            ['<', 'qlpk.thoi_gian_hop_dong_den', $ngayTu],
                            ['>', 'qlpk.thoi_gian_hop_dong_tu', $ngayDen],
                        ],
                        ['!=', 'qlpk.trang_thai', PhongKhach::HOAN_THANH],
                        ['qlpk.active' => 1]
                    ]
                ])
                ->all();
        }
        $phongos = DanhMuc::findAll(['active' => 1, 'parent_id' => $_POST['idToaNha']]);
        $phongoids = [];
        foreach ($phongos as $item) {
            $phongoids[]=[
                'id'=>$item->id,
                'name'=>$item->name
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'content'=>$phongoids,
            'success'=>true
        ];
    }
    //get-don-gia-phong
    public function actionGetDonGiaPhong()
    {
        $model = DanhMuc::findOne($_POST['idPhong']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(is_null($model)){
            return [
                'content'=> 0,
                'success' => true
            ];
        }
        $goi = $_POST['goi'];
        if ($goi != 'thang'){
            $gias = json_decode($model->gia_thue_ngan, true);
            return [
                'content' => intval($gias[$goi]),
                'success' => true
            ];
        }
        if($model->type = DanhMuc::PHONG_O){
            return [
                'content' => $model->don_gia,
                'success' => true
            ];
        }else
            return [
                'content' => 'Vui lòng nhập mã phòng',
                'success' => false
            ];
    }
    //view
    public function actionView()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        $toaNhaID = DanhMuc::find()
            ->andFilterWhere(['active' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        $thangs = array_combine(range(1, 12), range(1, 12));
        $nams = array_combine(range(2000, 2050), range(2000, 2050));

        return $this->render('view',[
            'toanhaids' => $toanhaids,
            'toaNhaID' => $toaNhaID->id,
            'thangs' => $thangs,
            'nams' => $nams
        ]);
    }
    //get-chi-phi
    public function actionGetChiPhi()
    {
        $thang = $_POST['thang'];
        $nam = $_POST['nam'];

        $phieuChi = PhieuChi::findOne([
            'thang' => $thang,
            'nam' => $nam,
            'active' => 1,
            'toa_nha_id' => intval($_POST['toaNhaID'])
        ]);

        if (is_null($phieuChi)){
            $phieuChi = new PhieuChi();
            $phieuChi->thang = $thang;
            $phieuChi->nam = $nam;
            $phieuChi->toa_nha_id = intval($_POST['toaNhaID']);
            $phieuChi->save();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chiTiets = ChiTietChiPhi::findAll(['phieu_chi_id' => $phieuChi->id]);
        $tongTien = 0;
        $daTT = 0;
        foreach ($chiTiets as $item) {
            $tongTien += $item->so_tien;
            $daTT += $item->da_thanh_toan;
        }
        return [
            'success' => true,
            'content' => $this->renderPartial('chi-phi/danh-sach', [
                'chiTiets' => $chiTiets,
            ]),
            'tongTien' => number_format($tongTien,0,',','.'),
            'daThanhToan' => number_format($daTT,0,',','.'),
            'conLai' => number_format($tongTien - $daTT,0,',','.')
        ];
    }
    //luu-chi-phi
    public function actionLuuChiPhi()
    {
        $tenChiPhi = $_POST['tenChiPhi'];
        $ghiChu = $_POST['ghiChu'];
        $tongTien = $_POST['tongTien'];
        $daThanhToan = $_POST['daThanhToan'];
        $chiTietID = intval($_POST['chiTietID']);
        $soTien = intval(str_replace('.','',$tongTien));
        $daThanhToan = intval(str_replace('.','',$daThanhToan));

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($daThanhToan > $soTien){
            return [
                'success' => false,
                'content' => 'Số tiền đã thanh toán không hợp lệ!'
            ];
        }

        $phieuChi = PhieuChi::findOne([
            'active' => 1,
            'thang' => intval($_POST['thang']),
            'nam' => intval($_POST['nam']),
            'toa_nha_id' => intval($_POST['toaNhaID']),
        ]);
        $chiTiet = ChiTietChiPhi::findOne($chiTietID);
        if(!is_null($chiTiet)){
            $phieuChi->updateAttributes([
                'tong_tien' => $phieuChi->tong_tien - $chiTiet->so_tien + $soTien,
            ]);
            if($chiTiet->chi_phi_id == 1){
                $chiTiet->updateAttributes([
                    'ghi_chu' => $ghiChu,
                ]);
            }else{
                $chiTiet->updateAttributes([
                    'ghi_chu' => $ghiChu,
                    'so_tien' => $soTien,
                    'da_thanh_toan' => $daThanhToan,
                    'ten_chi_phi' => $tenChiPhi
                ]);
            }
        }else{
            $chiTiet = new ChiTietChiPhi();
            $chiTiet->phieu_chi_id = $phieuChi->id;
            $chiTiet->so_tien = $soTien;
            $chiTiet->da_thanh_toan = $daThanhToan;
            $chiTiet->ten_chi_phi = $tenChiPhi;
            $chiTiet->ghi_chu = $ghiChu;
            if($chiTiet->save()){
                $phieuChi->updateAttributes([
                    'tong_tien' => $phieuChi->tong_tien + $soTien,
                ]);
            }
        }
        return [
            'success' => true,
            'content' => 'Cập nhật chi phí '.$chiTiet->ten_chi_phi.' thành công'
        ];
    }
    //xoa-chi-phi
    public function actionXoaChiPhi()
    {
        $chiTiet = ChiTietChiPhi::findOne($_POST['chiTietID']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!is_null($chiTiet)){
            $phieuChi = PhieuChi::findOne($chiTiet->phieu_chi_id);
            $phieuChi->updateAttributes([
                'tong_tien' => $phieuChi->tong_tien - $chiTiet->so_tien,
            ]);
            $chiTiet->delete();
            return [
                'success' => true,
                'content' => 'Xóa chi phí thành công'
            ];
        }
        if(intval($_POST['chiTietID']) == -1){
            return [
                'success' => true,
                'content' => 'Xóa chi phí thành công'
            ];
        }
        return [
            'success' => false,
            'content' => 'Không tìm thấy chi phí'
        ];
    }
    public function actionGetBangGia()
    {
        $phong = DanhMuc::findOne($_POST['id']);
        $giaDichVus = json_decode($phong->gia_dich_vu, true);

        $donGiaDien = [];
        $donGiaDien['label'] = 'Giá điện (VNĐ/KW)';
        $donGiaDien['name'] = 'gia_dien';
        $donGiaDien['value'] = $phong->gia_dien;
        $donGiaNuoc = [];
        $donGiaNuoc['label'] = 'Giá nước (VNĐ/m³)';
        $donGiaNuoc['name'] = 'gia_nuoc';
        $donGiaNuoc['value'] = $phong->gia_nuoc;
        $giaNuocNguoi = [];
        $giaNuocNguoi['label'] = 'Giá nước (1 người)';
        $giaNuocNguoi['name'] = 'gia_nuoc_nguoi';
        $giaNuocNguoi['value'] = $phong->gia_nuoc_nguoi;

        $giaDichVus[] = $donGiaDien;
        $giaDichVus[] = $donGiaNuoc;
        $giaDichVus[] = $giaNuocNguoi;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $giaDichVus,
            'tenPhong' => 'PHÒNG '.strtoupper($phong->name)
        ];
    }
    public function actionGetNgayThang()
    {
        $goi = $_POST['goi'];
        $dateOb = \DateTime::createFromFormat('d/m/Y H:i', $_POST['time']);

        if (!$dateOb) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => false,
                'content' => ''
            ];
        }

        switch ($goi) {
            case '3_gio':
                $dateOb->modify('+3 hours');
                break;
            case '6_gio':
                $dateOb->modify('+6 hours');
                break;
            default:
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => false,
                    'content' => ''
                ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'ngay' => $dateOb->format('d/m/Y'),
            'gio' => $dateOb->format('H'),
            'phut' => $dateOb->format('i')
        ];
    }
    public function actionGetLichDat($id)
    {
        $phong = DanhMuc::findOne($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $hopDongs = QuanLyPhongKhach::find()
            ->andFilterWhere(['phong_id'=>$phong->id])
            ->andFilterWhere(['active'=>1])->all();
        $result = [];
        foreach ($hopDongs as $hopDong){
            $book = [];
            $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s',$hopDong->thoi_gian_hop_dong_tu);
            $dateTo = DateTime::createFromFormat('Y-m-d H:i:s',$hopDong->thoi_gian_hop_dong_den);
            $book['title'] = $hopDong->hoten;
            $book['start'] = $dateFrom->format('Y-m-d').'T'.$dateFrom->format('H:i');
            $book['end'] = $dateTo->format('Y-m-d').'T'.$dateTo->format('H:i');
            $book['color'] = '#a8d5e2';
            $book['textColor'] = '#34495e';
            $result[] = $book;
        }
        return [
            'title'=> "Lịch đăt phòng ".$phong->name,
            'content'=>$this->renderAjax('toa-nha-phong-o/get-lich', [
                'results' => $result
            ]),
            'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
        ];
    }
    public function actionGetGiaNuocKhoi()
    {
        $hoaDon = QuanLyHoaDon::findOne(['id'=>$_POST['hoaDonID']]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($hoaDon)) {
            $phong = DanhMuc::findOne($hoaDon->phong_id);
            return [
                'success' => true,
                'donGia' => $phong->gia_nuoc_nguoi,
            ];
        }
        return [
            'success' => false,
            'content' => ''
        ];
    }
    public function actionThongKePhong()
    {
        $searchModel = new QuanLyPhongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionMoiGioi()
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
        $thangTruoc = strtotime("-1 month");
        $query = QuanLyPhongKhach::find()
            ->where(['toa_nha_id' => $toaNhaID->id, 'active' => 1])
            ->andWhere(['>','so_tien_moi_gioi',0])
            ->andWhere(['MONTH(thoi_gian_hop_dong_tu)' => (int)date('m', $thangTruoc)])
            ->andWhere(['YEAR(thoi_gian_hop_dong_tu)' => (int)date('Y', $thangTruoc)]);

        $hoanThanh = clone $query;
        $congNo = clone $query;
        $tongTienQuery = clone $query;
        $daThanhToanQuery = clone $query;

        $hopDongs = $congNo->andFilterWhere(['<','da_thanh_toan_moi_gioi',new Expression('so_tien_moi_gioi')])->all();
        $hopDongDaTTs = $hoanThanh->andFilterWhere(['>=','da_thanh_toan_moi_gioi',new Expression('so_tien_moi_gioi')])->all();
        $tongTien = $tongTienQuery->sum('so_tien_moi_gioi');
        $daThanhToan = $daThanhToanQuery->sum('da_thanh_toan_moi_gioi');

        return $this->render('moi-gioi/thong-ke-moi-gioi', [
            'toanhaids'=>$toanhaids,
            'toaNhaID'=>$toaNhaID->id,
            'thangs' => $thangs,
            'nams' => $nams,
            'hoanThanh' => count($hopDongDaTTs),
            'congNo' => count($hopDongs),
            'conNo' => number_format($tongTien - $daThanhToan, 0, ',', '.'),
            'daThanhToan' => number_format($daThanhToan, 0, ',', '.'),
        ]);
    }
    public function actionThongKeMoiGioi()
    {
        $toaNhaID = $_POST['toaNhaID'];
        $phongID = $_POST['phongID'];
        $thang = intval($_POST['thang']);
        $nam = intval($_POST['nam']);
        $loai = $_POST['loai'];

        $thangTruoc = $thang - 1 == 0 ? 12 : $thang - 1;
        $nam = $thangTruoc == 12 ? $nam - 1 : $nam;

        $operator = ($loai == 'con no') ? '>=' : '<';

        $query = QuanLyPhongKhach::find()
            ->where(['toa_nha_id' => $toaNhaID, 'active' => 1])
            ->andWhere(['>','so_tien_moi_gioi',0])
            ->andWhere(['MONTH(thoi_gian_hop_dong_tu)' => $thangTruoc])
            ->andWhere(['YEAR(thoi_gian_hop_dong_tu)' => $nam]);

        if (!empty($phongID)) {
            $query->andFilterWhere(['phong_id' => $phongID]);
        }

        $hoanThanhQuery = clone $query;
        $conNoQuery = clone $query;
        $tongTienQuery = clone $query;
        $daThanhToanQuery = clone $query;
        $hopDongsQuery = clone $query;

        $hoanThanh = $hoanThanhQuery->andFilterWhere(['>=', 'da_thanh_toan_moi_gioi', new Expression('so_tien_moi_gioi')])->count();
        $conNo = $conNoQuery->andFilterWhere(['<', 'da_thanh_toan_moi_gioi', new Expression('so_tien_moi_gioi')])->count();

        $tongTien = $tongTienQuery->sum('so_tien_moi_gioi');
        $daThanhToan = $daThanhToanQuery->sum('da_thanh_toan_moi_gioi');

        $hopDongs = $hopDongsQuery->andFilterWhere([$operator, 'da_thanh_toan_moi_gioi', new Expression('so_tien_moi_gioi')])->all();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $this->renderPartial('moi-gioi/danh-sach', [
                'hopDongs' => $hopDongs,
                'loai' => $loai
            ]),
            'hoanThanh' => $hoanThanh,
            'daHoanThanh' => number_format($daThanhToan, 0, ',', '.'),
            'congNo' => $conNo,
            'conNo' => number_format($tongTien - $daThanhToan, 0, ',', '.'),
        ];
    }
    public function actionUpdateMoiGioi()
    {
        $hopDong = PhongKhach::findOne($_POST['hopDongID']);
        $soTien = trim($_POST['daThanhToan']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $daThanhToan = intval(str_replace('.','',$soTien));
        if($daThanhToan > $hopDong->so_tien_moi_gioi){
            return [
                'success' => false,
                'content' => 'Số tiền vượt quá mức phải trả'
            ];
        }
        $hopDong->updateAttributes([
            'da_thanh_toan_moi_gioi' => $daThanhToan,
        ]);
        return [
            'success' => true,
            'content' => 'Cập nhật tiền thanh toán môi giới hợp đồng '.$hopDong->ma_hop_dong.' thành công!'
        ];
    }
    public function actionChiPhi()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        $toaNhaID = DanhMuc::find()
            ->andFilterWhere(['active' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        $thangs = array_combine(range(1, 12), range(1, 12));
        $nams = array_combine(range(2000, 2050), range(2000, 2050));

        return $this->render('chi-phi/chi-phi',[
            'toanhaids' => $toanhaids,
            'toaNhaID' => $toaNhaID->id,
            'thangs' => $thangs,
            'nams' => $nams
        ]);
    }
    public function actionTongHop()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        $toaNhaID = DanhMuc::find()
            ->andFilterWhere(['active' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->one()->id;
        $tongThu = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['thang' => (int)date('m')])
            ->andFilterWhere(['nam' => (int)date('Y')])
            ->andFilterWhere(['parent_id' => $toaNhaID])
            ->sum('da_thanh_toan') ?? 0;
        $phieuChis = PhieuChi::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['thang' => (int)date('m')])
            ->andFilterWhere(['nam' => (int)date('Y')])
            ->andFilterWhere(['toa_nha_id' => $toaNhaID])->all();
        $tongChi = 0;
        foreach($phieuChis as $phieuChi){
            $tongChi += ChiTietChiPhi::find()
                ->andFilterWhere(['phieu_chi_id' => $phieuChi->id])
                ->sum('da_thanh_toan') ?? 0;
        }
        return $this->render('loi-nhuan',[
            'toanhaids' => $toanhaids,
            'toaNhaID' => $toaNhaID,
            'tongThu' => number_format($tongThu,0,',','.'),
            'tongChi' => number_format($tongChi,0,',','.'),
            'loiNhuan' => number_format($tongThu - $tongChi,0,',','.'),
        ]);
    }
    public function actionGetChartData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $timeIndex = strtotime('2024-09-01');
        $timeNow = strtotime('now');
        $chartDatas = [];

        $dataThu = [];
        $dataChi = [];
        $dataLoiNhuan = [];
        while($timeIndex <= $timeNow){
            $queryThu = QuanLyHoaDon::find()
                ->andFilterWhere(['active' => 1])
                ->andFilterWhere(['thang' => (int)date('m', $timeIndex)])
                ->andFilterWhere(['nam' => (int)date('Y', $timeIndex)]);
            if (!empty($_POST['toaNhaID'])) {
                $queryThu->andFilterWhere(['parent_id' => $_POST['toaNhaID']]);
            }
            $tongThu = $queryThu->sum('da_thanh_toan') ?? 0;

            $queryChi = PhieuChi::find()
                ->andFilterWhere(['active' => 1])
                ->andFilterWhere(['thang' => (int)date('m', $timeIndex)])
                ->andFilterWhere(['nam' => (int)date('Y', $timeIndex)]);
            if (!empty($_POST['toaNhaID'])) {
                $queryChi->andFilterWhere(['toa_nha_id' => $_POST['toaNhaID']]);
            }
            $phieuChis = $queryChi->all();
            $tongChi = 0;
            foreach($phieuChis as $phieuChi){
                $tongChi += ChiTietChiPhi::find()
                    ->andFilterWhere(['phieu_chi_id' => $phieuChi->id])
                    ->sum('da_thanh_toan') ?? 0;
            }
            $dataThu[] = [
                'date' => $timeIndex * 1000,
                'value' => $tongThu
            ];
            $dataChi[] = [
                'date' => $timeIndex * 1000,
                'value' => $tongChi
            ];
            $dataLoiNhuan[] = [
                'date' => $timeIndex * 1000,
                'value' => $tongThu - $tongChi
            ];
            $chartDatas[] = [
                'year' => date('m/Y', $timeIndex),
                'tong_thu' => intval($tongThu),
                'tong_chi' => $tongChi,
                'loi_nhuan' => $tongThu - $tongChi,
            ];
            $timeIndex = strtotime("+1 month", $timeIndex);
        }

        return [
            'success' => true,
            'dataThu' => $dataThu,
            'dataChi' => $dataChi,
            'dataLoiNhuan' => $dataLoiNhuan,
            'chartDatas' => $chartDatas,
            'tongThu' => number_format($tongThu,0,'.',','),
            'tongChi' => number_format($tongChi,0,'.',','),
            'loiNhuan' => number_format($tongThu - $tongChi,0,'.',','),
        ];
    }
    //thong-ke-thu-chi
    public function actionThongKeThuChi() {
        $fromDate = myAPI::convertDMY2YMD($_POST['from_ngay_thong_ke']);
        $toDate = myAPI::convertDMY2YMD($_POST['to_ngay_thong_ke']);

        // Báo cáo lãi lỗ
        $tongThu = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'created', $fromDate, $toDate])
            ->sum('da_thanh_toan') ?? 0;

        $phieuChis = PhieuChi::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'created', $fromDate, $toDate])
            ->all();

        $tongChi = 0;
        foreach($phieuChis as $phieuChi){
            $tongChi += ChiTietChiPhi::find()
                ->andFilterWhere(['phieu_chi_id' => $phieuChi->id])
                ->sum('da_thanh_toan') ?? 0;
        }

        $bao_cao_lai_lo = [
            'tong_thu' => $tongThu,
            'tong_chi' => $tongChi,
            'loi_nhuan' => $tongThu - $tongChi,
        ];


        // Hợp đồng
        $hopDongs = QuanLyPhongKhach::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'thoi_gian_hop_dong_den', $fromDate, $toDate])
            ->all();

        // Hóa đơn
        $hoaDons = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'created', $fromDate, $toDate])
            ->all();

        // Giao dịch
        $giaoDichs = QuanLyGiaoDich::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'created', $fromDate, $toDate])
            ->all();

        // Công nợ
        $congNos = QuanLyHoaDon::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'created', $fromDate, $toDate])
            ->andFilterWhere(['<', 'da_thanh_toan', 'tong_tien'])
            ->all();

        // Phòng ở
        $phongOs = QuanLyPhong::find()
            ->andFilterWhere(['active_phong' => 1])
            ->andFilterWhere(['between', 'thoi_gian_hop_dong_den', $fromDate, $toDate])
            ->all();

        // Chi phí môi giới
        $chiPhiMoiGiois = QuanLyPhongKhach::find()
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['between', 'thoi_gian_hop_dong_den', $fromDate, $toDate])
            ->andFilterWhere(['>','so_tien_moi_gioi',0])
            ->all();

        $data = [
            'bao_cao_lai_lo' => $bao_cao_lai_lo,
            'hop_dong' => $hopDongs,
            'hoa_don' => $hoaDons,
            'giao_dich' => $giaoDichs,
            'cong_no' => $congNos,
            'phong_o' => $phongOs,
            'chi_phi_moi_gioi' => $chiPhiMoiGiois,
            'chi_phi_khac' => $phieuChis,
        ];

        $export = new exportThuChi();
        $export->data = $data;
        $export->path_file = dirname(dirname(__DIR__)) . '/files_excel/';
        $export->from_date = $fromDate;
        $export->to_date = $toDate;
        $export->stream = false;

        $filename = $export->run();
        $file = str_replace('index.php', '', Url::home(true)) . 'files_excel/' . $filename;

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title' => 'Tải file',
            'link_file' => \yii\helpers\Html::a('<i class="fa fa-cloud-download"></i> Nhấn vào đây để tải file về!', $file, ['class' => 'text-primary', 'target' => '_blank']),
            'message' => 'Nhấn vào đây để tải file về!'
        ];
    }
}
