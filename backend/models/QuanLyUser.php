<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "qlcvsd_quan_ly_user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property string|null $auth_key
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $password
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $anhdaidien
 * @property int|null $VIP
 * @property float|null $vi_dien_tu
 * @property int|null $hoat_dong
 * @property string|null $birth_day
 * @property string|null $vai_tro
 */

class QuanLyUser extends \yii\db\ActiveRecord
{
    public $vi_dien_tu_tu;
    public $vi_dien_tu_den;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quan_ly_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
        [['id', 'status', 'VIP', 'hoat_dong'], 'integer'],
        [['created_at', 'updated_at', 'birth_day'], 'safe'],
        [['vi_dien_tu'], 'number'],
        [['vai_tro'], 'string'],
        [['username', 'password_hash', 'email', 'password', 'hoten', 'anhdaidien'], 'string', 'max' => 100],
        [['password_reset_token'], 'string', 'max' => 45],
        [['auth_key'], 'string', 'max' => 32],
        [['dien_thoai'], 'string', 'max' => 20],
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      return [
        'id' => 'ID',
        'username' => 'Username',
        'password_hash' => 'Password Hash',
        'password_reset_token' => 'Password Reset Token',
        'email' => 'Email',
        'auth_key' => 'Auth Key',
        'status' => 'Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'password' => 'Password',
        'hoten' => 'Hoten',
        'dien_thoai' => 'Dien Thoai',
        'anhdaidien' => 'Anhdaidien',
        'VIP' => 'Vip',
        'vi_dien_tu' => 'Vi Dien Tu',
        'hoat_dong' => 'Hoat Dong',
        'birth_day' => 'Birth Day',
        'vai_tro' => 'Vai Tro',
      ];
    }
}
