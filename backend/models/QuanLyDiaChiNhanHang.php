<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_dia_chi_nhan_hang}}".
 *
 * @property int $id
 * @property string|null $thong_tin_dia_chi
 * @property string|null $ghi_chu
 * @property int|null $user_id
 * @property int|null $mac_dinh
 * @property int|null $active
 * @property string|null $ho_ten_nguoi_nhan
 * @property string|null $dien_thoai_nguoi_nhan
 * @property string|null $hoten
 * @property string|null $dien_thoai
 */
class QuanLyDiaChiNhanHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_dia_chi_nhan_hang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'mac_dinh', 'active'], 'integer'],
            [['thong_tin_dia_chi', 'ghi_chu'], 'string'],
            [['ho_ten_nguoi_nhan', 'hoten'], 'string', 'max' => 100],
            [['dien_thoai_nguoi_nhan', 'dien_thoai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thong_tin_dia_chi' => 'Thong Tin Dia Chi',
            'ghi_chu' => 'Ghi Chu',
            'user_id' => 'User ID',
            'mac_dinh' => 'Mac Dinh',
            'active' => 'Active',
            'ho_ten_nguoi_nhan' => 'Ho Ten Nguoi Nhan',
            'dien_thoai_nguoi_nhan' => 'Dien Thoai Nguoi Nhan',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
        ];
    }
}
