<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietDonHang;
use backend\models\DanhMuc;
use backend\models\DiaChiNhanHang;
use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\KhieuNai;
use backend\models\KyGui;
use backend\models\QuanLyChiTietDonHang;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyDonKyGui;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyKhachHang;
use backend\models\QuanLyKhieuNai;
use backend\models\QuanLyTrangThaiDonHang;
use backend\models\QuanLyUser;
use backend\models\search\QuanLyDonHangSearch;
use backend\models\search\QuanLyDonKyGuiSearch;
use backend\models\ThongBao;
use backend\models\TrangThaiDonHang;
use backend\models\TrangThaiDonKyGui;
use backend\models\UserVaiTro;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;

//
/**
 * QuanLyDonKyGuiController implements the CRUD actions for ThucHienCongViec model.
 */
class QuanLyDonKyGuiController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = ['index', 'save-don-ky-gui', 'huy-don-hang-ky-gui', 'delete-don-ky-gui',
            'get-list-trang-thai-don-ky-gui', 'thanh-toan-them-nhieu-don-hang-ky-gui', 'yeu-cau-giao-hang-don-ky-gui',
            'change-status-don-ky-gui', 'xem-chi-tiet-don-ky-gui', 'chon-don-ky-gui', 'get-don-ky-gui-da-chon',
            'xoa-don-ky-gui-da-chon', 'luu-trang-thai-don-ky-gui-hang-loat', 'change-info-don-ky-gui',
            'hoan-tien-don-hang'];
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('QuanLyDonKyGui', $action_name, $this->contentAPI->uid);
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
                        return \Yii::$app->user->id == 1 || myAPI::isAccess2('QuanLyDonKyGui', $action_name);
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
        $searchModel = new QuanLyDonKyGuiSearch();
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
                $data = $dataProvider->getModels();

                $results = [];

                /** @var QuanLyDonKyGui $node */
                foreach ($data as $node){
                    $results[] = [
                        'nid' => $node->id,
                        'title' => 'KG'.$node->id,
                        'field_ghi_chu' => is_null($node->field_ghi_chu) ? '' : $node->field_ghi_chu,
                        'field_tong_tien' => is_null($node->field_tong_tien) ? 0 : $node->field_tong_tien,
                        'field_thanh_tien' => is_null($node->field_thanh_tien) ? 0 : $node->field_thanh_tien, //$node->,
                        'field_trang_thai' => $node->field_trang_thai,
                        'field_so_tien_da_thanh_toan' => is_null($node->field_so_tien_da_thanh_toan) ? 0 : $node->field_so_tien_da_thanh_toan, //isset($node->['und']) ? $node->field_so_tien_da_thanh_toan : 0,
                        'field_so_tien_hoan_lai' => is_null($node->field_so_tien_hoan_lai) ? 0 : $node->field_so_tien_hoan_lai, //isset($node->field_so_tien_hoan_lai['und']) ? $node->field_so_tien_hoan_lai : 0,
                        'field_khoi_luong' => is_null($node->field_khoi_luong) ? 0 : $node->field_khoi_luong, //$node->field_khoi_luong ?? null,
                        'field_ngay_dat_hang' => is_null($node->created) ? '' : date("d/m/Y H:i:s" ,strtotime($node->created)),
                        'field_tuyen_van_chuyen' => is_null($node->ten_tuyen_van_chuyen) ? '' : $node->ten_tuyen_van_chuyen,
                        'field_ma_van_don_ky_gui' => $node->field_ma_van_don_ky_gui,
                        'field_ma_khach' => '',
                        'line' => $node->line,
                        'field_ty_gia' => $node->field_ty_gia,
                        'kich_thuoc' => $node->kich_thuoc,
                        'phi_van_chuyen_noi_dia_ndt' => $node->phi_van_chuyen_noi_dia,
                        'phi_van_chuyen_noi_dia_vnd' => $node->phi_van_chuyen_noi_dia_vnd,
                        'field_hinh_anh' => is_null($node->field_hinh_anh) ? '' : $node->field_hinh_anh,
                        'field_co_anh' => $node->field_co_anh == 1,
                        'field_phi_can_nang' => is_null($node->field_phi_can_nang) ? 0 : $node->field_phi_can_nang,
                        'field_dvt_khoi_luong' => is_null($node->field_dvt_khoi_luong) ? '' : $node->field_dvt_khoi_luong,
                        'khachHang' => [
                            'uid' => $node->field_khach_hang_id,
                            'hoTen' => $node->ho_ten_khach_hang,
                            'dienThoai' => $node->dien_thoai_khach_hang,
                            'username' => $node->username_khach_hang,
                        ], //$thongTinKhachHangArr[$node->field_khach_hang['und'][0]['target_id']], // $thongTinKhachHangArr[$node->field_khach_hang['und'][0]['target_id']],
                        'tuyenVanChuyen' => is_null($node->ten_tuyen_van_chuyen) ? '' : $node->ten_tuyen_van_chuyen, //is_null($node->field_tuyen_van_chuyen_id) ? '' : $node->field_tuyen_van_chuyen_id,
                        'diaChiNhanHang' => !(is_null($node->field_dia_chi_nhan_hang_id) || $node->field_dia_chi_nhan_hang_id == '') ? [
                            'nid' => $node->field_dia_chi_nhan_hang_id,
                            'field_ho_ten' => $node->ho_ten_nguoi_nhan,
                            'field_dien_thoai' => $node->dien_thoai_nguoi_nhan,
                            'field_dia_chi' => $node->thong_tin_dia_chi
                        ] : [
                            'nid' => 0,
                            'field_ho_ten' => '',
                            'field_dien_thoai' => '',
                            'field_dia_chi' => '',
                        ]
                    ];
                }
                return [
                    'success' => true,
                    'content' =>  $results,
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
            if(isset($_GET['QuanLyDonKyGuiSearch']))
                Yii::$app->session->set('params_DonKyGui', $_GET['QuanLyDonKyGuiSearch']);
            else{
                if(Yii::$app->session->get('params_DonKyGui'))
                    $searchModel->attributes = Yii::$app->session->get('params_DonKyGui');
            }

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            if(myAPI::checkOnlyRule(VaiTro::KHACH_HANG, \Yii::$app->user->id))
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

    //save-don-ky-gui
    public function actionSaveDonKyGui(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){

                $user = User::findOne($content->uid);
                $strArrThongBao = ['Lưu đơn ký gửi thành công'];
                $strMaVanDonDaTonTai = [];

                if($content->data->nid > 0) {
                    $node = KyGui::findOne($content->data->nid);
                    $fields = [
                        'field_ghi_chu' => $content->data->ghiChu,
                        'field_ma_van_don_ky_gui' => $content->data->maVanDon,
                        'line' => $content->data->lineVanChuyen,
                    ];

                    $strThongBao = [];
                    if(User::isViewAll($content->uid)){
//                        if($content->data->maVanDon != '' && !is_null($content->data->maVanDon))
//                            $fields['field_tuyen_van_chuyen_id'] = $content->data->selectedTuyenVanChuyen;

                        if($node->field_trang_thai != $content->data->selectedTrangThai){
                            $fields['field_trang_thai'] = $content->data->selectedTrangThai;
                            $trangThaiDonHang = new TrangThaiDonKyGui();
                            $trangThaiDonHang->field_trang_thai = $content->data->selectedTrangThai;
                            $trangThaiDonHang->field_don_ky_gui_id = $node->id;
                            $trangThaiDonHang->user_id = $content->uid;
                            if($trangThaiDonHang->save())
                                $strArrThongBao[] = 'Đơn hàng KG'.$content->data->nid.' chuyển trạng thái '.$content->data->selectedTrangThai;
                            else
                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
                        }
                        $khoiLuong = floatval(str_replace(',', '', $content->data->khoiLuong));

                        if($content->data->khoiLuong != ''){
                            $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui($khoiLuong, $content->data->lineVanChuyen, $content->data->donViTinh); //tinhPhiKhoiLuong($khoiLuong, 'kg', 7131);// getCuocKhoiLuong();
                        }else
                            $phiCanNang = 0;

                        $fields['field_khoi_luong'] = floatval($content->data->khoiLuong);
                        $fields['field_phi_can_nang'] = $phiCanNang;
                        $fields['field_dvt_khoi_luong'] = $content->data->donViTinh;

                        $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;
                        $phiVanChuyenNoiDiaNDT = floatval(str_replace(',', '', $content->data->phiVanChuyenNoiDiaNDT));
                        $phiVanChuyenNoiDiaVND = $phiVanChuyenNoiDiaNDT * $tyGia;

                        $fields['kich_thuoc'] = $content->data->ghiChuKichThuoc;
                        $fields['phi_van_chuyen_noi_dia'] = $phiVanChuyenNoiDiaNDT;
                        $fields['phi_van_chuyen_noi_dia_vnd'] = $phiVanChuyenNoiDiaVND;

                        $fields['field_tong_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;
                        $fields['field_thanh_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;

//                        if($content->data->khoiLuong != $node->field_khoi_luong)
//                            $strArrThongBao[] = 'Khối lượng ĐH KG'.$node->id.' đã được cập nhật';
//                        if(count($strArrThongBao) == 0)
                        $strArrThongBao[] = 'Lưu thông tin đơn hàng thành công';
                    }
                    $node->updateAttributes($fields);

                    if(count($strArrThongBao) > 0){
                        myAPI::sendMessNotiForOneUser($node->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$content->data->nid, $strThongBao);
                        $modelThongBao = new ThongBao();
                        $modelThongBao->nguoi_nhan_thong_bao_id = $node->user_id;
                        $modelThongBao->da_xem = 0;
                        $modelThongBao->route = 'ky-gui';
                        $modelThongBao->params = $node->id;
                        $modelThongBao->ghi_chu = implode("\n", $strThongBao);
                        $modelThongBao->user_id = $content->uid;
                        $modelThongBao->save();
                    }
                }
                else{
//                    if((is_null($content->data->selectedTuyenVanChuyen) || $content->data->selectedTuyenVanChuyen == '') && User::isViewAll($content->uid)){
//                        return (['success' => false, 'content' => 'Vui lòng chọn tuyến vận chuyển']);
//                    }
//                    else
                    if(myAPI::isAccess([VaiTro::QUAN_LY_HE_THONG, VaiTro::QUAN_LY_KHO]) && (is_null($content->data->maKhach) || $content->data->maKhach == '') && ($content->data->nid == 0 || is_null($content->data->nid)))
                    {
                        return (['success' => false, 'content'  => 'Vui lòng nhập mã khách hàng']);
                    }
                    else{
                        if(count($content->data->dsKhoiLuong) == 0){
                            return (['success' => false, 'content' => 'Vui lòng nhập mã vận đơn']);
                        }
                        else {
                            if(User::isViewAll($content->uid)){
                                $khachHang = User::findOne(['user_old_id' => $content->data->maKhach]); //();
                                if(is_null($khachHang)){
                                    return (['success' => false, 'content' => 'Mã khách không tồn tại']);
                                }
                            }else
                                $khachHang = $user;

                            $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;

                            foreach ($content->data->dsKhoiLuong as $item){
                                $donHang = KyGui::findOne(['field_ma_van_don_ky_gui' => $item->name]);
                                // khách nhập thì k đc phép nhập mã vận đơn đã có trong hệ thống
                                if(!is_null($donHang)){
                                    if(!User::isViewAll($content->uid))
                                        $strMaVanDonDaTonTai[] = $item->name;
                                    else{
                                        if($donHang->field_trang_thai == KyGui::DON_HANG_CHO || $donHang->field_trang_thai == KyGui::DANG_O_VIET_NAM){
                                            $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui(
                                                floatval(str_replace(',', '', $item->khoiLuong)), //tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)), 'kg', 7131); //getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong))
                                                $content->data->lineVanChuyen
                                            ); //getPhiKhoiLuongDonKyGui();

                                            $donHang->updateAttributes([
                                                'field_ghi_chu' => $item->ghiChu,
                                                'field_ma_van_don_ky_gui' => $item->name,
                                                'field_khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
                                                'field_phi_can_nang' => $phiCanNang,
                                                'field_tong_tien' => $phiCanNang,
                                                'field_thanh_tien' => $phiCanNang,
                                                'field_trang_thai' => $content->data->selectedTrangThai //KyGui::DANG_O_VIET_NAM,
                                            ]);

                                            // Lưu lịch sử trạng thái đơn ký gửi
                                            $trangThaiDonHang = new TrangThaiDonKyGui();
                                            $trangThaiDonHang->field_trang_thai =  $content->data->selectedTrangThai; //KyGui::DANG_O_VIET_NAM,
                                            $trangThaiDonHang->field_don_ky_gui_id = $donHang->id;
                                            $trangThaiDonHang->user_id = $content->uid;
                                            if(!$trangThaiDonHang->save())
                                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
                                            else
                                                $strArrThongBao[] = 'Lưu đơn ký gửi thành công';
                                        }else
                                            return ['success' => false, 'content' => 'Không thể cập nhật thông tin MVĐ đã giao hoặc đang y/c giao hàng '.$item->name];
                                    }
                                }
                                else{
                                    // Kiểm tra có đơn mua hộ nào có mã vận đơn này chưa
                                    $donHang = DonHang::findOne(['ma_van_don' => $item->name]); //getNodeFromQuery($queryDonHangMuHo);

                                    if(!is_null($donHang)){
                                        $user = User::findOne($donHang->user_id);
                                        if($user->user_old_id != $content->data->maKhach)
                                            return ['success' => false, 'content' => 'Mã vận đơn '.$item->name.' không thuộc sở hữu của khách hàng có mã '.$content->data->maKhach];

                                        // Nếu là khách thì k đc phép nhập mã vận đơn đã tồn tại trong hệ thống
                                        if(!User::isViewAll($content->uid))
                                            $strMaVanDonDaTonTai[] = $item->name;
                                        else{
                                            // Ngược lại update trạng thái đã về kho VN
//                  if($donHang->field_trang_thai == DON_HANG_CHO || $donHang->field_trang_thai == DANG_O_KHO_VN){
                                            // Nếu là quản lý thì update lại thông tin khối lượng và ghi chú
                                            $lineVanChuyen = ($donHang->line_van_chuyen == 7130) ? 'bang_gia_line_cham' : 'bang_gia_line_nhanh'; //isset(['und']) ? $donHang->field_line_van_chuyen['und'][0]['target_id'] : 7131; // Mặc định là line chậm
                                            $fieldsDonHang = [
                                                'ghi_chu' => $item->ghiChu,
                                                'ma_van_don' => $item->name,
                                                'line' => $content->data->lineVanChuyen,
                                                'line_van_chuyen' => $content->data->lineVanChuyen == 'Line nhanh' ? 7130 : 7131,
                                                'khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
                                            ];

                                            $phiCanNang = (new KyGui())->tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)),
                                                'kg',
                                                $lineVanChuyen);

//                  $phiCanNang = getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)));
                                            $phiCanNangCu = $donHang->phi_khoi_luong;
                                            $fieldsDonHang['phi_khoi_luong'] = $phiCanNang;
                                            $tongTienCu = $donHang->thanh_tien;
                                            $fieldsDonHang['thanh_tien'] = $tongTienCu - $phiCanNangCu + $phiCanNang;
                                            $fieldsDonHang['trang_thai'] = $content->data->selectedTrangThai; //KyGui::DANG_O_VIET_NAM;
                                            $donHang->updateAttributes($fieldsDonHang);

                                            // Thêm lịch sử trạng thái cho đơn hàng về VN
                                            // Lưu thông tin trạng thái đơn hàng
                                            // Lưu lịch sử trạng thái đơn ký gửi
                                            $trangThaiDonHang = new TrangThaiDonHang();
                                            $trangThaiDonHang->trang_thai = KyGui::DANG_O_VIET_NAM;
                                            $trangThaiDonHang->don_hang_id = $donHang->id;
                                            $trangThaiDonHang->user_id = $content->uid;
                                            if(!$trangThaiDonHang->save())
                                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
                                        }
                                    }
                                    else{
                                        $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui(
                                            floatval(str_replace(',', '', $item->khoiLuong)),
                                            $content->data->lineVanChuyen
                                        ); //tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)), 'kg', 7131); //getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)));
                                        $phiVanChuyenNoiDiaVND = intval($item->phi_van_chuyen_noi_dia_ndt) * $tyGia;
                                            $fieldsDonHangKyGui = [
                                            'field_ma_van_don_ky_gui' => $item->name,
//                                            'field_tuyen_van_chuyen_id' => $content->data->selectedTuyenVanChuyen,
                                            'field_ghi_chu' => $item->ghiChu,
                                            // Nếu k có thông tin khách hàng => người nhập là khách hàng, k phải quản lý
                                            // thì trạng thái đơn là đơn chờ, ngược lại là đang ở VN
                                            'field_trang_thai' => $content->data->selectedTrangThai, //!User::isViewAll($content->uid) ? KyGui::DON_HANG_CHO : KyGui::DANG_O_VIET_NAM,
                                            'phi_van_chuyen_noi_dia' => $item->phi_van_chuyen_noi_dia_ndt,
                                            'phi_van_chuyen_noi_dia_vnd' => $phiVanChuyenNoiDiaVND,
                                            'field_tong_tien' => $phiVanChuyenNoiDiaVND,
                                            'field_thanh_tien' => $phiCanNang + $phiVanChuyenNoiDiaVND,
                                            'field_khach_hang_id' => $khachHang->id,
                                            'user_id' => $content->uid,
                                            'field_khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
                                            'field_dvt_khoi_luong' => 'kg', //$content->data->donViTinhKhoiLuong,
                                            'field_phi_can_nang' => $phiCanNang,
                                            'line' => $content->data->lineVanChuyen,
                                        ];

                                        $node = new KyGui();
                                        foreach ($fieldsDonHangKyGui as $field => $value)
                                            $node->{$field} = $value;
                                        $node->save();
                                        // Lưu lịch sử trạng thái đơn ký gửi (trong after Save)
                                    }
                                }
                            }

                            if(User::isViewAll($content->uid))
                                myAPI::sendMessNotiForOneUser($khachHang->id, 'ĐH KÝ GỬI CỦA BẠN ĐÃ ĐƯỢC CẬP NHẬT', 'Một số đơn ký gửi của bạn đã được cập nhật trạng thái, bạn có thể yêu cầu giao hàng.');
                            else {
                                myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA LÊN ĐƠN KÝ GỬI', 'Khách hàng '.$khachHang->dien_thoai.' vừa lên đơn ký gửi');
                                myAPI::sendMail(
                                    implode('<br />', [
                                        '<strong>Họ tên KH: </strong>'.$khachHang->hoten,
                                        '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                                    ]),
                                    'Khách hàng vừa lên đơn ký gửi'
                                );
                            }
                        }

                    }
                }
                return (['success' => true, 'content' => implode('. ', $strArrThongBao).(count($strMaVanDonDaTonTai) > 0 ? ' Mã vận đơn '.implode('. ', $strMaVanDonDaTonTai).' đã tồn tại' : '')]);
            }else
                return $check;
        }
        else{
            $uid = Yii::$app->user->id;
            $user = User::findOne($uid);
            $strArrThongBao = ['Lưu đơn ký gửi thành công'];
            $strMaVanDonDaTonTai = [];
            if(!isset($_POST['lineVC']) && !isset($_POST['dvtKhoiLuong']) && !isset($_POST['ghiChu']) && !isset($_POST['trangThai']) && !isset($_POST['khoiLuong']) && !isset($_POST['phiVCNoiDia']) && !isset($_POST['kichThuoc']))
            {
                $strThongBao = [];
                if(!is_null($_POST['idKyGui'])) {
                    $node = KyGui::findOne($_POST['idKyGui']);
                    $fields = [
                        'field_ma_van_don_ky_gui' => $_POST['maVanDon'],
                    ];
                    $node->updateAttributes($fields);
                    if(count($strArrThongBao) > 0){
                        myAPI::sendMessNotiForOneUser($node->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$_POST['idKyGui'], $strThongBao);
                        $modelThongBao = new ThongBao();
                        $modelThongBao->nguoi_nhan_thong_bao_id = $node->user_id;
                        $modelThongBao->da_xem = 0;
                        $modelThongBao->route = 'ky-gui';
                        $modelThongBao->params = $node->id;
                        $modelThongBao->ghi_chu = implode("\n", $strThongBao);
                        $modelThongBao->user_id = $uid;
                        $modelThongBao->save();
                    }
                }
                myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA CẬP NHẬT ĐƠN KÝ GỬI', 'Khách hàng '.$user->dien_thoai.' vừa cập nhật đơn ký gửi');
                myAPI::sendMail(
                    implode('<br />', [
                        '<strong>Họ tên KH: </strong>'.$user->hoten,
                        '<strong>Điện thoại: </strong>'.$user->dien_thoai,
                    ]),
                    'Khách hàng vừa cập nhật đơn ký gửi'
                );
                return (['success' => true,'title' => 'Thông báo', 'content' => implode('. ', $strArrThongBao)]);
            }
            if($_POST['lineVC'] == "")
                return (['success' => false,'title' => 'Thông báo', 'content' => 'Vui lòng chọn line vận chuyển']);
            if($_POST['dvtKhoiLuong'] == "")
                $_POST['dvtKhoiLuong'] = "Kg";
            if(!is_null($_POST['idKyGui'])) {
                $node = KyGui::findOne($_POST['idKyGui']);
                $fields = [
                    'field_ghi_chu' => $_POST['ghiChu'],
                    'field_ma_van_don_ky_gui' => $_POST['maVanDon'],
                    'line' => $_POST['lineVC'],
                ];

                $strThongBao = [];
                if(User::isViewAll($uid)){
//                        if($content->data->maVanDon != '' && !is_null($content->data->maVanDon))
//                            $fields['field_tuyen_van_chuyen_id'] = $content->data->selectedTuyenVanChuyen;

                    if($node->field_trang_thai != $_POST['trangThai']){
                        $fields['field_trang_thai'] = $_POST['trangThai'];
                        $trangThaiDonHang = new TrangThaiDonKyGui();
                        $trangThaiDonHang->field_trang_thai = $_POST['trangThai'];
                        $trangThaiDonHang->field_don_ky_gui_id = $node->id;
                        $trangThaiDonHang->user_id = $uid;
                        if($trangThaiDonHang->save())
                            $strArrThongBao[] = 'Đơn hàng KG'.$_POST['idKyGui'].' chuyển trạng thái '.$_POST['trangThai'];
                        else
                            return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
                    }
                    $khoiLuong = floatval(str_replace(',', '', $_POST['khoiLuong']));

                    if($_POST['khoiLuong'] != ''){
                        $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui($khoiLuong, $_POST['lineVC'], $_POST['dvtKhoiLuong']); //tinhPhiKhoiLuong($khoiLuong, 'kg', 7131);// getCuocKhoiLuong();
                    }else
                        $phiCanNang = 0;

                    $fields['field_khoi_luong'] = floatval($_POST['khoiLuong']);
                    $fields['field_phi_can_nang'] = $phiCanNang;
                    $fields['field_dvt_khoi_luong'] = $_POST['dvtKhoiLuong'];

                    $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;
                    $phiVanChuyenNoiDiaNDT = floatval(str_replace(',', '', $_POST['phiVCNoiDia']));
                    $phiVanChuyenNoiDiaVND = $phiVanChuyenNoiDiaNDT * $tyGia;

                    $fields['kich_thuoc'] = $_POST['kichThuoc'];
                    $fields['phi_van_chuyen_noi_dia'] = $phiVanChuyenNoiDiaNDT;
                    $fields['phi_van_chuyen_noi_dia_vnd'] = $phiVanChuyenNoiDiaVND;

                    $fields['field_tong_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;
                    $fields['field_thanh_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;

//                        if($content->data->khoiLuong != $node->field_khoi_luong)
//                            $strArrThongBao[] = 'Khối lượng ĐH KG'.$node->id.' đã được cập nhật';
//                        if(count($strArrThongBao) == 0)
                    $strArrThongBao[] = 'Lưu thông tin đơn hàng thành công';
                }
                $node->updateAttributes($fields);

                if(count($strArrThongBao) > 0){
                    myAPI::sendMessNotiForOneUser($node->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$_POST['idKyGui'], $strThongBao);
                    $modelThongBao = new ThongBao();
                    $modelThongBao->nguoi_nhan_thong_bao_id = $node->user_id;
                    $modelThongBao->da_xem = 0;
                    $modelThongBao->route = 'ky-gui';
                    $modelThongBao->params = $node->id;
                    $modelThongBao->ghi_chu = implode("\n", $strThongBao);
                    $modelThongBao->user_id = $uid;
                    $modelThongBao->save();
                }

                if(User::isViewAll($uid))
                    myAPI::sendMessNotiForOneUser($user->id, 'ĐH CỦA BẠN ĐANG Ở VN', 'Một số đơn ký gửi của bạn đang ở kho VN, bạn có thể yêu cầu giao hàng.');
                else {
                    myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA CẬP NHẬT ĐƠN KÝ GỬI', 'Khách hàng '.$user->dien_thoai.' vừa cập nhật đơn ký gửi');
                    myAPI::sendMail(
                        implode('<br />', [
                            '<strong>Họ tên KH: </strong>'.$user->hoten,
                            '<strong>Điện thoại: </strong>'.$user->dien_thoai,
                        ]),
                        'Khách hàng vừa cập nhật đơn ký gửi'
                    );
                }
            }
            return (['success' => true,'title' => 'Thông báo', 'content' => implode('. ', $strArrThongBao)]);
        }
    }

//    public function actionSaveDonKyGui(){
//        $content = json_decode(file_get_contents('php://input'));
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        if(isset($content->uid)){
//            $check = myAPI::checkBeforeAction($this->contentAPI);
//            if($check['success']){
//                $uid = $content->uid;
//                $nid = $content->data->nid;
//                $ghiChu = $content->data->ghiChu;
//                $maVanDon = $content->data->maVanDon;
//                $lineVanChuyen = $content->data->lineVanChuyen;
//                $trangThai = $content->data->selectedTrangThai;
//                $khoiLuongKG = $content->data->khoiLuong;
//                $dvt = $content->data->donViTinh;
//                $phiVanChuyenNoiDiaNDT = $content->data->phiVanChuyenNoiDiaNDT;
//                $ghiChuKichThuoc = $content->data->ghiChuKichThuoc;
//                $maKhach = $content->data->maKhach;
//                $dsKhoiLuong = $content->data->dsKhoiLuong;
//            }
//            else return $check;
//        }
//        else{
//            $uid = Yii::$app->user->id;
//            $nid = $_POST['idKyGui'];
//            $ghiChu = $_POST['ghiChu'];
//            $maVanDon = $_POST['maVanDon'];
//            if($_POST['lineVC'] != "")
//                $lineVanChuyen = $_POST['lineVC'];
//            else return (['success' => false,'title' => 'Thông báo', 'content'  => 'Vui lòng chọn line vận chuyển']);
//            $trangThai = $_POST['trangThai'];
//            $khoiLuongKG = $_POST['khoiLuong'];
//            if($_POST['dvtKhoiLuong'] != "")
//                $dvt = $_POST['dvtKhoiLuong'];
//            else $dvt ="Kg";
//            $phiVanChuyenNoiDiaNDT = $_POST['phiVCNoiDia'];
//            $ghiChuKichThuoc = $_POST['kichThuoc'];
//            $maKhach = $_POST['maKH'];
//        }
//        $user = User::findOne($uid);
//        $strArrThongBao = ['Lưu đơn ký gửi thành công'];
//        $strMaVanDonDaTonTai = [];
//
//        if($nid > 0) {
//            $node = KyGui::findOne($nid);
//            $fields = [
//                'field_ghi_chu' => $ghiChu,
//                'field_ma_van_don_ky_gui' => $maVanDon,
//                'line' => $lineVanChuyen,
//            ];
//
//            $strThongBao = [];
//            if(User::isViewAll($uid)){
//                if($node->field_trang_thai != $trangThai){
//                    $fields['field_trang_thai'] = $trangThai;
//                    $trangThaiDonHang = new TrangThaiDonKyGui();
//                    $trangThaiDonHang->field_trang_thai = $trangThai;
//                    $trangThaiDonHang->field_don_ky_gui_id = $node->id;
//                    $trangThaiDonHang->user_id = $uid;
//                    if($trangThaiDonHang->save())
//                        $strArrThongBao[] = 'Đơn hàng KG'.$nid.' chuyển trạng thái '.$trangThai;
//                    else
//                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
//                }
//                $khoiLuong = floatval(str_replace(',', '', $khoiLuongKG));
//
//                if($khoiLuongKG != ''){
//                    $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui($khoiLuong, $lineVanChuyen, $dvt); //tinhPhiKhoiLuong($khoiLuong, 'kg', 7131);// getCuocKhoiLuong();
//                }else
//                    $phiCanNang = 0;
//
//                $fields['field_khoi_luong'] = floatval($khoiLuongKG);
//                $fields['field_phi_can_nang'] = $phiCanNang;
//                $fields['field_dvt_khoi_luong'] = $dvt;
//
//                $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;
//                $phiVanChuyenNoiDiaNDT = floatval(str_replace(',', '', $phiVanChuyenNoiDiaNDT));
//                $phiVanChuyenNoiDiaVND = $phiVanChuyenNoiDiaNDT * $tyGia;
//
//                $fields['kich_thuoc'] = $ghiChuKichThuoc;
//                $fields['phi_van_chuyen_noi_dia'] = $phiVanChuyenNoiDiaNDT;
//                $fields['phi_van_chuyen_noi_dia_vnd'] = $phiVanChuyenNoiDiaVND;
//
//                $fields['field_tong_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;
//                $fields['field_thanh_tien'] = $phiCanNang + $phiVanChuyenNoiDiaVND;
//                $strArrThongBao[] = 'Lưu thông tin đơn hàng thành công';
//            }
//            $node->updateAttributes($fields);
//
//            if(count($strArrThongBao) > 0){
//                myAPI::sendMessNotiForOneUser($node->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$nid, $strThongBao);
//                $modelThongBao = new ThongBao();
//                $modelThongBao->nguoi_nhan_thong_bao_id = $node->user_id;
//                $modelThongBao->da_xem = 0;
//                $modelThongBao->route = 'ky-gui';
//                $modelThongBao->params = $node->id;
//                $modelThongBao->ghi_chu = implode("\n", $strThongBao);
//                $modelThongBao->user_id = $uid;
//                $modelThongBao->save();
//            }
//        }
//        else{
//            if(User::isViewAll($uid) && (is_null($maKhach) || $maKhach == '') && ($nid == 0 || is_null($nid)))
//            {
//                return (['success' => false, 'content'  => 'Vui lòng nhập mã khách hàng']);
//            }
//            else{
//                if(isset($dsKhoiLuong) && count($dsKhoiLuong) == 0){
//                    return (['success' => false, 'content' => 'Vui lòng nhập mã vận đơn']);
//                }
//                else {
//                    if(User::isViewAll($uid)){
//                        $khachHang = User::findOne($maKhach); //();
//                        if(is_null($khachHang)){
//                            return (['success' => false, 'content' => 'Mã khách không tồn tại']);
//                        }
//                    }else
//                        $khachHang = $user;
//
//                    $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;
//
//                    foreach ($dsKhoiLuong as $item){
//                        $donHang = KyGui::findOne(['field_ma_van_don_ky_gui' => $item->name]);
//                        // khách nhập thì k đc phép nhập mã vận đơn đã có trong hệ thống
//                        if(!is_null($donHang)){
//                            if(!User::isViewAll($uid))
//                                $strMaVanDonDaTonTai[] = $item->name;
//                            else{
//                                if($donHang->field_trang_thai == KyGui::DON_HANG_CHO || $donHang->field_trang_thai == KyGui::DANG_O_VIET_NAM){
//                                    $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui(
//                                        floatval(str_replace(',', '', $item->khoiLuong)), //tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)), 'kg', 7131); //getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong))
//                                        $item->line_van_chuyen
//                                    ); //getPhiKhoiLuongDonKyGui();
//
//                                    $donHang->updateAttributes([
//                                        'field_ghi_chu' => $item->ghiChu,
//                                        'field_ma_van_don_ky_gui' => $item->name,
//                                        'field_khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
//                                        'field_phi_can_nang' => $phiCanNang,
//                                        'field_tong_tien' => $phiCanNang,
//                                        'field_thanh_tien' => $phiCanNang,
//                                        'field_trang_thai' => KyGui::DANG_O_VIET_NAM,
//                                    ]);
//
//                                    // Lưu lịch sử trạng thái đơn ký gửi
//                                    $trangThaiDonHang = new TrangThaiDonKyGui();
//                                    $trangThaiDonHang->field_trang_thai = KyGui::DANG_O_VIET_NAM;
//                                    $trangThaiDonHang->field_don_ky_gui_id = $donHang->id;
//                                    $trangThaiDonHang->user_id = $uid;
//                                    if(!$trangThaiDonHang->save())
//                                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
//                                    else
//                                        $strArrThongBao[] = 'Lưu đơn ký gửi thành công';
//                                }else
//                                    return ['success' => false, 'content' => 'Không thể cập nhật thông tin MVĐ đã giao hoặc đang y/c giao hàng '.$item->name];
//                            }
//                        }
//                        else{
//                            // Kiểm tra có đơn mua hộ nào có mã vận đơn này chưa
//                            $donHang = DonHang::findOne(['ma_van_don' => $item->name]); //getNodeFromQuery($queryDonHangMuHo);
//
//                            if(!is_null($donHang)){
//                                // Nếu là khách thì k đc phép nhập mã vận đơn đã tồn tại trong hệ thống
//                                if(!User::isViewAll($uid))
//                                    $strMaVanDonDaTonTai[] = $item->name;
//                                else{
//                                    // Ngược lại update trạng thái đã về kho VN
////                  if($donHang->field_trang_thai == DON_HANG_CHO || $donHang->field_trang_thai == DANG_O_KHO_VN){
//                                    // Nếu là quản lý thì update lại thông tin khối lượng và ghi chú
//                                    $lineVanChuyen = $donHang->line_van_chuyen; //isset(['und']) ? $donHang->field_line_van_chuyen['und'][0]['target_id'] : 7131; // Mặc định là line chậm
//                                    $fieldsDonHang = [
//                                        'field_ghi_chu' => $item->ghiChu,
//                                        'field_ma_van_don' => $item->name,
//                                        'line' => $item->lineVanChuyen,
//                                        'field_khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
//                                    ];
//
//                                    $phiCanNang = (new KyGui())->tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)), 'kg', $lineVanChuyen);
//
////                  $phiCanNang = getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)));
//                                    $phiCanNangCu = $donHang->phi_khoi_luong;
//                                    $fieldsDonHang['field_phi_khoi_luong'] = $phiCanNang;
//                                    $tongTienCu = $donHang->thanh_tien;
//                                    $fieldsDonHang['field_thanh_tien'] = $tongTienCu - $phiCanNangCu + $phiCanNang;
//                                    $fieldsDonHang['field_trang_thai'] = KyGui::DANG_O_VIET_NAM;
//                                    $donHang->updateAttributes($fieldsDonHang);
//
//                                    // Thêm lịch sử trạng thái cho đơn hàng về VN
//                                    // Lưu thông tin trạng thái đơn hàng
//                                    // Lưu lịch sử trạng thái đơn ký gửi
//                                    $trangThaiDonHang = new TrangThaiDonKyGui();
//                                    $trangThaiDonHang->field_trang_thai = KyGui::DANG_O_VIET_NAM;
//                                    $trangThaiDonHang->field_don_ky_gui_id = $donHang->id;
//                                    $trangThaiDonHang->user_id = $uid;
//                                    if(!$trangThaiDonHang->save())
//                                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];
//                                }
//                            }
//                            else{
//                                $phiCanNang = KyGui::getPhiKhoiLuongDonKyGui(
//                                    floatval(str_replace(',', '', $item->khoiLuong)),
//                                    $item->line_van_chuyen
//                                ); //tinhPhiKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)), 'kg', 7131); //getCuocKhoiLuong(floatval(str_replace(',', '', $item->khoiLuong)));
//                                $phiVanChuyenNoiDiaVND = intval($item->phi_van_chuyen_noi_dia_ndt) * $tyGia;
//                                $fieldsDonHangKyGui = [
//                                    'field_ma_van_don_ky_gui' => $item->name,
////                                            'field_tuyen_van_chuyen_id' => $content->data->selectedTuyenVanChuyen,
//                                    'field_ghi_chu' => $item->ghiChu,
//                                    // Nếu k có thông tin khách hàng => người nhập là khách hàng, k phải quản lý
//                                    // thì trạng thái đơn là đơn chờ, ngược lại là đang ở VN
//                                    'field_trang_thai' => !User::isViewAll($uid) ? KyGui::DON_HANG_CHO : KyGui::DANG_O_VIET_NAM,
//                                    'phi_van_chuyen_noi_dia' => $item->phi_van_chuyen_noi_dia_ndt,
//                                    'phi_van_chuyen_noi_dia_vnd' => $phiVanChuyenNoiDiaVND,
//                                    'field_tong_tien' => $phiVanChuyenNoiDiaVND,
//                                    'field_thanh_tien' => $phiCanNang + $phiVanChuyenNoiDiaVND,
//                                    'field_khach_hang_id' => $khachHang->id,
//                                    'user_id' => $uid,
//                                    'field_khoi_luong' => floatval(str_replace(',', '', $item->khoiLuong)),
//                                    'field_dvt_khoi_luong' => 'kg', //$content->data->donViTinhKhoiLuong,
//                                    'field_phi_can_nang' => $phiCanNang,
//                                    'line' => $item->line_van_chuyen,
//                                ];
//
//                                $node = new KyGui();
//                                foreach ($fieldsDonHangKyGui as $field => $value)
//                                    $node->{$field} = $value;
//                                $node->save();
//                            }
//                        }
//                    }
//
//                    if(User::isViewAll($uid))
//                        myAPI::sendMessNotiForOneUser($khachHang->id, 'ĐH CỦA BẠN ĐANG Ở VN', 'Một số đơn ký gửi của bạn đang ở kho VN, bạn có thể yêu cầu giao hàng.');
//                    else {
//                        myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA LÊN ĐƠN KÝ GỬI', 'Khách hàng '.$khachHang->dien_thoai.' vừa lên đơn ký gửi');
//                        myAPI::sendMail(
//                            implode('<br />', [
//                                '<strong>Họ tên KH: </strong>'.$khachHang->hoten,
//                                '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
//                            ]),
//                            'Khách hàng vừa lên đơn ký gửi'
//                        );
//                    }
//                }
//
//            }
//        }
//        return (['success' => true ,'title'=> 'Thông báo','content' => implode('. ', $strArrThongBao).(count($strMaVanDonDaTonTai) > 0 ? ' Mã vận đơn '.implode('. ', $strMaVanDonDaTonTai).' đã tồn tại' : '')]);
//    }

    //huy-don-hang-ky-gui
    public function actionHuyDonHangKyGui(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                // Chỉ huỷ đơn hàng "Đơn hàng chờ"
                if(!isset($content->nid))
                    return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
                else{
                    $donHang = KyGui::findOne($content->nid);
                    if(is_null($donHang))
                        return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
                    else{
                        $allow = false;
                        $curentUser = User::findOne($content->uid);
                        // Người quản lý huỷ hoặc người tạo đơn hàng có quyền huỷ khi đơn hàng đang chờ mua
                        if(User::isViewAll($content->uid) || $donHang->field_khach_hang_id == $content->uid)
                            $allow = true;
                        if(!$allow)
                            return (['success' => false, 'content' => 'Bạn không có quyền huỷ đơn hàng này']);
                        else{
                            // Nếu người huỷ không là quản lý nhưng đơn hàng không phải đơn chờ thì không cho phép huỷ
                            if(!User::isViewAll($content->uid) && $donHang->field_trang_thai != KyGui::DON_HANG_CHO)
                                return (['success' => false, 'content' => 'Chỉ huỷ đơn hàng đang chờ mua']);
                            else{
                                $noiDungThongBaoArr = [];
                                $khachHang = User::findOne($donHang->field_khach_hang_id);

                                $trangThaiDonHang = new TrangThaiDonKyGui();
                                $trangThaiDonHang->field_trang_thai = KyGui::DA_HUY;
                                $trangThaiDonHang->field_don_ky_gui_id = $donHang->id;
                                $trangThaiDonHang->field_ghi_chu = $content->ghiChu;
                                $trangThaiDonHang->user_id = $content->uid;
                                if($trangThaiDonHang->save())
                                    $strThongBao = 'Đơn hàng KG'.$donHang->id.' đã huỷ';
                                else
                                    return ['success' => false, 'content' => strip_tags(Html::errorSummary($trangThaiDonHang))];

                                $modelThongBao = new ThongBao();
                                $modelThongBao->nguoi_nhan_thong_bao_id = $donHang->field_khach_hang_id;
                                $modelThongBao->da_xem = 0;
                                $modelThongBao->route = 'ky-gui';
                                $modelThongBao->params = $donHang->id;
                                $modelThongBao->ghi_chu = $strThongBao;
                                $modelThongBao->user_id = $content->uid;
                                $modelThongBao->save();

                                $soTienDaThanhToan = $donHang->field_so_tien_da_thanh_toan;
                                if($soTienDaThanhToan > 0){

                                    // Tạo giao dịch Hoàn tiền vào ví cho khách
//                $maGiaoDich = 'RVOR'.$donHang->uid.date("ynjGi");
                                    $fieldsGDHoanTien = [
                                        'khach_hang' => $donHang->field_khach_hang_id,
                                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                                        'loai_giao_dich' => GiaoDich::HOAN_TIEN_DON_HANG,
                                        'tong_tien' => $soTienDaThanhToan,
                                        'so_tien_giao_dich' => $soTienDaThanhToan,
                                        'don_ky_gui_id' => $donHang->id,
                                        'ghi_chu' => 'Huỷ đơn hàng',
                                        'active' => 1
                                    ];
                                    $model = new GiaoDich();
                                    foreach ($fieldsGDHoanTien as $field => $value)
                                        $model->{$field} = $value;
                                    if(!$model->save())
                                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($model))];
                                    else{
                                        $model->updateAttributes(['ma_giao_dich' => 'HTRV'.$model->id]);

                                        // Cộng tiền vào ví khách hàng
                                        $viCu = $khachHang->vi_dien_tu;
                                        $khachHang->updateAttributes(['vi_dien_tu' => $viCu + $soTienDaThanhToan]);

                                        $noiDungThongBaoArr[] = 'Bạn được hoàn lại '.number_format($soTienDaThanhToan, 0, '', '.').' VNĐ vào ví';
                                    }
                                    $noiDungThongBao = implode("\n", $noiDungThongBaoArr);

                                    $modelThongBao = new ThongBao();
                                    $modelThongBao->nguoi_nhan_thong_bao_id = $donHang->field_khach_hang_id;
                                    $modelThongBao->da_xem = 0;
                                    $modelThongBao->route = 'giao-dich';
                                    $modelThongBao->params = $model->id;
                                    $modelThongBao->ghi_chu = $noiDungThongBao;
                                    $modelThongBao->user_id = $content->uid;
                                    $modelThongBao->save();
                                }

                                // Thông báo tới khách hàng có phát sinh giao dịch hoàn tiền thành công
                                myAPI::sendMessNotiForOneUser($donHang->field_khach_hang_id, 'HUỶ ĐƠN KG'.$donHang->id, implode("\n", $noiDungThongBaoArr));
                                myAPI::guiThongBaoLoiDenQuanTriVien('HUỶ ĐƠN KG'.$donHang->id, implode("\n", $noiDungThongBaoArr));

                                myAPI::sendMail(
                                    implode('<br/>', [
                                        implode("\n", $noiDungThongBaoArr),
                                        '<strong>Người thực hiện: </strong>'.$curentUser->hoten,
                                        '<strong>Mã đơn: </strong>KG'.$donHang->id,
                                        '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                                        '<strong>ĐT Khách hàng: </strong>'.$khachHang->dien_thoai,
                                    ]),
                                    'Huỷ đơn KG'.$donHang->id
                                );
                                return (['success' => true, 'content' => 'Huỷ đơn hàng KG'.$donHang->id.' thành công. '.number_format($soTienDaThanhToan, 0, '', '.').' VNĐ được hoàn vào ví.']);
                            }
                        }
                    }
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

    //delete-don-ky-gui
    public function actionDeleteDonKyGui(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                $node = KyGui::findOne($content->nid);//();

                if($node->field_trang_thai == KyGui::DON_HANG_CHO || User::isViewAll($content->uid)){
                    $node->updateAttributes(['field_active' => 0]);

                    return ([
                        'success' => true,
                        'content' => 'Xoá đơn ký gửi thành công'
                    ]);
                }else
                    return([
                        'success' => false,
                        'content' => 'Chỉ xoá được đơn hàng chờ'
                    ]);

            }else
                return $check;
        }else{
            $idKyGui = $_POST['idKyGui'];
            $uid = Yii::$app->user->id;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $kyGui = KyGui::findOne($idKyGui);
        if(($kyGui->user_id == $uid && ($kyGui->field_trang_thai == KyGui::DON_HANG_CHO)) || User::isViewAll($uid)){
            $kyGui->updateAttributes(['field_active' => 0]);
            return ([
                'success' => true,
                'title' => 'Thông báo',
                'content' => 'Xoá đơn ký gửi thành công'
            ]);
        }else
            return [
                'title' => 'Thông báo',
                'success' => false,
                'content' => 'Bạn không có quyền xoá đơn ký gửi này hoặc bạn chỉ được phép xoá đơn hàng chờ'
            ];
    }

    //get-list-trang-thai-don-ky-gui
    public function actionGetListTrangThaiDonKyGui(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                $nodes = TrangThaiDonKyGui::findAll(['field_don_ky_gui_id' => $content->nidDonKyGui]);

                $data = [];
                foreach ($nodes as $node){
                    $data[] = [
                        'nid' => $node->id,
                        'field_trang_thai' => $node->field_trang_thai,
                        'field_ghi_chu' => $node->field_ghi_chu,
                        'created' => date("d/m/Y H:i:s"),
                    ];
                }
                return ([
                    'success' => true,
                    'content' => $data
                ]);

            }else
                return $check;
        }
        else
            return [
                'success' => false,
                'content' => 'Không có thông tin người dùng'
            ];
    }

    //chon-don-ky-gui
    public function actionChonDonKyGui(){
        $kyGui = KyGui::findOne($_POST['idKyGui']);
        $kyGui->updateAttributes(['da_chon_thuc_hien_chuc_nang' => !$kyGui->da_chon_thuc_hien_chuc_nang]);
    }

    //get-don-ky-gui-da-chon
    public function actionGetDonKyGuiDaChon(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donKyGuiDaChon =  KyGui::find()->select(['id'])
            ->andFilterWhere(['da_chon_thuc_hien_chuc_nang' => 1])
            ->andFilterWhere(['field_active' => 1])
            ->all();
        return ArrayHelper::map($donKyGuiDaChon, 'id', 'id');
    }

    //xoa-don-ky-gui-da-chon
    public function actionXoaDonKyGuiDaChon(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        KyGui::updateAll(['da_chon_thuc_hien_chuc_nang' => 0], ['id' => $_POST['idKyGui']]);
    }

    //change-status-don-ky-gui
    public function actionChangeStatusDonKyGui(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $kyGui = KyGui::findOne($_POST['idKyGui']);
        if(!is_null($kyGui)){
            $kyGui->updateAttributes(['field_trang_thai' => $_POST['trangThaiMoi']]);
            $trangThaiDonKyGui = new TrangThaiDonKyGui();
            $trangThaiDonKyGui->field_don_ky_gui_id = $kyGui->id;
            $trangThaiDonKyGui->field_trang_thai = $_POST['trangThaiMoi'];
            $trangThaiDonKyGui->user_id = Yii::$app->user->id;
            $trangThaiDonKyGui->save();

            myAPI::sendMessNotiForOneUser($kyGui->user_id, 'O247 - Trạng thái đơn ký gửi', 'Trạng thái đơn ký gửi '.$kyGui->id.' chuyển sang trạng thái '.$_POST['trangThaiMoi']);

            return  [
                'success' => true,
                'content' => 'Thay đổi trạng thái đơn ký gửi thành công'
            ];
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn ký gửi'
            ];
    }

    //change-info-don-ky-gui
    public function actionChangeInfoDonKyGui(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne(Yii::$app->user->id);
        $kyGui = KyGui::findOne($_POST['idKyGui']);
        if(!is_null($kyGui)){
            if(isset($_POST['maVanDon']))
            {
                $kyGui->updateAttributes(['field_ma_van_don_ky_gui' => $_POST['maVanDon']]);
//            myAPI::sendMessNotiForOneUser($kyGui->user_id, 'O247 - Trạng thái đơn ký gửi', 'Trạng thái đơn ký gửi '.$kyGui->id.' chuyển sang trạng thái '.$_POST['trangThaiMoi']);
                $strThongBao =[];
                myAPI::sendMessNotiForOneUser($kyGui->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$_POST['idKyGui'], $strThongBao);
                $modelThongBao = new ThongBao();
                $modelThongBao->nguoi_nhan_thong_bao_id = $kyGui->user_id;
                $modelThongBao->da_xem = 0;
                $modelThongBao->route = 'ky-gui';
                $modelThongBao->params = $kyGui->id;
                $modelThongBao->ghi_chu = implode("\n", $strThongBao);
                $modelThongBao->user_id = Yii::$app->user->id;
                $modelThongBao->save();

                myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA CẬP NHẬT ĐƠN KÝ GỬI', 'Khách hàng '.$user->dien_thoai.' vừa cập nhật đơn ký gửi');
                myAPI::sendMail(
                    implode('<br />', [
                        '<strong>Họ tên KH: </strong>'.$user->hoten,
                        '<strong>Điện thoại: </strong>'.$user->dien_thoai,
                    ]),
                    'Khách hàng vừa cập nhật đơn ký gửi'
                );
                return [
                    'success' => true,
                    'content' => 'Thay đổi mã vận đơn thành công'
                ];
            }else if (isset($_POST['ghiChu'])){
                $kyGui->updateAttributes(['field_ghi_chu' => $_POST['ghiChu']]);
//            myAPI::sendMessNotiForOneUser($kyGui->user_id, 'O247 - Trạng thái đơn ký gửi', 'Trạng thái đơn ký gửi '.$kyGui->id.' chuyển sang trạng thái '.$_POST['trangThaiMoi']);
                $strThongBao =[];
                myAPI::sendMessNotiForOneUser($kyGui->field_khach_hang_id, 'CẬP NHẬT ĐH KG'.$_POST['idKyGui'], $strThongBao);
                $modelThongBao = new ThongBao();
                $modelThongBao->nguoi_nhan_thong_bao_id = $kyGui->user_id;
                $modelThongBao->da_xem = 0;
                $modelThongBao->route = 'ky-gui';
                $modelThongBao->params = $kyGui->id;
                $modelThongBao->ghi_chu = implode("\n", $strThongBao);
                $modelThongBao->user_id = Yii::$app->user->id;
                $modelThongBao->save();

                myAPI::guiThongBaoLoiDenQuanTriVien('KH VỪA CẬP NHẬT ĐƠN KÝ GỬI', 'Khách hàng '.$user->dien_thoai.' vừa cập nhật đơn ký gửi');
                myAPI::sendMail(
                    implode('<br />', [
                        '<strong>Họ tên KH: </strong>'.$user->hoten,
                        '<strong>Điện thoại: </strong>'.$user->dien_thoai,
                    ]),
                    'Khách hàng vừa cập nhật đơn ký gửi'
                );
                return [
                    'success' => true,
                    'content' => 'Thay đổi ghi chú thành công'
                ];
            }
        }else
            return [
                'success' => false,
                'content' => 'Không tồn tại thông tin đơn ký gửi'
            ];
    }

    //luu-trang-thai-don-ky-gui-hang-loat
    public function actionLuuTrangThaiDonKyGuiHangLoat()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['ky_gui'])) {
            foreach ($_POST['ky_gui'] as $item) {
                $model = new TrangThaiDonKyGui();
                $model->field_trang_thai = $_POST['trang_thai'];
                $model->field_don_ky_gui_id = $item;
                $model->user_id = Yii::$app->user->id;
                $model->save();

                KyGui::updateAll(['da_chon_thuc_hien_chuc_nang' => 0, 'field_trang_thai' => $_POST['trang_thai']], ['id' => $item]);
            }

            return [
                'title' => 'Thông báo',
                'success' => true,
                'content' => 'Cập nhật trạng thái đơn ký gửi thành công'
            ];
        } else
            return [
                'title' => 'Thông báo',
                'success' => false,
                'content' => 'Chưa chọn đơn ký gửi để cập nhật trạng thái'
            ];
    }
    //xem-chi-tiet-don-ky-gui
    public function actionXemChiTietDonKyGui(){
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
            $id = $_POST['idKyGui'];
        }
        $node = QuanLyDonKyGui::findOne(['id' => $id]);
        if($node->user_id == $uid || $node->field_khach_hang_id == $uid || User::isViewAll($uid)){
            $data = [
                'nid' => $node->id,
                'field_ma_van_don_ky_gui' => $node->field_ma_van_don_ky_gui,
                'field_trang_thai' => $node->field_trang_thai,
                'field_khoi_luong' => $node->field_khoi_luong,
                'field_dvt_khoi_luong' => $node->field_dvt_khoi_luong,
                'field_thanh_tien' => $node->field_thanh_tien,
                'ho_ten_nguoi_nhan' => $node->ho_ten_nguoi_nhan,
                'dien_thoai_nguoi_nhan' => $node->dien_thoai_nguoi_nhan,
                'thong_tin_dia_chi' => $node->thong_tin_dia_chi,
            ];

            if(isset($content->uid))
                return ([
                    'success' => true,
                    'content' =>  $data,
                ]);
            else
                return [
                    'title' => 'Thông tin đơn ký gửi #'.$node->id,
                    'content' => $this->renderAjax('_view', [
                        'data' => QuanLyDonKyGui::findOne(['id' => $node->id]),
                        'lichSuThanhToan' => QuanLyGiaoDich::findAll(['don_ky_gui_id' => $node->id]),
                        'trangThaiDonKyGui' => TrangThaiDonKyGui::findAll(['field_don_ky_gui_id' => $node->id])
                    ])
                ];
        }else
            return [
                'title' => 'Thông báo',
                'success' => false,
                'content' => 'Bạn không có quyền xem đơn hàng này'
            ];
    }

    //thanh-toan-them-nhieu-don-hang-ky-gui
    public function actionThanhToanThemNhieuDonHangKyGui(){
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content->uid)){
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){
                if(!isset($content->data->donHangDaChons))
                    return (['success' => false, 'content' => 'Không có thông tin đơn hàng']);
                else if(count($content->data->donHangDaChons) == 0)
                    return (['success' => false, 'content' => 'Chọn ít nhất 1 đơn hàng để thanh toán']);
                else {
                    $tongTienCanThanhToanThem = 0;
                    $donHangs = [];
                    foreach ($content->data->donHangDaChons as $donHangDaChon){
                        $donHang = KyGui::findOne($donHangDaChon->nid);
                        if($donHang->field_khach_hang_id != $content->uid){
                            return (['success' => false, 'content' => 'Chỉ thanh toán thêm đơn hàng của bạn']);
                        }
                        $soTienCanThanhToanThem = doubleval($donHang->field_thanh_tien) - doubleval($donHang->field_so_tien_da_thanh_toan);
                        if($soTienCanThanhToanThem > 0){
                            $donHangs[] = ['donHang' => $donHang, 'tongTienCanThanhToanThem' => $soTienCanThanhToanThem];
                            $tongTienCanThanhToanThem += $soTienCanThanhToanThem;
                        }
                    }
                    $khachHang = User::findOne($donHangs[0]['donHang']->field_khach_hang_id);  //user_load(->field_khach_hang['und'][0]['target_id']);

                    $viDienTu  = $khachHang->vi_dien_tu;
                    if($tongTienCanThanhToanThem > $viDienTu){
                        //Gửi email thông báo cho admin biét có khách hàng đang muốn thanh toán thêm nhưng không đủ tiền trong ví
                        //node_load(5708)->field_ghi_chu
                        myAPI::sendMail(
                            implode('<br />', [
                                '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                                '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                                '<strong>Số tiền cần thanh toán: </strong>'.number_format($tongTienCanThanhToanThem, 0, '', '.').' VNĐ',
                                '<strong>Số tiền trong ví: </strong>'.number_format($viDienTu, 0, '', '.').' VNĐ',
                                '<strong>Còn thiếu: </strong>'.number_format($tongTienCanThanhToanThem - $viDienTu, 0, '', '.').' VNĐ'
                            ]),
                            myAPI::PREFIX_NAME_SYSTEM.' - THANH TOÁN THÊM VÀ KHÔNG ĐỦ TIỀN'
                        );
                        myAPI::guiThongBaoLoiDenQuanTriVien('['.myAPI::PREFIX_NAME_SYSTEM.'] YÊU CẦU GIAO HÀNG', 'Khách hàng '.$khachHang->dien_thoai.' thanh toán thêm và yêu cầu giao hàng nhưng còn thiếu '.number_format($tongTienCanThanhToanThem - $viDienTu, 0, '', '.').' VNĐ');

                        return (
                            [
                                'success' => false,
                                'content' => 'Số tiền trong ví ('.number_format($viDienTu, 0, '', '.').') không đủ để thanh toán thêm ('
                                    .number_format($tongTienCanThanhToanThem, 0, '', '.').')']);
                    }
                    else{
                        foreach ($donHangs as $donHangItem){
                            $fieldsGiaoDichTT = [
                                'khach_hang_id' => $donHangItem['donHang']->field_khach_hang_id,
                                'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                                'loai_giao_dich' => GiaoDich::THANH_TOAN_DON_HANG,
                                'tong_tien' => $donHangItem['tongTienCanThanhToanThem'],
                                'active' => 1,
                                'so_tien_giao_dich' => $donHangItem['tongTienCanThanhToanThem'],
                                'don_ky_gui_id' => $donHangItem['donHang']->id,
                                'ghi_chu' => 'Thanh toán thêm',
                                'user_id' => $content->uid,
                            ];

                            $giaoDichThanhToan = new GiaoDich();
                            foreach ($fieldsGiaoDichTT as $field => $value)
                                $giaoDichThanhToan->{$field} = $value;
                            if(!$giaoDichThanhToan->save())
                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($giaoDichThanhToan))];
                            else{
                                $donHangItem['donHang']->updateAttributes(
                                    [
                                        'field_so_tien_da_thanh_toan' => intval($donHangItem['donHang']->field_so_tien_da_thanh_toan) + intval($donHangItem['tongTienCanThanhToanThem'])
                                    ]
                                );
                            }
                        }

                        // Trừ tiền khỏi ví
                        $khachHang->updateAttributes([
                            'vi_dien_tu' => $viDienTu - $tongTienCanThanhToanThem
                        ]);

                        myAPI::guiThongBaoLoiDenQuanTriVien('THANH TOÁN THÊM', 'Khách hàng '.$khachHang->dien_thoai.' thanh toán thêm tiền đơn hàng ký gửi.');
                        myAPI::sendMail(implode('<br />', [
                            '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                            '<strong>Điện thoại: </strong>'.$khachHang->dien_thoai,
                            '<strong>Số tiền thanh toán: </strong>'.number_format($tongTienCanThanhToanThem, 0, '', '.').' VNĐ',
                        ]), 'Khách hàng thanh toán thêm tiền đơn hàng ký gửi');

                        return ([
                            'success' => true,
                            'content' => 'Thanh toán thêm đơn hàng thành công'
                        ]);
                    }
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
                    $donHang = KyGui::findOne($content->data->nid); //node_load();
                    $soTienDaThanhToan = intval($donHang->field_so_tien_da_thanh_toan);

                    // Cộng tiền vào ví của khách hàng
                    $khachHang = User::findOne($donHang->field_khach_hang_id); // user_load($donHang->field_khach_hang['und'][0]['target_id']);

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
                            'ghi_chu' => 'Hoàn tiền đơn hàng ký gửi '.$donHang->id,
                            'anh_giao_dich' => $content->data->hinhAnhChuyenKhoan,
                            'user_id' => $content->uid,
                            'don_ky_gui_id' => $donHang->id
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
                        $soTienHoanLaiCu = intval($donHang->field_so_tien_hoan_lai);
                        $donHang->updateAttributes([
                            'field_so_tien_da_thanh_toan' => $soTienDaThanhToan - $soTienGiaoDich,
                            'field_so_tien_hoan_lai' => $soTienHoanLaiCu + $soTienGiaoDich
                        ]);

                        // Gửi thông báo hoàn tiền
                        $noiDungThongBao = 'Đơn hàng KG'.$donHang->id.' được hoàn '.number_format($soTienGiaoDich, 0, '', '.').' vào ví điện tử';
                        myAPI::sendMessNotiForOneUser($khachHang->id, 'HOÀN TIỀN ĐƠN HÀNG KG'.$donHang->id, $noiDungThongBao);
                        $filedsThongBao = [
                            'nguoi_nhan_thong_bao_id' => $khachHang->id,
                            'da_xem' => 0,
                            'route' => '',
                            'ghi_chu' => $noiDungThongBao,
                            'user_id' => $content->uid,
                            'title' => 'HOÀN TIỀN ĐƠN HÀNG KG'.$donHang->id
                        ];
                        $thongBaoModel = new ThongBao();
                        foreach ($filedsThongBao as $field => $value)
                            $thongBaoModel->{$field} = $value;
                        $thongBaoModel->save();

                        return (['success' => true, 'content' => 'Hoàn tiền đơn hàng KG'.($donHang->id).' thành công!']);
                    }
                }
            }
        }
        else
            return $check;

    }
}
