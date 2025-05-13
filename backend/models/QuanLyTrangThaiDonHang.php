<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_Ly_trang_thai_don_hang}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $created
 * @property int|null $don_hang_id
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property string|null $hoten
 * @property string|null $dien_thoai
 */
class QuanLyTrangThaiDonHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_Ly_trang_thai_don_hang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'don_hang_id'], 'integer'],
            [['created'], 'safe'],
            [['trang_thai', 'ghi_chu'], 'string'],
            [['hoten'], 'string', 'max' => 100],
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
            'user_id' => 'User ID',
            'created' => 'Created',
            'don_hang_id' => 'Don Hang ID',
            'trang_thai' => 'Trang Thai',
            'ghi_chu' => 'Ghi Chu',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
        ];
    }
}
