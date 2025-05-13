<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_giao_dich}}".
 *
 * @property int $id
 * @property int|null $khach_hang_id
 * @property int|null $phong_khach_id
 * @property int|null $hoa_don_id
 * @property string|null $trang_thai_giao_dich
 * @property string|null $loai_giao_dich
 * @property string|null $ten_phong
 * @property string|null $ten_toa_nha
 * @property string|null $hoten
 * @property string|null $nguoi_thuc_hien
 * @property string|null $dien_thoai
 * @property float|null $tong_tien
 * @property float|null $thanh_tien
 * @property int|null $active
 * @property int|null $giao_dich_old_id
 * @property float|null $so_tien_giao_dich
 * @property string|null $ghi_chu
 * @property string|null $anh_chuyen_khoan
 * @property string|null $noi_dung_chuyen_khoan
 * @property int|null $user_id
 * @property int|null $ma_id_casso
 * @property string|null $ma_hop_dong
 * @property string|null $created
 * @property string|null $ma_qr
 * @property string|null $ma_hoa_don
 */
class QuanLyGiaoDich extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_giao_dich}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'khach_hang_id', 'phong_khach_id', 'hoa_don_id', 'active', 'user_id'], 'safe'],
            [['trang_thai_giao_dich', 'loai_giao_dich', 'ghi_chu', 'anh_chuyen_khoan'], 'safe'],
            [['tong_tien', 'so_tien_giao_dich', 'thanh_tien', 'hoten', 'dien_thoai','nguoi_thuc_hien'], 'safe'],
            [['created','ten_phong','ten_toa_nha'], 'safe'],
            [[ 'giao_dich_old_id'], 'safe'],
            [['noi_dung_chuyen_khoan', 'ma_qr'], 'safe'],
            [['ma_id_casso', 'ma_hop_dong', 'ma_hoa_don'], 'safe'],
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
            'trang_thai_giao_dich' => 'Trang Thai Giao Dich',
            'loai_giao_dich' => 'Loai Giao Dich',
            'tong_tien' => 'Tong Tien',
            'ma_giao_dich_khach_paste' => 'Ma Giao Dich Khach Paste',
            'active' => 'Active',
            'don_ky_gui_id' => 'Don Ky Gui ID',
            'ma_giao_dich_ngan_hang' => 'Ma Giao Dich Ngan Hang',
            'so_tien_giao_dich' => 'So Tien Giao Dich',
            'don_hang_lien_quan_id' => 'Don Hang Lien Quan ID',
            'so_tien_gd_moi_don_hang' => 'So Tien Gd Moi Don Hang',
            'ghi_chu' => 'Ghi Chu',
            'anh_giao_dich' => 'Anh Giao Dich',
            'url_anh_giao_dich' => 'Url Anh Giao Dich',
            'so_tai_khoan' => 'So Tai Khoan',
            'ten_ngan_hang' => 'Ten Ngan Hang',
            'ho_ten_tai_khoan' => 'Ho Ten Tai Khoan',
            'type_reference' => 'Type Reference',
            'user_id' => 'User ID',
            'created' => 'Created',
            'ma_giao_dich' => 'Ma Giao Dich',
            'ho_ten_khach_hang' => 'Ho Ten Khach Hang',
            'dien_thoai_khach_hang' => 'Dien Thoai Khach Hang',
            'ho_ten_user' => 'Ho Ten User',
            'dien_thoai_user' => 'Dien Thoai User',
        ];
    }
}
