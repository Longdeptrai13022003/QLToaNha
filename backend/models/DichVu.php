<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%dich_vu}}".
 *
 * @property int $id
 * @property string|null $ten
 * @property string|null $don_vi_tinh
 * @property int|null $don_gia
 * @property string|null $ghi_chu
 */
class DichVu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dich_vu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['don_gia'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ten'], 'string', 'max' => 255],
            [['don_vi_tinh'], 'string', 'max' => 100],
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
            'don_vi_tinh' => 'Don Vi Tinh',
            'don_gia' => 'Don Gia',
            'ghi_chu' => 'Ghi Chu',
        ];
    }
}
