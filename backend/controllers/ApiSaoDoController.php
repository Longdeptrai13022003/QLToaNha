<?php


namespace backend\controllers;


use backend\models\CauHinh;
use backend\models\KeHoachCvNhanVien;
use backend\models\PhongBanNhanVien;
use backend\models\PhongBanThucHienThamDinh;
use backend\models\QuanLyCongviecPhongban;
use backend\models\ThietBiNhanThongBao;
use backend\models\TrangThaiThamDinh;
use common\models\myAPI;
use common\models\SaoDoAPI;
use common\models\User;
use Illuminate\Support\Arr;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class ApiSaoDoController extends Controller
{
    public function actionCheckAccount(){
        $user = User::findOne([
            'username' => $_POST['username'],
            'status' => 10
        ]);
        if(is_null($user))
            return  [
                'success' => false,
                'message' => 'Tài khoản không tồn tại hoặc bị khóa'
            ];
        else{
            $password = \Yii::$app->security->validatePassword($_POST['password'], $user->password_hash);
            if($password){
                if($_POST['get_notify'] == 'true' || $_POST['get_notify'] == 1 || $_POST['get_notify'] == true){
                    $thietBi = ThietBiNhanThongBao::findOne(['code' => $_POST['code_equipment'], 'user_id' => $user->id]);
                    if(is_null($thietBi)){
                        $thietBi = new ThietBiNhanThongBao();
                        $thietBi->user_id = $user->id;
                        $thietBi->code = $_POST['code_equipment'];
                        if(!$thietBi->save())
                            return  [
                                'success' => false,
                                'message' => Html::errorSummary($thietBi)
                            ];
                        else
                            return  [
                                'success' => true,
                                'message' => 'Đã lưu thành công'
                            ];
                    }else{
                        return  [
                            'success' => true,
                            'message' => 'Đã lưu thành công'
                        ];
                    }
                }else{
                    $thietBi = ThietBiNhanThongBao::findOne(['user_id' => $user->id, 'code' => $_POST['code_equipment']]);
                    if(!is_null($thietBi)){
                        if($thietBi->delete())
                            return  [
                                'success' => true,
                                'message' => 'Đã hủy nhận thông báo thành công'
                            ];
                        else
                            return  [
                                'success' => false,
                                'message' => Html::errorSummary($thietBi)
                            ];
                    }else
                        return  [
                            'success' => false,
                            'message' => 'Mã thiết bị không hợp lệ'
                        ];
                }

            }else
                return  [
                    'success' => false,
                    'message' => 'Tên tài khoản hoặc mật khẩu bị sai'
                ];
        }
    }

    //test-send-message
    public function actionTestSendMessage(){
        $uids = ArrayHelper::map(
            User::findAll(['id' => 66]),
            'id', 'id'
        );
        SaoDoAPI::pushNotification('Test gui thong bao', 'noi dung thong bao', $uids);
    }


    //gui-thong-bao-tham-van

    //update-diem-nam

    //update-diem-quy
    public function actionUpdateDiemQuy(){
        ini_set('max_execution_time', 999999);
        $keHoachNam = QuanLyCongviecPhongban::find()
            ->select(['nam', 'phong_ban_id', 'cong_viec_id', 'id_kehoach_ca_nhan_phongban'])
            ->andWhere('(quy is null or quy = "")')
//            ->andFilterWhere(['cong_viec_id' => 13909])
            ->all();
        $tong = 0;
        $loi = [];
        /** @var QuanLyCongviecPhongban $item */
        foreach($keHoachNam as $item){
            $keHoachQuy = QuanLyCongviecPhongban::find()
                ->select(['tu_danh_gia', 'boss_danh_gia', 'quy', 'cong_viec_id', 'phong_ban_id', 'id_kehoach_ca_nhan_phongban'])
                ->andWhere('(quy is not null and quy <> "") and nhan_vien_phong_ban_id is null')
                ->andFilterWhere(['nam' => $item->nam])
                ->andFilterWhere(['phong_ban_id' => $item->phong_ban_id])
                ->andFilterWhere(['cong_viec_id' => $item->cong_viec_id])
                ->all();
            /** @var QuanLyCongviecPhongban $itemQuy */

            foreach ($keHoachQuy as $itemQuy) {
                // Tìm các kế hoạch cá nhân theo kế hoạch quý
                $data = KeHoachCvNhanVien::find()
                    ->andFilterWhere(['ke_hoach_cv_nvien_parent_id' => $itemQuy->id_kehoach_ca_nhan_phongban])
//                    ->andFilterWhere(['cong_viec_id' => $itemQuy->cong_viec_id])
//                    ->andWhere('nhan_vien_phong_ban_id is not null')
                    ->select(['tu_danh_gia', 'boss_danh_gia'])
                    ->all();

                $tongDiemBossDanhGia = 0;
                $tongDiemTuDanhGia = 0;
                /** @var KeHoachCvNhanVien $itemCongViecKeHoachCaNhan */
                foreach ($data as $itemCongViecKeHoachCaNhan) {
                    $tongDiemBossDanhGia += floatval($itemCongViecKeHoachCaNhan->boss_danh_gia);
                    $tongDiemTuDanhGia += floatval($itemCongViecKeHoachCaNhan->tu_danh_gia);
                }
                $keHoachNhanVienPhongBan = KeHoachCvNhanVien::findOne($itemQuy->id_kehoach_ca_nhan_phongban);
                if(!is_null($keHoachNhanVienPhongBan)){
                    $attUpdate = [];
                    if($keHoachNhanVienPhongBan->boss_danh_gia >= $tongDiemBossDanhGia && $keHoachNhanVienPhongBan->boss_danh_gia > $keHoachNhanVienPhongBan->diem_so)
                        $attUpdate['boss_danh_gia'] = $keHoachNhanVienPhongBan->boss_danh_gia - $tongDiemBossDanhGia;

                    if($keHoachNhanVienPhongBan->tu_danh_gia >= $tongDiemTuDanhGia && $keHoachNhanVienPhongBan->tu_danh_gia > $keHoachNhanVienPhongBan->diem_so)
                        $attUpdate['tu_danh_gia'] = $keHoachNhanVienPhongBan->tu_danh_gia - $tongDiemTuDanhGia;

                    if(count($attUpdate) > 0)
                        $keHoachNhanVienPhongBan->updateAttributes($attUpdate);
                    $tong++;
                }else
                    $loi[] = 'Không tồn tại CVNV Phòng ban '.$itemQuy->id_kehoach_ca_nhan_phongban;
            }
        }
        return [
            'content' => 'Đã cập nhật '.$tong.' kế hoạch quý',
            'loi' => implode('; ', $loi),
        ];
    }

    //test-send-email
//    public function actionTestSendEmail(){
//        myAPI::sendMailAmzon('content',
//            'info@andin.io',
//            ['hungddvimaru@gmail.com'],
//            'subject'
//        );
//    }
}
