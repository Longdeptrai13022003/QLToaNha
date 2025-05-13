<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%trang_thai_phong_khach}}".
 *
 * @property int $id
 * @property int|null $phong_khach_id
 * @property string|null $created
 * @property int|null $user_id
 * @property string|null $trang_thai
 *
 * @property PhongKhach $phongKhach
 * @property User $user
 */
class TrangThaiPhongKhach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trang_thai_phong_khach}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phong_khach_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['trang_thai'], 'string'],
            [['phong_khach_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhongKhach::className(), 'targetAttribute' => ['phong_khach_id' => 'id']],
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
            'phong_khach_id' => 'Phong Khach ID',
            'created' => 'Created',
            'user_id' => 'User ID',
            'trang_thai' => 'Trang Thai',
        ];
    }

    /**
     * Gets query for [[PhongKhach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongKhach()
    {
        return $this->hasOne(PhongKhach::className(), ['id' => 'phong_khach_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert){
            if($this->created == ''){
                $this->created = date('Y-m-d H:i:s');
            }
            if ($this->user_id == '')
                $this->user_id = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert,$changedAttributes)
    {
        PhongKhach::updateAll(['trang_thai'=>$this->trang_thai],['id'=>$this->phong_khach_id]);

        parent::afterSave($insert, $changedAttributes);
    }
}
