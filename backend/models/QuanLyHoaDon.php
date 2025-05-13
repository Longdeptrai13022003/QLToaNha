<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_hoa_don}}".
 *
 * @property int $id
 * @property int|null $phong_khach_id
 * @property int|null $active
 * @property float|null $chi_phi_dich_vu
 * @property int|null $chot_hoa_don
 * @property float|null $da_thanh_toan
 * @property string|null $created
 * @property int|null $thang
 * @property float|null $tien_phong
 * @property int|null $user_id
 * @property int|null $parent_id
 * @property int|null $khach_hang_id
 * @property int|null $phong_id
 * @property float|null $tong_tien
 * @property string|null $trang_thai
 * @property string|null $ma_hop_dong
 * @property string|null $ma_hoa_don
 * @property string|null $ten_phong
 * @property string|null $ten_toa_nha
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $nguoi_thuc_hien
 * @property int|null $nam
 * @property float|null $thanh_tien
 * @property int|null $so_nguoi
 */
class QuanLyHoaDon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_hoa_don}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phong_khach_id', 'active', 'chot_hoa_don', 'thang', 'user_id', 'nam'], 'integer'],
            [['chi_phi_dich_vu', 'da_thanh_toan', 'tien_phong', 'tong_tien', 'thanh_tien'], 'number'],
            [['created','parent_id','phong_id','khach_hang_id','so_nguoi'], 'safe'],
            [['trang_thai','ma_hoa_don','ten_phong','ten_toa_nha','ma_hop_dong','hoten','dien_thoai','nguoi_thuc_hien'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phong_khach_id' => 'Phong Khach ID',
            'active' => 'Active',
            'chi_phi_dich_vu' => 'Chi Phi Dich Vu',
            'chot_hoa_don' => 'Chot Hoa Don',
            'da_thanh_toan' => 'Da Thanh Toan',
            'created' => 'Created',
            'thang' => 'Thang',
            'tien_phong' => 'Tien Phong',
            'user_id' => 'User ID',
            'tong_tien' => 'Tong Tien',
            'trang_thai' => 'Trang Thai',
            'nam' => 'Nam',
            'khach_hang_id' => 'Khach Hang ID',
            'phong_id' => 'Phong ID',
            'thanh_tien' => 'Thanh Tien',
            'parent_id' => 'Parent ID',
        ];
    }
}
