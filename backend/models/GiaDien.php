<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%gia_dien}}".
 *
 * @property int $id
 * @property int|null $bac_1
 * @property int|null $bac_2
 * @property int|null $bac_3
 * @property int|null $bac_4
 * @property int|null $bac_5
 * @property int|null $bac_6
 * @property string|null $ngay_bat_dau
 */
class GiaDien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gia_dien}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bac_1', 'bac_2', 'bac_3', 'bac_4', 'bac_5', 'bac_6'], 'integer'],
            [['ngay_bat_dau'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bac_1' => 'Bac 1',
            'bac_2' => 'Bac 2',
            'bac_3' => 'Bac 3',
            'bac_4' => 'Bac 4',
            'bac_5' => 'Bac 5',
            'bac_6' => 'Bac 6',
            'ngay_bat_dau' => 'Ngay Bat Dau',
        ];
    }
}
