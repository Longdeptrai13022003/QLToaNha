<?php

namespace backend\controllers;

use app\models\QuanLyPhieuYeuCauGiaoHang;
use backend\models\CauHinh;
use backend\models\ChiTietPhieuYeuCauGiaoHang;
use backend\models\DiaChiNhanHang;
use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\KyGui;
use backend\models\PhieuYeuCauGiao;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyTrangThaiGiaoDich;
use backend\models\search\QuanLyDonHangSearch;
use backend\models\search\QuanLyGiaoDichSearch;
use backend\models\search\QuanLyPhieuYeuCauGiaoHangSearch;
use backend\models\ThietBiNhanThongBao;
use backend\models\ThongBao;
use backend\models\TrangThaiDonHang;
use backend\models\TrangThaiDonKyGui;
use backend\models\TrangThaiGiaoDich;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Engineering\ImPowerTest;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class YeuCauGiaoHangController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index', 'save-multiple-phieu-yeu-cau-giao', 'luu-ma-van-don-phieu-yeu-cau-giao',
            'luu-sdt-nha-xe', 'yeu-cau-giao-hang-don-ky-gui', 'luu-chi-phi'
        ];
        $rules = [];
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        if (isset($this->contentAPI->uid)) {
            $this->enableCsrfValidation = false;
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name = strtolower(str_replace('action', '', $action->id));
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('YeuCauGiaoHang', $action_name, $this->contentAPI->uid);
                    }
                ];
            }
        } else {
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name = strtolower(str_replace('action', '', $action->id));
                        return \Yii::$app->user->id == 1 || myAPI::isAccess2('YeuCauGiaoHang', $action_name);
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

    public function actionIndex()
    {
        $this->contentAPI = json_decode(file_get_contents('php://input'));

        if (isset($this->contentAPI->uid)) {
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $searchModel = new QuanLyPhieuYeuCauGiaoHangSearch();
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if ($check['success']) {
                $dataProvider = $searchModel->search($queryParams, $this->contentAPI);
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $dataProvider->setPagination(['page' => $this->contentAPI->data->page, 'pageSize' => 10]);
//          $dataProvider->setPagination([]);
                $data = $dataProvider->getModels();
                $results = [];
                /** @var QuanLyPhieuYeuCauGiaoHang $node */
                foreach ($data as $node) {
                    $results[] = [
                        'nid' => $node->id,
                        'field_danh_sach_don_hang' => is_null($node->field_danh_sach_don_hang) ? '' : $node->field_danh_sach_don_hang,
                        'field_ma_van_don' => is_null($node->field_ma_van_don) ? '' : $node->field_ma_van_don,
                        'field_hinh_thuc_nhan_hang' => $node->field_hinh_thuc_nhan_hang,
                        'field_so_dien_thoai_nha_xe' => is_null($node->field_so_dien_thoai_nha_xe) ? '' : $node->field_so_dien_thoai_nha_xe,
                        'field_phi_giao_hang_den_nha_xe' => $node->field_phi_giao_hang_den_nha_xe,
                        'field_so_tien_da_thanh_toan' => $node->field_so_tien_da_thanh_toan,
                        'field_so_tien_hoan_lai' => $node->field_so_tien_hoan_lai,
                        'phi_dong_goi' => $node->phi_dong_goi,
                        'khachHang' => [
                            'field_ho_ten' => $node->hoten,
                            'field_dien_thoai' => $node->dien_thoai
                        ],
                        'created' => date("d/m/Y H:i:s", strtotime($node->created)),
                        'thongTinDiaChiNhanHang' => [
                            'field_ho_ten' => $node->ho_ten_nguoi_nhan,
                            'field_dien_thoai' => $node->dien_thoai_nguoi_nhan,
                            'field_dia_chi' => $node->thong_tin_dia_chi
                        ],
                    ];
                }
                return [
                    'success' => true,
                    'content' => $results,
                    'loadMore' => ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount(),
                    'quanLy' => User::isViewAll($this->contentAPI->uid)
                ];
            } else {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
        } else {
            $searchModel = new QuanLyPhieuYeuCauGiaoHangSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
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

    //save-multiple-phieu-yeu-cau-giao
    public function actionSaveMultiplePhieuYeuCauGiao()
    {
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($content->uid)) {
            $check = myAPI::checkBeforeAction($content);
            if ($check['success']) {
                $khachHang = User::findOne($content->uid); //($content->uid);

                // Người đang đăng nhập là người thực hiện y/c giao hàng
                if (!isset($content->donHangs))
                    return (['success' => false, 'content' => 'Vui lòng chọn ít nhất 1 đơn hàng']);
                else if (count($content->donHangs) == 0)
                    return (['success' => false, 'content' => 'Vui lòng chọn ít nhất 1 đơn hàng']);
                else if (!isset($content->hinhThucNhanHang))
                    return (['success' => false, 'content' => 'Vui lòng chọn phương thức vận chuyển']);
                else if (!in_array(trim($content->hinhThucNhanHang), ['Chuyển phát nhanh', 'Gửi xe khách']))
                    return (['success' => false, 'content' => 'Vui lòng chọn phương thức vận chuyển (Chuyển phát nhanh / Gửi xe khách)']);
                else if (!isset($content->diaChiNhanHang))
                    return (['success' => false, 'content' => 'Vui lòng nhập địa chỉ nhận hàng']);
                else if (!isset($content->diaChiNhanHang->nid))
                    return (['success' => false, 'content' => 'Vui lòng nhập địa chỉ nhận hàng']);
                else {
                    if(isset($content->data->phanLoai))
                        $phanLoai = $content->data->phanLoai;
                    else
                        $phanLoai = null;
                    if ($phanLoai == 'Đơn hàng ký gửi') {
                        $nodesDonHang = KyGui::find()->andFilterWhere(['in', 'id', $content->donHangs])->all(); //node_load_multiple();
                        // Kiểm tra đã thanh toán hết tiền chưa. Nếu chưa thì đưa ra cảnh báo
                        $tongTienChuaThanhToan = 0;
                        /** @var KyGui $donHang */
                        foreach ($nodesDonHang as $donHang)
                            $tongTienChuaThanhToan += (doubleval($donHang->field_thanh_tien) - doubleval($donHang->field_so_tien_da_thanh_toan));

                        if ($tongTienChuaThanhToan > 0) {
                            if ($khachHang->vi_dien_tu < $tongTienChuaThanhToan) {
                                return (['success' => false, 'content' => 'Vui lòng nạp thêm tiền để thực hiện việc này']);
                            }
                        }

                        // Kiểm tra dữ liệu địa chỉ nhận hàng, nếu là địa chỉ mới thì lưu mới và lấy nid lưu vào phiếu y/c giao
                        if ($content->diaChiNhanHang->nid == 0) {
                            $modelDiaChiNhanHang = new DiaChiNhanHang();
                            $fields = [
                                'dien_thoai_nguoi_nhan' => $content->diaChiNhanHang->field_dien_thoai,
                                'thong_tin_dia_chi' => $content->diaChiNhanHang->field_dia_chi,
                                'mac_dinh' => $content->diaChiNhanHang->field_chon_mac_dinh ? 1 : 0,
                                'ghi_chu' => $content->diaChiNhanHang->field_ghi_chu,
                                'ho_ten_nguoi_nhan' => $content->diaChiNhanHang->field_ho_ten,
                                'user_id' => $khachHang->id,
                                'active' => 1
                            ];
                            foreach ($fields as $field => $value)
                                $modelDiaChiNhanHang->{$field} = $value;
                            if ($modelDiaChiNhanHang->save())
                                $nidDiaChiNhanHang = $modelDiaChiNhanHang->id;
                            else
                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($modelDiaChiNhanHang))];
                            // Nếu chọn địa chỉ này làm mặc định thì tất cả các địa chỉ còn lại là không mặc định
                            if ($content->diaChiNhanHang->field_chon_mac_dinh) {
                                // Update field mac_dinh = 0 cho mọi bản ghi địa chỉ nhận hàng khác của người dùng đang đăng nhập
                                \Yii::$app->db->createCommand('Update qlcvsd_dia_chi_nhan_hang set mac_dinh = 0 where user_id = :u and id <> :i', [
                                    ':u' => $content->uid,
                                    ':i' => $nidDiaChiNhanHang
                                ])->execute();
                            }
                        } else
                            $nidDiaChiNhanHang = $content->diaChiNhanHang->nid;

                        // Tạo phiếu yêu cầu giao
                        $phiDongGoi = CauHinh::findOne(['ghi_chu' => 'phi_dong_goi_don_hang_yeu_cau_giao'])->content;
                        $fields = [
                            'field_hinh_thuc_nhan_hang' => $content->hinhThucNhanHang,
                            'field_dia_chi_nhan_hang_id' => $nidDiaChiNhanHang,
                            'user_id' => $content->uid,
                            'phi_dong_goi' => $phiDongGoi,
                            'field_tong_tien' => $phiDongGoi,
                            'field_thanh_tien' => $phiDongGoi
                        ];
                        if (isset($content->data)) {
                            if (isset($content->data->phanLoai)) {
                                $fields['field_phan_loai'] = $content->data->phanLoai;
                            }
                        }

                        $phieuYCGiao = new PhieuYeuCauGiao();
                        foreach ($fields as $field => $value) {
                            $phieuYCGiao->{$field} = $value;
                        }
                        if ($phieuYCGiao->save()) {
                            foreach ($nodesDonHang as $donHang)
                                $donHang->updateAttributes([
                                    'field_dia_chi_nhan_hang_id' => $nidDiaChiNhanHang,
                                    'field_hinh_thuc_nhan_hang' => $content->hinhThucNhanHang
                                ]);
                            $phieuYCGiao->updateAttributes(['title' => 'YCG' . $phieuYCGiao->id]);

                            $maDonHang = [];
                            // Duyệt từng đơn hàng và thay đổi trạng thái cho đơn hàng thành Hoàn tất
                            $indexChiTietPhieuYCGiao = 0;
                            $tongTienGiaoDich = 0;
                            foreach ($nodesDonHang as $donHang) {
                                $indexChiTietPhieuYCGiao++;
                                $soTienConThieu = (doubleval($donHang->field_thanh_tien) - doubleval($donHang->field_so_tien_da_thanh_toan));
                                // Nếu số tiền chưa thanh toán > 0 thì trừ tiền từ ví
                                if ($soTienConThieu > 0) {
                                    $tongTienGiaoDich += $soTienConThieu;
                                    // Tạo giao dịch mới
                                    // Lưu giao dịch cho đơn hàng mới (trừ tiền khỏi ví)
                                    $giaoDichThanhToanDonHang = new GiaoDich();
                                    $fields = [
                                        'khach_hang_id' => $content->uid,
                                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                                        'loai_giao_dich' => GiaoDich::THANH_TOAN_DON_HANG,
                                        'active' => 1,
                                        'don_hang_lien_quan_id' => $donHang->id,
                                        'tong_tien' => $soTienConThieu,
                                        'user_id' => $content->uid
                                    ];
                                    foreach ($fields as $field => $value) {
                                        $giaoDichThanhToanDonHang->{$field} = $value;
                                    }
                                    $giaoDichThanhToanDonHang->save();
                                    $giaoDichThanhToanDonHang->updateAttributes(['ma_giao_dich' => myAPI::SUB_NAME . 'TT' . $giaoDichThanhToanDonHang->id]);
                                }

                                // Update lại ví khách hàng
                                $khachHang->updateAttributes(['vi_dien_tu' => $khachHang->vi_dien_tu - $tongTienGiaoDich]);

//                                $soNgayKhieuNaiToiDa = CauHinh::findOne(['ghi_chu' => 'so_ngay_khieu_nai_toi_da'])->content;
//                                $ngayKhieuNaiCuoiCung = strtotime("+{$soNgayKhieuNaiToiDa}days");
//
//                                $donHang->updateAttributes([
//                                    'field_trang_thai' => DonHang::DA_GIAO,
//                                    'han_cuoi_khieu_nai' => date("Y-m-d H:i:s", $ngayKhieuNaiCuoiCung),
//                                    'hinh_thuc_nhan_hang' => trim($content->hinhThucNhanHang),
//                                    'da_thanh_toan' => doubleval($donHang->thanh_tien),
//                                ]);
                                $maDonHang[] = $donHang->field_ma_van_don_ky_gui;

                                $modelLichSuTrangThai = new TrangThaiDonKyGui();
                                $modelLichSuTrangThai->updateAttributes([
                                    'field_trang_thai' => KyGui::DA_GIAO,
                                    'field_don_ky_gui_id' => $donHang->id,
                                    'user_id' => $content->uid
                                ]);
                                $modelLichSuTrangThai->save();

                                $modelChiTietPhieuGiao = new ChiTietPhieuYeuCauGiaoHang();
                                $modelChiTietPhieuGiao->field_phieu_yeu_cau_giao_id = $phieuYCGiao->id;
                                $modelChiTietPhieuGiao->don_hang_ky_gui_id = $donHang->id;
                                $modelChiTietPhieuGiao->user_id = $content->uid;
                                $modelChiTietPhieuGiao->save();
                            }
                            $phieuYCGiao->updateAttributes(['field_danh_sach_don_hang' => implode(', ', array_filter($maDonHang))]);

                            // Gửi thông tin cho QTV
                            $nameKH = $khachHang->hoten;
                            $noiDung = 'KH ' . $nameKH . ' vừa Y/C giao hàng, mã vận đơn ' . implode(', ', array_filter($maDonHang));

                            myAPI::guiThongBaoLoiDenQuanTriVien('[' . myAPI::PREFIX_NAME_SYSTEM . '] YÊU CẦU GIAO HÀNG', $noiDung);
                            myAPI::sendMail(implode('<br />', [
                                $noiDung,
                                '<strong>Người thực hiện: </strong>' . $nameKH,
                                '<strong>Mã đơn: </strong>PYC' . $phieuYCGiao->id,
                                '<strong>Khách hàng: </strong>' . $nameKH,
                                '<strong>ĐT Khách hàng: </strong>' . $nameKH,
                            ]), '[' . myAPI::PREFIX_NAME_SYSTEM . '] YÊU CẦU GIAO HÀNG');

                            return (['success' => true, 'content' => 'Lưu phiếu yêu cầu giao hàng thành công!']);
                        } else
                            return ['success' => false, 'content' => strip_tags(Html::errorSummary($phieuYCGiao))];

                    }
                    else {
                        $nodesDonHang = DonHang::find()->andFilterWhere(['in', 'id', $content->donHangs])->all(); //node_load_multiple();
                        //
                        // Kiểm tra đã thanh toán hết tiền chưa. Nếu chưa thì đưa ra cảnh báo
                        $tongTienChuaThanhToan = 0;
                        /** @var DonHang $donHang */
                        foreach ($nodesDonHang as $donHang)
                            $tongTienChuaThanhToan += (doubleval($donHang->thanh_tien) - doubleval($donHang->da_thanh_toan));

                        if ($tongTienChuaThanhToan > 0) {
                            if ($khachHang->vi_dien_tu < $tongTienChuaThanhToan) {
                                return (['success' => false, 'content' => 'Vui lòng nạp thêm tiền để thực hiện việc này']);
                            }
                        }

                        // Kiểm tra dữ liệu địa chỉ nhận hàng, nếu là địa chỉ mới thì lưu mới và lấy nid lưu vào phiếu y/c giao
                        if ($content->diaChiNhanHang->nid == 0) {
                            $modelDiaChiNhanHang = new DiaChiNhanHang();
                            $fields = [
                                'dien_thoai_nguoi_nhan' => $content->diaChiNhanHang->field_dien_thoai,
                                'thong_tin_dia_chi' => $content->diaChiNhanHang->field_dia_chi,
                                'mac_dinh' => $content->diaChiNhanHang->field_chon_mac_dinh ? 1 : 0,
                                'ghi_chu' => $content->diaChiNhanHang->field_ghi_chu,
                                'ho_ten_nguoi_nhan' => $content->diaChiNhanHang->field_ho_ten,
                                'user_id' => $khachHang->id,
                                'active' => 1
                            ];
                            foreach ($fields as $field => $value)
                                $modelDiaChiNhanHang->{$field} = $value;
                            if ($modelDiaChiNhanHang->save())
                                $nidDiaChiNhanHang = $modelDiaChiNhanHang->id;
                            else
                                return ['success' => false, 'content' => strip_tags(Html::errorSummary($modelDiaChiNhanHang))];
                            // Nếu chọn địa chỉ này làm mặc định thì tất cả các địa chỉ còn lại là không mặc định
                            if ($content->diaChiNhanHang->field_chon_mac_dinh) {
                                // Update field mac_dinh = 0 cho mọi bản ghi địa chỉ nhận hàng khác của người dùng đang đăng nhập
                                \Yii::$app->db->createCommand('Update qlcvsd_dia_chi_nhan_hang set mac_dinh = 0 where user_id = :u and id <> :i', [
                                    ':u' => $content->uid,
                                    ':i' => $nidDiaChiNhanHang
                                ])->execute();
                            }
                        } else
                            $nidDiaChiNhanHang = $content->diaChiNhanHang->nid;

                        // Tạo phiếu yêu cầu giao
                        $fields = [
                            'field_hinh_thuc_nhan_hang' => $content->hinhThucNhanHang,
                            'field_dia_chi_nhan_hang_id' => $nidDiaChiNhanHang,
                            'user_id' => $content->uid
                        ];
                        if (isset($content->data)) {
                            if (isset($content->data->phanLoai)) {
                                $fields['field_phan_loai'] = $content->data->phanLoai;
                            }
                        }

                        $phieuYCGiao = new PhieuYeuCauGiao();
                        foreach ($fields as $field => $value) {
                            $phieuYCGiao->{$field} = $value;
                        }
                        if ($phieuYCGiao->save()) {
                            $phieuYCGiao->updateAttributes(['title' => 'PYCG' . $phieuYCGiao->id]);
                            $maDonHang = [];
                            // Duyệt từng đơn hàng và thay đổi trạng thái cho đơn hàng thành Hoàn tất
                            $indexChiTietPhieuYCGiao = 0;
                            $tongTienGiaoDich = 0;
                            foreach ($nodesDonHang as $donHang) {
                                $indexChiTietPhieuYCGiao++;
                                $soTienConThieu = (doubleval($donHang->thanh_tien) - doubleval($donHang->da_thanh_toan));
                                // Nếu số tiền chưa thanh toán > 0 thì trừ tiền từ ví
                                if ($soTienConThieu > 0) {
                                    $tongTienGiaoDich += $soTienConThieu;
                                    // Tạo giao dịch mới
                                    // Lưu giao dịch cho đơn hàng mới (trừ tiền khỏi ví)
                                    $giaoDichThanhToanDonHang = new GiaoDich();
                                    $fields = [
                                        'khach_hang_id' => $content->uid,
                                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                                        'loai_giao_dich' => GiaoDich::THANH_TOAN_DON_HANG,
                                        'active' => 1,
                                        'don_hang_lien_quan_id' => $donHang->id,
                                        'tong_tien' => $soTienConThieu,
                                        'user_id' => $content->uid
                                    ];
                                    foreach ($fields as $field => $value) {
                                        $giaoDichThanhToanDonHang->{$field} = $value;
                                    }
                                    $giaoDichThanhToanDonHang->save();
                                    $giaoDichThanhToanDonHang->updateAttributes(['ma_giao_dich' => myAPI::SUB_NAME . 'TT' . $giaoDichThanhToanDonHang->id]);
                                }

                                // Update lại ví khách hàng
                                $khachHang->updateAttributes(['vi_dien_tu' => $khachHang->vi_dien_tu - $tongTienGiaoDich]);

                                $soNgayKhieuNaiToiDa = CauHinh::findOne(['ghi_chu' => 'so_ngay_khieu_nai_toi_da'])->content;
                                $ngayKhieuNaiCuoiCung = strtotime("+{$soNgayKhieuNaiToiDa}days");
                                $donHang->updateAttributes([
                                    'trang_thai' => DonHang::DA_GIAO,
                                    'han_cuoi_khieu_nai' => date("Y-m-d H:i:s", $ngayKhieuNaiCuoiCung),
                                    'hinh_thuc_nhan_hang' => trim($content->hinhThucNhanHang),
                                    'da_thanh_toan' => doubleval($donHang->thanh_tien),
                                ]);

                                if ($donHang->type == 'don_hang_ky_gui')
                                    $maDonHang[] = $donHang->ma_van_don_ky_gui;
                                else
                                    $maDonHang[] = $donHang->ma_van_don;

                                $modelLichSuTrangThai = new TrangThaiDonHang();
                                $modelLichSuTrangThai->updateAttributes([
                                    'trang_thai' => DonHang::DA_GIAO,
                                    'don_hang_id' => $donHang->id,
                                    'user_id' => $content->uid
                                ]);
                                $modelLichSuTrangThai->save();


                                $modelChiTietPhieuGiao = new ChiTietPhieuYeuCauGiaoHang();
                                $modelChiTietPhieuGiao->field_phieu_yeu_cau_giao_id = $phieuYCGiao->id;
                                $modelChiTietPhieuGiao->field_don_hang_id = $donHang->id;
                                $modelChiTietPhieuGiao->user_id = $content->uid;
                                $modelChiTietPhieuGiao->save();
                            }
                            $phieuYCGiao->updateAttributes(['field_danh_sach_don_hang' => implode(', ', array_filter($maDonHang))]);

                            // Gửi thông tin cho QTV
                            $nameKH = $khachHang->hoten;
                            $noiDung = 'KH ' . $nameKH . ' vừa Y/C giao hàng, mã vận đơn ' . implode(', ', array_filter($maDonHang));

                            myAPI::guiThongBaoLoiDenQuanTriVien('[' . myAPI::PREFIX_NAME_SYSTEM . '] YÊU CẦU GIAO HÀNG', $noiDung);
                            myAPI::sendMail(implode('<br />', [
                                $noiDung,
                                '<strong>Người thực hiện: </strong>' . $nameKH,
                                '<strong>Mã đơn: </strong>PYC' . $phieuYCGiao->id,
                                '<strong>Khách hàng: </strong>' . $nameKH,
                                '<strong>ĐT Khách hàng: </strong>' . $nameKH,
                            ]), '[' . myAPI::PREFIX_NAME_SYSTEM . '] YÊU CẦU GIAO HÀNG');

                            return (['success' => true, 'content' => 'Lưu phiếu yêu cầu giao hàng thành công!']);
                        } else
                            return ['success' => false, 'content' => strip_tags(Html::errorSummary($phieuYCGiao))];

                    }

                }

            } else
                return $check;
        } else
            return [
                'success' => false,
                'content' => 'Không có thông tin người dùng'
            ];


    }

    //luu-ma-van-don-phieu-yeu-cau-giao
    public function actionLuuMaVanDonPhieuYeuCauGiao()
    {
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($content->uid)) {
//            $user = User::findOne($content->uid);
            $phieuYCGiao = PhieuYeuCauGiao::findOne($content->data->nid);
            $phieuYCGiao->updateAttributes(['field_ma_van_don' => $content->data->maVanDon]);

            // Update ma van don cho tat ca don hang cua phieu yc giao
            $nodes = ChiTietPhieuYeuCauGiaoHang::findAll(['field_phieu_yeu_cau_giao_id' => $phieuYCGiao->id]);
            /** @var ChiTietPhieuYeuCauGiaoHang $node */
            foreach ($nodes as $node) {
                if ($node->don_hang_ky_gui_id != '') {
                    $donHang = KyGui::findOne($node->don_hang_ky_gui_id);
                    $fieldsDonHang = ['field_ma_van_chuyen_don_hang' => $content->data->maVanDon];
                } else {
                    $fieldsDonHang = ['ma_van_chuyen_don_hang' => $content->data->maVanDon];
                    $donHang = DonHang::findOne($node->field_don_hang_id);
                }

                // Update giá trị thời gian khiếu nại tối đa
                if ($content->data->maVanDon != '') {
                    $soNgayKhieuNaiToiDa = CauHinh::findOne(['ghi_chu' => 'so_ngay_khieu_nai_toi_da'])->content;
                    $ngayKhieuNaiCuoiCung = strtotime("+{$soNgayKhieuNaiToiDa}days");
                    if ($node->don_hang_ky_gui_id == '')
                        $fieldsDonHang['han_cuoi_khieu_nai'] = date("Y-m-d H:i:s", $ngayKhieuNaiCuoiCung);
                } else {
                    if ($node->don_hang_ky_gui_id != '')
                        $fieldsDonHang['field_han_cuoi_khieu_nai'] = null;
                }

                $donHang->updateAttributes($fieldsDonHang);
            }

            // Gửi thông báo cho khách hàng
            $noiDungThongBao = 'Đơn hàng ' . $phieuYCGiao->title . ' đang được giao. ' . ($content->data->maVanDon != '' ? 'Quý khách vui lòng theo dõi mã vận đơn ' . $content->data->maVanDon . ' để cập nhật trạng thái đơn hàng mới nhất nhé!' : "");
            myAPI::sendMessNotiForOneUser($phieuYCGiao->user_id, 'ĐH ' . $phieuYCGiao->id . ' đang di chuyển', $noiDungThongBao);
            $modelThongBao = new ThongBao();
            $modelThongBao->nguoi_nhan_thong_bao_id = $phieuYCGiao->user_id;
            $modelThongBao->da_xem = 0;
            $modelThongBao->route = 'giao-dich';
            $modelThongBao->params = $node->id;
            $modelThongBao->ghi_chu = $noiDungThongBao;
            $modelThongBao->user_id = $content->uid;
            $modelThongBao->save();

            return ([
                'success' => true,
                'content' => 'Cập nhật mã vận đơn thành công'
            ]);

        } else {
            $uid = \Yii::$app->user->id;
            if ($_POST['maVanDon'] != "") {
                $phieuYCGiao = PhieuYeuCauGiao::findOne($_POST['idPhieu']);
                $phieuYCGiao->updateAttributes(['field_ma_van_don' => $_POST['maVanDon']]);

                // Update ma van don cho tat ca don hang cua phieu yc giao
                $nodes = ChiTietPhieuYeuCauGiaoHang::findAll(['field_phieu_yeu_cau_giao_id' => $phieuYCGiao->id]);
                /** @var ChiTietPhieuYeuCauGiaoHang $node */
                foreach ($nodes as $node) {
                    if ($node->don_hang_ky_gui_id != '') {
                        $donHang = KyGui::findOne($node->don_hang_ky_gui_id);
                        $fieldsDonHang = ['field_ma_van_chuyen_don_hang' => $_POST['maVanDon']];
                    } else {
                        $fieldsDonHang = ['ma_van_chuyen_don_hang' => $_POST['maVanDon']];
                        $donHang = DonHang::findOne($node->field_don_hang_id);
                    }

                    // Update giá trị thời gian khiếu nại tối đa
                    if (!is_null($_POST['maVanDon'])) {
                        $soNgayKhieuNaiToiDa = CauHinh::findOne(['ghi_chu' => 'so_ngay_khieu_nai_toi_da'])->content;
                        $ngayKhieuNaiCuoiCung = strtotime("+{$soNgayKhieuNaiToiDa}days");
                        if ($node->don_hang_ky_gui_id == '')
                            $fieldsDonHang['han_cuoi_khieu_nai'] = date("Y-m-d H:i:s", $ngayKhieuNaiCuoiCung);
                    } else {
                        if ($node->don_hang_ky_gui_id != '')
                            $fieldsDonHang['field_han_cuoi_khieu_nai'] = null;
                    }

                    $donHang->updateAttributes($fieldsDonHang);
                }

                // Gửi thông báo cho khách hàng
                $noiDungThongBao = 'Đơn hàng ' . $phieuYCGiao->title . ' đang được giao. ' . ($_POST['maVanDon'] != '' ? 'Quý khách vui lòng theo dõi mã vận đơn ' . $_POST['maVanDon'] . ' để cập nhật trạng thái đơn hàng mới nhất nhé!' : "");
                myAPI::sendMessNotiForOneUser($phieuYCGiao->user_id, 'ĐH ' . $phieuYCGiao->id . ' đang di chuyển', $noiDungThongBao);
                $modelThongBao = new ThongBao();
                $modelThongBao->nguoi_nhan_thong_bao_id = $phieuYCGiao->user_id;
                $modelThongBao->da_xem = 0;
                $modelThongBao->route = 'giao-dich';
                $modelThongBao->params = $node->id;
                $modelThongBao->ghi_chu = $noiDungThongBao;
                $modelThongBao->user_id = $uid;
                $modelThongBao->save();

                return [
                    'success' => true,
                    'content' => 'Cập nhật mã vận đơn thành công',
                    'title' => 'Thông báo'
                ];
            } else {
                return [
                    'success' => false,
                    'content' => 'Chưa nhập mã vận đơn',
                    'title' => 'Thông báo'
                ];
            }

        }
    }

    //luu-sdt-nha-xe
    public function actionLuuSdtNhaXe()
    {
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($content->uid)) {
            $phieuYCGiao = PhieuYeuCauGiao::findOne($content->data->nid);
//enum('Chuyển phát nhanh', 'Gửi xe khách')
            if (trim($content->data->phiGiaoHangDenNhaXe) == '' && $phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách')
                return ['success' => false, 'content' => 'Vui lòng nhập phí giao hàng'];
            else if (trim($content->data->sdtNhaXe) == '' && $phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách')
                return ['success' => false, 'content' => 'Vui lòng nhập SĐT nhà xe'];
            else {
                $noiDungThongBao = [];

                $phiDongGoi = intval(str_replace(',', '', $content->data->phiDongGoi));
                $phiGiaoHangDenNhaXe = intval(str_replace(',', '', $content->data->phiGiaoHangDenNhaXe));
                $phiGiaoMoi = $phiDongGoi + $phiGiaoHangDenNhaXe;

                $field_so_tien_da_thanh_toan = (is_null($phieuYCGiao->field_so_tien_da_thanh_toan) ? 0 : $phieuYCGiao->field_so_tien_da_thanh_toan);
                $fieldsPhieuYCThanhToan = ([
                    'field_so_dien_thoai_nha_xe' => $content->data->sdtNhaXe,
                    'field_phi_giao_hang_den_nha_xe' => $phiGiaoHangDenNhaXe,
                    'phi_dong_goi' => $phiDongGoi,
                    'field_tong_tien' => $phiGiaoMoi,
                    'field_thanh_tien' => $phiGiaoMoi,
                ]);

                $soTienCanThanhToan = $phiGiaoMoi - $field_so_tien_da_thanh_toan;

                $khachHang = User::findOne($phieuYCGiao->user_id); //user_load($phieuYCGiao->uid);
                $viDienTu = intval($khachHang->vi_dien_tu);

                if ($soTienCanThanhToan > 0) { // Cần thanh toán thêm
                    if ($viDienTu <= $soTienCanThanhToan) {
                        $soTienGiaoDich = $viDienTu;
                    } else
                        $soTienGiaoDich = $soTienCanThanhToan;

                    $type = GiaoDich::THANH_TOAN_DON_HANG;
                } else { // Hoàn tiền
                    $soTienGiaoDich = abs($soTienCanThanhToan);
                    $type = GiaoDich::HOAN_TIEN_DON_HANG;
                }

                if ($soTienGiaoDich > 0 && (($viDienTu > 0 && $type == GiaoDich::THANH_TOAN_DON_HANG) || $type == GiaoDich::HOAN_TIEN_DON_HANG)) {
                    $noiDungGhiChu = 'Thanh toán chi phí khác khi yêu cầu giao hàng #' . $phieuYCGiao->id;
                    $giaoDichThanhToan = new GiaoDich();
                    $fields = [
                        'khach_hang_id' => $phieuYCGiao->user_id,
                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                        'loai_giao_dich' => $type,
                        'tong_tien' => $soTienGiaoDich,
                        'active' => 1,
                        'so_tien_giao_dich' => $soTienGiaoDich,
                        'phieu_yeu_cau_giao_id' => $phieuYCGiao->id,
                        'ghi_chu' => $noiDungGhiChu,
                        'user_id' => $content->uid
                    ];
                    foreach ($fields as $field => $value)
                        $giaoDichThanhToan->{$field} = $value;
                    if ($giaoDichThanhToan->save()) {
                        $giaoDichThanhToan->updateAttributes(['ma_giao_dich' => myAPI::SUB_NAME . 'TTY' . $giaoDichThanhToan->id]);
                    } else
                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($giaoDichThanhToan))];

                    $field_so_tien_da_thanh_toan += $soTienCanThanhToan;
                    $fieldsPhieuYCThanhToan['field_so_tien_da_thanh_toan'] = $field_so_tien_da_thanh_toan;
                    $phieuYCGiao->updateAttributes($fieldsPhieuYCThanhToan);

                    $khachHang->updateAttributes(['vi_dien_tu' => $viDienTu - $soTienCanThanhToan]);
                }

                if ($phiGiaoMoi > 0) {
                    $noiDungThongBao[] = 'Y/c giao ' . $phieuYCGiao->title . ' phát sinh ' . number_format($phiGiaoMoi, 0, '', '.') . ' VNĐ phí ship giao hàng đến nhà xe.';
                }

                // Update Sdt nhà xe cho tat ca don hang cua phieu yc giao
                $chiTietPhieuYCGiao = ChiTietPhieuYeuCauGiaoHang::findAll(['field_phieu_yeu_cau_giao_id' => $phieuYCGiao->id]);
                foreach ($chiTietPhieuYCGiao as $itemCTietPYCG) {
                    DonHang::updateAll(['field_so_dien_thoai_nha_xe' => $content->data->sdtNhaXe], ['id' => $itemCTietPYCG->field_don_hang_id]);
                    KyGui::updateAll(['field_so_dien_thoai_nha_xe' => $content->data->sdtNhaXe], ['id' => $itemCTietPYCG->don_hang_ky_gui_id]);
                }

                // Gửi thông báo cho khách hàng
                $noiDungThongBao[] = 'Đơn hàng ' . $phieuYCGiao->title . ($phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách' ? 'đã gửi tới nhà xe' : 'được giao cho ĐVVC') . '. ';
                myAPI::sendMessNotiForOneUser($phieuYCGiao->user_id, 'ĐH ' . $phieuYCGiao->title . ' đang di chuyển', implode(' ', $noiDungThongBao));

                $modelThongBao = new ThongBao();
                $modelThongBao->nguoi_nhan_thong_bao_id = $phieuYCGiao->user_id;
                $modelThongBao->da_xem = 0;
                $modelThongBao->route = 'thong-bao';
                $modelThongBao->params = $phieuYCGiao->id;
                $modelThongBao->ghi_chu = implode(' ', $noiDungThongBao);
                $modelThongBao->user_id = $content->uid;
                $modelThongBao->save();

                return ([
                    'success' => true,
                    'content' => 'Cập nhật phiếu YCGH thành công!',
                    'field_so_tien_da_thanh_toan' => $field_so_tien_da_thanh_toan,
                    'phi_dong_goi' => $phiDongGoi,
                    'field_phi_giao_hang_den_nha_xe' => $phiGiaoHangDenNhaXe,
                    'tong_tien' => $phiGiaoMoi
                ]);
            }

        } else {
            $uid = \Yii::$app->user->id;
            $phieuYCGiao = PhieuYeuCauGiao::findOne($_POST['idPhieu']);

//enum('Chuyển phát nhanh', 'Gửi xe khách')
            if (trim($_POST['phiGiaoHangDenNhaXe']) == '' && $phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách')
                return ['success' => false, 'content' => 'Vui lòng nhập phí giao hàng'];
            else if (trim($_POST['soDienThoaiNhaXe']) == '' && $phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách')
                return ['success' => false, 'content' => 'Vui lòng nhập SĐT nhà xe'];
            else {
                $noiDungThongBao = [];

                $phiDongGoi = intval(str_replace(',', '', $_POST['phiDongGoi']));
                $phiGiaoHangDenNhaXe = intval(str_replace(',', '', $_POST['phiGiaoHangDenNhaXe']));
                $phiGiaoMoi = $phiDongGoi + $phiGiaoHangDenNhaXe;

                $field_so_tien_da_thanh_toan = (is_null($phieuYCGiao->field_so_tien_da_thanh_toan) ? 0 : $phieuYCGiao->field_so_tien_da_thanh_toan);
                $fieldsPhieuYCThanhToan = ([
                    'field_so_dien_thoai_nha_xe' => $_POST['soDienThoaiNhaXe'],
                    'field_phi_giao_hang_den_nha_xe' => $phiGiaoHangDenNhaXe,
                    'phi_dong_goi' => $phiDongGoi,
                    'field_tong_tien' => $phiGiaoMoi,
                    'field_thanh_tien' => $phiGiaoMoi,
                ]);

                $soTienCanThanhToan = $phiGiaoMoi - $field_so_tien_da_thanh_toan;
//                $soTienCanThanhToan = $phiGiaoHangDenNhaXe - $field_so_tien_da_thanh_toan;

                $khachHang = User::findOne($phieuYCGiao->user_id); //user_load($phieuYCGiao->uid);
                $viDienTu = intval($khachHang->vi_dien_tu);

                if ($soTienCanThanhToan > 0) { // Cần thanh toán thêm
                    if ($viDienTu <= $soTienCanThanhToan) {
                        $soTienGiaoDich = $viDienTu;
                    } else
                        $soTienGiaoDich = $soTienCanThanhToan;

                    $type = GiaoDich::THANH_TOAN_DON_HANG;
                } else { // Hoàn tiền
                    $soTienGiaoDich = abs($soTienCanThanhToan);
                    $type = GiaoDich::HOAN_TIEN_DON_HANG;
                }

                if ($soTienGiaoDich > 0 && (($viDienTu > 0 && $type == GiaoDich::THANH_TOAN_DON_HANG) || $type == GiaoDich::HOAN_TIEN_DON_HANG)) {
                    $noiDungGhiChu = 'Thanh toán chi phí khác khi yêu cầu giao hàng #' . $phieuYCGiao->id;
                    $giaoDichThanhToan = new GiaoDich();
                    $fields = [
                        'khach_hang_id' => $phieuYCGiao->user_id,
                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                        'loai_giao_dich' => $type,
                        'tong_tien' => $soTienGiaoDich,
                        'active' => 1,
                        'so_tien_giao_dich' => $soTienGiaoDich,
                        'phieu_yeu_cau_giao_id' => $phieuYCGiao->id,
                        'ghi_chu' => $noiDungGhiChu,
                        'user_id' => $uid
                    ];
                    foreach ($fields as $field => $value)
                        $giaoDichThanhToan->{$field} = $value;
                    if ($giaoDichThanhToan->save()) {
                        $giaoDichThanhToan->updateAttributes(['ma_giao_dich' => myAPI::SUB_NAME . 'TTY' . $giaoDichThanhToan->id]);
                    } else
                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($giaoDichThanhToan))];

                    $field_so_tien_da_thanh_toan += $soTienCanThanhToan;
                    $fieldsPhieuYCThanhToan['field_so_tien_da_thanh_toan'] = $field_so_tien_da_thanh_toan;
                    $phieuYCGiao->updateAttributes($fieldsPhieuYCThanhToan);

                    $khachHang->updateAttributes(['vi_dien_tu' => $viDienTu - $soTienCanThanhToan]);
                }

                if($phiGiaoMoi > 0){
                    $noiDungThongBao[] = 'Y/c giao '.$phieuYCGiao->title.' phát sinh '.number_format($phiGiaoMoi, 0, '', '.').' VNĐ phí ship giao hàng đến nhà xe.';
                }
//                if ($phiGiaoHangDenNhaXe > 0)
//                    $noiDungThongBao[] = 'Y/c giao ' . $phieuYCGiao->title . ' phát sinh ' . number_format($phiGiaoHangDenNhaXe, 0, '', '.') . ' VNĐ phí ship giao hàng đến nhà xe.';

                // Update Sdt nhà xe cho tat ca don hang cua phieu yc giao
                $chiTietPhieuYCGiao = ChiTietPhieuYeuCauGiaoHang::findAll(['field_phieu_yeu_cau_giao_id' => $phieuYCGiao->id]);
                foreach ($chiTietPhieuYCGiao as $itemCTietPYCG) {
                    DonHang::updateAll(['field_so_dien_thoai_nha_xe' => $_POST['soDienThoaiNhaXe']], ['id' => $itemCTietPYCG->field_don_hang_id]);
                    KyGui::updateAll(['field_so_dien_thoai_nha_xe' => $_POST['soDienThoaiNhaXe']], ['id' => $itemCTietPYCG->don_hang_ky_gui_id]);
                    $phieuYCGiao->updateAttributes(['field_so_dien_thoai_nha_xe' => $_POST['soDienThoaiNhaXe']]);
                    $phieuYCGiao->updateAttributes(['field_phi_giao_hang_den_nha_xe' => $_POST['phiGiaoHangDenNhaXe']]);
                    $phieuYCGiao->updateAttributes(['phi_dong_goi' => $_POST['phiDongGoi']]);
                }

                // Gửi thông báo cho khách hàng
                $noiDungThongBao[] = 'Đơn hàng ' . $phieuYCGiao->title . ($phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách' ? 'đã gửi tới nhà xe' : 'được giao cho ĐVVC') . '. ';
                myAPI::sendMessNotiForOneUser($phieuYCGiao->user_id, 'ĐH ' . $phieuYCGiao->title . ' đang di chuyển', implode(' ', $noiDungThongBao));

                $modelThongBao = new ThongBao();
                $modelThongBao->nguoi_nhan_thong_bao_id = $phieuYCGiao->user_id;
                $modelThongBao->da_xem = 0;
                $modelThongBao->route = 'thong-bao';
                $modelThongBao->params = $phieuYCGiao->id;
                $modelThongBao->ghi_chu = implode(' ', $noiDungThongBao);
                $modelThongBao->user_id = $uid;
                $modelThongBao->save();

                return ([
                    'success' => true,
                    'content' => 'Cập nhật phiếu YCGH thành công!',
                    'field_so_tien_da_thanh_toan' => $field_so_tien_da_thanh_toan,
                    'phi_dong_goi' =>  $phiDongGoi,
                    'field_phi_giao_hang_den_nha_xe' => $phiGiaoHangDenNhaXe,
                    'tong_tien' => $phiGiaoMoi
                ]);
            }
        }
    }

    public function actionLuuChiPhi(){
        $uid = \Yii::$app->user->id;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $phieuYCGiao = PhieuYeuCauGiao::findOne($_POST['idPhieu']);

//enum('Chuyển phát nhanh', 'Gửi xe khách')
        if (trim($_POST['phiDongGoi']) == '' && $phieuYCGiao->field_hinh_thuc_nhan_hang == 'Chuyển phát nhanh')
            return ['success' => false, 'content' => 'Vui lòng nhập phí đóng gói'];
        else {
            $noiDungThongBao = [];

            $phiDongGoi = intval(str_replace(',', '', $_POST['phiDongGoi']));
            $phiGiaoMoi = $phiDongGoi ;

            $field_so_tien_da_thanh_toan = (is_null($phieuYCGiao->field_so_tien_da_thanh_toan) ? 0 : $phieuYCGiao->field_so_tien_da_thanh_toan);
            $fieldsPhieuYCThanhToan = ([
                'phi_dong_goi' => $phiDongGoi,
                'field_tong_tien' => $phiGiaoMoi,
                'field_thanh_tien' => $phiGiaoMoi,
            ]);

            $soTienCanThanhToan = $phiGiaoMoi - $field_so_tien_da_thanh_toan;
//            $soTienCanThanhToan = $phiGiaoHangDenNhaXe - $field_so_tien_da_thanh_toan;

            $khachHang = User::findOne($phieuYCGiao->user_id); //user_load($phieuYCGiao->uid);
            $viDienTu = intval($khachHang->vi_dien_tu);

            if ($soTienCanThanhToan > 0) { // Cần thanh toán thêm
                if ($viDienTu <= $soTienCanThanhToan) {
                    $soTienGiaoDich = $viDienTu;
                } else
                    $soTienGiaoDich = $soTienCanThanhToan;

                $type = GiaoDich::THANH_TOAN_DON_HANG;
            } else { // Hoàn tiền
                $soTienGiaoDich = abs($soTienCanThanhToan);
                $type = GiaoDich::HOAN_TIEN_DON_HANG;
            }

            if ($soTienGiaoDich > 0 && (($viDienTu > 0 && $type == GiaoDich::THANH_TOAN_DON_HANG) || $type == GiaoDich::HOAN_TIEN_DON_HANG)) {
                $noiDungGhiChu = 'Thanh toán chi phí khác khi yêu cầu giao hàng #' . $phieuYCGiao->id;
                $giaoDichThanhToan = new GiaoDich();
                $fields = [
                    'khach_hang_id' => $phieuYCGiao->user_id,
                    'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                    'loai_giao_dich' => $type,
                    'tong_tien' => $soTienGiaoDich,
                    'active' => 1,
                    'so_tien_giao_dich' => $soTienGiaoDich,
                    'phieu_yeu_cau_giao_id' => $phieuYCGiao->id,
                    'ghi_chu' => $noiDungGhiChu,
                    'user_id' => $uid
                ];
                foreach ($fields as $field => $value)
                    $giaoDichThanhToan->{$field} = $value;
                if ($giaoDichThanhToan->save()) {
                    $giaoDichThanhToan->updateAttributes(['ma_giao_dich' => myAPI::SUB_NAME . 'TTY' . $giaoDichThanhToan->id]);
                } else
                    return ['success' => false, 'content' => strip_tags(Html::errorSummary($giaoDichThanhToan))];

                $field_so_tien_da_thanh_toan += $soTienCanThanhToan;
                $fieldsPhieuYCThanhToan['field_so_tien_da_thanh_toan'] = $field_so_tien_da_thanh_toan;
                $phieuYCGiao->updateAttributes($fieldsPhieuYCThanhToan);

                $khachHang->updateAttributes(['vi_dien_tu' => $viDienTu - $soTienCanThanhToan]);
            }

            if($phiGiaoMoi > 0){
                $noiDungThongBao[] = 'Y/c giao '.$phieuYCGiao->title.' phát sinh '.number_format($phiGiaoMoi, 0, '', '.').' phí đóng gói.';
            }
//                if ($phiGiaoHangDenNhaXe > 0)
//                    $noiDungThongBao[] = 'Y/c giao ' . $phieuYCGiao->title . ' phát sinh ' . number_format($phiGiaoHangDenNhaXe, 0, '', '.') . ' VNĐ phí ship giao hàng đến nhà xe.';

            // Update Sdt nhà xe cho tat ca don hang cua phieu yc giao
            $chiTietPhieuYCGiao = ChiTietPhieuYeuCauGiaoHang::findAll(['field_phieu_yeu_cau_giao_id' => $phieuYCGiao->id]);
            foreach ($chiTietPhieuYCGiao as $itemCTietPYCG) {
                DonHang::updateAll(['phi_dong_go' => $_POST['phiDongGoi']], ['id' => $itemCTietPYCG->field_don_hang_id]);
//                KyGui::updateAll(['field_so_dien_thoai_nha_xe' => $_POST['soDienThoaiNhaXe']], ['id' => $itemCTietPYCG->don_hang_ky_gui_id]);
                $phieuYCGiao->updateAttributes(['phi_dong_goi' => $_POST['phiDongGoi']]);
            }

            // Gửi thông báo cho khách hàng
            $noiDungThongBao[] = 'Đơn hàng ' . $phieuYCGiao->title . ($phieuYCGiao->field_hinh_thuc_nhan_hang == 'Gửi xe khách' ? 'đã gửi tới nhà xe' : 'được giao cho ĐVVC') . '. ';
            myAPI::sendMessNotiForOneUser($phieuYCGiao->user_id, 'ĐH ' . $phieuYCGiao->title . ' đang di chuyển', implode(' ', $noiDungThongBao));

            $modelThongBao = new ThongBao();
            $modelThongBao->nguoi_nhan_thong_bao_id = $phieuYCGiao->user_id;
            $modelThongBao->da_xem = 0;
            $modelThongBao->route = 'thong-bao';
            $modelThongBao->params = $phieuYCGiao->id;
            $modelThongBao->ghi_chu = implode(' ', $noiDungThongBao);
            $modelThongBao->user_id = $uid;
            $modelThongBao->save();

            return ([
                'success' => true,
                'content' => 'Cập nhật phiếu YCGH thành công!',
                'field_so_tien_da_thanh_toan' => $field_so_tien_da_thanh_toan,
                'phi_dong_goi' =>  $phiDongGoi,
//                'field_phi_giao_hang_den_nha_xe' => $phiGiaoHangDenNhaXe,
                'tong_tien' => $phiGiaoMoi
            ]);
        }
    }
    public function kiemTraDonHangKyGuiTruocKhiGiao($uid, $nids)
    {
        // Lấy danh sách địa chỉ giao hàng của khách hàng
        $nodesDiaChiNhanHang = DiaChiNhanHang::findAll(['user_id' => $uid]);
        $dataNodesDiaChiNhanHang = [];
        foreach ($nodesDiaChiNhanHang as $item) {
            $dataNodesDiaChiNhanHang[] = [
                'nid' => $item->id,
                'field_dia_chi' => $item->thong_tin_dia_chi, // isset($item->field_dia_chi['und']) ? $item->field_dia_chi  : '',
                'field_ho_ten' => $item->ho_ten_nguoi_nhan, // isset($item->field_ho_ten['und']) ? $item->field_ho_ten : '',
                'field_dien_thoai' => $item->dien_thoai_nguoi_nhan, // isset($item->field_dien_thoai['und']) ? $item->field_dien_thoai : '',
                'field_ghi_chu' => $item->ghi_chu, // isset($item->field_ghi_chu['und']) ? $item->field_ghi_chu : '',
                'field_chon_mac_dinh' => $item->mac_dinh, // isset($item->field_chon_mac_dinh['und']) ? $item->field_chon_mac_dinh : '',
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
        $phuongThucVanChuyen = ['Chuyển phát nhanh', 'Gửi xe khách'];

        $nodesDonHang = KyGui::find()->andFilterWhere(['in', 'id', $nids])->all(); //node_load_multiple($nids);
        $tongTienChuaThanhToan = 0;
        /** @var KyGui $donHang */
        foreach ($nodesDonHang as $donHang)
            $tongTienChuaThanhToan += (doubleval($donHang->field_thanh_tien) - doubleval($donHang->field_so_tien_da_thanh_toan));

        $khachHang = User::findOne($uid);
        $viDienTu = $khachHang->vi_dien_tu;

        if ($tongTienChuaThanhToan > 0) {
            if ($viDienTu < $tongTienChuaThanhToan) {
                myAPI::sendMail(
                    implode('<br/>', [
                        'Khách hàng ' . $khachHang->hoten . ' yêu cầu giao hàng nhưng không đủ tiền',
                        '<strong>Số tiền còn thiếu: </strong>' . number_format($tongTienChuaThanhToan, 0, '', '.'),
                        '<strong>Họ tên: </strong>' . $khachHang->hoten,
                        '<strong>ĐT: </strong>' . $khachHang->dien_thoai
                    ]),
                    'KH Y/C Giao hàng nhưng không đủ tiền trong ví'
                );
                myAPI::guiThongBaoLoiDenQuanTriVien('Y/C GIAO HÀNG KHÔNG ĐỦ TIỀN', 'KH ' . $khachHang->dien_thoai . ' Y/C Giao hàng nhưng không đủ tiền trong ví');

                return ([
                    'success' => true,
                    'content' => [
                        'thieuTienTrongVi' => true,
                        'message' => 'Số tiền trong ví của bạn (' . number_format($viDienTu, 0, '', '.') . 'đ) không đủ để thanh toán hết số tiền còn thiếu (' . number_format($tongTienChuaThanhToan, 0, '', '.') . 'đ) trước khi xác nhận yêu cầu giao hàng!. Vui lòng nạp tiền để tiếp tục thực hiện việc này.',
                        'phuongThucVanChuyen' => []
                    ]
                ]);
            } else {
                myAPI::sendMail(
                    implode('<br/>', [
                        'Khách hàng ' . $khachHang->hoten . ' yêu cầu giao hàng có đủ tiền trong ví và đang chờ thanh toán',
                        '<strong>Họ tên: </strong>' . $khachHang->hoten,
                        '<strong>ĐT: </strong>' . $khachHang->dien_thoai
                    ]),
                    '[' . myAPI::PREFIX_NAME_SYSTEM . '] KH đang yêu cầu giao hàng'
                );
                myAPI::guiThongBaoLoiDenQuanTriVien(
                    'Y/C GIAO HÀNG', 'KH ' . $khachHang->dien_thoai . ' Y/C Giao hàng, có đủ tiền trong ví và đang chờ thanh toán'
                );

                return ([
                    'success' => true,
                    'content' => [
                        'thieuTienTrongVi' => false,
                        'message' => 'Bạn cần thanh toán hết số tiền ' . number_format($tongTienChuaThanhToan, 0, '', '.') . 'đ trước khi thực hiện việc này. Bằng việc xác nhận yêu cầu giao hàng, số tiền còn thiếu của bạn sẽ được trừ từ Ví điện tử!',
                        'phuongThucVanChuyen' => $phuongThucVanChuyen,
                        'dataNodesDiaChiNhanHang' => $dataNodesDiaChiNhanHang
                    ]
                ]);
            }
        } else
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


    //yeu-cau-giao-hang-don-ky-gui
    public function actionYeuCauGiaoHangDonKyGui()
    {
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($content->uid)) {
            $check = myAPI::checkBeforeAction($content);
            if ($check['success']) {
                if (!isset($content->data))
                    return (['success' => false, 'content' => 'Vui lòng chọn đơn hàng']);
                else {
                    if (count($content->data->donHangDaChons) == 0)
                        return (['success' => false, 'content' => 'Vui lòng chọn ít nhất 1 đơn hàng']);
                    else {
                        $arrNIDS = [];
                        // chức năng này chỉ dành cho khách hàng nên sẽ kiểm tra các đơn hàng đã chọn có phải của người đang đăng nhập không
                        foreach ($content->data->donHangDaChons as $item) {
                            $donHang = KyGui::findOne($item->nid);
                            if ($donHang->field_khach_hang_id != $content->uid) {
                                return (['success' => false, 'content' => 'Vui lòng chọn các đơn hàng của bạn']);
                            } else if ($item->trangThai != 'Đang ở VN') {
                                return (['success' => false, 'content' => 'Vui lòng chọn các đơn hàng đã Nhập kho VN']);
                            }
                            $arrNIDS[] = $item->nid;
                        }

                        return $this->kiemTraDonHangKyGuiTruocKhiGiao($content->uid, $arrNIDS);
                    }
                }

            } else
                return $check;
        } else
            return [
                'success' => false,
                'content' => 'Không có thông tin người dùng'
            ];

    }
}
