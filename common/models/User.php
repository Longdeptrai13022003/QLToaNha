<?php
namespace common\models;

use backend\models\DanhMuc;
use backend\models\ThietBiNhanThongBao;
use backend\models\UserVaiTro;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use Yii;
use yii\base\NotSupportedException;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property string|null $auth_key
 * @property int|null $status
 * @property int|null $user_old_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $password
 * @property string|null $hoten
 * @property string|null $dien_thoai
 * @property string|null $anhdaidien
 * @property string|null $anhcancuoc
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
 *
 * @property ChiTietDonHang[] $chiTietDonHangs
 * @property ChiTietDonHang[] $chiTietDonHangs0
 * @property DiaChiNhanHang[] $diaChiNhanHangs
 * @property DonHang[] $donHangs
 * @property GiaoDich[] $giaoDiches
 * @property GiaoDich[] $giaoDiches0
 * @property LogGetListSanPham[] $logGetListSanPhams
 * @property Product[] $products
 * @property ThietBiNhanThongBao[] $thietBiNhanThongBaos
 * @property TrangThaiDonHang[] $trangThaiDonHangs
 * @property TrangThaiGiaoDich[] $trangThaiGiaoDiches
 * @property VaitroUser[] $vaitroUsers
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public static $trang_thai = [
        10 => 'Hoạt động',
        0 => 'Không hoạt động',
    ];

    const THOI_VU = 'Thời vụ';
    const XAC_DINH_THOI_HAN = 'Xác định thời hạn';
    const KHONG_XAC_DINH_THOI_HAN = 'Không xác định thời hạn';

    public static $arr_loai_hop_dong = [
        self::THOI_VU => self::THOI_VU,
        self::XAC_DINH_THOI_HAN => self::XAC_DINH_THOI_HAN,
        self::KHONG_XAC_DINH_THOI_HAN => self::KHONG_XAC_DINH_THOI_HAN
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qlcvsd_user';
    }

    public function validatePasswordRules($attribute, $params, $validator)
    {
        if (trim($this->password_hash) === '') {
            $this->addError($attribute, 'Mật khẩu không được chứa khoảng trắng.');
        }
        if (strpos($this->password_hash, ' ') !== false) {
            $this->addError($attribute, 'Mật khẩu không được chứa dấu cách.');
        }
        if (mb_strlen($this->password_hash) < 6) {
            $this->addError($attribute, 'Mật khẩu phải có ít nhất 6 ký tự.');
        }
    }

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            TimestampBehavior::className(),
//        ];
//    }

    /**
     * @inheritdoc
     */
  public function rules()
  {
      return [
          [['status', 'VIP', 'hoat_dong', 'kichHoat', 'user_old_id'], 'integer'],
          [['created_at', 'updated_at', 'birth_day','so_cccd', 'anhcancuoc'], 'safe'],
          [['vi_dien_tu'], 'number'],
          [['username', 'password_hash', 'email', 'password', 'hoten', 'anhdaidien', 'ho_ten_tai_khoan', 'so_tai_khoan'], 'string', 'max' => 100],
          [['hoten', 'username','password_hash','dien_thoai'], 'required'],
          [['password_reset_token'], 'string', 'max' => 45],
          [['password_hash'], 'validatePasswordRules'],
          [['password_reset_token'], 'match', 'pattern' => '/^\S*$/', 'message' => 'Không được chứa dấu cách.'],
          [['auth_key'], 'string', 'max' => 32],
          [['dien_thoai'], 'string', 'max' => 20],
          [['dia_chi'], 'string', 'max' => 300],
          [['te_ngan_hang'], 'string', 'max' => 400],
          [['username'], 'unique', 'message' => 'Tên đăng nhập đã tồn tại'],
          ['email', 'email', 'message' => 'Email không hợp lệ.']
      ];
  }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Tài khoản'),
            'password_hash' => Yii::t('app', 'Mật khẩu'),
            'status' => Yii::t('app', 'Trạng thái'),
            'vaitro' => Yii::t('app', 'Vai trò'),
            'dien_thoai' => Yii::t('app', 'Điện thoại'),
            'email' => Yii::t('app', 'Email'),
            'hoten' => 'Họ tên',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param $arrRoles
     * @return bool
     */
    public function isAccess($arrRoles, $uid = null){
        return !is_null(UserVaiTro::find()->andFilterWhere(['in', 'vai_tro', $arrRoles])
            ->andFilterWhere(['id' => is_null($uid) ? Yii::$app->user->getId() : $uid])
            ->one());
//        return 1;
    }

  /**
   * Gets query for [[ThietBiNhanThongBaos]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getThietBiNhanThongBaos()
  {
    return $this->hasMany(ThietBiNhanThongBao::className(), ['user_id' => 'id']);
  }

  /**
   * Gets query for [[VaitroUsers]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getVaitroUsers()
  {
    return $this->hasMany(VaitroUser::className(), ['user_id' => 'id']);
  }

  /**
   * @param $uid
   * @return bool
   */
    public static function isViewAll($uid = null){
        if(is_null($uid))
            $nhanVienID = Yii::$app->user->id;
        else
            $nhanVienID = $uid;
        $user_vaitro = UserVaiTro::findOne(['id' => $nhanVienID, 'status' => 10, 'vai_tro_id' => 1]);
        return ($nhanVienID == 1 || !is_null($user_vaitro));
    }


    public function afterSave($insert, $changedAttributes)
    {
        if(isset($_POST['Vaitrouser'])){
            $vaitro = Vaitrouser::findAll(['user_id' => $this->id]);
            foreach ($vaitro as $item) {
                $item->delete();
            }

            foreach ($_POST['Vaitrouser'] as $item) {
                $vaitronguoidung = new Vaitrouser();
                $vaitronguoidung->vai_tro_id = $item;
                $vaitronguoidung->user_id = $this->id;
                if(!$vaitronguoidung->save()){
                    VarDumper::dump(Html::errorSummary($vaitronguoidung),10,true);
                    exit;
                }
            }
        }else{
            $vaitro = Vaitrouser::findAll(['user_id' => $this->id]);
            foreach ($vaitro as $item) {
                $item->delete();
            }
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function beforeSave($insert)
    {
        $this->birth_day = myAPI::convertDateSaveIntoDb($this->birth_day);
        if($insert){
            if ($this->created_at == '')
                $this->created_at = date("Y-m-d H:i:s");
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
