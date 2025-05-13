<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_sale}}".
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
 * @property int|null $kichHoat
 * @property string|null $dia_chi
 * @property string|null $ho_ten_tai_khoan
 * @property string|null $so_tai_khoan
 * @property string|null $te_ngan_hang
 * @property string|null $so_cccd
 * @property int|null $user_old_id
 */
class QuanLySale extends \yii\db\ActiveRecord
{
    public $vi_dien_tu_tu;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_sale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'VIP', 'hoat_dong', 'kichHoat', 'user_old_id'], 'integer'],
            [['created_at', 'updated_at', 'birth_day','so_cccd'], 'safe'],
            [['vi_dien_tu'], 'number'],
            [['hoten', 'username', 'password_hash','dien_thoai'], 'required'],
            [['username', 'password_hash', 'email', 'password', 'hoten', 'anhdaidien', 'ho_ten_tai_khoan', 'so_tai_khoan'], 'string', 'max' => 100],
            [['password_reset_token'], 'string', 'max' => 45],
            [['auth_key'], 'string', 'max' => 32],
            [['dien_thoai'], 'string', 'max' => 20],
            [['dia_chi'], 'string', 'max' => 300],
            [['te_ngan_hang'], 'string', 'max' => 400],
        ];
    }

    /**
     * {@inheritdoc}
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
            'kichHoat' => 'Kich Hoat',
            'dia_chi' => 'Dia Chi',
            'ho_ten_tai_khoan' => 'Ho Ten Tai Khoan',
            'so_tai_khoan' => 'So Tai Khoan',
            'te_ngan_hang' => 'Te Ngan Hang',
            'user_old_id' => 'User Old ID',
        ];
    }
}
