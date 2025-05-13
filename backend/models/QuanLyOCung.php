<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_o_cung}}".
 *
 * @property int $id
 * @property int|null $nguoi_o_cung_id
 * @property int|null $hoa_don_id
 * @property string|null $ma_hoa_don
 * @property int|null $thang
 * @property int|null $hop_dong_id
 * @property string|null $ho_ten
 * @property string|null $dien_thoai
 * @property int|null $active
 */
class QuanLyOCung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_o_cung}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nguoi_o_cung_id', 'hoa_don_id', 'thang', 'active','hop_dong_id'], 'integer'],
            [['ma_hoa_don', 'ho_ten'], 'string', 'max' => 100],
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
            'nguoi_o_cung_id' => 'Nguoi O Cung ID',
            'hoa_don_id' => 'Hoa Don ID',
            'ma_hoa_don' => 'Ma Hoa Don',
            'thang' => 'Thang',
            'ho_ten' => 'Ho Ten',
            'dien_thoai' => 'Dien Thoai',
            'active' => 'Active',
        ];
    }
}
