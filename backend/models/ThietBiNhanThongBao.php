<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%thiet_bi_nhan_thong_bao}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $active
 * @property string $code
 * @property string $created
 *
 * @property User $user
 */
class ThietBiNhanThongBao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%thiet_bi_nhan_thong_bao}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'active'], 'integer'],
            [['code', 'created'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
