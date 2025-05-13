<?php
namespace backend\models;

use common\models\myAPI;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $nickname;
    public $hoten;
    public $dia_chi;
    public $ngaysinh;
    public $dien_thoai;
    public $nguoilienhe;
    public $dien_thoainguoilienhe;
    public $moiquanhe;
    public $nguoigioithieu;
    public $bietdenace;
    public $facebook;
    public $dongy;
    public $taisaomuonhoctienganh;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'hoten' => 'Họ tên',
            'ngaysinh' => 'Ngày sinh',
            'dien_thoai' => 'Điện thoại',
            'nguoilienhe' => 'Người liên hệ',
            'moiquanhe' => 'Mối quan hệ',
            'bietdenace' => 'Bạn biết đến ACE từ đâu',
            'facebook' => 'Tài khoản Facebook',
            'taisaomuonhoctienganh' => 'Tại sao bạn muốn học tiếng Anh',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'khong_chua_ky_tu_dac_biet'],
            [['username'], 'string', 'min'=>8, 'max' => 20],
            [['username'], 'required'],
            [['hoten', 'username', 'email', 'password', 'dongy', 'password_repeat', 'dien_thoai'], 'required', 'message' => 'Chưa điền {attribute}'],
            [['nguoigioithieu', 'nickname', 'dia_chi'], 'safe'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Mật khẩu không khớp" ],
            [['username', 'dien_thoai'], 'unique', 'targetClass' => '\common\models\User', 'message' => 'Dữ liệu này đã tồn tại.'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email này đã được đăng ký.'],

            ['password', 'string', 'min' => 6],
        ];
    }

    public function khong_chua_ky_tu_dac_biet($attribute_name, $params){
        if(myAPI::checkUsername_invalid($this->username))
            return true;
        else{
            $this->addError('username', 'Tên đăng nhập gồm các ký tự 0-9, a-z, tối thiểu 8 ký tự');
            return false;
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->attributes = $this->attributes;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($user->save()){
            $vai_tro_khachhang = VaiTro::findOne(['name' => 'Khách hàng']);
            $vaitro_user = new Vaitrouser();
            $vaitro_user->user_id = $user->id;
            $vaitro_user->vai_tro_id = $vai_tro_khachhang->id;
            $vaitro_user->save();
            return $user;
        }
        return null;
    }
}
