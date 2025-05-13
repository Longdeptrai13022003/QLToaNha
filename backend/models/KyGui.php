<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%ky_gui}}".
 *
 * @property int $id
 * @property float|null $field_tong_tien_cny
 * @property float|null $field_tong_tien
 * @property float|null $field_so_tien_da_thanh_toan
 * @property string|null $field_trang_thai
 * @property string|null $kich_thuoc
 * @property float|null $field_khoi_luong
 * @property float|null $field_phi_can_nang
 * @property float|null $field_thanh_tien
 * @property int|null $field_active
 * @property int|null $field_dia_chi_nhan_hang_id
 * @property int|null $field_tuyen_van_chuyen_id
 * @property string|null $field_ghi_chu
 * @property string|null $line
 * @property int|null $field_ty_gia
 * @property string|null $field_hinh_anh
 * @property int|null $field_co_anh
 * @property string|null $field_ma_van_don_ky_gui
 * @property int|null $da_chon_thuc_hien_chuc_nang Chọn để thực hiện các chức năng
 * @property string|null $field_ma_khach
 * @property int|null $field_khach_hang_id
 * @property string|null $field_dvt_khoi_luong
 * @property string|null $field_ma_van_chuyen_don_hang
 * @property string|null $field_hinh_thuc_nhan_hang
 * @property string|null $field_so_dien_thoai_nha_xe
 * @property string|null $field_han_cuoi_khieu_nai
 * @property string|null $field_danh_sach_ma_ky_gui
 * @property float|null $field_danh_sach_khoi_luong
 * @property float|null $field_so_tien_hoan_lai
 * @property string|null $created
 * @property int|null $user_id
 *
 * @property GiaoDich[] $giaoDiches
 * @property DiaChiNhanHang $fieldDiaChiNhanHang
 * @property User $user
 * @property TrangThaiDonKyGui[] $trangThaiDonKyGuis
 */
class KyGui extends \yii\db\ActiveRecord
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

    const LINE_NHANH_NEW = 'Line nhanh';
    const LINE_CHAM_NEW = 'Line chậm';

    const KG = 'Kg';
    const KHOI = 'Khối';
    const CHUYEN_PHAT_NHANH = 'Chuyển phát nhanh';
    const GUI_XE_KHACH = 'Gửi xe khách';
    const CHO_XU_LY = 'Đơn hàng chờ';
    const NHAP_KHO_TQ = 'Đang ở kho TQ';
    const VC_TQ_VN = 'Đang VC TQ-VN';
    const KIEM_HOA = 'Kiểm hoá';
    const NHAP_KHO_VN = 'Đang ở VN';

    public static $listTrangThaiDonKyGui = [
        self::CHO_XU_LY => self::CHO_XU_LY,
        self::NHAP_KHO_TQ => self::NHAP_KHO_TQ,
        self::VC_TQ_VN => self::VC_TQ_VN,
        self::KIEM_HOA => self::KIEM_HOA,
        self::NHAP_KHO_VN => self::NHAP_KHO_VN,
        self::DA_GIAO => self::DA_GIAO,
    ];
    public static $listLineVC= [
        self::LINE_NHANH_NEW => self::LINE_NHANH_NEW,
        self::LINE_CHAM_NEW => self::LINE_CHAM_NEW,
    ];

    public static $listDvtKhoiLuong= [
        self::KG => self::KG,
        self::KHOI => self::KHOI,
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ky_gui}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_tong_tien_cny', 'field_tong_tien', 'field_so_tien_da_thanh_toan', 'field_khoi_luong', 'field_phi_can_nang',
                'field_thanh_tien', 'field_danh_sach_khoi_luong', 'field_so_tien_hoan_lai'], 'number'],
            [['field_trang_thai', 'field_ghi_chu', 'field_hinh_anh', 'field_dvt_khoi_luong', 'field_hinh_thuc_nhan_hang'], 'string'],
            [['field_active', 'field_dia_chi_nhan_hang_id', 'field_tuyen_van_chuyen_id', 'field_ty_gia', 'field_co_anh', 'field_khach_hang_id', 'user_id'], 'integer'],
            [['field_han_cuoi_khieu_nai', 'created', 'kich_thuoc', 'line','da_chon_thuc_hien_chuc_nang'], 'safe'],
            [['field_ma_van_don_ky_gui', 'field_ma_khach', 'field_so_dien_thoai_nha_xe', 'field_danh_sach_ma_ky_gui'], 'string', 'max' => 100],
            [['field_ma_van_chuyen_don_hang'], 'string', 'max' => 20],
            [['field_dia_chi_nhan_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaChiNhanHang::className(), 'targetAttribute' => ['field_dia_chi_nhan_hang_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_tong_tien_cny' => 'Field Tong Tien Cny',
            'field_tong_tien' => 'Field Tong Tien',
            'field_so_tien_da_thanh_toan' => 'Field So Tien Da Thanh Toan',
            'field_trang_thai' => 'Field Trang Thai',
            'field_khoi_luong' => 'Field Khoi Luong',
            'field_phi_can_nang' => 'Field Phi Can Nang',
            'field_thanh_tien' => 'Field Thanh Tien',
            'field_active' => 'Field Active',
            'field_dia_chi_nhan_hang_id' => 'Field Dia Chi Nhan Hang ID',
            'field_tuyen_van_chuyen_id' => 'Field Tuyen Van Chuyen ID',
            'field_ghi_chu' => 'Field Ghi Chu',
            'field_ty_gia' => 'Field Ty Gia',
            'field_hinh_anh' => 'Field Hinh Anh',
            'field_co_anh' => 'Field Co Anh',
            'field_ma_van_don_ky_gui' => 'Field Ma Van Don Ky Gui',
            'field_ma_khach' => 'Field Ma Khach',
            'field_khach_hang_id' => 'Field Khach Hang ID',
            'field_dvt_khoi_luong' => 'Field Dvt Khoi Luong',
            'field_ma_van_chuyen_don_hang' => 'Field Ma Van Chuyen Don Hang',
            'field_hinh_thuc_nhan_hang' => 'Field Hinh Thuc Nhan Hang',
            'field_so_dien_thoai_nha_xe' => 'Field So Dien Thoai Nha Xe',
            'field_han_cuoi_khieu_nai' => 'Field Han Cuoi Khieu Nai',
            'field_danh_sach_ma_ky_gui' => 'Field Danh Sach Ma Ky Gui',
            'field_danh_sach_khoi_luong' => 'Field Danh Sach Khoi Luong',
            'field_so_tien_hoan_lai' => 'Field So Tien Hoan Lai',
            'created' => 'Created',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[GiaoDiches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoDiches()
    {
        return $this->hasMany(GiaoDich::className(), ['don_ky_gui_id' => 'id']);
    }

    /**
     * Gets query for [[FieldDiaChiNhanHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldDiaChiNhanHang()
    {
        return $this->hasOne(DiaChiNhanHang::className(), ['id' => 'field_dia_chi_nhan_hang_id']);
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

//    /**
//     * Gets query for [[TrangThaiDonKyGuis]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public static function getTrangThaiDonKyGuis()
//    {
//        return $this->hasMany(TrangThaiDonKyGui::className(), ['field_don_ky_gui_id' => 'id']);
//    }

    /**
     * @param $nodeLine string
     * @param $donViTinh string
     * @param $khoiLuong int
     * @return float|int
     */
    public function getPhiKhoiLuong($nodeLine, $donViTinh, $khoiLuong){
        $data = explode('<br />', nl2br($nodeLine));
        if($donViTinh == 'Khối')
            return $khoiLuong * doubleval(explode(':', $data[0])[1]); // -1:2500000
        else{
            for($i = count($data) - 1; $i > 0 ; $i--)
                if(doubleval(explode(':', $data[$i])[0]) < $khoiLuong)
                    return $khoiLuong * explode(':', $data[$i])[1];
        }
        return 0;
    }

    public static function getPhiKhoiLuongDonKyGui($khoiLuong, $typeLine = 'Line chậm', $donViTinh = 'kg'){
        if($typeLine == 'Line chậm')
            $cauHinh = CauHinh::findOne(['ghi_chu' => 'bang_gia_line_cham_ky_gui'])->content;
        else
            $cauHinh = CauHinh::findOne(['ghi_chu' => 'bang_gia_line_nhanh_ky_gui'])->content;

        return (new KyGui)->getPhiKhoiLuong($cauHinh, $donViTinh, $khoiLuong);
//-1:2800000
//0:28000
//200:28000
        //return intval(CauHinh::findOne(['ghi_chu' => 'don_gia_ky_gui'])->content) * $khoiLuong;
    }

    public function tinhPhiKhoiLuong($khoiLuong, $donViTinh = 'kg', $line = 'bang_gia_line_cham_ky_gui'){
        $nodeLine = CauHinh::findOne(['ghi_chu' => $line])->content;
        return (new KyGui)->getPhiKhoiLuong($nodeLine, $donViTinh, $khoiLuong);
    }

    public function beforeSave($insert)
    {
        if($this->field_trang_thai == '' || is_null($this->field_trang_thai))
            $this->field_trang_thai = 'Đơn hàng chờ';
        if($insert)
            $this->created = date("Y-m-d H:i:s");
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $trangThaiDonKyGui = new TrangThaiDonKyGui();
            $trangThaiDonKyGui->user_id = $this->user_id;
            $trangThaiDonKyGui->created = date("Y-m-d H:i:s");
            $trangThaiDonKyGui->field_trang_thai = KyGui::DON_HANG_CHO;
            $trangThaiDonKyGui->field_don_ky_gui_id = $this->id;
            $trangThaiDonKyGui->save();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
