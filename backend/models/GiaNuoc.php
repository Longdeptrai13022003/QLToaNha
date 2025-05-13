<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%gia_nuoc}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $luong_nuoc
 * @property string|null $don_gia
 * @property int|null $thue
 */
class GiaNuoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gia_nuoc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thue'], 'integer'],
            [['name', 'luong_nuoc', 'don_gia'], 'string', 'max' => 100],
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
            'luong_nuoc' => 'Luong Nuoc',
            'don_gia' => 'Don Gia',
            'thue' => 'Thue',
        ];
    }
}
