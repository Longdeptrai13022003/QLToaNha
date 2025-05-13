<?php


namespace common\models;

use backend\models\CauHinh;
use backend\models\DanhMuc;
use backend\models\NguoiThucHienCongViec;
use backend\models\PhongBanNhanVien;
use backend\models\PhongBanThucHienThamDinh;
use backend\models\QuanLyCvThuchienCanhan;
use backend\models\ThietBiNhanThongBao;
use backend\models\ThucHienCongViec;
use backend\models\ThucHienCvXinYKienLanhDao;
use backend\models\TrangThaiNguoiThucHienCv;
use backend\models\TrangThaiThamDinh;
use backend\models\TrangThaiThucHienCv;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Response;

class SaoDoAPI
{
    private $email_gui_thong_bao_he_thong;
    private $so_lan_cham_toi_da;
     private $email_nhan_thong_bao;
    /**

     * @return mixed
     */
    public function getSoLanChamToiDa()
    {
        return $this->so_lan_cham_toi_da;
    }

    /**
     * @param mixed $so_lan_cham_toi_da
     */
    public function setSoLanChamToiDa($so_lan_cham_toi_da)
    {
        $this->so_lan_cham_toi_da = $so_lan_cham_toi_da;
    }

    /**
     * @return mixed
     */
    public function getEmailNhanThongBao()
    {
        return $this->email_nhan_thong_bao;
    }

    /**
     * @param mixed $email_nhan_thong_bao
     */
    public function setEmailNhanThongBao($email_nhan_thong_bao)
    {
        $this->email_nhan_thong_bao = $email_nhan_thong_bao;
    }

    /**
     * @return mixed
     */
    public function getEmailPhanHoiCongViecCaNhan()
    {
        return $this->email_phan_hoi_cong_viec_ca_nhan;
    }

    /**
     * @param mixed $email_phan_hoi_cong_viec_ca_nhan
     */
    public function setEmailPhanHoiCongViecCaNhan($email_phan_hoi_cong_viec_ca_nhan)
    {
        $this->email_phan_hoi_cong_viec_ca_nhan = $email_phan_hoi_cong_viec_ca_nhan;
    }

    /**
     * @return mixed
     */
    public function getGanToiHan()
    {
        return $this->gan_toi_han;
    }

    /**
     * @param mixed $gan_toi_han
     */
    public function setGanToiHan($gan_toi_han)
    {
        $this->gan_toi_han = $gan_toi_han;
    }

    /**
     * @return mixed
     */
    public function getEmailToiPhongBan()
    {
        return $this->email_toi_phong_ban;
    }

    /**
     * @param mixed $email_toi_phong_ban
     */
    public function setEmailToiPhongBan($email_toi_phong_ban)
    {
        $this->email_toi_phong_ban = $email_toi_phong_ban;
    }

    /**
     * @return mixed
     */
    public function getEmailToiCaNhan()
    {
        return $this->email_toi_ca_nhan;
    }

    /**
     * @param mixed $email_toi_ca_nhan
     */
    public function setEmailToiCaNhan($email_toi_ca_nhan)
    {
        $this->email_toi_ca_nhan = $email_toi_ca_nhan;
    }

    /**
     * @return mixed
     */
    public function getEmailToiLanhDao()
    {
        return $this->email_toi_lanh_dao;
    }

    /**
     * @param mixed $email_toi_lanh_dao
     */
    public function setEmailToiLanhDao($email_toi_lanh_dao)
    {
        $this->email_toi_lanh_dao = $email_toi_lanh_dao;
    }

    /**
     * @return mixed
     */
    public function getEmailToiTruongPhong()
    {
        return $this->email_toi_truong_phong;
    }

    /**
     * @param mixed $email_toi_truong_phong
     */
    public function setEmailToiTruongPhong($email_toi_truong_phong)
    {
        $this->email_toi_truong_phong = $email_toi_truong_phong;
    }
     private $email_phan_hoi_cong_viec_ca_nhan;
     private $gan_toi_han;
     private $email_toi_phong_ban;
     private $email_toi_ca_nhan;
     private $email_toi_lanh_dao;
     private $email_toi_truong_phong;

    /**
     * @return mixed
     */
    public function getEmailGuiThongBaoHeThong()
    {
        return $this->email_gui_thong_bao_he_thong;
    }

    /**
     * @param mixed $email_gui_thong_bao_he_thong
     */
    public function setEmailGuiThongBaoHeThong($email_gui_thong_bao_he_thong)
    {
        $this->email_gui_thong_bao_he_thong = $email_gui_thong_bao_he_thong;
    }

    public function __construct()
    {
        $data = CauHinh::find()->all();
        /** @var CauHinh $item */
        foreach ($data as $item) {
            if($item->ghi_chu == 'email_gui_thong_bao_he_thong')
                $this->setEmailGuiThongBaoHeThong($item->content);
            else if($item->ghi_chu == 'so_lan_cham_toi_da')
                $this->setSoLanChamToiDa($item->content);
            else if($item->ghi_chu == 'email_nhan_thong_bao')
                $this->setEmailNhanThongBao($item->content);
            else if($item->ghi_chu == 'email_phan_hoi_cong_viec_ca_nhan ')
                $this->setEmailPhanHoiCongViecCaNhan($item->content);
            else if($item->ghi_chu == 'gan_toi_han')
                $this->setGanToiHan($item->content);
            else if($item->ghi_chu == 'email_toi_phong_ban')
                $this->setEmailToiPhongBan($item->content);
            else if($item->ghi_chu == 'email_toi_ca_nhan')
                $this->setEmailToiCaNhan($item->content);
            else if($item->ghi_chu == 'email_toi_lanh_dao')
                $this->setEmailToiLanhDao($item->content);
            else if($item->ghi_chu == 'email_toi_truong_phong')
                $this->setEmailToiTruongPhong($item->content);
        }
    }

    public static function getPhanHoi(){
        $dataPhanHoi = Yii::$app->db->createCommand('SELECT qlcvsd_dem_sl_phan_hoi_moi(:id) AS so_luong', [
            ':id' => Yii::$app->user->id
        ])->queryOne();
        if(isset($dataPhanHoi['so_luong']))
            $so_luong = $dataPhanHoi['so_luong'];
        else
            $so_luong = 0;
        $listPhanHoi = [];
        if($so_luong > 0){
            $listPhanHoi = \backend\models\PhanHoiThucHienCv::find()
                ->andFilterWhere(['nguoi_nhan_id' => Yii::$app->user->id, 'da_xem' => 0])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
        return [
            'so_luong' => $so_luong,
            'listPhanHoi' => $listPhanHoi
        ];
    }

    public static function getCVToiHan($idPhongBan){
        $dsCVToiHan = ['phong_ban' => [], 'ca_nhan' => []];
        $soNgayToiHan = \backend\models\CauHinh::findOne(['ghi_chu' => 'gan_toi_han'])->content;

        $cv_toi_han = Yii::$app->db->createCommand('CALL qlcvsd_new_cong_viec_ca_nhan_toi_han(:uid, :so_ngay)', [':uid' => Yii::$app->user->id, ':so_ngay' => $soNgayToiHan])
            ->queryAll();
        $dsCVToiHan['ca_nhan'] = $cv_toi_han;

        if ($idPhongBan > 0) {
            $cv_toi_han = Yii::$app->db->createCommand('CALL qlcvsd_new_cong_viec_phong_ban_toi_han(:phong_ban_id, :so_ngay)', [':phong_ban_id' => $idPhongBan, ':so_ngay' => $soNgayToiHan])
                ->queryAll();
            $dsCVToiHan['phong_ban'] = $cv_toi_han;
        }
        return $dsCVToiHan;
    }

    public static function getCVQuaHan($idPhongBan){
        //delete qlcvsd_so_luong_cv_qua_han
        $dsCVQuaHan = ['phong_ban' => [], 'ca_nhan' => []];

//        qlcvsd_new_cong_viec_ca_nhan_qua_han
        $cv_qua_han = Yii::$app->db->createCommand("CALL `qlcvsd_new_cong_viec_ca_nhan_qua_han`(:uid);", [':uid' => Yii::$app->user->id])->queryAll();
        $dsCVQuaHan['ca_nhan'] = $cv_qua_han;

        if($idPhongBan > 0){
            Yii::$app->session->set("idPhongBanHienTai", $idPhongBan);
            $cv_qua_han = Yii::$app->db->createCommand("CALL `qlcvsd_new_cong_viec_phong_ban_het_han`(:phong_ban_id);", [':phong_ban_id' => $idPhongBan])->queryAll();
            $dsCVQuaHan['phong_ban'] = $cv_qua_han;
        }

        return $dsCVQuaHan;
    }

    public static function getCVQuaHanPhongBan($phongBanID){
        $s_luong_cv_qua_han = 0;
        $dsCVQuaHan = [];
        Yii::$app->session->set("idPhongBanHienTai", $phongBanID);
        if ($phongBanID != '') {
            $s_luong_cv_qua_han = Yii::$app->db->createCommand('SELECT qlcvsd_so_luong_cv_qua_han(:phong_ban_id) AS so_luong;', [':phong_ban_id' => $phongBanID])->queryAll();
            $s_luong_cv_qua_han = isset($s_luong_cv_qua_han[0]['so_luong']) ? $s_luong_cv_qua_han[0]['so_luong'] : 0;
            if ($s_luong_cv_qua_han > 0) {
                $dsCVQuaHan = \backend\models\QuanLyNhacViecThucHien::find()
                    ->andWhere("trang_thai <> 'Đã hoàn thành' and trang_thai <> 'Hủy' and so_ngay_con_lai < 0 and phong_ban_thuc_hien_id = :phong_ban_id", [
                        ':phong_ban_id' => $phongBanID
                    ])
                    ->all();
            }
        }
        return [
            'dsCVQuaHan' => $dsCVQuaHan,
            's_luong_cv_qua_han' => $s_luong_cv_qua_han
        ];
    }

  /**
   * @param $deviceToken
   * @param $tieuDe
   * @param $noiDung
   * @return void
   */
    public static function sendMessageNotifications($deviceToken, $tieuDe, $noiDung){

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gg.minhhien.com.vn/send-message.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
          'deviceToken' => $deviceToken,
          'tieuDe' => strip_tags($tieuDe),
          'noiDung' => strip_tags($noiDung),
        ]),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;
    }

    public static function pushNotification($title, $message, $uids){
        $recipents = ThietBiNhanThongBao::find()
            ->andFilterWhere(['in', 'user_id', $uids])
            ->all();
        $arrCode = [];
        foreach ($recipents as $recipent){
            $arrCode[] = $recipent->code;
        }
        self::sendMessageNotifications($arrCode, $title, $message);
    }
}
