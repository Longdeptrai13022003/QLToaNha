<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_trang_thai_giao_dich}}".
 *
 * @property int $id
 * @property int|null $giao_dich_id
 * @property string|null $created
 * @property int|null $user_id
 * @property string|null $trang_thai
 * @property string|null $hoten
 * @property string|null $dien_thoai
 */
class QuanLyTrangThaiGiaoDich extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_trang_thai_giao_dich}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'giao_dich_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['trang_thai'], 'string'],
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
            'giao_dich_id' => 'Giao Dich ID',
            'created' => 'Created',
            'user_id' => 'User ID',
            'trang_thai' => 'Trang Thai',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
        ];
    }
}
