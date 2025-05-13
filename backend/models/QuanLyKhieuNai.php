<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_khieu_nai}}".
 *
 * @property int $id
 * @property string|null $titlte
 * @property string|null $field_noi_dung_khieu_nai
 * @property string|null $field_trang_thai_khieu_nai
 * @property string|null $field_nguoi_nhap_phan_hoi
 * @property int|null $field_don_hang_id
 * @property string|null $field_anh_khieu_nai
 * @property int|null $field_active
 * @property int|null $user_id
 * @property string|null $created
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $username
 */
class QuanLyKhieuNai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_khieu_nai}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'field_don_hang_id', 'field_active', 'user_id'], 'integer'],
            [['field_noi_dung_khieu_nai', 'field_trang_thai_khieu_nai', 'field_nguoi_nhap_phan_hoi', 'field_anh_khieu_nai'], 'string'],
            [['created'], 'safe'],
            [['titlte', 'hoten', 'username'], 'string', 'max' => 100],
            [['dien_thoai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titlte' => 'Titlte',
            'field_noi_dung_khieu_nai' => 'Field Noi Dung Khieu Nai',
            'field_trang_thai_khieu_nai' => 'Field Trang Thai Khieu Nai',
            'field_nguoi_nhap_phan_hoi' => 'Field Nguoi Nhap Phan Hoi',
            'field_don_hang_id' => 'Field Don Hang ID',
            'field_anh_khieu_nai' => 'Field Anh Khieu Nai',
            'field_active' => 'Field Active',
            'user_id' => 'User ID',
            'created' => 'Created',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
            'username' => 'Username',
        ];
    }
}
