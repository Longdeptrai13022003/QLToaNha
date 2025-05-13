<?php

namespace backend\models;

use common\models\myAPI;
use common\models\User;
use DateTime;
use Yii;

/**
 * This is the model class for table "qlcvsd_phong_khach".
 *
 * @property int $id
 * @property int|null $khach_hang_id
 * @property int|null $phong_id
 * @property int|null $user_id
 * @property int|null $sale_id
 * @property string|null $created
 * @property string|null $thoi_gian_hop_dong_tu
 * @property string|null $thoi_gian_hop_dong_den
 * @property string|null $gio_vao
 * @property string|null $gio_ra
 * @property float|null $coc_truoc
 * @property string|null $trang_thai
 * @property string|null $ma_hop_dong
 * @property string|null $loai_hop_dong
 * @property int|null $so_thang_hop_dong
 * @property float|null $don_gia
 * @property float|null $moi_gioi
 * @property int|null $active
 * @property int|null $phong_cu_id
 * @property float $chiet_khau
 * @property string $kieu_chiet_khau
 * @property string $kieu_moi_gioi
 * @property string $ghi_chu
 * @property float $so_tien_chiet_khau
 * @property float $so_tien_moi_gioi
 * @property float $thanh_tien
 * @property float $da_thanh_toan
 * @property float $da_thanh_toan_moi_gioi
 *
 * @property DanhMuc $phongCu
 * @property DanhMuc $phong
 * @property User $khachHang
 * @property User $user
 */
class PhongKhach extends \yii\db\ActiveRecord
{
    const HOAN_THANH = 'Hoàn thành';
    const CHO_DUYET = 'Chờ duyệt';
    const DA_DUYET = 'Đã duyệt';
    const HUY_HOP_DONG = 'Hủy hợp đồng';
    const BA_GIO = '3_gio';
    const SAU_GIO = '6_gio';
    const NGAY = 'ngay';
    const THANG = 'thang';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qlcvsd_phong_khach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['khach_hang_id', 'phong_id', 'user_id','sale_id', 'so_thang_hop_dong', 'active', 'phong_cu_id'], 'integer'],
            [['created','thanh_tien','da_thanh_toan','gio_vao','gio_ra','loai_hop_dong'], 'safe'],
            [['thoi_gian_hop_dong_tu', 'thoi_gian_hop_dong_den','coc_truoc','khach_hang_id','ma_hop_dong'], 'required'],
            [['coc_truoc', 'chiet_khau','da_thanh_toan','moi_gioi','da_thanh_toan_moi_gioi','so_tien_moi_gioi'], 'number'],
            [['trang_thai', 'kieu_chiet_khau','kieu_moi_gioi'], 'string'],
            [['ma_hop_dong'], 'string', 'max' => 100],
            [['phong_cu_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['phong_cu_id' => 'id']],
            [['phong_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['phong_id' => 'id']],
            [['khach_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['khach_hang_id' => 'id']],
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
            'khach_hang_id' => 'Khach Hang ID',
            'phong_id' => 'Phong ID',
            'user_id' => 'User ID',
            'created' => 'Created',
            'thoi_gian_hop_dong_tu' => 'Thoi Gian Hop Dong Tu',
            'thoi_gian_hop_dong_den' => 'Thoi Gian Hop Dong Den',
            'coc_truoc' => 'Tiền cọc',
            'trang_thai' => 'Trang Thai',
            'ma_hop_dong' => 'Mã hợp đồng',
            'so_thang_hop_dong' => 'So Thang Hop Dong',
            'don_gia' => 'Don Gia',
            'active' => 'Active',
            'phong_cu_id' => 'Phong Cu ID',
            'chiet_khau' => 'Chiết khấu',
            'kieu_chiet_khau' => 'Kieu Chiet Khau',
            'so_tien_chiet_khau' => 'So Tien Chiet Khau',
            'da_thanh_toan' => 'Da thanh toan',
            'anh_hop_dong'=>'Anh hop dong'
        ];
    }

    /**
     * Gets query for [[PhongCu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongCu()
    {
        return $this->hasOne(DanhMuc::className(), ['id' => 'phong_cu_id']);
    }

    /**
     * Gets query for [[Phong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhong()
    {
        return $this->hasOne(DanhMuc::className(), ['id' => 'phong_id']);
    }

    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(User::className(), ['id' => 'khach_hang_id']);
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
    public function beforeSave($insert)
    {
        if($insert && ($this->created == '' || is_null($this->created))){
            $this->created = date("Y-m-d H:i:s");
        }
        if($this->user_id == '' || is_null($this->user_id))
            $this->user_id = Yii::$app->user->id;
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->thoi_gian_hop_dong_tu);
        $check = $date && $date->format('Y-m-d H:i:s') === $this->thoi_gian_hop_dong_tu;
        if (!$check){
            $this->thoi_gian_hop_dong_tu = myAPI::convertDateSaveIntoDb($this->thoi_gian_hop_dong_tu);
            $this->thoi_gian_hop_dong_den = myAPI::convertDateSaveIntoDb($this->thoi_gian_hop_dong_den);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            if($this->trang_thai == ''){
                $model = new TrangThaiPhongKhach();
                $model->trang_thai = self::DA_DUYET;
                $model->phong_khach_id = $this->id;
                $model->save();
            }
            $trangThaiPhong = new TrangThaiPhong();
            $trangThaiPhong->khach_hang_id = $this->khach_hang_id;
            $trangThaiPhong->trang_thai = TrangThaiPhong::DANG_CO_KHACH;
            $trangThaiPhong->thoi_gian_tu = $this->thoi_gian_hop_dong_tu;
            $trangThaiPhong->thoi_gian_den = $this->thoi_gian_hop_dong_den;
            $trangThaiPhong->phong_id = $this->phong_id;
            $trangThaiPhong->save();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
    public function afterUpdate()
    {
        $model = new TrangThaiPhongKhach();
        $model->trang_thai = $this->trang_thai;
        $model->phong_khach_id = $this->id;
        $model->save();
    }
    public function afterDelete()
    {
        $hoaDons = HoaDon::findAll(['phong_khach_id'=>$this->id]);
        $giaoDichs = GiaoDich::findAll(['phong_khach_id'=>$this->id]);
        foreach ($hoaDons as $hoaDon){
            $hoaDon->updateAttributes(['active'=>0]);
        }
        foreach ($giaoDichs as $giaoDich){
            $giaoDich->updateAttributes(['active'=>0]);
        }
        $this->updateAttributes(['active'=>0]);
    }

    public function afterHoanThanh($loai)
    {
        $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s',$this->thoi_gian_hop_dong_tu);
        $dateTo = DateTime::createFromFormat('Y-m-d H:i:s',$this->thoi_gian_hop_dong_den);

        $this->updateAttributes([
            'trang_thai' => PhongKhach::HOAN_THANH
        ]);
        if($dateFrom->format('Y-m') == $dateTo->format('Y-m')){
            return;
        }

        $this->afterUpdate();
        //Nếu hoàn thành hợp đồng thì tạo 1 hóa đơn tháng sau để thanh toán nốt tiền dịch vụ, tiền phòng = 0
        $nextMonth = strtotime('+1 month');
        if($loai == 'truoc'){
            $hoaDonFix = HoaDon::findOne([
                'active'=>1,
                'phong_khach_id'=>$this->id,
                'thang'=> (int)date('m'),
                'nam'=> (int)date('Y'),
            ]);
        }else{
            $hoaDonFix = HoaDon::findOne([
                'active'=>1,
                'phong_khach_id'=>$this->id,
                'thang'=> (int)date('m',$nextMonth),
                'nam'=> (int)date('Y',$nextMonth),
            ]);
        }
        if(is_null($hoaDonFix)){
            $hoaDonFix = new HoaDon();
            $hoaDonFix->phong_khach_id = $this->id;
            $hoaDonFix->thang = (int)date('m',$nextMonth);
            $hoaDonFix->nam = (int)date('Y',$nextMonth);
            $hoaDonFix->da_thanh_toan = 0;
            $hoaDonFix->tien_phong = 0;
            $hoaDonFix->chi_phi_dich_vu = 0;
            $hoaDonFix->tong_tien = 0;
            $hoaDonFix->save();
        }
        $chiTiets = ChiTietHoaDon::findAll([
            'hoa_don_id' => $hoaDonFix->id
        ]);
        foreach ($chiTiets as $chiTiet){
            if($chiTiet->dich_vu_id != 2){
                $chiTiet->updateAttributes([
                    'thanh_tien' => 0
                ]);
            }else{
                $hoaDonFix->updateAttributes([
                    'chi_phi_dich_vu' => $chiTiet->thanh_tien
                ]);
            }
        }
        $hoaDonFix->updateAttributes([
            'tong_tien' => $hoaDonFix->chi_phi_dich_vu,
            'tien_phong' => 0
        ]);
        $hoaDons = HoaDon::find()
            ->andFilterWhere(['phong_khach_id'=>$this->id])
            ->andFilterWhere(['active'=>1])
            ->andFilterWhere(['>','id',$hoaDonFix->id])->all();

        if(count($hoaDons) > 0){
            foreach ($hoaDons as $hoaDon){
                $hoaDon->updateAttributes([
                    'trang_thai' => HoaDon::HOAN_THANH,
                    'active'=>0
                ]);
                $hoaDon->afterUpdate();
            }
        }
    }
}