<?php

namespace backend\models;

use common\models\myAPI;
use common\models\User;
use Yii;

/**
 * This is the model class for table "qlcvsd_quan_ly_don_hang".
 *
 * @property int $id
 * @property string|null $created
 * @property int|null $user_id
 * @property int|null $so_luong
 * @property int|null $user_id_goc
 * @property float|null $tong_tien
 * @property string|null $anh_don_hang
 * @property float|null $chiet_khau
 * @property string|null $kieu_chiet_khau
 * @property float|null $tien_chiet_khau
 * @property int|null $da_chon_de_thanh_toan
 * @property string|null $trang_thai
 * @property float|null $phi_giao_hang_tan_noi
 * @property int|null $loai_giao_hang_id
 * @property int|null $phuong_thuc_thanh_toan_id
 * @property string|null $anh_dia_chi_nhan_hang
 * @property float|null $thanh_tien
 * @property string|null $anh_dia_chi
 * @property int|null $parent_id
 * @property string|null $ho_ten_nguoi_thanh_toan
 * @property string|null $dien_thoai_nguoi_thanh_toan
 * @property string|null $hinh_anh_dia_chi
 * @property int|null $dia_chi_nhan_hang_id
 * @property float|null $da_thanh_toan
 * @property float|null $hoan_tien
 * @property int|null $shop_id
 * @property int|null $active
 * @property string|null $shop_name
 * @property float|null $ship_noi_dia_cny
 * @property float|null $ship_noi_dia_vnd
 * @property int|null $ty_gia
 * @property float|null $phi_van_chuyen_hang
 * @property float|null $phi_dong_go
 * @property float|null $phi_mua_hang
 * @property float|null $khoi_luong
 * @property float|null $ti_le_phan_tram_mua_hang
 * @property string|null $ghi_chu
 * @property string|null $ma_van_don
 * @property string|null $website
 * @property string|null $shop_link
 * @property float|null $tong_tien_cny
 * @property int|null $tong_so_luong
 * @property string|null $dich_vu
 * @property string|null $anh_chi_tiet_don_hang
 * @property int|null $don_hang_id
 * @property float|null $tien_hang_chiet_khau Số tiền chiết khấu sau khi áp dụng đơn vị tính chiết khấu. VD: 10% được 100k thì lưu 100k
 * @property string|null $kieu_chiet_khau_tien_hang
 * @property float|null $chiet_khau_tien_hang VD: 10 (%) hoặc 20.000
 * @property float|null $phi_khoi_luong
 * @property string|null $han_cuoi_khieu_nai
 * @property int|null $qua_han_khieu_nai
 * @property string|null $danh_sach_thuoc_tinh
 * @property string|null $dvt_khoi_luong
 * @property string|null $ma_van_chuyen_don_hang
 * @property string|null $so_dien_thoai_nha_xe
 * @property string|null $hinh_thuc_nhan_hang
 * @property string|null $cong_cu_mua_hang
 * @property float|null $so_tien_hoan_lai
 * @property float|null $phi_giao_hang_den_nha_xe
 * @property string|null $ma_kien_hang
 * @property float|null $can_nang_tinh_phi
 * @property int|null $don_hang_dong_bo_cu_id
 * @property int|null $da_duyet
 * @property int|null $da_chon_thuc_hien_chuc_nang Chọn để thực hiện các chức năng
 * @property int|null $da_nhap_khoi_luong
 * @property int|null $line_van_chuyen 7130: Line nhanh 7131: Line chậm
 * @property string|null $cong_thuc_khoi_luong
 * @property string|null $type
 * @property string|null $username
 * @property int|null $khach_hang_id
 * @property string|null $ma_van_don_ky_gui
 * @property string|null $field_noi_dung_khieu_nai
 * @property string|null $field_nguoi_nhap_phan_hoi
 * @property string|null $field_trang_thai_khieu_nai
 * @property string|null $field_ngay_phan_hoi
 * @property string|null $loai_giao_hang
 * @property string|null $phuong_thuc_giao_hang
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $ho_ten_nguoi_nhan
 * @property string|null $dien_thoai_nguoi_nhan
 * @property string|null $thong_tin_dia_chi
 * @property string|null $ghi_chu_dia_chi
 */

class QuanLyDonHang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quan_ly_don_hang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'so_luong', 'da_chon_de_thanh_toan', 'loai_giao_hang_id', 'phuong_thuc_thanh_toan_id',
                'parent_id', 'dia_chi_nhan_hang_id', 'shop_id', 'active', 'ty_gia', 'tong_so_luong', 'don_hang_id',
                'qua_han_khieu_nai','username', 'user_id_goc'], 'safe'],
            [['created', 'han_cuoi_khieu_nai','ma_kien_hang', 'can_nang_tinh_phi'], 'safe'],
            [['tong_tien', 'chiet_khau', 'tien_chiet_khau', 'phi_giao_hang_tan_noi', 'thanh_tien', 'da_thanh_toan',
                'hoan_tien', 'ship_noi_dia_cny', 'ship_noi_dia_vnd', 'phi_van_chuyen_hang', 'phi_dong_go',
                'phi_mua_hang', 'khoi_luong', 'ti_le_phan_tram_mua_hang', 'tong_tien_cny', 'tien_hang_chiet_khau',
                'chiet_khau_tien_hang', 'phi_khoi_luong', 'so_tien_hoan_lai', 'phi_giao_hang_den_nha_xe'], 'safe'],
            [['anh_don_hang', 'kieu_chiet_khau', 'trang_thai', 'anh_dia_chi_nhan_hang', 'shop_name', 'ghi_chu',
                'shop_link', 'anh_chi_tiet_don_hang', 'kieu_chiet_khau_tien_hang', 'danh_sach_thuoc_tinh',
                'dvt_khoi_luong', 'hinh_thuc_nhan_hang', 'thong_tin_dia_chi', 'ghi_chu_dia_chi'], 'safe'],
            [['anh_dia_chi', 'website', 'da_chon_thuc_hien_chuc_nang'], 'safe'],
            [['ho_ten_nguoi_thanh_toan', 'dien_thoai_nguoi_thanh_toan', 'hinh_anh_dia_chi', 'ma_van_don', 'dich_vu',
                'ma_van_chuyen_don_hang', 'cong_cu_mua_hang', 'loai_giao_hang', 'phuong_thuc_giao_hang', 'hoten',
                'ho_ten_nguoi_nhan'], 'safe'],
            [['so_dien_thoai_nha_xe', 'dien_thoai', 'dien_thoai_nguoi_nhan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'user_id' => 'User ID',
            'so_luong' => 'So Luong',
            'tong_tien' => 'Tong Tien',
            'anh_don_hang' => 'Anh Don Hang',
            'chiet_khau' => 'Chiet Khau',
            'kieu_chiet_khau' => 'Kieu Chiet Khau',
            'da_chon_de_thanh_toan' => 'Da Chon De Thanh Toan',
            'trang_thai' => 'Trang Thai',
            'phi_giao_hang_tan_noi' => 'Phi Giao Hang Tan Noi',
            'loai_giao_hang_id' => 'Loai Giao Hang ID',
            'phuong_thuc_thanh_toan_id' => 'Phuong Thuc Thanh Toan ID',
            'anh_dia_chi_nhan_hang' => 'Anh Dia Chi Nhan Hang',
            'thanh_tien' => 'Thanh Tien',
            'anh_dia_chi' => 'Anh Dia Chi',
            'parent_id' => 'Parent ID',
            'ho_ten_nguoi_thanh_toan' => 'Ho Ten Nguoi Thanh Toan',
            'dien_thoai_nguoi_thanh_toan' => 'Dien Thoai Nguoi Thanh Toan',
            'hinh_anh_dia_chi' => 'Hinh Anh Dia Chi',
            'loai_giao_hang' => 'Loai Giao Hang',
            'phuong_thuc_giao_hang' => 'Phuong Thuc Giao Hang',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
        ];
    }

    /**
     * @param $nodeDonHang DonHang
     * @param $nodes ChiTietDonHang[]
     * @return array
     */
    public static function updateDonHang($nodeDonHang, $nodes){
        $tyGia = $nodeDonHang->ty_gia;
        $tongSL = 0;
        $tongTienCNY = 0;
        $chiTietDonHang = [];
        $chiPhiKiemDem = 0;
        foreach ($nodes as $node){
            $tongSL += intval($node->so_luong);
            $tongTienCNY += intval($node->so_luong) * doubleval($node->price_money);
//    $chiPhiKiemDem += ($node->field_ho_tro_kiem_dem['und'][0]['value'] == 1) ? $node->field_phi_kiem_dem['und'][0]['value'] : 0;
        }
        $tongTienVND = round($tongTienCNY * $tyGia);

        $chiPhiMuaHangHo = QuanLyDonHang::getChiPhiMuaHang($tongTienVND);
        $chiPhiMuaHang = $chiPhiMuaHangHo['chiPhiMuaHang'];
        $chiPhiTheoThangGiaTri = $chiPhiMuaHangHo['chiPhiTheoThangGiaTri'];

        $nodeDonHang->updateAttributes([
            'tong_so_luong' => $tongSL,
            'tong_tien_cny' => $tongTienCNY,
            'tong_tien' => $tongTienVND,
            'ti_le_phan_tram_mua_hang' => $chiPhiTheoThangGiaTri,
            'phi_mua_hang' => $chiPhiMuaHang,
            'thanh_tien' => $tongTienVND + $chiPhiMuaHang,
        ]);
        return [
            'tongSL' => $tongSL,
            'tongTienCNY' => $tongTienCNY,
            'tongTienVND' => $tongTienVND,
            'chiPhiMuaHang' => $chiPhiMuaHang,
            'chiPhiTheoThangGiaTri' => $chiPhiTheoThangGiaTri,
            'chiTietDonHang' => $chiTietDonHang,
//    'chiPhiKiemDem' => $chiPhiKiemDem,
            'field_thanh_tien' => $tongTienVND + $chiPhiMuaHang,
//    'field_thanh_tien' => $tongTienVND + $chiPhiMuaHang + $chiPhiKiemDem,
        ];
    }

   public static function getChiPhiMuaHang($tongTienVND): array
    {
        $nodeCauHinhPhiMuaHangHo = CauHinh::findOne(['ghi_chu' => 'phi_mua_ho'])->content;
        $data = explode('<br />', nl2br($nodeCauHinhPhiMuaHangHo));

        foreach ($data as $index => $item)
            $data[$index] = trim($item);

        $firstRow = explode(':', $data[0]);
        $chiPhiMuaHang = null;
        if($tongTienVND < doubleval($firstRow[0])) // VD <300.000 thì phí là 10.000
        {
            $chiPhiMuaHang = doubleval($firstRow[1]); // 10.000d
            $chiPhiTheoThangGiaTri = 0;
        }else{
            for($i = 1; $i < count($data) - 1; $i++){
                $arrChiPhi = explode(':', $data[$i]); // 1020902-30902902:3
                $arrKhoangChiPhi = explode('-', $arrChiPhi[0]);
                if($tongTienVND >= intval($arrKhoangChiPhi[0]) && $tongTienVND < intval($arrKhoangChiPhi[1])){
                    $chiPhiMuaHang = round(floatval($arrChiPhi[1]) * $tongTienVND / 100);
                    $chiPhiTheoThangGiaTri = $arrChiPhi[1];
                }
            }
            if(is_null($chiPhiMuaHang)){
                $chiPhiMuaHang = round(floatval($data[count($data) - 1]) * $tongTienVND / 100);
                $chiPhiTheoThangGiaTri = $data[count($data) - 1];
            }
        }
        return [
            'chiPhiMuaHang' => $chiPhiMuaHang,
            'chiPhiTheoThangGiaTri' => $chiPhiTheoThangGiaTri
        ];
    }

    /**
     * @param $donHang DonHang
     * @param $new bool
     * @param $content object
     * @param $khachHang User
     * @return void
     */
    public static function updateLaiDonHang($donHang, $new, $content, $khachHang){
        //Update chi tiết đơn hàng đã chọn từ đơn hàng cũ vào đơn hàng mới
        $chiTietDonHangDaChon = ChiTietDonHang::findAll(['don_hang_id' => $donHang->id]);

        $soLuong = 0; //TODO CẬP NHẬT LẠI SỐ LƯỢNG VÀ TỔNG TIỀN ĐƠN HÀNG KHI CHECKOUT
        $tongTienDonhang = 0;
        $tongTienCNYDonHang = 0;
        $anhDonHang = [];
        $thuocTinhSanPham = [];

        /** @var ChiTietDonHang $node */
        foreach ($chiTietDonHangDaChon as $node){
            // Di chuyển chi tiết đơn hàng cũ sang đơn hàng mới
            $soLuong += $node->so_luong;
            $tongTienCNYDonHang += $node->tong_tien_cny;
            $tongTienDonhang += $node->tong_tien;
            $anhDonHang[] = $node->images;
            $thuocTinhSanPham[] = ['product_name' => $node->product_name, 'property' => $node->props_name, 'property_vn' => $node->props_name_vn];
        }

        $chiPhiMuaHangHo = QuanLyDonHang::getChiPhiMuaHang($tongTienDonhang);

        $chiPhiMuaHang = $chiPhiMuaHangHo['chiPhiMuaHang'];
        $chiPhiTheoThangGiaTri = $chiPhiMuaHangHo['chiPhiTheoThangGiaTri'];

        // Update lại tổng số lượng, tổng tiền CNY, tổng tiền VND của Đơn hàng
        $fieldsUpdate['tong_so_luong'] = $soLuong;
        $fieldsUpdate['tong_tien_cny'] = $tongTienCNYDonHang;
        $fieldsUpdate['ti_le_phan_tram_mua_hang'] = $chiPhiTheoThangGiaTri;
        $fieldsUpdate['tong_tien'] = $tongTienDonhang;
        $fieldsUpdate['thanh_tien'] = $tongTienDonhang + $chiPhiMuaHang;
        $fieldsUpdate['anh_don_hang'] = json_encode($anhDonHang);
        $fieldsUpdate['danh_sach_thuoc_tinh'] = json_encode($thuocTinhSanPham);
        $fieldsUpdate['phi_mua_hang'] = $chiPhiMuaHang;
        $thanhTien = $tongTienDonhang + $chiPhiMuaHang;
        $fieldsUpdate['da_thanh_toan'] = $thanhTien;

        // Update số tiền đã thanh toán
//            foreach ($fields as $field => $value)
        $donHang->updateAttributes($fieldsUpdate);

        if($new){
            $giaoDich = new GiaoDich();
            $giaoDich->khach_hang_id = $donHang->user_id;
            $giaoDich->trang_thai_giao_dich = GiaoDich::THANH_CONG;
            $giaoDich->loai_giao_dich = GiaoDich::THANH_TOAN_DON_HANG;
            $giaoDich->active = 1;
            $giaoDich->don_hang_lien_quan_id = $donHang->id;
            $giaoDich->tong_tien = $thanhTien;
            $giaoDich->user_id = ($content != '' ? $content->uid : Yii::$app->user->id);
            $giaoDich->so_du_trong_vi = $khachHang->vi_dien_tu - intval($thanhTien);
            $giaoDich->save();

            // Trừ tiền đơn hàng trong ví điện tử theo đơn hàng mới
            $khachHang->updateAttributes(['vi_dien_tu' => $khachHang->vi_dien_tu - intval($thanhTien)]);
        }
        else{
            if(count($chiTietDonHangDaChon) == 0)
                $donHang->updateAttributes(['active' => 0]);
        }
    }

    /**
     * @param $chiTietDonHang QuanLyChiTietDonHang[]
     * @param $content
     * @param $khachHang User
     * @return array
     */
   public static function muaHang($chiTietDonHang, $content, $khachHang){
       $nidsDonHangMoi = [];
       $ids = [];
       // Di chuyển chi tiết đơn hàng cũ sang đơn hàng mới
        foreach ($chiTietDonHang as $item){
            if(!isset($nidsDonHangMoi[$item->don_hang_id])){
                $donHangMoi = new DonHang();
                $fields = [
                    'shop_name' => $item->shop_name,
                    'shop_id' => $item->shop_id,
                    'ty_gia' => $item->ty_gia,
                    'created' => date("Y-m-d H:i:s"),  //$item->created_don_hang,
//                'anh_don_hang' => $donHangCu->anh_don_hang,
                    'phi_van_chuyen_hang' => 0,
                    'phi_dong_go' => 0,
                    'trang_thai' => DonHang::CHO_MUA,
                    'ship_noi_dia_cny' => 0,
                    'ship_noi_dia_vnd' => 0,
                    // Update số tiền đã thanh toán sau khi tạo xong giao dịch
//      'field_so_tien_da_thanh_toan' => $donHangCu->field_thanh_tien['und'][0]['value'],
                    'khoi_luong' => 0,
                    'chiet_khau' => $item->chiet_khau,
                    'kieu_chiet_khau' => $item->kieu_chiet_khau,
                    'ghi_chu' => $item->ghi_chu_don_hang,
                    'don_hang_id' => $item->don_hang_id,
                    'user_id' => isset($content->uid) ? $content->uid : Yii::$app->user->id,
                    'active' => 1,
                    'website' => $item->website
                ];

                foreach ($fields as $field => $value)
                    $donHangMoi->{$field} = $value;
                $donHangMoi->save();

                $nidsDonHangMoi[$item->don_hang_id] = $donHangMoi;

                $ids[] = $donHangMoi->id;
            }

            ChiTietDonHang::updateAll([
                'don_hang_id' => $nidsDonHangMoi[$item->don_hang_id]->id], ['id' => $item->id]);
        }

        // Update lại danh sách đơn hàng cũ và cũ
       foreach ($nidsDonHangMoi as $idDonhangCu => $donHangMoi){
           // Update lại danh sách đơn hàng mới
           self::updateLaiDonHang($donHangMoi, true, $content, $khachHang);
           // Update lại danh sách đơn hàng cũ
           self::updateLaiDonHang(DonHang::findOne($idDonhangCu),false, $content, $khachHang);
       }

        return (
            [
                'success' => true,
                'content' => [
                    'type' => 'done',
                    'message' => 'Hệ thống đã nhận đơn đặt hàng. ',
                    'nidDonHangs' => $ids
                ]
            ]
        ) ;
    }
}
