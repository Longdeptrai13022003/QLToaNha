<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "qlcvsd_thiet_lap_gia".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $don_gia
 * @property string|null $don_vi_tinh
 */
class ThietLapGia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qlcvsd_thiet_lap_gia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['don_gia'], 'number'],
            [['name', 'don_vi_tinh'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'don_gia' => 'Don Gia',
            'don_vi_tinh' => 'Don Vi Tinh',
        ];
    }
}
