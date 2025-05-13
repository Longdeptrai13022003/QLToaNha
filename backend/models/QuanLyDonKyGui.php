<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "{{%quan_ly_don_ky_gui}}".
 *
 * @property int $id
 * @property float|null $field_tong_tien_cny
 * @property float|null $field_tong_tien
 * @property float|null $field_so_tien_da_thanh_toan
 * @property string|null $field_trang_thai
 * @property float|null $field_khoi_luong
 * @property float|null $field_phi_can_nang
 * @property float|null $field_thanh_tien
 * @property int|null $field_active
 * @property int|null $field_dia_chi_nhan_hang_id
 * @property int|null $field_tuyen_van_chuyen_id
 * @property string|null $field_ghi_chu
 * @property string|null $kich_thuoc
 * @property int|null $field_ty_gia
 * @property string|null $field_hinh_anh
 * @property int|null $field_co_anh
 * @property string|null $field_ma_van_don_ky_gui
 * @property string|null $field_ma_khach
 * @property int|null $field_khach_hang_id
 * @property string|null $field_dvt_khoi_luong
 * @property string|null $field_ma_van_chuyen_don_hang
 * @property string|null $field_hinh_thuc_nhan_hang
 * @property string|null $field_so_dien_thoai_nha_xe
 * @property string|null $field_han_cuoi_khieu_nai
 * @property string|null $field_danh_sach_ma_ky_gui
 * @property float|null $field_danh_sach_khoi_luong
 * @property int|null $da_chon_thuc_hien_chuc_nang Chọn để thực hiện các chức năng
 * @property float|null $field_so_tien_hoan_lai
 * @property string|null $created
 * @property string|null $line
 * @property int|null $user_id
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $username
 * @property string|null $ho_ten_khach_hang
 * @property string|null $dien_thoai_khach_hang
 * @property string|null $username_khach_hang
 * @property string|null $ho_ten_nguoi_nhan
 * @property string|null $ten_tuyen_van_chuyen
 * @property string|null $dien_thoai_nguoi_nhan
 * @property string|null $thong_tin_dia_chi
 * @property int|null $phi_van_chuyen_noi_dia_vnd
 * @property double|null $phi_van_chuyen_noi_dia
 */

class QuanLyDonKyGui extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_don_ky_gui}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'field_active', 'field_dia_chi_nhan_hang_id', 'field_tuyen_van_chuyen_id', 'field_ty_gia',
                'field_co_anh', 'field_khach_hang_id', 'user_id'], 'integer'],
            [['field_tong_tien_cny', 'field_tong_tien', 'field_so_tien_da_thanh_toan', 'field_khoi_luong',
                'field_phi_can_nang', 'field_thanh_tien', 'field_danh_sach_khoi_luong', 'field_so_tien_hoan_lai'], 'number'],
            [['field_trang_thai', 'field_ghi_chu', 'field_hinh_anh', 'field_dvt_khoi_luong', 'field_hinh_thuc_nhan_hang',
                'thong_tin_dia_chi'], 'string'],
            [['field_han_cuoi_khieu_nai', 'created', 'ten_tuyen_van_chuyen', 'username_khach_hang', 'dien_thoai_khach_hang',
                'ho_ten_khach_hang', 'kich_thuoc', 'line', 'da_chon_thuc_hien_chuc_nang'], 'safe'],
            [['field_ma_van_don_ky_gui', 'field_ma_khach', 'field_so_dien_thoai_nha_xe', 'field_danh_sach_ma_ky_gui', 'hoten',
                'username', 'ho_ten_nguoi_nhan'], 'string', 'max' => 100],
            [['field_ma_van_chuyen_don_hang', 'dien_thoai', 'dien_thoai_nguoi_nhan'], 'string', 'max' => 20],
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
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
            'username' => 'Username',
        ];
    }
}
