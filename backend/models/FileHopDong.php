<?php

namespace backend\models;

use common\models\myAPI;
use Yii;

/**
 * This is the model class for table "qlcvsd_file_hop_dong".
 *
 * @property int $id
 * @property int|null $phong_khach_id
 * @property string|null $file
 * @property string|null $created
 * @property int|null $user_id
 */
class FileHopDong extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qlcvsd_file_hop_dong';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phong_khach_id', 'user_id'], 'safe'],
            [['created'], 'safe'],
            [['file'], 'string', 'max' => 300],
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
            'file' => 'File đính kèm',
            'created' => 'Created',
            'user_id' => 'Khách hàng',
        ];
    }
    public function beforeSave($insert)
    {
        if($insert && ($this->created == '' || is_null($this->created))){
            $this->created = date("Y-m-d H:i:s");
        }
        if($this->user_id == '' || is_null($this->user_id))
            $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }
}
