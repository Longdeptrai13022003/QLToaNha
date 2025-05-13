<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property string $created
 * @property string $updated
 * @property string $content
 * @property string $base64
 * @property integer $user_id
 * @property string $type
 * @property string $link_url
 * @property string $obj_from_extension
 * @property integer $id_column
 * @property string $deleted
 */
class LogIS extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'id_column', 'base64', 'link_url'], 'safe'],
            [['created', 'updated', 'deleted', 'content'], 'safe'],
            [['user_id', 'id_column', 'obj_from_extension'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'updated' => 'Updated',
            'user_id' => 'User ID',
            'type' => 'Type',
            'id_column' => 'Id Column',
            'deleted' => 'Deleted',
        ];
    }
}
