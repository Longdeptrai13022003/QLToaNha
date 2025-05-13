<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietDonHang;
use backend\models\DiaChiNhanHang;
use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\KhieuNai;
use backend\models\QuanLyChiTietDonHang;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyKhachHang;
use backend\models\QuanLyKhieuNai;
use backend\models\QuanLyTrangThaiDonHang;
use backend\models\QuanLyUser;
use backend\models\search\QuanLyDonHangSearch;
use backend\models\ThongBao;
use backend\models\TrangThaiDonHang;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;

//
/**
 * QuanLyDonHangController implements the CRUD actions for ThucHienCongViec model.
 */
class QuanLyDonHangController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'gio-hang', 'update-gio-hang', 'save-ghi-chu-chi-tiet-don-hang', 'get-list-chi-tiet-don-hang',
            'index', 'save-ghi-chu-don-hang', 'delete-don-hang', 'checkout',
            'huy-don-hang', 'delete-chi-tiet-don-hang', 'chi-tiet-don-hang', 'chon-don-hang', 'get-don-hang-da-chon',
            'xoa-don-hang-da-chon', 'luu-trang-thai-don-hang-loat', 'sua-ma-van-don', 'change-status-don-hang',
            'sua-khoi-luong', 'update-ma-van-don', 'update-khoi-luong', 'update-phi-mua-ho', 'update-phi-ship-noi-dia',
            'thanh-toan-them-don-hang', 'luu-thanh-toan-them', 'tai-ket-qua-tim-kiem', 'create', 'save', 'update-don-hang',
            'hoan-tien-don-hang', 'yeu-cau-giao-hang', 'get-list-khieu-nai', 'save-khieu-nai', 'get-list-don-hang-khieu-nai',
            'dong-khieu-nai', 'xoa-gio-hang-thanh-vien-khac','chon-thanh-toan', 'get-don-hang-thanh-toan', 'thanh-toan-gio-hang',
            'chon-chi-tiet-don-hang', 'change-quantity-don-hang', 'xoa-don-hang-da-chon-de-thanh-toan'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('QuanLyDonHang', $action_name, $this->contentAPI->uid);
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
                        return \Yii::$app->user->id == 1 || myAPI::isAccess2('QuanLyDonHang', $action_name);
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

    /**
     * Lists all ThucHienCongViec models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        $searchModel = new QuanLyDonHangSearch();

        if(isset($this->contentAPI->uid)){
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                Yii::$app->response->format = Response::FORMAT_JSON;

                $dataProvider = $searchModel->search($queryParams, $this->contentAPI);
                $dataProvider->setPagination(['page' => $this->contentAPI->data->page, 'pageSize' => 10]);

//          $dataProvider->setSort(
//              [
//                  'defaultOrder' => ['created' => SORT_DESC]
//              ]
//          );
//          $dataProvider->setPagination([]);
                $data = $dataProvider->getModels();
                return [
                    'success' => true,
                    'content' =>  $data,
                    'roles' => '',//ArrayHelper::map(UserVaiTro::findAll(['user_id' => $this->contentAPI->uid]), 'vai_tro', 'vai_tro'),
                    'loadMore' => ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount()
                ];
            }else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
        }
        else{
            if(isset($_POST['exportExcel'])){
                if(Yii::$app->session->get('params_DonHang'))
                    $searchModel->attributes = Yii::$app->session->get('params_DonHang');

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination = false;
                $data = $dataProvider->getModels();

                $content = $this->renderPartial('_ket_qua_tim_kiem', [
                    'data' => $data,
                    'title' => 'BÁO CÁO ĐƠN HÀNG',
                    'type' => 'Đơn hàng'
                ]);
                $fileName = 'DANH_SACH_DON_HANG_'.date("Y-m-d-His").'.html';
                file_put_contents(dirname(dirname(__DIR__)).'/file_don_hang/'.$fileName, $content);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'link_file' => CauHinh::findOne(['ghi_chu' => 'domain'])->content.'/file_don_hang/'.$fileName
                ];
            }
            else{
                if(isset($_GET['QuanLyDonHangSearch']))
                    Yii::$app->session->set('params_DonHang', $_GET['QuanLyDonHangSearch']);
                else{
                    if(Yii::$app->session->get('params_DonHang'))
                        $searchModel->attributes = Yii::$app->session->get('params_DonHang');
                }

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                if(myAPI::checkOnlyRule(VaiTro::KHACH_HANG, Yii::$app->user->id))
                    return $this->render('khach-hang/index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                else
                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
            }

        }
    }

    public function actionCreate()
    {
        $userId = Yii::$app->user->id;
        $request = Yii::$app->request;
        $model = new DonHang();
        $khach_hang = ArrayHelper::map(QuanLyUser::find()->andFilterWhere(['hoat_dong'=>1,'vai_tro' => 'Khách hàng'])->andWhere(['<>', 'hoten', 'chưa đăng ký tài khoản'])->all(),'id','hoten');

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'khach_hang' => $khach_hang
            ]);
        }

    }

    //huy-don-hang
    public function actionHuyDonHang(){
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        $curentUser = User::findOne($this->contentAPI->uid);

        if(!isset($this->contentAPI->uid)){
            $id = $_POST['idDonHang'];
            $uid = Yii::$app->user->id;
        }
        else{
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if(!$check['success'])
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
            $id = $this->contentAPI->idDonHang;
            $uid = $this->contentAPI->uid;
        }

        $donHang = DonHang::findOne($id);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($donHang->user_id == $uid || User::isViewAll($uid)){
            if($donHang->trang_thai != DonHang::CHO_XAC_NHAN && $donHang->trang_thai != DonHang::DON_HANG_CHO && $donHang->trang_thai != DonHang::CHO_MUA)
                return ['success' => false, 'content' => 'Chỉ huỷ đơn hàng chờ'];
            else {
                $trangThaiDonHang = new TrangThaiDonHang();
                $trangThaiDonHang->don_hang_id = $donHang->id;
                $trangThaiDonHang->trang_thai = DonHang::DA_HUY;
                $trangThaiDonHang->ghi_chu = $this->contentAPI->ghiChu;
                $trangThaiDonHang->user_id = $this->contentAPI->uid;

                $trangThaiDonHang->save();
                $donHang->updateAttributes(['trang_thai' => DonHang::DA_HUY]);

                $strThongBao[] = 'Huỷ đơn hàng '.$donHang->id.' thành công';

                $khachHang = User::findOne($donHang->user_id); // user_load($donHang->uid);
                if($donHang->da_thanh_toan > 0){
                    $soTienDaThanhToan = $donHang->da_thanh_toan;
                    if($soTienDaThanhToan > 0){
                        // Tạo giao dịch Hoàn tiền vào ví cho khách
                        $giaoDich = new GiaoDich();
                        $fields = [
                            'khach_hang_id' => $donHang->user_id,
                            'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                            'loai_giao_dich' => GiaoDich::HOAN_TIEN_DON_HANG,
                            'tong_tien' => $soTienDaThanhToan,
                            'so_tien_giao_dich' => $soTienDaThanhToan,
                            'don_hang_lien_quan_id' => $donHang->id,
                            'user_id' => $this->contentAPI->uid,
                            'ghi_chu' => 'Huỷ đơn hàng',
                            'active' => 1
                        ];
                        foreach ($fields as $field => $value)
                            $giaoDich->{$field} = $value;

                        $giaoDich->save();
                        $giaoDich->updateAttributes(['ma_giao_dich' => 'HT'.$giaoDich->id]);

                        // Cộng tiền vào ví khách hàng
                        $khachHang->updateAttributes(['vi_dien_tu' => $khachHang->vi_dien_tu + $soTienDaThanhToan]);

                        // Thông báo tới khách hàng có phát sinh giao dịch hoàn tiền thành công
                        $noiDungThongBao = 'Bạn được hoàn lại '.number_format($soTienDaThanhToan, 0, '', '.').' VNĐ vào ví';
                        $modelThongBao = new ThongBao();
                        $modelThongBao->nguoi_nhan_thong_bao_id = $donHang->user_id;
                        $modelThongBao->da_xem = 0;
                        $modelThongBao->route = 'don-hang';
                        $modelThongBao->params = $donHang->id;
                        $modelThongBao->ghi_chu = $noiDungThongBao;
                        $modelThongBao->user_id = $this->contentAPI->uid;
                        $modelThongBao->save();

                        $strThongBao[] = number_format($soTienDaThanhToan, 0, '', '.').' VNĐ được hoàn vào ví.';
                    }
//                    $hoTenKH = isset($khachHang->field_ho_ten['und']) ? $khachHang->field_ho_ten['und'][0]['value'] : $khachHang->name;
//                    $dienThoaiKH = isset($khachHang->field_dien_thoai['und']) ? $khachHang->field_dien_thoai['und'][0]['value'] : '';

                    myAPI::sendMessNotiForOneUser($khachHang->id, 'HUỶ ĐƠN ORDER '.$donHang->id, implode("\n", $strThongBao));
                    myAPI::guiThongBaoLoiDenQuanTriVien('HUỶ ĐƠN ORDER '.$donHang->id, implode("\n", $strThongBao));
                    myAPI::sendMail(implode('<br/>', [
                        implode("\n", $strThongBao),
                        '<strong>Người thực hiện: </strong>'.($curentUser->hoten),
                        '<strong>Mã đơn: </strong>Order'.$donHang->id,
                        '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                        '<strong>ĐT Khách hàng: </strong>'.$khachHang->dien_thoai,
                    ]), 'Huỷ đơn '.$donHang->id);

                    return (['success' => true, 'content' => implode(' ', $strThongBao)]);
                }
                else{
                    myAPI::sendMessNotiForOneUser($khachHang->id, 'HUỶ ĐƠN '.$donHang->id, implode("\n", $strThongBao));
                    myAPI::guiThongBaoLoiDenQuanTriVien('HUỶ ĐƠN ORDER '.$donHang->id, implode("\n", $strThongBao));
                    myAPI::sendMail(implode('<br/>', [
                        implode("\n", $strThongBao),
                        '<strong>Người thực hiện: </strong>'.($curentUser->hoten),
                        '<strong>Mã đơn: </strong> Order'.$donHang->id,
                        '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                        '<strong>ĐT Khách hàng: </strong>'.$khachHang->dien_thoai,
                    ]), '['.myAPI::PREFIX_NAME_SYSTEM.'] Huỷ đơn hàng '.$donHang->id);

                    return ([
                        'success'=> true,
                        'content' => implode("\n", $strThongBao)
                    ]);
                }
            }
        }else
            return [
                'success' => false,
                'content' => 'Bạn không có quyền thực hiện việc này'
            ];
    }

//    //xem-chi-tiet-don-hang-va-giao-dich
//  public function actionXemChiTietDonHangVaGiaoDich(){
//    $this->contentAPI = json_decode(file_get_contents('php://input'));
//
//    if(!isset($this->contentAPI->uid)){
//      $id = $_POST['quan_ly_don_hang_id'];
//      $uid = Yii::$app->user->id;
//    }
//    else{
//      $check = myAPI::checkBeforeAction($this->contentAPI);
//      if(!$check['success'])
//      {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        return $check;
//      }
//      $id = $this->contentAPI->data->id;
//      $uid = $this->contentAPI->uid;
//    }
//
//    $donHang = DonHang::findOne($id);
//    Yii::$app->response->format = Response::FORMAT_JSON;
//
//    if($donHang->user_id == $uid || User::isViewAll($uid)){
//      $lichSuTrangThai = TrangThaiDonHang::findAll(['don_hang_id' => $id]);
//      foreach ($lichSuTrangThai as $index => $item) {
//        $lichSuTrangThai[$index]['user_id'] = User::findOne($item->user_id)->hoten;
//      }
//
//      $results = [
//        'chiTietDonHang' => ChiTietDonHang::findAll(['don_hang_id' => $id]),
//        'lichSuTrangThai' => $lichSuTrangThai,
//        'model' => $donHang
//      ];
//      return [
//        'success' => true,
//        'content' => isset($this->contentAPI->uid) ? $results : $this->renderAjax('_view', $results),
//        'title' => 'Chi tiết đơn hàng '.$donHang->id
//      ];
//    }else
//      return [
//        'success' => false,
//        'content' => 'Bạn không có quyền thực hiện việc này'
//      ];
//  }

    //gio-hang
    public function actionGioHang(){
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        $searchModel = new QuanLyDonHangSearch();

        if(isset($this->contentAPI->uid)){
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $check = myAPI::checkBeforeAction($this->contentAPI);

            if($check['success']){
                $dataProvider = $searchModel->searchGioHang($queryParams, $this->contentAPI);
                Yii::$app->response->format = Response::FORMAT_JSON;
                $dataProvider->setPagination(['page' => isset($this->contentAPI->data) ? $this->contentAPI->data->page : 0, 'pageSize' => 10]);

//          $dataProvider->setPagination([]);
                $data = $dataProvider->getModels();

                $gioHang = [];
                $thongTinKhachHang = [];
                /** @var QuanLyDonHang $item */
                foreach ($data as $item){
                    if(!isset($thongTinKhachHang[$item->user_id_goc])){
                        $khachHang = User::findOne($item->user_id_goc);
                        $thongTinKhachHang[$item->user_id_goc] = [
                            'uid' => $khachHang->user_old_id,
                            'hoTen' => $khachHang->hoten,
                            'dienThoai' => $khachHang->dien_thoai,
                            'username' => $khachHang->username,
                        ];
                    }
                    $gioHangItem = $item;
                    if(is_null($gioHangItem->shop_name))
                        $gioHangItem->shop_name = '';

                    $gioHang[] = [
                        'donHang' => $gioHangItem,
                        'chiTietDonHang' => QuanLyChiTietDonHang::findAll(['don_hang_id' => $item->id]),
                        'thongTinKhachHang' => $thongTinKhachHang[$item->user_id_goc],
                    ];
                }

                $nodeCauHinhPhiMuaHangHo = CauHinh::findOne(['ghi_chu' => 'phi_mua_ho'])->content;
                $data = explode('<br />', nl2br($nodeCauHinhPhiMuaHangHo));

                foreach ($data as $index => $item)
                    $data[$index] = trim($item);

                $firstRow = explode(':', $data[0]);

                return [
                    'dieuKienChiPhiMuaHangMacDinh' => doubleval($firstRow[0]),
                    'chiPhiMuaHangMacDinh' => doubleval($firstRow[1]),
                    'phanTramMuaHang' => intval($data[1]),
//                    'success' => true,
//                    'content' =>  $gioHang,
//                    'loadMore' => ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount()
                    'success' => true,
                    'content' =>  $gioHang,
                    'roles' => '',//ArrayHelper::map(UserVaiTro::findAll(['user_id' => $this->contentAPI->uid]), 'vai_tro', 'vai_tro'),
                    'loadMore' => isset($this->contentAPI->data) ? (
                        ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount()
                    ) : false,
                    'cauHinhChiPhiMuaHang' => $data
                ];
            }else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
        }
        else{
            if(isset($_POST['exportExcel'])){
                if(Yii::$app->session->get('params_GioHang'))
                    $searchModel->attributes = Yii::$app->session->get('params_GioHang');

                $dataProvider = $searchModel->searchGioHang(Yii::$app->request->queryParams);
                $dataProvider->pagination = false;
                $data = $dataProvider->getModels();

                $content = $this->renderPartial('gio-hang/_ket_qua_tim_kiem_gio_hang', [
                    'data' => $data,
                    'title' => 'BÁO CÁO GIỎ HÀNG',
                    'type' => 'Giỏ hàng'
                ]);
                $fileName = 'DANH_SACH_GIO_HANG_'.date("Y-m-d-His").'.html';
                file_put_contents(dirname(dirname(__DIR__)).'/file_don_hang/'.$fileName, $content);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'link_file' => CauHinh::findOne(['ghi_chu' => 'domain'])->content.'/file_don_hang/'.$fileName
                ];
            }
            else{
                if(isset($_GET['QuanLyDonHangSearch']))
                    Yii::$app->session->set('params_GioHang', $_GET['QuanLyDonHangSearch']);
                else{
                    if(Yii::$app->session->get('params_GioHang'))
                        $searchModel->attributes = Yii::$app->session->get('params_GioHang');
                }

                $dataProvider = $searchModel->searchGioHang(Yii::$app->request->queryParams);

                return $this->render('gio-hang/index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }
    }

    //update-gio-hang
    public function actionUpdateGioHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                if($content->data->checkAll == 'all'){
                    $donHangs = DonHang::findAll(
                        ['trang_thai' => DonHang::GIO_HANG, 'user_id' => $content->uid]
                    );

                    foreach ($donHangs as $item){
                        foreach ($item->chiTietDonHangs as $chiTietDonHang){
                            $chiTietDonHang->updateAttributes(['da_chon_de_thanh_toan' => $content->data->checked == true ? 1 : 0]);
                        }
                        $item->updateAttributes(['da_chon_de_thanh_toan' => $content->data->checked == true ? 1 : 0]);
                    }
                    return ([
                        'success' => true,
                        'content' => 'Cập nhật giỏ hàng thành công'
                    ]);
                }else{
                    // Cập nhật lại thông tin chi tiết đơn hàng
                    $donHangs = [];
                    foreach ($content->data->chiTietDonHang as $item){
                        $chiTietDonHang = ChiTietDonHang::findOne($item->nid); //ChiTiet();
                        if(!isset($donHangs[$chiTietDonHang->don_hang_id]))
                            $donHangs[$chiTietDonHang->don_hang_id] = DonHang::findOne($chiTietDonHang->don_hang_id);

//                    $tongTienCTDHCu += doubleval($chiTietDonHang->tong_tien_cny);
//                    $tongTienCTDHMoi += $item->tongTienCNY;
                        $tongTienVND = $item->soLuong * $chiTietDonHang->price_money * $donHangs[$chiTietDonHang->don_hang_id]->ty_gia;
                        $chiPhiMuaHo = QuanLyDonHang::getChiPhiMuaHang($tongTienVND);

//                    $phiMuaHo = QuanLyDonHang::getChiPhiMuaHang($tongTienCTDHCu)
                        $chiTietDonHang->updateAttributes([
                            'so_luong' => $item->soLuong,
                            'price_money' => $item->donGia,
                            'tong_tien_cny' => $item->soLuong * $chiTietDonHang->price_money, //$item->tongTienCNY,
                            'da_chon_de_thanh_toan' => $item->chonDeThanhToan,
                            'tong_tien' =>  $tongTienVND,//$item->tongTien,
                            'phi_mua_ho' => $chiPhiMuaHo['chiPhiMuaHang'],
                            'ty_le_mua_ho' => $chiPhiMuaHo['chiPhiTheoThangGiaTri']/100
                        ]);
                    }

                    // Cập nhật lại đơn hàng
                    foreach ($donHangs as $donHang){
                        $chiTietDonHang = ChiTietDonHang::findAll(['don_hang_id' => $donHang->id]);
                        $tongNDT = 0;
                        $soLuong = 0;
                        $sLDaChon = 0;
                        foreach ($chiTietDonHang as $itemCTDH){
                            $soLuong += $itemCTDH->so_luong;
                            $tongNDT += $itemCTDH->tong_tien_cny;
                            if($itemCTDH->da_chon_de_thanh_toan == 1)
                                $sLDaChon++;
                        }
                        $tongVND = $tongNDT * $donHang->ty_gia;
                        $chiPhiMuaHo = QuanLyDonHang::getChiPhiMuaHang($tongVND);

                        $donHang->updateAttributes([
                            'phi_mua_hang' => $chiPhiMuaHo['chiPhiMuaHang'],
                            'thanh_tien' => $tongVND + $chiPhiMuaHo['chiPhiMuaHang'],
                            'ti_le_phan_tram_mua_hang' => $chiPhiMuaHo['chiPhiTheoThangGiaTri'],
                            'tong_tien_cny' => $tongNDT,
//                        'da_chon_de_thanh_toan' => $item->daChonThanhToan,
                            'tong_tien' => $tongVND,
                            'tong_so_luong' => $soLuong,
                            'da_chon_de_thanh_toan' => ($sLDaChon == count($chiTietDonHang))
                        ]);
                    }

                    return ([
                        'success' => true,
                        'content' => 'Cập nhật giỏ hàng thành công'
                    ]);
                }

            }else
                return $check;
        }
        else
            return [
                'success' => false,
                'content' => 'Không có thông tin người dùng'
            ];
    }

    //save-ghi-chu-don-hang
    public function actionSaveGhiChuDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = myAPI::checkBeforeAction($this->contentAPI);
        if($check['success']){
            DonHang::updateAll(['ghi_chu' => $content->data->ghiChu], ['id' => $content->data->nid]);
            return ([
                'success' => true,
                'content' => 'Cập nhật ghi chú đơn hàng thành công!'
            ]);
        }else
            return $check;
    }

    //save-ghi-chu-chi-tiet-don-hang
    public function  actionSaveGhiChuChiTietDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = myAPI::checkBeforeAction($this->contentAPI);
        if($check['success']){
            ChiTietDonHang::updateAll(['notes' => $content->data->ghiChu], ['id' => $content->data->nid]);
            return ([
                'success' => true,
                'content' => 'Cập nhật ghi chú đơn hàng thành công!'
            ]);
        }else
            return $check;
    }

    //delete-don-hang
    public function actionDeleteDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        if(isset($content->uid)){
            $idDonHang = $content->data->nid;
            $uid = $content->uid;

            $check = myAPI::checkBeforeAction($this->contentAPI);
            if(!$check['success'])
                return $check;
        }else{
            $idDonHang = $_POST['idDonHang'];
            $uid = Yii::$app->user->id;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $donHang = DonHang::findOne($idDonHang);
        if(($donHang->user_id == $uid && ($donHang->trang_thai == DonHang::GIO_HANG)) || ($donHang->user_id == $uid && ($donHang->trang_thai == DonHang::CHO_MUA)) || ($donHang->user_id == $uid && ($donHang->trang_thai == DonHang::DON_HANG_CHO)) || User::isViewAll($uid)){
            $donHang->updateAttributes(['active' => 0]);
            return ([
                'success' => true,
                'title' => 'Thông báo',
                'content' => 'Xoá đơn hàng thành công'
            ]);
        }else
            return [
                'title' => 'Thông báo',
                'success' => false,
                'content' => 'Bạn không có quyền xoá đơn hàng này hoặc bạn chỉ được phép xoá đơn hàng trong giỏ hoặc đơn hàng chờ'
            ];
    }

    //delete-chi-tiet-don-hang
    public function actionDeleteChiTietDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = myAPI::checkBeforeAction($this->contentAPI);
        if($check['success']){
            $nodeChiTietDonHang = ChiTietDonHang::findOne($content->data->nid);
            $donHang = $nodeChiTietDonHang->donHang;

            if($donHang->user_id == $content->uid ||  User::isViewAll($content->uid)){
                $nodeChiTietDonHang->delete();
                $chiTietDonHangs = ChiTietDonHang::findAll(['don_hang_id' => $donHang->id]);

                // Đếm số lượng chi tiết đơn hàng còn lại.
                // Nếu số lượng = 0 thì xoá đơn hàng
                if(count($chiTietDonHangs) == 0){
                    TrangThaiDonHang::deleteAll(['don_hang_id' => $donHang->id]);
                    $donHang->delete();

                    return ([
                        'success' => true,
                        'content' => 'Xoá dữ liệu thành công'
                    ]);
                }
                // Ngược lại, tính toán lại các con số của đơn hàng
                else{
                    QuanLyDonHang::updateDonHang($donHang, $chiTietDonHangs);
                    return ([
                        'success' => true,
                        'content' => 'Xoá dữ liệu thành công'
                    ]);
                }
                // Duyệt lại đơn hàng
            }
            else
                return [
                    'success' => false,
                    'content' => ''
                ];
        }else
            return $check;
    }

    //Đặt hàng từ giỏ hàng vào đơn hàng chính thức
    public function actionCheckout(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = myAPI::checkBeforeAction($this->contentAPI);
        if($check['success']){
            $khachHang = User::findOne($content->uid);
            $viDienTu = $khachHang->vi_dien_tu;

            if($content->data->type == 'Đặt 1 đơn hàng'){
                $nodeDonHang = DonHang::findOne($content->data->nid);
                if($nodeDonHang->thanh_tien == 0)
                    return ([
                        'success' => false,
                        'content' => 'Vui lòng chọn ít nhất 1 sản phẩm'
                    ]);
                else{
                    // Kiểm tra ví của khách có đủ tiền không. Nếu không đủ thì thông báo bật lên y/c chuyển khoản số tiền
                    // tương đương thành tiền của 1 đơn hàng
                    if($viDienTu < $nodeDonHang->thanh_tien){
//          $responseThemGD = themGiaoDichNapTien($content, [$nodeDonHang->nid], intval($nodeDonHang->thanh_tien - $viDienTu));
                        // Sinh QrCode
//          sinhMaQR(
//            $responseThemGD['maGiaoDichMoi'],
//            intval($nodeDonHang->thanh_tien) - $viDienTu,
//          );
                        // Gửi email thông báo cho admin biết có khách đang đặt hàng  nhưng không đủ tiền
                        //node_load(5708)->ghi_chu
                        myAPI::sendMail(
                            implode('<br />', [
                                '<strong>Họ tên KH: </strong>'.$khachHang->hoten,
                                '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                                '<strong>Mã đơn hàng: </strong>'.$nodeDonHang->id,
                            ]),
                            '['.myAPI::PREFIX_NAME_SYSTEM.'] Có khách đặt hàng nhưng không đủ tiền'
                        );
                        return (['success' => false, 'content' => 'Ví của bạn ('.number_format($viDienTu, 0, '', '.').') không đủ tiền để thanh toán đơn hàng ('.number_format($nodeDonHang->thanh_tien, 0, '', '.').'), vui lòng truy cập chức năng Thêm > Nạp tiền để nạp tiền vào ví sau đó thực hiện lại chức năng này.']);
                    }
                    else{
                        //                 Lấy toàn bộ các đơn hàng có tổng tiền > 0 (đơn hàng được chọn để thanh toán)
                        $chiTietDonHang = QuanLyChiTietDonHang::find()
                            ->andFilterWhere(['user_id' => $content->uid])
//                    ->andWhere('thanh_tien > 0')
                            ->andFilterWhere(['trang_thai' => DonHang::GIO_HANG])
                            ->andFilterWhere(['don_hang_id' => $nodeDonHang->id])
//                            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
                            ->all();

                        return QuanLyDonHang::muaHang(
                            $chiTietDonHang,
                            $content,
                            $khachHang
                        );
                    }
                }
            }
            else{
//                 Lấy toàn bộ các đơn hàng có tổng tiền > 0 (đơn hàng được chọn để thanh toán)
                $chiTietDonHang = QuanLyChiTietDonHang::find()
                    ->andFilterWhere(['user_id_don_hang' => $content->uid])
//                    ->andWhere('thanh_tien > 0')
                    ->andFilterWhere(['trang_thai' => DonHang::GIO_HANG])
//                    ->andFilterWhere(['active' => 1])
                    ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
                    ->all();
                if(count($chiTietDonHang) == 0)
                    return ([
                        'success' => false,
                        'content' => 'Vui lòng chọn ít nhất 1 sản phẩm'
                    ]);
                else{
                    $tongTienCanThanhToan = 0;
                    $nids = [];
                    /** @var QuanLyChiTietDonHang $node */
                    foreach ($chiTietDonHang as $node) {
                        $nids[$node->don_hang_id] = $node->don_hang_id;
                        $tongTienCanThanhToan += intval($node->tong_tien);
                    }

                    if($viDienTu < $tongTienCanThanhToan){
//          $responseThemGD = themGiaoDichNapTien($content, $nids, $tongTienCanThanhToan - $viDienTu);
                        // Sinh QrCode
//          sinhMaQR($responseThemGD['maGiaoDichMoi'], intval($tongTienCanThanhToan - $viDienTu));\
                        myAPI::sendMail(
                            implode('<br />', [
                                '<strong>Họ tên KH: </strong>'.$khachHang->hoten,
                                '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                            ]),
                            'Có khách đặt hàng nhưng không đủ tiền'
                        );
                        myAPI::guiThongBaoLoiDenQuanTriVien('KH KHÔNG ĐỦ TIỀN THANH TOÁN ĐH', $khachHang->dien_thoai.' Không đủ tiền thanh toán đơn hàng');
                        return (['success' => false, 'content' => 'Ví của bạn không đủ để mua sản phẩm, vui lòng nạp thêm tiền']);
                    }
                    else{
                        return QuanLyDonHang::muaHang(
                            $chiTietDonHang,
                            $content,
                            $khachHang
                        );
                    }
                }
            }
        }else
            return $check;
    }

    //Thanh toán giỏ hàng trên web
    public function actionThanhToanGioHang()
    {
        $uid = Yii::$app->user->id;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $khachHang = User::findOne($uid);
        $viDienTu = $khachHang->vi_dien_tu;

        $chiTietDonHang = QuanLyChiTietDonHang::find()
            ->andFilterWhere(['user_id' => $uid])
            ->andFilterWhere(['trang_thai' => DonHang::GIO_HANG])
            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
            ->all();
        if(count($chiTietDonHang) == 0)
            return [
                'success' => false,
                'title' => 'Thông báo',
                'content' => 'Vui lòng chọn ít nhất 1 sản phẩm'
            ];
        else{
            $tongTienCanThanhToan = 0;
            $nids = [];
            /** @var QuanLyChiTietDonHang $node */
            foreach ($chiTietDonHang as $node) {
                $nids[$node->don_hang_id] = $node->don_hang_id;
                $tongTienCanThanhToan += intval($node->tong_tien);
            }
            if($viDienTu < $tongTienCanThanhToan){
                myAPI::sendMail(
                    implode('<br />', [
                        '<strong>Họ tên KH: </strong>'.$khachHang->hoten,
                        '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                    ]),
                    'Có khách đặt hàng nhưng không đủ tiền'
                );
                myAPI::guiThongBaoLoiDenQuanTriVien('KH KHÔNG ĐỦ TIỀN THANH TOÁN ĐH', $khachHang->dien_thoai.' Không đủ tiền thanh toán đơn hàng');
                return ['success' => false, 'content' => 'Ví của bạn không đủ để mua sản phẩm, vui lòng nạp thêm tiền'];
            }
            else{
                return QuanLyDonHang::muaHang(
                    $chiTietDonHang,
                    '',
                    $khachHang
                );
            }
        }
    }

    //chi-tiet-don-hang
    public function actionChiTietDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($content);
            if(!$check['success'])
                return $check;
            $uid = $content->uid;
            $id = $content->nid;
        }
        else{
            $uid = Yii::$app->user->id;
            $id = $_POST['idDonHang'];
        }

        $node = QuanLyDonHang::findOne(['id' => $id]);
        if($node->user_id == $uid || User::isViewAll($uid)){
            $data = [
                'nid' => $node->id,
                'field_shop_name' => $node->shop_name,
                'field_tong_so_luong' => $node->tong_so_luong,
                'field_khoi_luong' => $node->khoi_luong,
                'field_tong_tien_cny' => $node->tong_tien_cny,
                'field_ship_noi_dia_vnd' => $node->ship_noi_dia_vnd,
                'field_chiet_khau_tien_hang' => $node->chiet_khau_tien_hang,
                'field_tien_hang_chiet_khau' => $node->tien_hang_chiet_khau,
                'field_tong_tien' => $node->tong_tien,
                'field_phi_van_chuyen_hang' => $node->phi_van_chuyen_hang,
                'field_dvt_khoi_luong' => $node->dvt_khoi_luong,
                'field_phi_kiem_dem' => null, //$node->phi_kiem_dem,
                'field_phi_dong_go' => $node->phi_dong_go,
                'field_phi_mua_hang' => $node->phi_mua_hang,
                'field_thanh_tien' => $node->thanh_tien,
                'field_so_tien_da_thanh_toan' => $node->da_thanh_toan,
                'field_trang_thai' => $node->trang_thai,
                'field_anh_don_hang' => $node->anh_don_hang,
                'field_phi_khoi_luong' => $node->phi_khoi_luong,
                'field_ma_kien_hang' => $node->ma_kien_hang,
                'field_ma_van_don' => $node->ma_van_don,
                'field_can_nang_tinh_phi' => $node->can_nang_tinh_phi,
                'ngay_dat_hang' => $node->created,
                'diaChiNhanHang' => [
                    'field_ho_ten' => $node->ho_ten_nguoi_nhan,
                    'field_dien_thoai' => $node->dien_thoai_nguoi_nhan,
                    'field_dia_chi' => $node->thong_tin_dia_chi
                ]
            ];

            if(isset($content->uid))
                return ([
                    'success' => true,
                    'content' =>  $data,
                ]);
            else
                return [
                    'title' => 'Thông tin đơn hàng #'.$node->id,
                    'content' => $this->renderAjax('_view', [
                        'data' => QuanLyDonHang::findOne(['id' => $node->id]),
                        'chiTietDonHang' => QuanLyChiTietDonHang::findAll(['don_hang_id' => $node->id]),
                        'lichSuThanhToan' => QuanLyGiaoDich::findAll(['don_hang_lien_quan_id' => $node->id]),
                        'trangThaiDonHang' => QuanLyTrangThaiDonHang::findAll(['don_hang_id' => $node->id])
                    ])
                ];
        }else
            return [
                'success' => false,
                'content' => 'Bạn không có quyền xem đơn hàng này'
            ];
    }

    //xoa-gio-hang-thanh-vien-khac
    public function actionXoaGioHangThanhVienKhac(){
        $uid = Yii::$app->user->id;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rows = Yii::$app->request->post('rows', []);
        if(empty($rows))
        {
            return[
                'success' => false,
                'content' => 'Chưa chọn giỏ hàng để xóa'
            ];
        }
        else{
            foreach ($rows as $item)
            {
                $gioHang = DonHang::findOne($item);
                if($gioHang->user_id == $uid || User::isViewAll($uid))
                {
                    $gioHang->updateAttributes([
                        'active' => 0
                    ]);
                }
                else
                    return[
                        'success' => false,
                        'content' => 'Bạn chỉ được phép giỏ hàng của bạn!'
                    ];
            }
            return ['success' => true];
        }
    }

    //get-list-chi-tiet-don-hang
    public function actionGetListChiTietDonHang(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($content);
            if(!$check['success'])
                return $check;
            $uid = $content->uid;
            $id = $content->nidDonHang;
        }
        else{
            $uid = Yii::$app->user->id;
            $id = $_POST['idDonHang'];
        }

        if($check['success']){
            // danh sách chi tiết đơn hàng
            $chiTietDonHang = QuanLyChiTietDonHang::findAll(['don_hang_id' => $id]);

            // Danh sách giao dịch liên quan đến đơn hàng
            $danhSachGiaoDich = QuanLyGiaoDich::findAll(['don_hang_lien_quan_id' => $id]);

            // Danh sách trạng thái đơn hàng
            $danhSachTrangThaiDonHang = QuanLyTrangThaiDonHang::findAll(['don_hang_id' => $id]);

            return [
                'success' => true,
                'content' => [
                    'chiTietDonHang' => $chiTietDonHang,
                    'danhSachGiaoDich' => $danhSachGiaoDich,
                    'danhSachTrangThaiDonHang' => $danhSachTrangThaiDonHang
                ]
            ];
        }else
            return $check;
    }

    //change-status-don-hang
    public function actionChangeStatusDonHang(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        if(!is_null($donHang)){
            $donHang->updateAttributes(['trang_thai' => $_POST['trangThaiMoi']]);

            $trangThaiDonHang = new TrangThaiDonHang();
            $trangThaiDonHang->don_hang_id = $donHang->id;
            $trangThaiDonHang->trang_thai = $_POST['trangThaiMoi'];
            $trangThaiDonHang->user_id = Yii::$app->user->id;
            $trangThaiDonHang->save();

            myAPI::sendMessNotiForOneUser($donHang->user_id, myAPI::PREFIX_NAME_SYSTEM.' - Trạng thái đơn hàng', 'Trạng thái đơn hàng '.$donHang->id.' chuyển sang trạng thái '.$_POST['trangThaiMoi']);

            return  [
                'success' => true,
                'content' => 'Thay đổi trạng thái đơn hàng thành công'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn hàng'
            ];
    }

    //change-quantity-don-hang
    public function actionChangeQuantityDonHang()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chiTietDonHang = ChiTietDonHang::findOne($_POST['idDonHang']);
        $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
        if(!is_null($chiTietDonHang)){
            $chiTietDonHang->updateAttributes([
                'so_luong' => $_POST['soLuong'],
                'tong_tien_cny' => $_POST['soLuong'] * $chiTietDonHang->price_money,
                'tong_tien' => $_POST['soLuong'] * $chiTietDonHang->price_money * $donHang->ty_gia,
            ]);
//            $tongTienChiTietDH = $chiTietDonHang->tong_tien;
//            $chiPhi = QuanLyDonHang::getChiPhiMuaHang($tongTienChiTietDH);
//            $chiTietDonHang->updateAttributes([
//                'phi_mua_ho' => $chiPhi['chiPhiMuaHang']
//            ]);

            $chiTietDH = ChiTietDonHang::findAll(['don_hang_id' => $donHang->id]);
            $tongNDT = 0;
            $soLuong = 0;
            foreach ($chiTietDH as $itemCTDH){
                $soLuong += $itemCTDH->so_luong;
                $tongNDT += $itemCTDH->tong_tien_cny;
            }
            $tongVND = $tongNDT * $donHang->ty_gia;
            $chiPhiMuaHo = QuanLyDonHang::getChiPhiMuaHang($tongVND);

            $donHang->updateAttributes([
                'phi_mua_hang' => $chiPhiMuaHo['chiPhiMuaHang'],
                'thanh_tien' => $tongVND + $chiPhiMuaHo['chiPhiMuaHang'],
                'ti_le_phan_tram_mua_hang' => $chiPhiMuaHo['chiPhiTheoThangGiaTri'],
                'tong_tien_cny' => $tongNDT,
                'tong_tien' => $tongVND,
                'tong_so_luong' => $soLuong,
            ]);

            //Tính lại tổng tiền giỏ hàng
            $chiTietDonHangDaChon =  ChiTietDonHang::find()->select(['tong_tien', 'don_hang_id', 'phi_mua_ho'])
                ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
                ->andFilterWhere(['user_id' => Yii::$app->user->id])
                ->all();
            $totalAmount = 0;
            foreach ($chiTietDonHangDaChon as $chiTietDonHang) {
                $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
                if($donHang->active == 1 && $donHang->trang_thai == 'Giỏ hàng')
                    $totalAmount += $chiTietDonHang->tong_tien;
            };
            if($totalAmount != 0)
                $totalAmount  += $donHang->phi_mua_hang;
            $totalAmount = number_format($totalAmount,0,'','.');
            return ['totalAmount' => $totalAmount];
        }else
            return [
                'success' => false,
            ];
    }

    //update-ma-van-don
    public function actionUpdateMaVanDon(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        if(!is_null($donHang)){
            $donHang->updateAttributes(['ma_van_don' => $_POST['maVanDon']]);

            return  [
                'success' => true,
                'content' => 'Thay đổi MVĐ thành công'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn hàng'
            ];
    }

    //update-khoi-luong
    public function actionUpdateKhoiLuong(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        if(!is_null($donHang)){
            $khoiLuong = floatval($_POST['khoiLuong']);
            $phiKhoiLuong = (new DonHang())->tinhPhiKhoiLuong($khoiLuong);
            $donHang->updateAttributes([
                'khoi_luong' => $khoiLuong,
                'phi_khoi_luong' => $phiKhoiLuong,
                'thanh_tien' => $donHang->thanh_tien - $donHang->phi_khoi_luong + $phiKhoiLuong
            ]);

            return  [
                'success' => true,
                'content' => 'KL đã được cập nhật.'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn hàng'
            ];
    }

    //update-phi-mua-ho
    public function actionUpdatePhiMuaHo(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        if(!is_null($donHang)){
            $donHang->updateAttributes([
                'phi_mua_hang' => intval($_POST['chiPhiMuaHo']),
                'thanh_tien' => $donHang->thanh_tien - $donHang->phi_mua_hang + intval($_POST['chiPhiMuaHo'])
            ]);

            return  [
                'success' => true,
                'content' => 'Phí mua hộ đã được cập nhật.'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn hàng'
            ];
    }

    //chon-don-hang
    public function actionChonDonHang(){
        $donHang = DonHang::findOne($_POST['idDonHang']);
        $donHang->updateAttributes(['da_chon_thuc_hien_chuc_nang' => !$donHang->da_chon_thuc_hien_chuc_nang]);
    }

    //chon-thanh-toan
    public function actionChonThanhToan(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        $chiTietDonHang = ChiTietDonHang::find()->where(['don_hang_id' => $_POST['idDonHang']])->all();
        $donHang->updateAttributes(['da_chon_de_thanh_toan' => !$donHang->da_chon_de_thanh_toan]);
        foreach ($chiTietDonHang as $chiTietDH)
        {
            $chiTietDH->updateAttributes (['da_chon_de_thanh_toan' => $donHang->da_chon_de_thanh_toan]);
        }

        //Tính lại tổng tiền giỏ hàng
        $chiTietDonHangDaChon =  ChiTietDonHang::find()->select(['tong_tien', 'don_hang_id', 'phi_mua_ho'])
            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
            ->andFilterWhere(['user_id' => Yii::$app->user->id])
            ->all();
        $totalAmount = 0;
        foreach ($chiTietDonHangDaChon as $chiTietDonHang) {
            $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
            if($donHang->active == 1 && $donHang->trang_thai == 'Giỏ hàng')
                $totalAmount += $chiTietDonHang->tong_tien;
        };
        if($totalAmount != 0)
            $totalAmount  += $donHang->phi_mua_hang;
        $totalAmount = number_format($totalAmount,0,'','.');
        return ['totalAmount' => $totalAmount];
    }

    //chon-chi-tiet-don-hang
    public function actionChonChiTietDonHang(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chiTietDonHang = ChiTietDonHang::findOne($_POST['idDonHang']);
        $chiTietDonHang->updateAttributes (['da_chon_de_thanh_toan' => !$chiTietDonHang->da_chon_de_thanh_toan]);
        if($chiTietDonHang->da_chon_de_thanh_toan == 0)
        {
            $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
            $donHang->updateAttributes(['da_chon_de_thanh_toan' => 0]);
        }

        //Tính lại tổng tiền giỏ hàng
        $chiTietDonHangDaChon =  ChiTietDonHang::find()->select(['tong_tien', 'don_hang_id', 'phi_mua_ho'])
            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
            ->andFilterWhere(['user_id' => Yii::$app->user->id])
            ->all();
        $totalAmount = 0;
        foreach ($chiTietDonHangDaChon as $chiTietDonHang) {
            $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
            if($donHang->active == 1 && $donHang->trang_thai == 'Giỏ hàng')
                $totalAmount += $chiTietDonHang->tong_tien;
        };
        if($totalAmount != 0)
            $totalAmount  += $donHang->phi_mua_hang;
        $totalAmount = number_format($totalAmount,0,'','.');
        return ['totalAmount' => $totalAmount];
    }

    //get-don-hang-da-chon
    public function actionGetDonHangDaChon(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHangDaChon =  DonHang::find()->select(['id'])
            ->andFilterWhere(['da_chon_thuc_hien_chuc_nang' => 1])
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['user_id' => Yii::$app->user->id])
            ->all();
        return ArrayHelper::map($donHangDaChon, 'id', 'id');
    }

    //get-don-hang-thanh-toan
    public function actionGetDonHangThanhToan(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chiTietDonHangDaChon =  ChiTietDonHang::find()->select(['tong_tien', 'don_hang_id', 'phi_mua_ho'])
            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
            ->andFilterWhere(['user_id' => Yii::$app->user->id])
            ->all();
        $totalAmount = 0;
        $da_tinh_phi_mua_hang = 0;
        foreach ($chiTietDonHangDaChon as $chiTietDonHang) {
            $donHang = DonHang::findOne($chiTietDonHang->don_hang_id);
            if($donHang->active == 1 && $donHang->trang_thai == 'Giỏ hàng')
                $totalAmount += $chiTietDonHang->tong_tien;
        };
        if($totalAmount != 0)
            $totalAmount  += $donHang->phi_mua_hang;
        $totalAmount = number_format($totalAmount,0,'','.');

        $donHangDaChon =  DonHang::find()->select(['id'])
            ->andFilterWhere(['da_chon_de_thanh_toan' => 1])
            ->andFilterWhere(['active' => 1])
            ->andFilterWhere(['user_id' => Yii::$app->user->id])
            ->all();
        return [
            'totalAmount' => $totalAmount,
            'donHangDaChon' => ArrayHelper::map($donHangDaChon, 'id', 'id'),
        ];
    }

    //xoa-don-hang-da-chon
    public function actionXoaDonHangDaChon(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        DonHang::updateAll(['da_chon_thuc_hien_chuc_nang' => 0], ['id' => $_POST['idDonHang']]);
    }

    //xoa-don-hang-da-chon-de-thanh-toan
    public function actionXoaDonHangDaChonDeThanhToan(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        DonHang::updateAll(['da_chon_de_thanh_toan' => 0], ['id' => $_POST['idDonHang']]);
        $chiTietDonHang = ChiTietDonHang::find()->where(['don_hang_id' => $_POST['idDonHang']])->all();
        foreach ($chiTietDonHang as $chiTietDH)
        {
            $chiTietDH->updateAttributes (['da_chon_de_thanh_toan' => 0]);
        }
    }

    //luu-trang-thai-don-hang-loat
    public function actionLuuTrangThaiDonHangLoat(){
        foreach ($_POST['don_hang'] as $item){
            $model = new TrangThaiDonHang();
            $model->trang_thai = $_POST['trang_thai'];
            $model->don_hang_id = $item;
            $model->user_id = Yii::$app->user->id;
            $model->save();

            DonHang::updateAll(['da_chon_thuc_hien_chuc_nang' => 0, 'trang_thai' => $_POST['trang_thai']], ['id' => $item]);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title' => 'Thông báo',
            'content' => 'Cập nhật trạng thái đơn hàng thành công'
        ];
    }

    //update-phi-ship-noi-dia
    public function actionUpdatePhiShipNoiDia(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        if(!is_null($donHang)){
            $donHang->updateAttributes([
                'ship_noi_dia_cny' => intval($_POST['chiPhiVanChuyen']),
                'ship_noi_dia_vnd' => intval($_POST['chiPhiVanChuyen']) * $donHang->ty_gia,
                'thanh_tien' => $donHang->thanh_tien - $donHang->ship_noi_dia_vnd + intval($_POST['chiPhiVanChuyen']) * $donHang->ty_gia
            ]);

            return  [
                'success' => true,
                'content' => 'Phí mua hộ đã được cập nhật.'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn hàng'
            ];
    }

    //luu-thanh-toan-them
    public function actionLuuThanhToanThem(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = DonHang::findOne($_POST['idDonHang']);
        // Kiểm tra số tiền thanh toán thêm <= số tiền cần thanh toán thì tiếp tục
        if(intval($_POST['soTienThanhToanThem']) <= intval($donHang->thanh_tien) - intval($donHang->da_thanh_toan)){
            // Kiểm tra trong ví khách hàng còn đủ tiền không. Nếu còn thì tiếp tục
            $khachHang = User::findOne($donHang->user_id);
            if(intval($khachHang->vi_dien_tu) >= intval($_POST['soTienThanhToanThem'])){
                // Tạo giao dịch thanh toán đơn hàng cho khách
                $model = new GiaoDich();
                $model->khach_hang_id = $donHang->user_id;
                $model->trang_thai_giao_dich = GiaoDich::THANH_CONG;
                $model->loai_giao_dich = GiaoDich::THANH_TOAN_DON_HANG;
                $model->tong_tien = intval($_POST['soTienThanhToanThem']);
                $model->active = 1;
                $model->so_tien_giao_dich = intval($_POST['soTienThanhToanThem']);
                $model->don_hang_lien_quan_id = $donHang->id;
                $model->user_id = Yii::$app->user->id;
                $model->created = date("Y-m-d H:i:s");
                $model->so_du_trong_vi = $khachHang->vi_dien_tu;
                if($model->save()){
                    // Trừ tiền khỏi ví khách hàng
                    $khachHang->updateAttributes([
                        'vi_dien_tu' => $khachHang->vi_dien_tu - intval($_POST['soTienThanhToanThem'])
                    ]);
                    //update lại số tiền đã thanh toán
                    $donHang->updateAttributes(['da_thanh_toan' => $donHang->da_thanh_toan + intval($_POST['soTienThanhToanThem'])]);

                    return [
                        'success' => true,
                        'content' => 'Thanh toán thêm đơn hàng thành công',
                        'title' => 'Thông báo'
                    ];
                }
                else
                    return [
                        'success' => false,
                        'content' => Html::errorSummary($model)
                    ];
            }
            else
                return [
                    'success' => false,
                    'content' => 'Số tiền trong ví khách hàng '.number_format($khachHang->vi_dien_tu, 0, '', '.').' không đủ để thanh toán thêm đơn hàng '.number_format(
                        number_format(intval($_POST['soTienThanhToanThem']), 0, '', '.')
                        ),
                    'title' => 'Thông báo'
                ];
        }
        else{
            return [
                'success' => false,
                'content' => 'Số tiền thanh toán thêm không lớn hơn '.number_format($donHang->thanh_tien - $donHang->da_thanh_toan,0, '', '.').' VNĐ',
                'title' => 'Thông báo'
            ];
        }

    }

    /**
     * @param $khoiLuong float
     * @param $donViTinh string
     * @param $line int
     * @return array
     */
    public function tinhPhiKhoiLuong($khoiLuong, $donViTinh, $line){
        if($line == DonHang::LINE_NHANH)
            $dataStr = CauHinh::findOne(['ghi_chu' => 'bang_gia_line_nhanh'])->content;
        else
            $dataStr = CauHinh::findOne(['ghi_chu' => 'bang_gia_line_cham'])->content;
        $data = explode('<br />', nl2br($dataStr));

        if($donViTinh == 'Khối')
            return [
                'cong_thuc' => $dataStr,
                'value' => $khoiLuong * doubleval(explode(':', $data[0])[1])
            ]; // -1:2500000
        else{
            for($i = count($data) - 1; $i > 0 ; $i--)
                if(doubleval(explode(':', $data[$i])[0]) < $khoiLuong)
                    return [
                        'cong_thuc' => $dataStr,
                        'value' => $khoiLuong * explode(':', $data[$i])[1]
                    ];
        }
        return [
            'cong_thuc' => $dataStr,
            'value' => 0
        ];
    }

    //update-don-hang
    public function actionUpdateDonHang(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        $strThongBao = [];
        if($check['success']){
            if(is_null($content->data->selectedLineVC))
                return ['success' => false, 'content' => 'Vui lòng chọn line vận chuyển'];

            $donHang = DonHang::findOne($content->data->nid);
            $khachHang = User::findOne($donHang->user_id);

            $tyGia = $donHang->ty_gia;
            $thanhTienDonHang = $donHang->thanh_tien;

//            $entityDonHang = entity_metadata_wrapper('node', $donHang);
            // Nếu trạng thái là Hoàn tất (Đã giao hàng) thì update ngày khiếu nại tối đa là + x ngày
            if($content->data->selectedTrangThai == 'Đã giao hàng'){
                $soNgayKhieuNaiToiDa = CauHinh::findOne(['ghi_chu' => 'so_ngay_khieu_nai_toi_da'])->content;
                $ngayKhieuNaiCuoiCung = strtotime("+{$soNgayKhieuNaiToiDa}days");
                $donHang->updateAttributes(['han_cuoi_khieu_nai' => date("Y-m-d", $ngayKhieuNaiCuoiCung)]);
                $strThongBao[] = 'Đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid.' đã được giao';
            }else{
                $donHang->updateAttributes(['han_cuoi_khieu_nai' => null]);
            }

            // Update trạng thái đơn hàng nếu có thay đổi
            if($donHang->trang_thai != $content->data->selectedTrangThai){
                $trangThaiDonHang = new TrangThaiDonHang();
                $trangThaiDonHang->user_id = $content->uid;
                $trangThaiDonHang->don_hang_id = $content->data->nid;
                $trangThaiDonHang->trang_thai = $content->data->selectedTrangThai;
                $trangThaiDonHang->save();

                $fieldsUpdateDonHang['trang_thai'] = $content->data->selectedTrangThai;

                $strThongBao[] = 'Đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid.' chuyển trạng thái '.$content->data->selectedTrangThai;
            }

            // Update phí vận chuyển nội địa
            $phiVCNoiDia = doubleval(str_replace(',', '', $content->data->phiVCNoiDia));
            if(doubleval($donHang->ship_noi_dia_cny) != $phiVCNoiDia){
                $thanhTienDonHang = $thanhTienDonHang - doubleval($donHang->ship_noi_dia_cny) * $tyGia + $phiVCNoiDia * $tyGia;
                $donHang->updateAttributes(['ship_noi_dia_cny' => $phiVCNoiDia, 'ship_noi_dia_vnd' => $phiVCNoiDia * $tyGia]);

                $strThongBao[] = 'Phí vận chuyển ĐH '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid.' được cập nhật';
            }

            // Update phí mua hàng
            $phiMuaHang = doubleval(str_replace(',', '', $content->data->phiMuaHang));
            if(doubleval($donHang->phi_mua_hang) != $phiMuaHang){
                $thanhTienDonHang = $thanhTienDonHang - doubleval($donHang->phi_mua_hang) + $phiMuaHang;
                $donHang->updateAttributes(['phi_mua_hang' => $phiMuaHang]);
                $strThongBao[] = 'Phí mua đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid.' được cập nhật';
            }
            $chietKhauTienHang = doubleval(str_replace(',', '', $content->data->chietKhauTienHang));

            // Update Chiết khấu tiền hàng
            $tienHang = doubleval($donHang->tong_tien);
            $tienChietKhau = $chietKhauTienHang;
            if($content->data->kieuChietKhauTienHang == '%')
                $tienChietKhau = $chietKhauTienHang * $tienHang / 100;
            else if($content->data->kieuChietKhauTienHang == 'NDT')
                $tienChietKhau = $chietKhauTienHang * $tyGia;
            $tienChietKhauCu = doubleval($donHang->tien_hang_chiet_khau);
            $thanhTienDonHang = $thanhTienDonHang + $tienChietKhauCu - $tienChietKhau;

            $fieldsUpdateDonHang = [
                // Update Mã vận đơn
                'ma_van_don' => $content->data->maVanDon,
                'chiet_khau_tien_hang' => $chietKhauTienHang,
                'kieu_chiet_khau_tien_hang' => $content->data->kieuChietKhauTienHang,
                'tien_hang_chiet_khau' => $tienChietKhau,
                'line_van_chuyen' => $content->data->selectedLineVC,
            ];


            // Update tuyến vận chuyển
//            $entityDonHang->field_line_van_chuyen->set($content->data->selectedLineVC);

            // Cộng lại tiền trong ví của khách sau khi chiết khấu
            // Tạo giao dịch rút tiền vs trạng thái chờ xác minh
            // Nếu có biến động về chiết khấu thì lưu lại lịch sử giao dịch
            if($tienChietKhau - $tienChietKhauCu != 0){
                $giaoDich = new GiaoDich();
                $fieldsGiaoDich = [
                    'khach_hang_id' => $khachHang->id,
                    'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                    'active' => 1,
                    'so_tien_giao_dich' => $tienChietKhau,
                    'loai_giao_dich' => GiaoDich::HOAN_TIEN_DON_HANG,
                    'tong_tien' => $tienChietKhau - $tienChietKhauCu,
                    'ghi_chu' => 'Chiết khấu đơn hàng',
                    'user_id' => $content->uid,
                    'don_hang_lien_quan_id' => $donHang->id,
                ];
                foreach ($fieldsGiaoDich as $fieldGD => $valueGD)
                    $giaoDich->{$fieldGD} = $valueGD;
                if($giaoDich->save()){
                    $giaoDich->updateAttributes(['ma_giao_dich' => 'HTDH'.sprintf('%02d',$giaoDich->id)]);
                }

                $viDienTu = intval($khachHang->vi_dien_tu);
                $viDienTu = $viDienTu - $tienChietKhauCu + $tienChietKhau;
                $khachHang->updateAttributes(['vi_dien_tu' => $viDienTu]);

                // Lưu thông báo đã chiết khấu tiền hàng
                $thongBaoChietKhau = 'Đơn hàng '.$donHang->id.' được chiết khấu và hoàn lại '.number_format($tienChietKhau, 0, '', '.').' VNĐ vào ví';
                $thongBao = new ThongBao();
                $fieldThongBao = [
                    'ghi_chu' => $thongBaoChietKhau,
                    'nguoi_nhan_thong_bao_id' => $khachHang->id,
                    'da_xem' => 0,
                    'route' => 'chi-tiet-don-hang',
                    'params' => $donHang->id,
                    'user_id' => $content->uid
                ];
                foreach ($fieldThongBao as $fieldTB => $valueTB)
                    $thongBao->{$fieldTB} = $valueTB;
                $thongBao->save();
                $strThongBao[] = $thongBaoChietKhau;
            }

            // Update khối lượng và chi phí khối lượng theo tuyến
            if($donHang->khoi_luong != $content->data->khoiLuong)
                $strThongBao[] = 'Khối lượng ĐH '.myAPI::PREFIX_NAME_SYSTEM.$donHang->id.' được cập nhật';

            $khoiLuong = doubleval(str_replace(',', '', $content->data->khoiLuong));
            $fieldsUpdateDonHang['khoi_luong'] = $khoiLuong;
            $fieldsUpdateDonHang['da_nhap_khoi_luong'] = 1;
            $fieldsUpdateDonHang['dvt_khoi_luong'] = $content->data->donViTinhKhoiLuong == '' ? 'kg' : $content->data->donViTinhKhoiLuong;

            $resultPhiKhoiLuong = $this->tinhPhiKhoiLuong($khoiLuong, $content->data->donViTinhKhoiLuong, $content->data->selectedLineVC);
            $phiKhoiLuongCu = doubleval($donHang->phi_khoi_luong);
            $thanhTienDonHang = $thanhTienDonHang - $phiKhoiLuongCu + $resultPhiKhoiLuong['value'];

            $fieldsUpdateDonHang['thanh_tien']  = $thanhTienDonHang;
            $fieldsUpdateDonHang['phi_khoi_luong']  = $resultPhiKhoiLuong['value'];
            $fieldsUpdateDonHang['cong_thuc_khoi_luong']  = $resultPhiKhoiLuong['cong_thuc'];

            $donHang->updateAttributes($fieldsUpdateDonHang);

            // Gửi thông báo cho khách hàng biết về nội dung này
            if(count($strThongBao) > 0){
                myAPI::sendMessNotiForOneUser($khachHang->id, 'CẬP NHẬT ĐH '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid, $strThongBao);

                $filedsThongBao = [
                    'nguoi_nhan_thong_bao_id' => $khachHang->id,
                    'da_xem' => 0,
                    'route' => '',
                    'ghi_chu' => implode("\n", $strThongBao),
                    'user_id' => $content->uid,
                    'title' => 'CẬP NHẬT ĐH '.myAPI::PREFIX_NAME_SYSTEM.$content->data->nid
                ];
                $thongBaoModel = new ThongBao();
                foreach ($filedsThongBao as $field => $value)
                    $thongBaoModel->{$field} = $value;
                $thongBaoModel->save();
            }
            return ([
                'success' => true,
                'content' => 'Lưu thông tin đơn hàng và trạng thái đơn hàng thành công!',
                'fields' => [
                    'tienHang' => $tienHang,
                    'thanhTienDonHang' => $thanhTienDonHang,
                    'tongCacChiPhi' => $resultPhiKhoiLuong['value'] + $phiMuaHang,
                    'tongGiaTriDon' => $thanhTienDonHang,
                    'field_phi_mua_hang' => $phiMuaHang,
                    'field_ship_noi_dia_vnd' => $phiVCNoiDia * $tyGia,
                    'field_tien_hang_chiet_khau' => $tienChietKhau,
                    'field_khoi_luong' => $khoiLuong,
                    'field_dvt_khoi_luong' => $content->data->donViTinhKhoiLuong,
                    'field_phi_khoi_luong' => $resultPhiKhoiLuong['value'],
                    'field_chiet_khau_tien_hang' => $chietKhauTienHang,
                    'field_kieu_chiet_khau_tien_hang' => $content->data->kieuChietKhauTienHang,
                    'field_trang_thai' => $content->data->selectedTrangThai,
                    'field_ma_van_don' => $content->data->maVanDon,
                    'field_line_van_chuyen' => $content->data->selectedLineVC,
                    'field_ship_noi_dia_cny' => $phiVCNoiDia,
                    'conThieu' => $thanhTienDonHang - doubleval($donHang->da_thanh_toan)
                ]
            ]);

        }
        else
            return $check;
    }

    //hoan-tien-don-hang
    public function actionHoanTienDonHang(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){

            if(!isset($content->data))
                return (['success' => false, 'content' => 'Vui lòng bổ sung thông tin đơn hàng']);
            else if(!isset($content->data->nid))
                return (['success' => false, 'content' => 'Vui lòng bổ sung thông tin đơn hàng']);
            else{
                if(trim($content->data->soTien) == '')
                    return (['success' => false, 'content' => 'Vui lòng nhập số tiền hoàn lại']);
                else{
                    $soTienGiaoDich = intval(str_replace(',','', trim($content->data->soTien)));

                    // Kiểm tra số tiền hoàn lại > số tiền đã thanh toán thì báo lỗi
                    $donHang = DonHang::findOne($content->data->nid); //node_load();
                    $soTienDaThanhToan = intval($donHang->da_thanh_toan);

                    // Cộng tiền vào ví của khách hàng
                    $khachHang = User::findOne($donHang->user_id); // user_load($donHang->uid);

                    if($soTienGiaoDich > $soTienDaThanhToan)
                        return (['success' => false, 'content' => 'Số tiền hoàn lại không được vượt quá '.number_format($soTienDaThanhToan, 0, '', '.').'VNĐ']);
                    else if($soTienGiaoDich <= 0)
                        return (['success' => false, 'content' => 'Vui lòng nhập số tiền giao dịch > 0']);
                    else{
                        $fields =  [
                            'khach_hang_id' => $khachHang->id,
                            'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                            'active' => 1,
                            'so_tien_giao_dich' => $soTienGiaoDich,
                            'loai_giao_dich' => GiaoDich::HOAN_TIEN_DON_HANG,
                            'tong_tien' => $soTienGiaoDich,
                            'ghi_chu' => 'Hoàn tiền đơn hàng '.$donHang->id,
                            'anh_giao_dich' => $content->data->hinhAnhChuyenKhoan,
                            'don_hang_lien_quan_id' => $donHang->id,
                            'user_id' => $content->uid
//              'field_url_anh_giao_dich' => 'https://app.order247.vip/anh-giao-dich/'.trim($maGiaoDich).'.jpg',
                        ];
                        $nodeGD = new GiaoDich();
                        foreach ($fields as $field => $value)
                            $nodeGD->{$field} = $value;
                        $nodeGD->save();
                        $nodeGD->updateAttributes([
                            'ma_giao_dich' => myAPI::PREFIX_NAME_SYSTEM.'HT'.$nodeGD->id,
                            'url_anh_giao_dich' => myAPI::LINK_SYSTEM.'/anh-giao-dich/'.myAPI::PREFIX_NAME_SYSTEM.'HT'.$nodeGD->id.'jpg'
                        ]);

                        myAPI::base64_to_jpeg(
                            $content->data->hinhAnhChuyenKhoan,
                            dirname(__DIR__, 2) .'/anh-giao-dich/'.myAPI::PREFIX_NAME_SYSTEM.'HT'.$nodeGD->id.'.jpg'
                        );

                        $viDienTu  = $khachHang->vi_dien_tu;
                        $khachHang->updateAttributes(['vi_dien_tu' => $viDienTu + $soTienGiaoDich]);

                        // Trừ tiền khỏi số tiền đã thanh toán trong đơn hàng của khách
                        $soTienHoanLaiCu = intval($donHang->so_tien_hoan_lai);
                        $donHang->updateAttributes([
                            'da_thanh_toan' => $soTienDaThanhToan - $soTienGiaoDich,
                            'so_tien_hoan_lai' => $soTienHoanLaiCu + $soTienGiaoDich
                        ]);

                        // Gửi thông báo hoàn tiền
                        $noiDungThongBao = 'Đơn hàng '.$donHang->id.' được hoàn '.number_format($soTienGiaoDich, 0, '', '.').' vào ví điện tử';
                        myAPI::sendMessNotiForOneUser($khachHang->id, 'HOÀN TIỀN ĐƠN HÀNG '.$donHang->id, $noiDungThongBao);
                        $filedsThongBao = [
                            'nguoi_nhan_thong_bao_id' => $khachHang->id,
                            'da_xem' => 0,
                            'route' => '',
                            'ghi_chu' => $noiDungThongBao,
                            'user_id' => $content->uid,
                            'title' => 'HOÀN TIỀN ĐƠN HÀNG '.$donHang->id
                        ];
                        $thongBaoModel = new ThongBao();
                        foreach ($filedsThongBao as $field => $value)
                            $thongBaoModel->{$field} = $value;
                        $thongBaoModel->save();

                        return (['success' => true, 'content' => 'Hoàn tiền đơn hàng '.($donHang->id).' thành công!']);
                    }
                }

            }

        }
        else
            return $check;

    }

    public function kiemTraDonHangTruocKhiGiao($uid, $nids){
        // Lấy danh sách địa chỉ giao hàng của khách hàng
        $diaChiNhanHangs = DiaChiNhanHang::findAll(['user_id' => $uid, 'active' => 1]);

        foreach ($diaChiNhanHangs as $item){
            $dataNodesDiaChiNhanHang[] = [
                'nid' => $item->id,
                'field_dia_chi' => $item->thong_tin_dia_chi, // isset($item->field_dia_chi['und']) ? $item->field_dia_chi['und'][0]['value']  : '',
                'field_ho_ten' =>  $item->ho_ten_nguoi_nhan, // isset($item->field_ho_ten['und']) ? $item->field_ho_ten['und'][0]['value'] : '',
                'field_dien_thoai' => $item->dien_thoai_nguoi_nhan, //isset($item->field_dien_thoai['und']) ? $item->field_dien_thoai['und'][0]['value'] : '',
                'field_ghi_chu' => $item->ghi_chu, // isset($item->field_ghi_chu['und']) ? $item->field_ghi_chu['und'][0]['value'] : '',
                'field_chon_mac_dinh' => $item->mac_dinh, /// isset($item->field_chon_mac_dinh['und']) ? $item->field_chon_mac_dinh['und'][0]['value'] : '',
            ];
        }
        $dataNodesDiaChiNhanHang[] = [
            'nid' => 0,
            'field_dia_chi' => '',
            'field_ho_ten' => '',
            'field_dien_thoai' => '',
            'field_ghi_chu' => '',
            'field_chon_mac_dinh' => '',
        ];

        // Phương thức vận chuyển
        $phuongThucVanChuyen = [DonHang::CHUYEN_PHAT_NHANH, DonHang::GUI_XE_KHACH];
        $donHangs = DonHang::find()->andFilterWhere(['in', 'id', $nids])->all();

        $tongTienChuaThanhToan = 0;
        /** @var DonHang $donHang */
        foreach ($donHangs as $donHang)
            $tongTienChuaThanhToan += (doubleval($donHang->thanh_tien) - doubleval($donHang->da_thanh_toan));
        $khachHang = User::findOne($uid);
        $viDienTu = intval($khachHang->vi_dien_tu);

        if($tongTienChuaThanhToan > 0){
            if($viDienTu < $tongTienChuaThanhToan){
                myAPI::sendMail(
                    implode('<br/>', [
                        'Khách hàng '.$khachHang->field_ho_ten['und'][0]['value'].' yêu cầu giao hàng nhưng không đủ tiền',
                        '<strong>Số tiền còn thiếu: </strong>'.number_format($tongTienChuaThanhToan, 0, '', '.'),
                        '<strong>Họ tên: </strong>'.$khachHang->field_ho_ten['und'][0]['value'],
                        '<strong>ĐT: </strong>'.$khachHang->field_dien_thoai['und'][0]['value']
                    ]),
                    '['.myAPI::PREFIX_NAME_SYSTEM.'] Y/C Giao hàng không đủ tiền'
                );

                return ([
                    'success' => true,
                    'content' => [
                        'thieuTienTrongVi' => true,
                        'message' => 'Số tiền trong ví của bạn ('.number_format($viDienTu, 0, '', '.').'đ) không đủ để thanh toán hết số tiền còn thiếu ('.number_format($tongTienChuaThanhToan, 0, '', '.').'đ) trước khi xác nhận yêu cầu giao hàng!. Vui lòng nạp tiền để tiếp tục thực hiện việc này.',
                        'phuongThucVanChuyen' => []
                    ]
                ]);
            }

            else{
                return ([
                    'success' => true,
                    'content' => [
                        'thieuTienTrongVi' => false,
                        'message' => 'Bạn cần thanh toán hết số tiền '.number_format($tongTienChuaThanhToan, 0, '', '.').'đ trước khi thực hiện việc này. Bằng việc xác nhận yêu cầu giao hàng, số tiền còn thiếu của bạn sẽ được trừ từ Ví điện tử!',
                        'phuongThucVanChuyen' => $phuongThucVanChuyen,
                        'dataNodesDiaChiNhanHang' => $dataNodesDiaChiNhanHang
                    ]
                ]);
            }
        }
        else
            return ([
                'success' => true,
                'content' => [
                    'tongTienChuaThanhToan' => $tongTienChuaThanhToan,
                    'field_vi_dien_tu' => $khachHang->vi_dien_tu,
                    'thieuTienTrongVi' => false,
                    'message' => '',
                    'phuongThucVanChuyen' => $phuongThucVanChuyen,
                    'dataNodesDiaChiNhanHang' => $dataNodesDiaChiNhanHang,
                ]
            ]);

    }

    //yeu-cau-giao-hang
    public function actionYeuCauGiaoHang(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){

            if(!isset($content->data))
                return (['success' => false, 'content' => 'Vui lòng chọn chức năng và đơn hàng']);
            else {
                if(count($content->data->donHangDaChons) == 0)
                    return (['success' => false, 'content' => '4 Vui lòng chọn ít nhất 1 đơn hàng']);
                else{
                    $arrNIDS = [];
                    // chức năng này chỉ dành cho khách hàng nên sẽ kiểm tra các đơn hàng đã chọn có phải của người đang đăng nhập không
                    foreach ($content->data->donHangDaChons as $item){
                        if($item->uid != $content->uid){
                            return (['success' => false, 'content' => 'Vui lòng chọn các đơn hàng của bạn']);
                        }
                        else if($item->trangThai != 'Đang ở VN'){
                            return (['success' => false, 'content' => 'Vui lòng chọn các đơn hàng đã Nhập kho VN']);
                        }
                        $arrNIDS[] = $item->nid;
                    }

                    // Kiểm tra các đơn hàng đã chọn, nếu chưa thanh toán hết tiền đơn hàng thì
                    // Kiểm tra trong ví còn đủ tiền thì thông báo số tiền còn thiếu sẽ được trừ từ ví
                    // Ngược lại yêu cầu nạp thêm tiền để thanh toán hết số tiền còn thiếu
                    // Trg hợp cuối cùng nếu đã thanh toán hết số tiền còn thiếu thì k cần thông báo gì thêm
                   return $this->kiemTraDonHangTruocKhiGiao($content->uid, $arrNIDS);
                }
            }

        }
        else
            return $check;

    }

    //get-list-khieu-nai
    public function actionGetListKhieuNai(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        $isQuanLy = User::isViewAll($content->uid);
        if($check['success']){
            if(!isset($content->nid))
                return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
            else{
                $khieuNaiForUser = QuanLyKhieuNai::find()->andFilterWhere(['field_active' => 1, 'field_don_hang_id' => $content->nid]);
                if(!$isQuanLy)
                    $khieuNaiForUser->andFilterWhere([ 'user_id' => $content->uid, ]);
                $nodes = $khieuNaiForUser->all();

                $data = [];
                /** @var QuanLyKhieuNai $node */
                foreach ($nodes as $node){
                    $data[] = [
                        'nguoiTao' => [
                            'hoTen' => $node->hoten,
                            'uid' => $node->user_id,
                            'quanLy' => User::isViewAll($node->user_id)
                        ],
                        'nid' => $node->id,
                        'field_noi_dung_khieu_nai' => $node->field_noi_dung_khieu_nai,
                        'field_anh_khieu_nai' => $node->field_anh_khieu_nai,
                        'created' => date("d/m/Y H:i", strtotime($node->created))
                    ];
                }
                return (['success' => true, 'content' => $data, 'quanLy' => $isQuanLy]);
            }
        }
        else
            return $check;
    }

    //save-khieu-nai
    public function actionSaveKhieuNai(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){

            if(!isset($content->data))
                return (['success' => false, 'content' => 'Không có dữ liệu khiếu nại để lưu']);
            else if(!isset($content->data->nid))
                return (['success' => false, 'content' => 'Không có dữ liệu đơn hàng']);
            else if(!isset($content->data->noiDungKhieuNai))
                return (['success' => false, 'content' => 'Không có nội dung khiếu nại']);
            else if(trim($content->data->noiDungKhieuNai) == '')
                return (['success' => false, 'content' => 'Không có nội dung khiếu nại']);
            else if(trim($content->data->nid) == '')
                return (['success' => false, 'content' => 'Không có dữ liệu đơn hàng']);
            else{
                $donHang = DonHang::findOne($content->data->nid);
                $tenAnhKhieuNai = 'RVKN'.time();
                $fileSaved = dirname(__DIR__, 2).'/anh-khieu-nai/'.trim($tenAnhKhieuNai).'.jpg';
                myAPI::base64_to_jpeg(
                    $content->data->hinhAnh,
                    $fileSaved
                );

                $modelKhieuNai = new KhieuNai();
                $fields =  [
                    'field_noi_dung_khieu_nai' => strval($content->data->noiDungKhieuNai),
                    'field_trang_thai_khieu_nai' => 'Đang mở',
                    'field_nguoi_nhap_phan_hoi' => $content->uid == $donHang->user_id ? 'Khách hàng' : 'Quản lý',
                    'field_don_hang_id' => $content->data->nid,
                    'field_anh_khieu_nai' => trim($content->data->hinhAnh) != '' ? CauHinh::findOne(['ghi_chu' => 'domain'])->content.'/anh-khieu-nai/'.trim($tenAnhKhieuNai).'.jpg' : '',
                    'user_id' => $content->uid
                ];
                foreach ($fields as $field => $value)
                    $modelKhieuNai->{$field} = $value;
                if($modelKhieuNai->save()){
                    $thoiGianPhanHoi = time();

                    $donHang->updateAttributes([
                        'field_noi_dung_khieu_nai' => strval($content->data->noiDungKhieuNai),
                        'field_trang_thai_khieu_nai' => 'Đang mở',
                        'field_nguoi_nhap_phan_hoi' => $content->uid == $donHang->user_id ? 'Khách hàng' : 'Quản lý',
                        'field_ngay_phan_hoi' => date("Y-m-d H:i:s", $thoiGianPhanHoi),
                    ]);

                    $hanCuoiKhieuNai = $donHang->han_cuoi_khieu_nai;
                    $trangThaiKhieuNai = $modelKhieuNai->field_trang_thai_khieu_nai;
                    return ([
                        'success' => true,
                        'content' => 'Nội dung khiếu nại / phản hồi đã được lưu lại thành công',
                        'thongTinKhieuNai' => [
                            'field_han_cuoi_khieu_nai' => date("d/m/Y", strtotime($hanCuoiKhieuNai)),
                            'choPhepKhieuNai' => ($hanCuoiKhieuNai >= date("Y-m-d") && $trangThaiKhieuNai == 'Đang mở') ? true : false,
                            'field_trang_thai_khieu_nai' => $trangThaiKhieuNai,

                            'field_noi_dung_khieu_nai' => $content->data->noiDungKhieuNai,
                            'field_nguoi_nhap_phan_hoi' => $content->uid == $donHang->user_id ? 'Khách hàng' : 'Quản lý',
                            'field_ngay_phan_hoi' => date("d/m/Y H:i", $thoiGianPhanHoi),
                            'loadingDongKhieuNai' => false
                        ]
                    ]);
                }else
                    return [
                        'success' => false,
                        'content' => strip_tags(Html::errorSummary($modelKhieuNai))
                    ];
            }

        }
        else
            return $check;
    }

    //get-list-don-hang-khieu-nai
    public function actionGetListDonHangKhieuNai(){
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        $searchModel = new QuanLyDonHangSearch();

        if(isset($this->contentAPI->uid)){
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                Yii::$app->response->format = Response::FORMAT_JSON;

                $dataProvider = $searchModel->searchDonHangKhieuNai($queryParams, $this->contentAPI);
                $dataProvider->setPagination(['page' => $this->contentAPI->data->page, 'pageSize' => 10]);
                $data = $dataProvider->getModels();

                $results = ['choPhepKhieuNai' => [], 'khongChoPhepKhieuNai' => []];
                /** @var QuanLyDonHang $node */
                foreach ($data as $node){
                    $hanCuoiKhieuNai = date("Y-m-d", strtotime($node->han_cuoi_khieu_nai));
                    $trangThaiKhieuNai = $node->field_trang_thai_khieu_nai == '' ? 'Đang mở' : $node->field_trang_thai_khieu_nai;

                    $donHangContent = [
                        'nid' => $node->id,
                        'field_shop_name' => $node->shop_name,
                        'field_tong_so_luong' => $node->tong_so_luong,
                        'field_khoi_luong' => $node->khoi_luong,
                        'field_tong_tien_cny' => $node->tong_tien_cny,
                        'field_tong_tien' => $node->tong_tien,
                        'field_phi_van_chuyen_hang' => $node->phi_van_chuyen_hang,
                        'field_phi_kiem_dem' => null, //$node->field_phi_kiem_dem['und'][0]['value'],
                        'field_phi_dong_go' => $node->phi_dong_go,
                        'field_phi_mua_hang' => $node->phi_mua_hang,
                        'field_chiet_khau_tien_hang' => $node->chiet_khau_tien_hang,
                        'field_ship_noi_dia_cny' => $node->ship_noi_dia_cny,
                        'field_kieu_chiet_khau_tien_hang' => $node->chiet_khau_tien_hang == '' ? '%' : $node->chiet_khau_tien_hang,
                        'field_ship_noi_dia_vnd' => $node->ship_noi_dia_vnd == '' ? 0 : $node->ship_noi_dia_vnd,
                        'field_thanh_tien' => $node->thanh_tien,
                        'field_tien_hang_chiet_khau' => $node->tien_hang_chiet_khau,
                        'field_so_tien_da_thanh_toan' => $node->da_thanh_toan,
                        'field_trang_thai' => $node->trang_thai,
                        'field_anh_don_hang' => strpos($node->anh_don_hang, '[') !== false ?
                            (count(json_decode($node->anh_don_hang)) > 0 ?
                                json_decode($node->anh_don_hang)[0] :
                                CauHinh::findOne(['ghi_chu' => 'no_image'])->content
                            )
                            : $node->anh_don_hang,
                        'field_phi_khoi_luong' => $node->phi_khoi_luong == '' ? 0 : $node->phi_khoi_luong,
                        'field_ma_kien_hang' => $node->ma_kien_hang,
                        'field_can_nang_tinh_phi' => $node->can_nang_tinh_phi,
                        'field_ma_van_don' => $node->ma_van_don,
                        'field_dvt_khoi_luong' => $node->dvt_khoi_luong == '' ? 'kg' : $node->dvt_khoi_luong,
                        'field_line_van_chuyen' => $node->line_van_chuyen == '' ? 7130 : $node->line_van_chuyen, // Line nhânh
                        'field_cong_thuc_khoi_luong' => is_null($node->cong_thuc_khoi_luong) ? '' : $node->cong_thuc_khoi_luong, //isset(['und']) ? $node->field_cong_thuc_khoi_luong['und'][0]['value'] : '',
                        'field_ngay_dat_hang' => date("d/m/Y", strtotime($node->created)),
                        'khachHang' => [
                            'uid' => $node->user_id,
                            'hoTen' => $node->hoten,
                            'dienThoai' => $node->dien_thoai,
                            'username' => $node->username
                        ],
                        'roles' => '', //$user->roles,
                        'diaChiNhanHang' => [
                            'field_ho_ten' => is_null($node->ho_ten_nguoi_nhan) ? '' : $node->ho_ten_nguoi_nhan,
                            'field_dien_thoai' => is_null($node->dien_thoai_nguoi_nhan) ? '' : $node->dien_thoai_nguoi_nhan,
                            'field_dia_chi' => is_null($node->thong_tin_dia_chi) ? '' : $node->thong_tin_dia_chi
                        ],
                        'thongTinKhieuNai' => [
                            'field_han_cuoi_khieu_nai' => date("d/m/Y", strtotime($hanCuoiKhieuNai)),
                            'choPhepKhieuNai' => ($hanCuoiKhieuNai >= date("Y-m-d") && $trangThaiKhieuNai == 'Đang mở') ? true : false,
                            'field_noi_dung_khieu_nai' => $node->field_noi_dung_khieu_nai,
                            'field_trang_thai_khieu_nai' => $trangThaiKhieuNai,
                            'field_nguoi_nhap_phan_hoi' => !is_null($node->field_nguoi_nhap_phan_hoi) ? $node->field_nguoi_nhap_phan_hoi : 'Khách hàng',
                            'field_ngay_phan_hoi' => $node->field_ngay_phan_hoi,
                            'loadingDongKhieuNai' => false
                        ]
                    ];

                    if($hanCuoiKhieuNai >= date("Y-m-d"))
                        $results['choPhepKhieuNai'][] = $donHangContent;
                    else
                        $results['khongChoPhepKhieuNai'][] = $donHangContent;
                }
                return [
                    'success' => true,
                    'content' =>  array_merge($results['choPhepKhieuNai'], $results['khongChoPhepKhieuNai']),
                    'roles' => '',//ArrayHelper::map(UserVaiTro::findAll(['user_id' => $this->contentAPI->uid]), 'vai_tro', 'vai_tro'),
                    'loadMore' => ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount(),
                ];
            }else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
        }
        else{
            if(isset($_POST['exportExcel'])){
                if(Yii::$app->session->get('params_DonHang'))
                    $searchModel->attributes = Yii::$app->session->get('params_DonHang');

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination = false;
                $data = $dataProvider->getModels();

                $content = $this->renderPartial('_ket_qua_tim_kiem', [
                    'data' => $data,
                    'title' => 'BÁO CÁO ĐƠN HÀNG',
                    'type' => 'Đơn hàng'
                ]);
                $fileName = 'DANH_SACH_DON_HANG_'.date("Y-m-d-His").'.html';
                file_put_contents(dirname(dirname(__DIR__)).'/file_don_hang/'.$fileName, $content);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'link_file' => CauHinh::findOne(['ghi_chu' => 'domain'])->content.'/file_don_hang/'.$fileName
                ];
            }
            else{
                if(isset($_GET['QuanLyDonHangSearch']))
                    Yii::$app->session->set('params_DonHang', $_GET['QuanLyDonHangSearch']);
                else{
                    if(Yii::$app->session->get('params_DonHang'))
                        $searchModel->attributes = Yii::$app->session->get('params_DonHang');
                }

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }

        }
    }

    //dong-khieu-nai
    public function actionDongKhieuNai(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            if(!isset($content->data))
                return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
            else if(!isset($content->data->nid))
                return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
            else{
                $nodeDonHang = DonHang::findOne($content->data->nid);
                $nodeDonHang->updateAttributes(['field_trang_thai_khieu_nai' => 'Đã đóng']);
                return ([
                    'success' => true,
                    'content' => 'Chức năng khiếu nại của đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$nodeDonHang->id.' đã đóng!'
                ]
                );
            }

        }
        else
            return $check;
    }
}
