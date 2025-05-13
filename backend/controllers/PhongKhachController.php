<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietHoaDon;
use backend\models\ChiTietOCung;
use backend\models\DanhMuc;
use backend\models\FileHopDong;
use backend\models\GiaDien;
use backend\models\GiaoDich;
use backend\models\HoaDon;
use backend\models\NguoiOCung;
use backend\models\QuanLyKhachHang;
use backend\models\QuanLyOCung;
use backend\models\QuanLyPhong;
use backend\models\QuanLyPhongKhach;
use backend\models\QuanLyUser;
use backend\models\search\DanhMucSearch;
use backend\models\search\QuanLyKhachHangSearch;
use backend\models\search\QuanLyPhongKhachSearch;
use backend\models\search\QuanLyPhongSearch;
use backend\models\search\QuanLySaleSearch;
use backend\models\search\UserSearch;
use backend\models\ThietLapGia;
use backend\models\Vaitrouser;
use common\models\myAPI;
use common\models\User;
use DateTime;
use Mpdf\Tag\U;
use Yii;
use backend\models\PhongKhach;
use backend\models\search\PhongKhachSearch;
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
use function GuzzleHttp\Psr7\str;

/**
 * PhongKhachController implements the CRUD actions for PhongKhach model.
 */
class PhongKhachController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index','create','view','update','save-hop-dong','delete','xoa-file-hop-dong','thanh-toan','save-giao-dich','kiem-tra',
            'chuyen-khoan','get-list-hop-dong','thanh-toan-moi-gioi','save-moi-gioi','get-tien-dien','thue-ngan-han','get-list-phong',
            'dong-phong','mo-phong','get-khach-hang','get-form-thong-tin','save-update','get-lich-dat','hoan-thanh','xoa-anh-json'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('PhongKhach', $action_name, $this->contentAPI->uid);
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
                        return myAPI::isAccess2('PhongKhach', $action_name);
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
     * Lists all PhongKhach models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new QuanLyPhongKhachSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        $packages = [
            '3_gio' => 'Gói 3 giờ',
            '6_gio' => 'Gói 6 giờ',
            'ngay' => 'Gói ngày',
            'thang' => 'Gói tháng'
        ];
        $searchModelKhach = new QuanLyKhachHangSearch();
        $dataProviderKhach = $searchModelKhach->search(\Yii::$app->request->queryParams);
        $searchModelSale = new QuanLySaleSearch();
        $dataProviderSale = $searchModelSale->search(\Yii::$app->request->queryParams);
        $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
        $gios = [];
        for ($i = 0; $i <= 23; $i++){
            $gios[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        $phuts = [];
        for ($i = 0; $i <= 59; $i++){
            $phuts[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        $model = new PhongKhach();
        $stt = CauHinh::findOne(['ghi_chu'=>'ma_hop_dong'])->content;
        $model->ma_hop_dong = 'HD'.sprintf('%05d',$stt);
        $model->thoi_gian_hop_dong_tu = $model->thoi_gian_hop_dong_den = date('Y-m-d');
        $model->so_thang_hop_dong = 1;
        $model->chiet_khau = 0;
        $model->coc_truoc = 0;

        return $this->render('create', [
            'model' => $model,
            'searchModelKhach' => $searchModelKhach,
            'searchModelSale' => $searchModelSale,
            'toanhaids' => $toanhaids,
            'gios' => $gios,
            'phuts' => $phuts,
            'packages' => $packages,
            'dataProviderKhach' => $dataProviderKhach,
            'dataProviderSale' => $dataProviderSale,
            'domain' => $domain,
        ]);
    }
    public function timeValidation($ngayVao,$ngayRa)
    {
        $format = 'd/m/Y H:i:s';

        $dateVao = DateTime::createFromFormat($format, $ngayVao);
        $dateRa = DateTime::createFromFormat($format, $ngayRa);

        if (!$dateVao || !$dateRa) {
            return false;
        }

        return $dateRa > $dateVao;
    }
    public function createBill($timeIndex,$model,$oldHopDongID = null)
    {
        $bill = new HoaDon();
        $startDate = 1;
        $endDate = (int)date("t",$timeIndex);
        $thangBatDau = (int)date('m', strtotime($model->thoi_gian_hop_dong_tu));
        $namBatDau = (int)date('Y', strtotime($model->thoi_gian_hop_dong_tu));
        $ngayBatDau = (int)date('d', strtotime($model->thoi_gian_hop_dong_tu));
        $thangKetThuc = (int)date('m', strtotime($model->thoi_gian_hop_dong_den));
        $namKetThuc = (int)date('Y', strtotime($model->thoi_gian_hop_dong_den));
        $ngayKetThuc = (int)date('d', strtotime($model->thoi_gian_hop_dong_den));
        $soNgay = (int)date("t",$timeIndex);

        $thang = (int)date('m',$timeIndex);
        $nam = (int)date('Y',$timeIndex);
        if($thang == $thangBatDau && $nam == $namBatDau){
            $startDate = $ngayBatDau;
        }
        if($thang == $thangKetThuc && $nam == $namKetThuc){
            $endDate = $ngayKetThuc;
        }

        $bill->thang = $thang;
        $bill->nam = $nam;
        $bill->phong_khach_id = $model->id;
        $bill->tien_phong = $model->don_gia - $model->so_tien_chiet_khau;
        if ($model->loai_hop_dong == 'ngay'){
            $bill->tien_phong = $model->thanh_tien;
        }elseif ($model->loai_hop_dong == 'thang'){
            //Trường hợp tháng thiếu ngày
            $diff = $endDate - $startDate + 1;
            $giaPhong = (int)round(((float)$bill->tien_phong/(float)$soNgay)*(float)$diff);
            
            $bill->tien_phong = $giaPhong;
        }
        $bill->chi_phi_dich_vu = 0;
        $bill->da_thanh_toan = 0;
        $bill->tong_tien = $bill->tien_phong;
        $sttHD = CauHinh::findOne(['ghi_chu'=>'maHoaDon'])->content;
        $bill->ma_hoa_don = 'B'.sprintf('%06d',$sttHD);
        $bill->trang_thai = HoaDon::CHUA_THANH_TOAN;

        //Cap nhat ma hoa don moi nhat
        if ($bill->save()){
            $cauHinh = CauHinh::findOne(['ghi_chu'=>'maHoaDon']);
            $cauHinh->updateAttributes(['content'=>intval($cauHinh->content)+1]);

            //Giữ lại các hóa đơn và giao dịch cũ
            $curThang = (int)date('m');
            $curNam = (int)date('Y');
            $check = ($thang <= $curThang && $nam == $curNam) || $nam < $curNam;
            if(!is_null($oldHopDongID) && $check){
                $oldHoaDon = HoaDon::findOne([
                    'phong_khach_id'=>$oldHopDongID,
                    'thang'=>$thang,
                    'nam'=>$nam,
                ]);
                $bill->updateAttributes([
                    'tien_phong'=>$oldHoaDon->tien_phong,
                    'da_thanh_toan'=>$oldHoaDon->da_thanh_toan,
                    'tong_tien'=>$oldHoaDon->tong_tien,
                    'chi_phi_dich_vu'=>$oldHoaDon->chi_phi_dich_vu,
                    'so_nguoi' => $oldHoaDon->so_nguoi,
                    'trang_thai' => $oldHoaDon->trang_thai,
                ]);

                //Giữ lại các giao dịch cũ đã tạo, không tính tiền cọc vì đã tạo trong quá trình sửa hđ rồi
                $oldGiaoDichs = GiaoDich::findAll([
                    'hoa_don_id'=>$oldHoaDon->id,
                ]);
                foreach ($oldGiaoDichs as $oldGiaoDich){
                    $giaoDich = new GiaoDich();
                    $giaoDich->hoa_don_id = $bill->id;
                    $giaoDich->phong_khach_id = $bill->phong_khach_id;
                    $giaoDich->tong_tien = $oldGiaoDich->tong_tien;
                    $giaoDich->so_tien_giao_dich = $oldGiaoDich->so_tien_giao_dich;
                    $giaoDich->khach_hang_id = $oldGiaoDich->khach_hang_id;
                    $giaoDich->trang_thai_giao_dich = $oldGiaoDich->trang_thai_giao_dich;
                    $giaoDich->save();
                }

                //Giữ lại các chi phí dịch vụ cũ
                $chiTiets = ChiTietHoaDon::findAll(['hoa_don_id'=>$bill->id]);
                foreach ($chiTiets as $chiTiet){
                    $oldChiTiet = ChiTietHoaDon::findOne([
                        'hoa_don_id'=>$oldHoaDon->id,
                        'dich_vu_id' => $chiTiet->dich_vu_id
                    ]);
                    $chiTiet->updateAttributes([
                        'don_gia'=>$oldChiTiet->don_gia,
                        'so_luong'=>$oldChiTiet->so_luong,
                        'thanh_tien'=>$oldChiTiet->thanh_tien,
                        'chi_so_cu' => $oldChiTiet->chi_so_cu,
                        'anh' => $oldChiTiet->anh,
                    ]);
                }
                //Cập nhật số người ở cùng cũ
                $oCungs = ChiTietOCung::findAll(['hoa_don_id'=>$bill->id]);
                foreach ($oCungs as $oCung){
                    $oCung->delete();
                }
                $oldOCungs = ChiTietOCung::findAll(['hoa_don_id'=>$oldHoaDon->id]);
                foreach ($oldOCungs as $oldOCung){
                    $oldOCung->updateAttributes([
                        'hoa_don_id'=>$bill->id,
                    ]);
                }
            }
        }
    }
    //save-hop-dong
    public function actionSaveHopDong()
    {
        $loi = '';
        $model = new PhongKhach();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        $timeVao = $model->thoi_gian_hop_dong_tu.' '.$_POST['gio_vao'].':'.$_POST['phut_vao'].':00';
        $timeRa = $model->thoi_gian_hop_dong_den.' '.$_POST['gio_ra'].':'.$_POST['phut_ra'].':00';
        if ($model->khach_hang_id == ''){
            $loi = 'Vui lòng chọn khách hàng!';
        }elseif ($model->phong_id == ''){
            $loi = 'Vui lòng chọn phòng thuê!';
        }elseif (!$this->timeValidation($timeVao,$timeRa)){
            $loi = 'Thời gian hợp đồng không hợp lệ!';
        }elseif ($model->moi_gioi != '' && $model->sale_id == ''){
            if ($model->moi_gioi != 0){
                $loi = 'Chưa chọn người môi giới!';
            }
        }
        if($loi != ''){
            return [
                'success' => false,
                'content' => $loi
            ];
        }

        $phong = DanhMuc::findOne($model->phong_id);
        $giaThueNgan = json_decode($phong->gia_thue_ngan, true);

        //Luu chiet khau va coc truoc
        $model->chiet_khau = str_replace('.','',$model->chiet_khau);
        $model->coc_truoc = str_replace('.','',$model->coc_truoc);
        $model->trang_thai = PhongKhach::DA_DUYET;

        //Luu thoi gian hop dong tu - den
        $dateTu = DateTime::createFromFormat('d/m/Y H:i:s', $timeVao);
        $dateDen = DateTime::createFromFormat('d/m/Y H:i:s', $timeRa);
        $model->thoi_gian_hop_dong_tu = $dateTu->format('Y-m-d H:i:s');
        $model->thoi_gian_hop_dong_den = $dateDen->format('Y-m-d H:i:s');

        //Luu ma hop dong
        $stt = CauHinh::findOne(['ghi_chu'=>'ma_hop_dong'])->content;
        $model->ma_hop_dong = 'HD'.sprintf('%05d',$stt);

        if ($model->loai_hop_dong == 'thang'){
            $soNam = (int)$dateDen->format('Y') - (int)$dateTu->format('Y');
            $soThangChenhLech = ((int)$dateDen->format('m')-(int)$dateTu->format('m'))+1+$soNam*12;
            $model->so_thang_hop_dong = $soThangChenhLech;

            $model->don_gia = $phong->don_gia;

            //Cap nhat gia dich vu phong
            $dichVus = json_decode($phong->gia_dich_vu, true);
            $giaDichVu = [];
            foreach ($dichVus as $dichVu){
                $item = [];
                $item['label'] = $dichVu['label'];
                $item['name'] = $dichVu['name'];
                $item['value'] = intval(str_replace('.','',$_POST[$dichVu['name']]));
                $giaDichVu[] = $item;
            }
            $phong->updateAttributes([
                'gia_dich_vu' => json_encode($giaDichVu, JSON_UNESCAPED_UNICODE),
                'gia_dien' => intval(str_replace('.','',$_POST['gia_dien'])),
                'gia_nuoc' => intval(str_replace('.','',$_POST['gia_nuoc'])),
                'gia_nuoc_nguoi' => intval(str_replace('.','',$_POST['gia_nuoc_nguoi']))
            ]);
        }elseif ($model->loai_hop_dong == 'ngay'){
            $model->don_gia = intval($giaThueNgan['ngay']);
        }elseif ($model->loai_hop_dong == '3_gio'){
            $model->don_gia = intval($giaThueNgan['3_gio']);
        }elseif ($model->loai_hop_dong == '6_gio'){
            $model->don_gia = intval($giaThueNgan['6_gio']);
        }

        //Luu so tien chiet khau
        $model->so_tien_chiet_khau = ($model->kieu_chiet_khau == '%') ? $model->chiet_khau*$model->don_gia/100 : $model->chiet_khau;
        $model->da_thanh_toan = 0;

        $tongTien = $model->don_gia - $model->so_tien_chiet_khau;

        if ($model->loai_hop_dong == 'thang'){
            $tongTien = $model->so_thang_hop_dong * $tongTien;
        }elseif ($model->loai_hop_dong == 'ngay'){
            $soNgay = intval($dateTu->diff($dateDen)->days);
            $tongTien = $tongTien * ($soNgay + 1);
        }

        //Luu thong tin moi gioi
        $model->moi_gioi = str_replace('.','',$model->moi_gioi);
        $model->da_thanh_toan_moi_gioi = str_replace('.','',$model->da_thanh_toan_moi_gioi);
        if ($model->moi_gioi != ''){
            if($model->kieu_moi_gioi == '%'){
                $model->so_tien_moi_gioi = $model->moi_gioi * ($model->don_gia - $model->so_tien_chiet_khau) / 100;
            }else{
                $model->so_tien_moi_gioi = $model->moi_gioi;
            }
        }
        $fileChuyenKhoans = UploadedFile::getInstancesByName('anh_chuyen_khoan');

        $fileHopDongs = UploadedFile::getInstancesByName('file_hop_dong');

        $model->thanh_tien = $tongTien;

        if($model->save()){
            //Cap nhat ma hop dong moi nhat
            $cauHinh = CauHinh::findOne(['ghi_chu'=>'ma_hop_dong']);
            $cauHinh->updateAttributes(['content'=>intval($cauHinh->content)+1]);

            //Tao giao dich neu co coc truoc
            $time = time();
            if($model->coc_truoc != 0){
                $giaoDich = new GiaoDich();
                $giaoDich->phong_khach_id = $model->id;
                $giaoDich->tong_tien = $model->coc_truoc;
                $giaoDich->so_tien_giao_dich = $model->coc_truoc;
                $giaoDich->khach_hang_id = $model->khach_hang_id;
                $giaoDich->loai_giao_dich = GiaoDich::THANH_TOAN_HOP_DONG;

//                Lưu ảnh chuyển khoản
                $fileName = [];
                foreach ($fileChuyenKhoans as $fileChuyenKhoan){
                    $fileName[] = $time.$fileChuyenKhoan->name;
                }
                $giaoDich->anh_chuyen_khoan = implode(',',$fileName);

                if ($giaoDich->save())
                    foreach ($fileChuyenKhoans as $index => $fileChuyenKhoan){
                        $fileChuyenKhoan->saveAs(dirname(dirname(__DIR__)).'/hinh-anh/'.$fileName[$index]);
                    }
            }

//            Lưu ảnh hợp đồng
            $fileName = [];
            foreach ($fileHopDongs as $fileHopDong){
                $fileName[] = $time.$fileHopDong->name;
            }
            $model->updateAttributes([
                'anh_hop_dong' => json_encode($fileName,true)
            ]);
            foreach ($fileHopDongs as $index => $fileHopDong){
                $fileHopDong->saveAs(dirname(dirname(__DIR__)).'/hinh-anh/'.$fileName[$index]);
            }

            $timeIndex = strtotime($model->thoi_gian_hop_dong_tu);
            if ($model->loai_hop_dong == 'thang'){
                //Luu thong tin nguoi o cung
                if(isset($_POST['ho_ten'])){
                    $hoTens = $_POST['ho_ten'];
                    $dienThoais = $_POST['dien_thoai'];
                    foreach ($hoTens as $index => $hoTen){
                        if (trim($hoTen) == ''){
                            continue;
                        }
                        $oCung = new NguoiOCung();
                        $oCung->hop_dong_id = $model->id;
                        $oCung->ho_ten = $hoTen;
                        $oCung->dien_thoai = $dienThoais[$index];
                        $oCung->save();
                    }
                }

                //Tao cac hoa don di kem
                for ($i = 0; $i < $soThangChenhLech; $i+=1){
                    $this->createBill($timeIndex,$model);
                    $timeIndex = strtotime("+1 month",$timeIndex);
                }
                $thanhTien = HoaDon::find()
                    ->andFilterWhere(['phong_khach_id'=>$model->id])
                    ->andFilterWhere(['active'=>1])
                    ->sum('tong_tien');
                $model->updateAttributes([
                    'thanh_tien' => $thanhTien,
                ]);
            }else{
                $this->createBill($timeIndex,$model);
            }
            return [
                'success' => true,
                'content' => 'Lưu thông tin hợp đồng thành công'
            ];
        }
        return [
            'success' => false,
            'content' => 'Thông tin không hợp lệ'
        ];
    }

    /**
     * Displays a single PhongKhach model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = PhongKhach::findOne($id);
        $khach = User::findOne($model->khach_hang_id);
        $user = User::findOne($model->user_id);
        $phong = \backend\models\DanhMuc::findOne(['id'=>$model->phong_id]);
        $toanha = \backend\models\DanhMuc::findOne(['id'=>$phong->parent_id]);
        $giaoDichs = GiaoDich::findAll([
            'phong_khach_id'=>$model->id,
            'loai_giao_dich' => GiaoDich::THANH_TOAN_HOP_DONG
        ]);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Hợp đồng khách: ".$khach->hoten,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'khach' => $khach,
                        'phong' => $phong,
                        'toanha' => $toanha,
                        'user' => $user,
                        'giaoDichs'=>$giaoDichs
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Chỉnh sửa','#', ['data-value'=>$model->id, 'data-pjax' => 0,'id'=>'btn-sua-hop-dong','class'=>'btn btn-primary'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new PhongKhach model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /**
     * Updates an existing PhongKhach model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $oldModel = PhongKhach::findOne($id);
        $phong = DanhMuc::findOne($oldModel->phong_id);
        $packages = [
            '3_gio' => 'Gói 3 giờ',
            '6_gio' => 'Gói 6 giờ',
            'ngay' => 'Gói ngày',
            'thang' => 'Gói tháng'
        ];
        $gios = [];
        for ($i = 0; $i <= 23; $i++){
            $gios[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        $phuts = [];
        for ($i = 0; $i <= 59; $i++){
            $phuts[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        $phongids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id = '.$phong->parent_id.' and active = 1')->all(),
            'id',
            'name'
        );
        $searchModelKhach = new QuanLyKhachHangSearch();
        $dataProviderKhach = $searchModelKhach->search(\Yii::$app->request->queryParams);
        $searchModelSale = new QuanLySaleSearch();
        $dataProviderSale = $searchModelSale->search(\Yii::$app->request->queryParams);
        $khach = User::findOne($oldModel->khach_hang_id);
        $sale = User::findOne($oldModel->sale_id);
        $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;

        $fileHDs = FileHopDong::findAll(['phong_khach_id'=>$oldModel->id]);

        return $this->render('update', [
            'model' => $oldModel,
            'khach' => $khach,
            'phong' => $phong,
            'phongids' => $phongids,
            'fileHDs' => $fileHDs,
            'gios' => $gios,
            'phuts' => $phuts,
            'searchModelKhach' => $searchModelKhach,
            'searchModelSale' => $searchModelSale,
            'toanhaids' => $toanhaids,
            'dataProviderKhach' => $dataProviderKhach,
            'dataProviderSale' => $dataProviderSale,
            'packages' => $packages,
            'sale' => $sale,
            'domain' => $domain
        ]);
    }


    public function actionSaveUpdate()
    {
        $loi = '';
        //Load model cũ
        $oldModel = PhongKhach::findOne($_POST['hop_dong_id']);

        $model = new PhongKhach();
        $model->load(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        $timeVao = $model->thoi_gian_hop_dong_tu.' '.$_POST['gio_vao'].':'.$_POST['phut_vao'].':00';
        $timeRa = $model->thoi_gian_hop_dong_den.' '.$_POST['gio_ra'].':'.$_POST['phut_ra'].':00';
        if ($model->khach_hang_id == ''){
            $loi = 'Vui lòng chọn khách hàng!';
        }elseif ($model->phong_id == ''){
            $loi = 'Vui lòng chọn phòng thuê!';
        }elseif (!$this->timeValidation($timeVao,$timeRa)){
            $loi = 'Thời gian hợp đồng không hợp lệ!';
        }elseif ($model->moi_gioi != '' && $model->sale_id == ''){
            if ($model->moi_gioi != 0)
                $loi = 'Chưa chọn người môi giới!';
        }
        if($loi != ''){
            return [
                'success' => false,
                'content' => $loi
            ];
        }

        $phong = DanhMuc::findOne($model->phong_id);
        $giaThueNgan = json_decode($phong->gia_thue_ngan, true);

        //Luu chiet khau va coc truoc
        $model->chiet_khau = str_replace('.','',$model->chiet_khau);
        $model->coc_truoc = str_replace('.','',$model->coc_truoc);
        $model->trang_thai = PhongKhach::DA_DUYET;

        //Luu thoi gian hop dong tu - den
        $dateTu = DateTime::createFromFormat('d/m/Y H:i:s', $timeVao);
        $dateDen = DateTime::createFromFormat('d/m/Y H:i:s', $timeRa);
        $model->thoi_gian_hop_dong_tu = $dateTu->format('Y-m-d H:i:s');
        $model->thoi_gian_hop_dong_den = $dateDen->format('Y-m-d H:i:s');

        //Luu ma hop dong
        $model->ma_hop_dong = $oldModel->ma_hop_dong;

        if ($model->loai_hop_dong == 'thang'){
            $soNam = (int)$dateDen->format('Y') - (int)$dateTu->format('Y');
            $soThangChenhLech = ((int)$dateDen->format('m')-(int)$dateTu->format('m'))+1+$soNam*12;
            $model->so_thang_hop_dong = $soThangChenhLech;

            $model->don_gia = $phong->don_gia;

            //Cap nhat gia dich vu phong
            $dichVus = json_decode($phong->gia_dich_vu, true);
            $giaDichVu = [];
            foreach ($dichVus as $dichVu){
                $item = [];
                $item['label'] = $dichVu['label'];
                $item['name'] = $dichVu['name'];
                $item['value'] = intval(str_replace('.','',$_POST[$dichVu['name']]));
                $giaDichVu[] = $item;
            }
            $phong->updateAttributes([
                'gia_dich_vu' => json_encode($giaDichVu, JSON_UNESCAPED_UNICODE),
                'gia_dien' => intval(str_replace('.','',$_POST['gia_dien'])),
                'gia_nuoc' => intval(str_replace('.','',$_POST['gia_nuoc'])),
                'gia_nuoc_nguoi' => intval(str_replace('.','',$_POST['gia_nuoc_nguoi']))
            ]);
        }elseif ($model->loai_hop_dong == 'ngay'){
            $model->don_gia = intval($giaThueNgan['ngay']);
        }elseif ($model->loai_hop_dong == '3_gio'){
            $model->don_gia = intval($giaThueNgan['3_gio']);
        }elseif ($model->loai_hop_dong == '6_gio'){
            $model->don_gia = intval($giaThueNgan['6_gio']);
        }

        //Luu so tien chiet khau
        $model->so_tien_chiet_khau = ($model->kieu_chiet_khau == '%') ? $model->chiet_khau*$model->don_gia/100 : $model->chiet_khau;
        $model->da_thanh_toan = 0;

        $tongTien = $model->don_gia - $model->so_tien_chiet_khau;

        if ($model->loai_hop_dong == 'thang'){
            $tongTien = $model->so_thang_hop_dong * $tongTien;
        }elseif ($model->loai_hop_dong == 'ngay'){
            $soNgay = intval($dateTu->diff($dateDen)->days);
            $tongTien = $tongTien * ($soNgay + 1);
        }

        //Luu thong tin moi gioi
        $model->moi_gioi = str_replace('.','',$model->moi_gioi);
        $model->da_thanh_toan_moi_gioi = str_replace('.','',$model->da_thanh_toan_moi_gioi);
        if ($model->moi_gioi != ''){
            if($model->kieu_moi_gioi == '%'){
                $model->so_tien_moi_gioi = $model->moi_gioi * ($model->don_gia - $model->so_tien_chiet_khau) / 100;
            }else{
                $model->so_tien_moi_gioi = $model->moi_gioi;
            }
        }

        $fileChuyenKhoans = UploadedFile::getInstancesByName('anh_chuyen_khoan');
        $fileHopDongs = UploadedFile::getInstancesByName('file_hop_dong');

        $model->thanh_tien = $tongTien;

        if($model->save()){
            //Tao giao dich neu co coc truoc
            $time = time();
            if($model->coc_truoc != 0){
                $giaoDich = new GiaoDich();
                $giaoDich->phong_khach_id = $model->id;
                $giaoDich->tong_tien = $model->coc_truoc;
                $giaoDich->so_tien_giao_dich = $model->coc_truoc;
                $giaoDich->khach_hang_id = $model->khach_hang_id;
                $giaoDich->loai_giao_dich = GiaoDich::THANH_TOAN_HOP_DONG;

                $fileName = [];
                foreach ($fileChuyenKhoans as $fileChuyenKhoan){
                    $fileName[] = $time.$fileChuyenKhoan->name;
                }
                $giaoDich->anh_chuyen_khoan = implode(',',$fileName);

                if ($giaoDich->save())
                    foreach ($fileChuyenKhoans as $index => $fileChuyenKhoan){
                        $fileChuyenKhoan->saveAs(dirname(dirname(__DIR__)).'/hinh-anh/'.$fileName[$index]);
                    }
            }
            $timeIndex = strtotime($model->thoi_gian_hop_dong_tu);
            if ($model->loai_hop_dong == 'thang'){
                //Luu thong tin nguoi o cung
                $nguoiOCungs = [];
                if(isset($_POST['ho_ten'])){
                    $hoTens = $_POST['ho_ten'];
                    $dienThoais = $_POST['dien_thoai'];
                    foreach ($hoTens as $index => $hoTen){
                        if (trim($hoTen) == ''){
                            continue;
                        }
                        $oCung = new NguoiOCung();
                        $oCung->hop_dong_id = $model->id;
                        $oCung->ho_ten = $hoTen;
                        $oCung->dien_thoai = $dienThoais[$index];
                        if ($oCung->save()){
                            $nguoiOCungs[] = $oCung;
                        }
                    }
                }

                //Tao cac hoa don di kem
                for ($i = 0; $i < $soThangChenhLech; $i+=1){
                    $this->createBill($timeIndex,$model,$oldModel->id);
                    $timeIndex = strtotime("+1 month",$timeIndex);
                }
            }else{
                $this->createBill($timeIndex,$model,$oldModel->id);
            }
//Lưu ảnh trạng thái
//            $oldFileNames = json_decode($oldModel->anh_trang_thai, true);
//            if (!is_array($oldFileNames)) {
//                $oldFileNames = [];
//            }
//
//            $newFileNames = [];
//            foreach ($fileTrangThais as $fileTrangThai) {
//                $newFileNames[] = $time . $fileTrangThai->name;
//            }
//            $mergedFileNames = array_merge($oldFileNames, $newFileNames);
//            $model->updateAttributes([
//                'anh_trang_thai' => json_encode($mergedFileNames)
//            ]);
//            if (!empty($newFileNames)) {
//                foreach ($fileTrangThais as $index => $fileTrangThai) {
//                    $fileTrangThai->saveAs(dirname(dirname(__DIR__)) . '/hinh-anh/' . $newFileNames[$index]);
//                }
//            }
//            Lưu ảnh hợp đồng
            $oldFileNames = json_decode($oldModel->anh_hop_dong, true);
            if (!is_array($oldFileNames)) {
                $oldFileNames = [];
            }

            $newFileNames = [];
            foreach ($fileHopDongs as $fileHopDong) {
                $newFileNames[] = $time . $fileHopDong->name;
            }
            $mergedFileNames = array_merge($oldFileNames, $newFileNames);
            $model->updateAttributes([
                'anh_hop_dong' => json_encode($mergedFileNames)
            ]);
            if (!empty($newFileNames)) {
                foreach ($fileHopDongs as $index => $fileHopDong) {
                    $fileHopDong->saveAs(dirname(dirname(__DIR__)) . '/hinh-anh/' . $newFileNames[$index]);
                }
            }

            $oldModel->afterDelete();
            $model->updateAttributes(['phong_cu_id'=>$oldModel->id]);
            return [
                'success' => true,
                'content' => 'Lưu thông tin hợp đồng thành công'
            ];
        }
        return [
            'success' => false,
            'content' => 'Thông tin không hợp lệ'
        ];
    }


    /**
     * Delete an existing PhongKhach model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phongKhach = PhongKhach::findOne($_POST['hopDongID']);
        if (!is_null($phongKhach)) {
            $phongKhach->updateAttributes(['active' => 0]);
            $hoaDons = HoaDon::findAll(['phong_khach_id'=>$phongKhach->id]);
            foreach ($hoaDons as $hoaDon){
                $hoaDon->updateAttributes([
                    'active' => 0
                ]);
                $giaoDichs = GiaoDich::findAll(['hoa_don_id'=>$hoaDon->id]);
                foreach ($giaoDichs as $giaoDich){
                    $giaoDich->updateAttributes([
                        'active'=>0
                    ]);
                }
            }
            return [
                'success' => true,
                'content' => 'Xóa hợp đồng '.$phongKhach->ma_hop_dong.' thành công!'
            ];
        } else {
            return ([
                'success' => false,
                'content' => 'Không tìm thấy thông tin',
                'title' => 'Thông báo'
            ]);
        }
    }

     /**
     * Delete multiple existing PhongKhach model.
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
     * Finds the PhongKhach model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhongKhach the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhongKhach::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
//    xoa-file-hop-dong
    public function actionXoaFileHopDong()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $fileHD = FileHopDong::findOne($_POST['fid']);
        if (!is_null($fileHD)){
            $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$fileHD->file;
            unlink($path);
            $fileHD->delete();
            return [
                'success' => true
            ];
        }
        return [
            'success' => false,
        ];
    }
//    thanh-toan
    public function actionThanhToan($id)
    {
        $request = Yii::$app->request;
        $model = PhongKhach::findOne($id);
        $khach = User::findOne($model->khach_hang_id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> 'Thanh toán hợp đồng mã: '.$model->ma_hop_dong,
                'content'=>$this->renderAjax('thanh-toan', [
                    'model' => $model,
                    'khach'=>$khach,
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left btn-dong','data-dismiss'=>"modal"]).
                    Html::a('Xác nhận',['thanh-toan','id'=>$id],['class'=>'btn btn-primary btn-thanh-toan', 'data-pjax' => 0])
            ];
        }else{
            return $this->render('thanh-toan', [
                'model' => $model,
                'khach'=>$khach,
            ]);
        }
    }
//    thanh-toan-moi-gioi
    public function actionThanhToanMoiGioi($id)
    {
        $request = Yii::$app->request;
        $model = PhongKhach::findOne($id);
        $sale = User::findOne($model->sale_id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> 'Thanh toán môi giới hợp đồng: '.$model->ma_hop_dong,
                'content'=>$this->renderAjax('thanh-toan-moi-gioi', [
                    'model' => $model,
                    'sale'=>$sale,
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left btn-dong','data-dismiss'=>"modal"]).
                    Html::a('Xác nhận',['thanh-toan-moi-gioi','id'=>$id],['class'=>'btn btn-primary btn-thanh-toan-moi-gioi', 'data-pjax' => 0])
            ];
        }else{
            return $this->render('thanh-toan-moi-gioi', [
                'model' => $model,
                'sale'=>$sale,
            ]);
        }
    }
//    save-giao-dich
    public function actionSaveGiaoDich()
    {
        $phongKhach = PhongKhach::findOne($_POST['phong_khach_id']);
        $fileChuyenKhoans = UploadedFile::getInstancesByName('anh_chuyen_khoan');
        $giaoDich = new GiaoDich();
        $soTien = intval(str_replace('.','',$_POST['so_tien']));
        $giaoDich->so_tien_giao_dich = $soTien;
        $giaoDich->phong_khach_id = $_POST['phong_khach_id'];
        $giaoDich->tong_tien = $soTien;
        $giaoDich->khach_hang_id = $phongKhach->khach_hang_id;
        $giaoDich->trang_thai_giao_dich = GiaoDich::THANH_CONG;
        $giaoDich->loai_giao_dich = GiaoDich::THANH_TOAN_HOP_DONG;

        Yii::$app->response->format = Response::FORMAT_JSON;
        $time = time();
        $fileName = [];
        foreach ($fileChuyenKhoans as $fileChuyenKhoan){
            $fileName[] = $time.$fileChuyenKhoan->name;
        }
        $giaoDich->anh_chuyen_khoan = implode(',',$fileName);

        if ($giaoDich->save()){
            $phongKhach->updateAttributes([
                'coc_truoc' => $phongKhach->coc_truoc+$soTien
            ]);
            foreach ($fileChuyenKhoans as $index => $fileChuyenKhoan){
                $fileChuyenKhoan->saveAs(dirname(dirname(__DIR__)).'/hinh-anh/'.$fileName[$index]);
            }
            return [
                'success' => true
            ];
        }
        return [
            'success' => false
        ];
    }
//    save-moi-gioi
    public function actionSaveMoiGioi()
    {
        $hopDong = PhongKhach::findOne($_POST['phong_khach_id']);
        $soTien = intval(str_replace('.','',$_POST['so_tien']));
        $giaoDich = new GiaoDich();
        $giaoDich->so_tien_giao_dich = $soTien;
        $giaoDich->phong_khach_id = $_POST['phong_khach_id'];
        $giaoDich->tong_tien = $soTien;
        $giaoDich->trang_thai_giao_dich = GiaoDich::THANH_CONG;
        $giaoDich->loai_giao_dich = GiaoDich::PHI_MOI_GIOI;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($giaoDich->save()){
            $hopDong->updateAttributes([
                'da_thanh_toan_moi_gioi' => $soTien + $hopDong->da_thanh_toan_moi_gioi
            ]);
            return [
                'success' => true,
                'content' => 'Thanh toán môi giới hợp đồng thành công'
            ];
        }
        return [
            'success' => false,
            'content' => 'Thông tin giao dịch không hợp lệ!'
        ];
    }
//    kiem-tra
    public function actionKiemTra()
    {
        $hopDongID = $_POST['hopDongID'];
        $user = QuanLyUser::findOne(['id'=>Yii::$app->user->id]);
        $model = PhongKhach::findOne($hopDongID);
        $now = Date('Y-m-d H:i:s');
        $created = $model->created;
        $cauHinh = CauHinh::findOne(['ghi_chu'=>'thoi_gian'])->content;
        $timePlus = strtotime('+'.$cauHinh.' hours',strtotime($created));
        $nowTime = strtotime($now);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($timePlus < $nowTime && $user->vai_tro != 'Quản lý hệ thống')
            return [
                'success' => false,
                'thoiGian' => $cauHinh
            ];
        return [
            'success' => true,
            'thoiGian' => $cauHinh
        ];
    }
    //get-list-hop-dong
    public function actionGetListHopDong()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $hopDongs = PhongKhach::findAll([
                'khach_hang_id' => $content->uid,
                'active' => 1
            ]);
            return [
                'success' => true,
                'content' => $hopDongs,
            ];
        }else
            return $check;
    }
//  get-tien-dien
    public function actionGetTienDien()
    {
        $toiDa = CauHinh::findOne(['ghi_chu'=>'so_dien_toi_da'])->content;
        $soDau = intval($_POST['soDau']);
        $soCuoi = intval($_POST['soCuoi']);
        $soTieuThu = 0;
        $tienDien = 0;
        if ($soCuoi < $soDau){
            $soTieuThu = ($toiDa - $soDau) + $soCuoi;
        }else{
            $soTieuThu = $soCuoi - $soDau;
        }
        $bangGia = GiaDien::findOne($_POST['bangGiaID']);

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
        $phaiTra = (int)((float)$tienDien * 1.08);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'tienDien' => $phaiTra
        ];
    }
//  thue-ngan-han
    public function actionThueNganHan()
    {
        $searchModel = new QuanLyPhongSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $toanhaids = ArrayHelper::map(
            \backend\models\DanhMuc::find()->andWhere('parent_id is null and active = 1')->all(),
            'id',
            'name'
        );
        return $this->render('thue-ngan-han/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'toanhaids' => $toanhaids
        ]);
    }
//  mo-phong
    public function actionMoPhong()
    {
        $phongIDs = $_POST['phongID'];
        $phongs = [];
        foreach ($phongIDs as $phongID){
            $phongs[$phongID] = DanhMuc::findOne($phongID)->name;
        }
        $gios = [];
        for ($i = 0; $i <= 23; $i++){
            $gios[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        $phuts = [];
        for ($i = 0; $i <= 59; $i++){
            $phuts[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "Mở phòng",
            'content'=>$this->renderAjax('thue-ngan-han/mo-phong', [
                'phongs' => $phongs,
                'gios' => $gios,
                'phuts' => $phuts
            ])
        ];
    }
//  dong-phong
    public function actionDongPhong()
    {
        $phongIDs = $_POST['phongID'];
        $phongs = [];
        foreach ($phongIDs as $phongID){
            $phongs[$phongID] = DanhMuc::findOne($phongID)->name;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "Đóng phòng",
            'content'=>$this->renderAjax('thue-ngan-han/dong-phong', [
                'phongs' => $phongs
            ])
        ];
    }
//  get-khach-hang
    public function actionGetKhachHang(){
        $sdt = \Yii::$app->request->get('query');
        $khachs = User::find()->where('dien_thoai LIKE :sdt',[':sdt' => "%{$sdt}%"])->limit(10)->all();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $khachs;
    }
    //get-form-thong-tin
    public function actionGetFormThongTin()
    {
        $oCungs = [];
        if ($_POST['id']!=-1){
            $oCungs = NguoiOCung::find()->andFilterWhere(['hop_dong_id' => $_POST['id']])->all();
        }
        $goi = $_POST['goi'];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($goi == 'thang'){
            return [
                'success' => true,
                'content' => $this->renderPartial('thong-tin-dai-han', [
                    'oCungs' => $oCungs
                ])
            ];
        }
        return [
            'success' => true,
            'content' => ''
        ];
    }
    public function actionGetLichDat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $phong = DanhMuc::findOne($_POST['id']);
        $hopDongs = QuanLyPhongKhach::find()
            ->andFilterWhere(['phong_id'=>$phong->id])
            ->andFilterWhere(['!=','trang_thai',PhongKhach::HOAN_THANH])
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
            'success' => true,
            'result' => $result
        ];
    }
    public function actionHoanThanh()
    {
        $hopDong = PhongKhach::findOne($_POST['id']);
        $loai = trim($_POST['loai']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($hopDong)){
            $hopDong->afterHoanThanh($loai);
            return [
                'success' => true,
                'content' => 'Xác nhận hợp đồng '.$hopDong->ma_hop_dong.' đã kết thúc'
            ];
        }
        return [
            'success' => false,
            'content' => 'Không tìm thấy hợp đồng'
        ];
    }
    //xoá ảnh hợp đồng
    public function actionXoaAnhJson()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $hopDongId = $_POST['hopDongID'] ?? null;
        $loai = $_POST['loai'] ?? null;
        $fileName = $_POST['fileName'] ?? null;

        $hopDong = PhongKhach::findOne($hopDongId);

        if (is_null($hopDong)) {
            return [
                'success' => false,
                'content' => 'Không tìm thấy hợp đồng',
            ];
        }

        $fileAnhs = json_decode($hopDong->$loai, true) ?? [];

        if (!in_array($fileName, $fileAnhs)) {
            return [
                'success' => false,
                'content' => 'Không tìm thấy ảnh trong danh sách',
            ];
        }

        // Xóa file vật lý
        $filePath = dirname(dirname(__DIR__)) . '/hinh-anh/' . $fileName;
        if (file_exists($filePath) && $fileName != 'no-image.jpg') {
            if (!unlink($filePath)) {
                return [
                    'success' => false,
                    'content' => 'Không thể xóa file vật lý',
                ];
            }
        }

        // Xóa khỏi mảng và cập nhật lại JSON
        $updatedFiles = array_filter($fileAnhs, function($file) use ($fileName) {
            return $file !== $fileName;
        });

        $hopDong->$loai = json_encode(array_values($updatedFiles));
        if ($hopDong->save(false)) {
            $url = CauHinh::findOne(['ghi_chu' => 'no_image'])->content;
            $urlNoImage = "<img  class='example-image img-responsive' src=".$url."\" width='100%'>";
            return [
                'success' => true,
                'content' => 'Xóa ảnh thành công',
                'noImage' => $urlNoImage,
            ];
        }
        return [
            'success' => false,
            'content' => 'Không thể lưu hợp đồng sau khi cập nhật danh sách ảnh',
        ];
    }

}
