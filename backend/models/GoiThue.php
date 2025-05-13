<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%goi_thue}}".
 *
 * @property int $id
 * @property string $ten
 * @property string|null $ky_hieu
 * @property int|null $don_gia
 */
class GoiThue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%goi_thue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['don_gia'], 'integer'],
            [['ten'], 'string', 'max' => 50],
            [['ky_hieu'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Ten',
            'ky_hieu' => 'Ky Hieu',
            'don_gia' => 'Don Gia',
        ];
    }
}
