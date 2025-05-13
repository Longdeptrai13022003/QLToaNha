<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_phan_quyen}}".
 *
 * @property integer $id
 * @property integer $chuc_nang_id
 * @property integer $vai_tro_id
 * @property string $name
 * @property string $nhom
 * @property string $controller_action
 * @property string $tenvaitro
 * @property integer $user_id
 */
class QuanLyPhanQuyen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qlcvsd_quan_ly_phan_quyen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chuc_nang_id', 'vai_tro_id', 'user_id'], 'integer'],
            [['chuc_nang_id', 'vai_tro_id', 'name', 'nhom', 'controller_action', 'tenvaitro', 'user_id'], 'required'],
            [['name', 'nhom', 'controller_action', 'tenvaitro'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chuc_nang_id' => 'Chuc Nang ID',
            'vai_tro_id' => 'Vai Tro ID',
            'name' => 'Tên',
            'nhom' => 'Nhóm',
            'controller_action' => 'Tên controller_action',
            'tenvaitro' => 'Tenvaitro',
            'user_id' => 'Thành viên',
        ];
    }
}
