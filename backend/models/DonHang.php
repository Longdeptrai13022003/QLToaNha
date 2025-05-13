<?php

namespace backend\models;

use common\models\User;
use Yii;


/**
 * This is the model class for table "{{%don_hang}}".
 *
 * @property int $id
 * @property string|null $created
 * @property int|null $user_id
 * @property int|null $da_duyet
 * @property int|null $don_hang_dong_bo_cu_id
 * @property int|null $da_chon_thuc_hien_chuc_nang
 * @property int|null $so_luong
 * @property float|null $tong_tien
 * @property string|null $anh_don_hang
 * @property string|null $ma_van_don_ky_gui
 * @property string|null $type
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
 * @property float|null $can_nang_tinh_phi
 * @property float|null $phi_mua_hang
 * @property float|null $khoi_luong
 * @property float|null $ti_le_phan_tram_mua_hang
 * @property string|null $ghi_chu
 * @property string|null $ma_kien_hang
 * @property string|null $ma_van_don
 * @property string|null $website
 * @property string|null $shop_link
 * @property float|null $tong_tien_cny
 * @property int|null $tong_so_luong
 * @property string|null $dich_vu
 * @property string|null $anh_chi_tiet_don_hang
 * @property int|null $don_hang_id
 * @property int|null $khach_hang_id
 * @property int|null $line_van_chuyen
 * @property float|null $tien_hang_chiet_khau Số tiền chiết khấu sau khi áp dụng đơn vị tính chiết khấu. VD: 10% được 100k thì lưu 100k
 * @property string|null $kieu_chiet_khau_tien_hang
 * @property float|null $chiet_khau_tien_hang VD: 10 (%) hoặc 20.000
 * @property float|null $phi_khoi_luong
 * @property string|null $han_cuoi_khieu_nai
 * @property string|null $cong_thuc_khoi_luong
 * @property int|null $qua_han_khieu_nai
 * @property string|null $danh_sach_thuoc_tinh
 * @property string|null $dvt_khoi_luong
 * @property string|null $ma_van_chuyen_don_hang
 * @property string|null $so_dien_thoai_nha_xe
 * @property string|null $hinh_thuc_nhan_hang
 * @property string|null $cong_cu_mua_hang
 * @property string|null $field_noi_dung_khieu_nai
 * @property string|null $field_nguoi_nhap_phan_hoi
 * @property string|null $field_trang_thai_khieu_nai
 * @property string|null $field_so_dien_thoai_nha_xe
 * @property string|null $field_ngay_phan_hoi
 * @property float|null $so_tien_hoan_lai
 * @property float|null $phi_giao_hang_den_nha_xe
 *
 * @property ChiTietDonHang[] $chiTietDonHangs
 * @property DanhMuc $phuongThucThanhToan
 * @property DanhMuc $loaiGiaoHang
 * @property DiaChiNhanHang $diaChiNhanHang
 * @property DonHang $parent
 * @property DonHang[] $donHangs
 * @property DonHang $donHang
 * @property DonHang[] $donHangs0
 * @property User $user
 * @property GiaoDich[] $giaoDiches
 * @property TrangThaiDonHang[] $trangThaiDonHangs
 */

class DonHang extends \yii\db\ActiveRecord
{
  const CHO_XAC_NHAN = 'Chờ xác nhận';
  const CHO_MUA = 'Chờ mua';
  const DON_HANG_CHO = 'Đơn hàng chờ';
  const DA_DAT_HANG = 'Đã đặt hàng';
  const CHO_CHUYEN_HANG = 'Chờ chuyển hàng';
  const DA_GUI_HANG = 'Đã gửi hàng';
  const DA_NHAN = 'Đã nhận';
  const DA_HOAN = 'Đã hoàn';
  const DA_HUY = 'Đã huỷ';
  const GIO_HANG = 'Giỏ hàng';
  const DANG_O_KHO_TQ = 'Đang ở kho TQ';
  const DA_GIAO = 'Đã giao hàng';
  const DANG_O_VIET_NAM = 'Đang ở VN';
  const DANG_MUA_HANG = 'Đang mua hàng';
  const DANG_CHO_HUY = 'Đang chờ huỷ';
  const YEU_CAU_GIAO_HANG = 'Yêu cầu giao hàng';
  const CHO_GIAO = 'Chờ giao';
  const NGUOI_BAN_GIAO = 'Người bán giao';
  const LINE_NHANH = 7130;
  const LINE_CHAM = 7131;
  const CHUYEN_PHAT_NHANH = 'Chuyển phát nhanh';
  const GUI_XE_KHACH = 'Gửi xe khách';

  public static $listTrangThaiDonHang = [
      self::DON_HANG_CHO => self::DON_HANG_CHO,
      self::CHO_MUA => self::CHO_MUA,
      self::DA_DAT_HANG => self::DA_DAT_HANG,
      self::DA_GUI_HANG => self::DA_GUI_HANG,
      self::DA_NHAN => self::DA_NHAN,
      self::DA_HUY => self::DA_HUY,
      self::CHO_CHUYEN_HANG => self::CHO_CHUYEN_HANG,
      self::DA_HOAN => self::DA_HOAN,
      self::DANG_O_KHO_TQ => self::DANG_O_KHO_TQ,
      self::DA_GIAO => self::DA_GIAO,
      self::DANG_O_VIET_NAM => self::DANG_O_VIET_NAM,
      self::DANG_MUA_HANG => self::DANG_MUA_HANG,
      self::DANG_CHO_HUY => self::DANG_CHO_HUY,
      self::YEU_CAU_GIAO_HANG => self::YEU_CAU_GIAO_HANG,
      self::CHO_GIAO => self::CHO_GIAO,
      self::NGUOI_BAN_GIAO => self::NGUOI_BAN_GIAO,
  ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%don_hang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'han_cuoi_khieu_nai', 'can_nang_tinh_phi', 'ma_kien_hang', 'don_hang_dong_bo_cu_id', 'da_duyet',
                'da_chon_thuc_hien_chuc_nang', 'line_van_chuyen', 'cong_thuc_khoi_luong', 'field_so_dien_thoai_nha_xe'], 'safe'],
            [['user_id', 'so_luong', 'da_chon_de_thanh_toan', 'loai_giao_hang_id', 'phuong_thuc_thanh_toan_id', 'parent_id',
                'dia_chi_nhan_hang_id', 'shop_id', 'active', 'ty_gia', 'tong_so_luong', 'don_hang_id',
                'qua_han_khieu_nai'], 'integer'],
            [['tong_tien', 'chiet_khau', 'tien_chiet_khau', 'phi_giao_hang_tan_noi', 'thanh_tien', 'da_thanh_toan', 'hoan_tien',
                'ship_noi_dia_cny', 'ship_noi_dia_vnd', 'phi_van_chuyen_hang', 'phi_dong_go', 'phi_mua_hang', 'khoi_luong',
                'ti_le_phan_tram_mua_hang', 'tong_tien_cny', 'tien_hang_chiet_khau', 'chiet_khau_tien_hang', 'phi_khoi_luong',
                'so_tien_hoan_lai', 'phi_giao_hang_den_nha_xe'], 'number'],
            [['anh_don_hang', 'kieu_chiet_khau', 'trang_thai', 'anh_dia_chi_nhan_hang', 'shop_name', 'ghi_chu', 'shop_link',
                'anh_chi_tiet_don_hang', 'kieu_chiet_khau_tien_hang', 'danh_sach_thuoc_tinh', 'dvt_khoi_luong', 'hinh_thuc_nhan_hang'], 'string'],
            [['anh_dia_chi', 'website'], 'string', 'max' => 300],
            [['type', 'khach_hang_id', 'ma_van_don_ky_gui', 'field_noi_dung_khieu_nai', 'field_nguoi_nhap_phan_hoi', 'field_trang_thai_khieu_nai', 'field_ngay_phan_hoi'], 'safe'],
            [['ho_ten_nguoi_thanh_toan', 'dien_thoai_nguoi_thanh_toan', 'hinh_anh_dia_chi', 'ma_van_don', 'dich_vu', 'ma_van_chuyen_don_hang', 'cong_cu_mua_hang'], 'string', 'max' => 100],
            [['so_dien_thoai_nha_xe'], 'string', 'max' => 20],
            [['phuong_thuc_thanh_toan_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['phuong_thuc_thanh_toan_id' => 'id']],
            [['loai_giao_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['loai_giao_hang_id' => 'id']],
            [['dia_chi_nhan_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaChiNhanHang::className(), 'targetAttribute' => ['dia_chi_nhan_hang_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DonHang::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['don_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => DonHang::className(), 'targetAttribute' => ['don_hang_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[ChiTietDonHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::className(), ['don_hang_id' => 'id']);
    }

    /**
     * Gets query for [[PhuongThucThanhToan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhuongThucThanhToan()
    {
        return $this->hasOne(DanhMuc::className(), ['id' => 'phuong_thuc_thanh_toan_id']);
    }

    /**
     * Gets query for [[LoaiGiaoHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiGiaoHang()
    {
        return $this->hasOne(DanhMuc::className(), ['id' => 'loai_giao_hang_id']);
    }

    /**
     * Gets query for [[DiaChiNhanHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiaChiNhanHang()
    {
        return $this->hasOne(DiaChiNhanHang::className(), ['id' => 'dia_chi_nhan_hang_id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DonHang::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[DonHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonHangs()
    {
        return $this->hasMany(DonHang::className(), ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TrangThaiDonHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrangThaiDonHangs()
    {
        return $this->hasMany(TrangThaiDonHang::className(), ['don_hang_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if($insert && ($this->created == '' || is_null($this->created)))
            $this->created = date("Y-m-d H:i:s");
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $model = new TrangThaiDonHang();
            $model->don_hang_id = $this->id;
            $model->trang_thai = $this->trang_thai;
            $model->user_id = $this->user_id;
            $model->created = date("Y-m-d H:i:s");
            $model->save();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @param $khoiLuong
     * @return float
     */
    public function tinhPhiKhoiLuong($khoiLuong){
        $cauHinhChiPhiKhoiLuong = explode('<br />', nl2br(CauHinh::findOne(['ghi_chu' => 'cau_hinh_chi_phi_khoi_luong'])->content));
        $donGiaPhiKhoiLuong = 0;
        foreach ($cauHinhChiPhiKhoiLuong as $item){
            if(strpos($item, ':') !== false){
                $arr = explode(':', $item);
                if(intval($arr[1])  >= $khoiLuong){
                    $donGiaPhiKhoiLuong = $arr[1];
                    break;
                }
            }else
                $donGiaPhiKhoiLuong = trim(intval($item));
        }
        return $donGiaPhiKhoiLuong * $khoiLuong;
    }
}
