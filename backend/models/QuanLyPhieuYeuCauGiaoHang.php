<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qlcvsd_quan_ly_phieu_yeu_cau_giao_hang".
 *
 * @property int $id
 * @property string|null $field_danh_sach_don_hang
 * @property string|null $field_ma_van_don
 * @property string|null $field_hinh_thuc_nhan_hang
 * @property string|null $field_so_dien_thoai_nha_xe
 * @property int|null $field_active
 * @property int|null $field_dia_chi_nhan_hang_id
 * @property string|null $field_phan_loai
 * @property string|null $field_ds_ma_van_don_ky_gui
 * @property float|null $field_phi_giao_hang_den_nha_xe
 * @property float|null $field_tong_tien
 * @property float|null $field_thanh_tien
 * @property float|null $field_so_tien_hoan_lai
 * @property float|null $field_so_tien_da_thanh_toan
 * @property string|null $created
 * @property int|null $user_id
 * @property int|null $phi_dong_goi
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $ho_ten_nguoi_nhan
 * @property string|null $dien_thoai_nguoi_nhan
 * @property string|null $thong_tin_dia_chi
 */
class QuanLyPhieuYeuCauGiaoHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qlcvsd_quan_ly_phieu_yeu_cau_giao_hang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'field_active', 'field_dia_chi_nhan_hang_id', 'user_id'], 'integer'],
            [['field_danh_sach_don_hang', 'field_hinh_thuc_nhan_hang', 'field_phan_loai', 'field_ds_ma_van_don_ky_gui', 'thong_tin_dia_chi'], 'string'],
            [['field_phi_giao_hang_den_nha_xe', 'field_tong_tien', 'field_thanh_tien', 'field_so_tien_hoan_lai', 'field_so_tien_da_thanh_toan'], 'number'],
            [['created', 'phi_dong_goi'], 'safe'],
            [['field_ma_van_don', 'field_so_dien_thoai_nha_xe', 'hoten', 'ho_ten_nguoi_nhan'], 'string', 'max' => 100],
            [['dien_thoai', 'dien_thoai_nguoi_nhan'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_danh_sach_don_hang' => 'Field Danh Sach Don Hang',
            'field_ma_van_don' => 'Field Ma Van Don',
            'field_hinh_thuc_nhan_hang' => 'Field Hinh Thuc Nhan Hang',
            'field_so_dien_thoai_nha_xe' => 'Field So Dien Thoai Nha Xe',
            'field_active' => 'Field Active',
            'field_dia_chi_nhan_hang_id' => 'Field Dia Chi Nhan Hang ID',
            'field_phan_loai' => 'Field Phan Loai',
            'field_ds_ma_van_don_ky_gui' => 'Field Ds Ma Van Don Ky Gui',
            'field_phi_giao_hang_den_nha_xe' => 'Field Phi Giao Hang Den Nha Xe',
            'field_tong_tien' => 'Field Tong Tien',
            'field_thanh_tien' => 'Field Thanh Tien',
            'field_so_tien_hoan_lai' => 'Field So Tien Hoan Lai',
            'field_so_tien_da_thanh_toan' => 'Field So Tien Da Thanh Toan',
            'created' => 'Created',
            'user_id' => 'User ID',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
            'ho_ten_nguoi_nhan' => 'Ho Ten Nguoi Nhan',
            'dien_thoai_nguoi_nhan' => 'Dien Thoai Nguoi Nhan',
            'thong_tin_dia_chi' => 'Thong Tin Dia Chi',
        ];
    }
}
