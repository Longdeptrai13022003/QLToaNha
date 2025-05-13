<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_phong}}".
 *
 * @property int $id
 * @property int|null $selected
 * @property int|null $parent_id
 * @property int|null $active
 * @property int|null $active_phong
 * @property string|null $hoten
 * @property string|null $ten_toa_nha
 * @property string|null $ma_hop_dong
 * @property string|null $thoi_gian_hop_dong_tu
 * @property string|null $thoi_gian_hop_dong_den
 * @property string|null $name
 * @property string|null $dien_thoai
 */
class QuanLyPhong extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_phong}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'selected','active_phong'], 'safe'],
            [['parent_id','active','thoi_gian_hop_dong_tu','thoi_gian_hop_dong_den'], 'safe'],
            [['hoten', 'name','ten_toa_nha'], 'safe'],
            [['dien_thoai','ma_hop_dong'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'selected' => 'Selected',
            'hoten' => 'Hoten',
            'dien_thoai' => 'Dien Thoai',
        ];
    }
}
