<?php


namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietDonHang;
use backend\models\ChiTietHoaDon;
use backend\models\ChiTietPhieuYeuCauGiaoHang;
use backend\models\DanhMuc;
use backend\models\DiaChiNhanHang;
use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\HoaDon;
use backend\models\LogGetListSanPham;
use backend\models\LogIS;
use backend\models\PhieuYeuCauGiao;
use backend\models\PhongKhach;
use backend\models\Product;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyHoaDon;
use backend\models\QuanLyPhongKhach;
use backend\models\ThietBiNhanThongBao;
use backend\models\TrangThaiDonHang;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\Response;
use function React\Promise\all;

class ApiController extends Controller
{
    /**
     * @param $content
     * @return array
     */

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
    //login (Đăng nhập)
    public function actionLogin()
    {
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if (!isset($content->username))
            return ['success' => false, 'content' => 'Vui lòng nhập tên đăng nhập'];
        else if (trim($content->username) == '')
            return ['success' => false, 'content' => 'Vui lòng nhập tên đăng nhập'];
        else if (!isset($content->password))
            return ['success' => false, 'content' => 'Vui lòng nhập mật khẩu'];
        else if (trim($content->password) == '')
            return ['success' => false, 'content' => 'Vui lòng nhập mật khẩu'];
        else {
            $user = User::findOne(['username' => $content->username]);

            if (is_null($user)) {
                return [
                    'success' => false,
                    'content' => 'Tài khoản không tồn tại'
                ];
            } else {
                if ($user->status != 10) {
                    return [
                        'success' => false,
                        'content' => 'Tài khoản đã bị khoá, vui lòng liên hệ quản trị viên'
                    ];
                } else {
                    if (\Yii::$app->security->validatePassword($content->password, $user->password_hash)) {
                        $newAuth = \Yii::$app->security->generateRandomString();
                        $user->updateAttributes(['auth_key' => $newAuth]);
                        return [
                            'success' => true,
                            'user' => [
                                'uid' => $user->id,
                                'auth' => $newAuth,
                            ]
                        ];
                    } else {
                        return [
                            'success' => false,
                            'content' => 'Mật khẩu không chính xác'
                        ];
                    }
                }
            }
        }
    }
    //logout (Đăng xuất)
    public function actionLogout(){
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne($content->uid);
        if(!is_null($user))
            $user->updateAttributes([
                'auth_key' => null
            ]);
        return [
            'success' => true,
            'content' => 'Đăng xuất thành công'
        ];
    }
    //forgot-password(Quên mật khẩu)
    public function actionForgotPassword(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $content = json_decode(file_get_contents('php://input'));
        if ($content->email == "") {
            return ([
                'success' => FALSE,
                'content' => 'Email không được để trống',
            ]);
        } else{
            if(!myAPI::verifyEmail($content->email)){
                return ([
                    'success' => FALSE,
                    'content' => 'Email không hợp lệ',
                ]);
            }
            else{
                $user = User::findOne(['email' => $content->email]);
                if(!is_null($user)){
                    $newPas = \Yii::$app->security->generateRandomString(6);
                    $user->updateAttributes([
                        'password_hash' => \Yii::$app->security->generatePasswordHash($newPas)
                    ]);
                    myAPI::sendMail(
                        'Mật khẩu mới của bạn trong ứng dụng '.myAPI::PREFIX_NAME_SYSTEM.' là: '.$newPas,
                        '['.myAPI::PREFIX_NAME_SYSTEM.'] KHÔI PHỤC MẬT KHẨU',
                        $user->email
                    );
                    return ([
                        'success' => TRUE,
                        'content' => "Mật khẩu mới đã được gửi về email " . $content->email
                    ]);
                }
                else{
                    return([
                        'success' => FALSE,
                        'content' => 'Không tìm thấy tài khoản tương ứng',
                    ]);
                }
            }
        }
    }

    //get-profile(Xem thông tin cá nhân)
    public function actionGetProfile(){
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return myAPI::checkBeforeAction($content);
    }
    //reset-password (Đổi mật khẩu)
    public function actionResetPassword(){
        $content = json_decode(file_get_contents('php://input'));

        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            \Yii::$app->response->format = Response::FORMAT_JSON;

            $user = User::findOne($content->uid);
//'passwordOld': pass_old,
//            'passwordNew': pass_new,
//            'passwordConfirm': pass_confirm,
            if(trim($content->passwordOld) == '')
                return ['success' => false, 'content' => 'Vùi lòng nhập mật khẩu cũ'];
            else if(!\Yii::$app->security->validatePassword($content->passwordOld, $user->password_hash))
                return ['success' => false, 'content' => 'Mật khẩu cũ không đúng!'];
            else{
                if($content->passwordNew != $content->passwordConfirm)
                    return ['success' => false, 'content' => 'Mật khẩu mới nhập lại không trùng khớp'];
                elseif(mb_strlen(trim($content->passwordNew)) < 6)
                    return ['success' => false, 'content' => 'Mật khẩu mới dài ít nhất 6 ký tự'];
                else{
                    User::updateAll(['password_hash' => \Yii::$app->security->generatePasswordHash($content->passwordNew)], ['id' => $content->uid]);
                    return [
                        'success' => true,
                        'content' => 'Đổi mật khẩu mới thành công'
                    ];
                }
            }
        }
        return $check;
    }
    //get-list-hop-dong
    public function actionGetListHopDong()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $hopDongs = PhongKhach::findAll([
                'khach_hang_id' => $content->uid,
                'active' => 1
            ]);
            if(count($hopDongs) == 0){
                return [
                    'success' => false,
                    'content' => 'Chưa có hợp đồng nào được tạo!'
                ];
            }
            return [
                'success' => true,
                'content' => $hopDongs,
            ];
        }else
            return $check;
    }
    //get-list-hoa-don
    public function actionGetListHoaDon()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $quanLyHoaDons = QuanLyHoaDon::findAll([
                'khach_hang_id' => $content->uid,
                'active' => 1
            ]);
            if(count($quanLyHoaDons) == 0){
                return [
                    'success' => false,
                    'content' => 'Chưa có hóa đơn nào được tạo!'
                ];
            }
            return [
                'success' => true,
                'content' => $quanLyHoaDons,
            ];
        }else
            return $check;
    }
    //get-list-giao-dich
    public function actionGetListGiaoDich()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $quanLyGiaoDichs = QuanLyGiaoDich::findAll([
                'khach_hang_id' => $content->uid,
                'active' => 1
            ]);
            if(count($quanLyGiaoDichs) == 0){
                return [
                    'success' => false,
                    'content' => 'Chưa có giao dịch nào được thực hiện!'
                ];
            }
            return [
                'success' => true,
                'content' => $quanLyGiaoDichs,
            ];
        }else
            return $check;
    }
    //xem-chi-tiet-hoa-don
    public function actionXemChiTietHoaDon()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $chiTietHoaDon = QuanLyHoaDon::find()
                ->andFilterWhere(['khach_hang_id' => $content->uid])
                ->andFilterWhere(['id' => $content->hoaDonID])
                ->andFilterWhere(['active' => 1])->one();
            if (is_null($chiTietHoaDon)){
                return [
                    'success' => false,
                    'content' => 'Hóa đơn không tồn tại!',
                ];
            }
            return [
                'success' => true,
                'content' => $chiTietHoaDon,
            ];
        }else
            return $check;
    }
    //xem-chi-tiet-hop-dong
    public function actionXemChiTietHopDong()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $chiTietHopDong = QuanLyPhongKhach::find()
                ->andFilterWhere(['khach_hang_id' => $content->uid])
                ->andFilterWhere(['ma_hop_dong' => $content->maHopDong])
                ->andFilterWhere(['active' => 1])->one();
            if (is_null($chiTietHopDong)){
                return [
                    'success' => false,
                    'content' => 'Mã hợp đồng không chính xác!',
                ];
            }
            return [
                'success' => true,
                'content' => $chiTietHopDong,
            ];
        }else
            return $check;
    }
    //xem-chi-tiet-giao-dich
    public function actionXemChiTietGiaoDich()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $chiTietGiaoDich = QuanLyGiaoDich::find()
                ->andFilterWhere(['khach_hang_id' => $content->uid])
                ->andFilterWhere(['id' => $content->giaoDichID])
                ->andFilterWhere(['active' => 1])->one();
            if (is_null($chiTietGiaoDich)){
                return [
                    'success' => false,
                    'content' => 'Giao dịch không tồn tại!',
                ];
            }
            return [
                'success' => true,
                'content' => $chiTietGiaoDich,
            ];
        }else
            return $check;
    }
    //Cap nhat profile (update-profile)
    public function actionUpdateProfile()
    {
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($check['success']){
            $user = User::findOne($content->uid);
            $user->hoten = $content->data->ho_ten;
            $user->birth_day = $content->data->ngay_sinh;
            $time = time();
            $fileNameTruoc = dirname(dirname(__DIR__)).'/hinh-anh/'.$time.'truoc.jpg';
            $fileNameSau = dirname(dirname(__DIR__)).'/hinh-anh/'.$time.'sau.jpg';
            if($user->save()){
                $path = explode(',',$user->anhcancuoc);
                if (count($path) > 0){
                    foreach ($path as $file){
                        if ($file == 'no-image.jpg'){
                            continue;
                        }
                        if (is_file(dirname(dirname(__DIR__)).'/hinh-anh/'.$file)){
                            unlink(dirname(dirname(__DIR__)).'/hinh-anh/'.$file);
                        }
                    }
                }
                myAPI::base64_to_jpeg($content->data->cccd_truoc,$fileNameTruoc);
                myAPI::base64_to_jpeg($content->data->cccd_sau,$fileNameSau);
                $user->updateAttributes([
                    'anhcancuoc' => $time.'truoc.jpg,'.$time.'sau.jpg'
                ]);
                return [
                    'success' => true,
                    'content' => 'Cập nhật thông tin tài khoản thành công!',
                ];
            }
            return [
                'success' => false,
                'content' => 'Kiểm tra lại thông tin cập nhật!',
            ];
        }else
            return $check;
    }
    public function actionRegistation(){
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($content->dien_thoai == "" || $content->matkhau == "" || $content->reMatkhau == "")
            return [
                'success' => false,
                'content' => 'Vui lòng nhập SĐT hoặc mật khẩu đầy đủ'
            ];
        else if($content->matkhau != $content->reMatkhau)
            return [
                'success' => false,
                'content' => 'Mật khẩu lặp lại chưa giống mật khẩu đã điền trên'
            ];
        else {
            $oldUser = User::findOne(['email' => trim($content->email)]);
            if(!is_null($oldUser))
                return [
                    'success' => false,
                    'content' => 'Email này đã tồn tại'
                ];
            else{
                $oldUser = User::findOne(['dien_thoai' => trim($content->dien_thoai)]);
                if(!is_null($oldUser))
                    return [
                        'success' => false,
                        'content' => 'Số điện thoại này đã tồn tại'
                    ];
                else{
                    $user = new User();
                    $user->username = $content->username;
                    $user->hoten = $content->hoten;
                    $user->dien_thoai = $content->dien_thoai;
                    $user->password_hash = $content->matkhau;
                    $user->email = $content->email;
                    $user->kichHoat = !CauHinh::findOne(['ghi_chu' => 'dang_upload_apple'])->content;
                    if($user->save()){
                        // Thêm vai trò khách hàng
//                        $vaiTroNguoiDung = new Vaitrouser();
//                        $vaiTroNguoiDung->vai_tro_id = 7; // Khách hàng
//                        $vaiTroNguoiDung->user_id = $user->id;
//                        $vaiTroNguoiDung->save();

                        return  [
                            'success' => true,
                            'content' => 'Lưu thông tin thành viên thành công'
                        ];
                    }else
                        return [
                            'success' => false,
                            'content' => strip_tags(Html::errorSummary($user))
                        ];


                }
            }
        }
    }
    //save-token-device
    public function actionSaveTokenDevice(){
        $content = json_decode(file_get_contents('php://input'));
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            $model = ThietBiNhanThongBao::findOne(['code' => $content->data->tokenDevice, 'user_id' => $content->uid]);
            if(is_null($model)){
                $model = new ThietBiNhanThongBao();
                $model->code = $content->data->tokenDevice;
                $model->user_id = $content->uid;
                $model->save();

                return [
                    'success' => true,
                    'content' => 'Đăng ký thiết bị thành công'
                ];
            }else
                return [
                    'success' => true,
                    'content' => 'Thiết bị đã được đăng ký'
                ];
        }
        return $check;
    }
    //save-profile
    public function actionSaveProfile(){
        $content = json_decode(file_get_contents('php://input'));

        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            \Yii::$app->response->format = Response::FORMAT_JSON;

            $checkUser = User::find()
                ->andFilterWhere(['<>','id',$content->uid])
                ->andFilterWhere(['dien_thoai'=>$content->data->dien_thoai])
                ->andFilterWhere(['status'=>10])->all();
            if(count($checkUser)>0)
                return ['success' => false, 'content' => 'Số điện thoại đã được đăng ký trước đó!'];
            $checkUser = User::find()
                ->andFilterWhere(['<>','id',$content->uid])
                ->andFilterWhere(['username'=>$content->data->username])
                ->andFilterWhere(['status'=>10])->all();
            if(count($checkUser)>0)
                return ['success' => false, 'content' => 'Tên đăng nhập đã được đăng ký trước đó!'];

            $user = User::findOne($content->uid);
            $user->hoten = $content->data->hoten;
            $user->dien_thoai = $content->data->dien_thoai;
            $user->so_cccd = $content->data->so_cccd;
            $user->email = $content->data->email;
            $user->username = $content->data->username;
            if($user->save())
                return ['success' => true, 'content' => 'Thông tin tài khoản đã được cập nhật!'];
            else
                return ['success' => false, 'content' => strip_tags(Html::errorSummary($user))];
        }
        return $check;
    }

    //huy-tai-khoan
    public function actionHuyTaiKhoan(){
        $content = json_decode(file_get_contents('php://input'));

        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            \Yii::$app->response->format = Response::FORMAT_JSON;

            $user = User::findOne($content->uid);
            $user->updateAttributes([
                'status' => 0,
//                'khong_xac_dinh_tai_khoan' => 1
            ]);
            return [
                'success' => true,
                'content' => 'Tài khoản của bạn đã được huỷ!'
            ];
        }
        return $check;
    }

    //register
    public function actionRegister(){
        $content = json_decode(file_get_contents('php://input'));
        if(!isset($content->hoTen))
            return ['success' => false, 'content' => 'Vui lòng nhập họ tên'];
        else if(!isset($content->dien_thoai))
            return ['success' => false, 'content' => 'Vui lòng nhập SĐT'];
        else if(!isset($content->email))
            return ['success' => false, 'content' => 'Vui lòng nhập Email'];
        else if(!isset($content->password))
            return ['success' => false, 'content' => 'Vui lòng nhập Mật khẩu'];
        else if(!isset($content->rePassword))
            return ['success' => false, 'content' => 'Vui lòng nhập lại Mật khẩu'];
        else if(strlen(trim($content->hoTen)) < 6)
            return ['success' => false, 'content' => 'Vui lòng nhập họ tên dài tối thiểu 6 ký tự'];
        else if(strlen(trim($content->dien_thoai)) < 10)
            return ['success' => false, 'content' => 'Vui lòng nhập họ SĐT dài tối thiểu 10 ký tự'];
        else if(strlen(trim($content->email)) == 0)
            return ['success' => false, 'content' => 'Vui lòng nhập email'];
        else if(strlen(trim($content->password)) < 6)
            return ['success' => false, 'content' => 'Vui lòng nhập mật khẩu dài tối thiểu 6 ký tự'];
        else if(trim($content->password) != trim($content->rePassword))
            return ['success' => false, 'content' => 'Mật khẩu nhập lại không khớp'];
        else if(!isset($content->username))
            return ['success' => false, 'content' => 'Vui lòng nhập tên đăng nhập'];
        else{
            $userN = User::findOne(['username' => $content->username]);
            $user = User::findOne(['dien_thoai' => $content->dien_thoai]);
            if(!is_null($user))
                return ['success' => false, 'content' => 'SĐT đã tồn tại'];
            elseif(!is_null($userN))
                return ['success' => false, 'content' => 'Tên đăng nhập đã tồn tại'];
            else {
                $user = User::findOne(['email' => $content->email]);
                if(!is_null($user))
                    return  ['success' => false, 'content' => 'Email đã tồn tại'];
                else{
                    $user = new User(); //User::findOne($content->uid);
                    $user->username = $content->username;
                    $user->password_hash = $content->password;
                    $user->email = $content->email;
                    $user->status =10;
                    $user->created_at = date("Y-m-d H:i:s");
                    $user->hoten = $content->hoTen;
                    $user->dien_thoai = $content->dien_thoai;
//                    $user->kichHoat =  intval(CauHinh::findOne(['ghi_chu' => 'dang_upload_apple'])->content) == 1 ? 0 : 1;

                    if($user->save()){
                        // Thêm vai trò khách hàng
                        $model = new Vaitrouser();
                        $model->user_id = $user->id;
                        $model->vai_tro_id = VaiTro::ID_VAI_TRO_KHACH_HANG;
                        $model->save();

                        return ['success' => true, 'content' => 'Đăng ký tài khoản thành công!'];
                    }else
                        return ['success' => false, 'content' => strip_tags(Html::errorSummary($user))];


                }
            }

        }
    }

    //khoi-tao-du-lieu-profile
    public function actionKhoiTaoDuLieuProfile(){
        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            $user = User::findOne($content->uid);
            return [
                'success' => true,
                'content' => $user,
                'fakeApp' => CauHinh::findOne(['ghi_chu' => 'fake_app'])->content
            ];
        }
        else return $check;
    }
    //dong-bo-user
    public function actionDongBoUser(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://order.andin.io/get-all-user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $users = json_decode($response)->users;
        $index = 0;
        foreach ($users as $user){
            if($user->uid > 0){
                if(isset($user->field_ho_ten->und)){
                    $modelUser = User::findOne(['username' => $user->name]);
                    if(is_null($modelUser))
                        $modelUser = new User();
//                    else
//                        continue;
                }else
                    $modelUser = new User();

                $modelUser->username = $user->name;
                $modelUser->password_hash = \Yii::$app->security->generatePasswordHash($modelUser->username);
                $modelUser->email = $user->mail;
                $modelUser->created_at = date("Y-m-d H:i:s", $user->created);
                $modelUser->hoten = isset($user->field_ho_ten->und) ? $user->field_ho_ten->und[0]->value : null;
                $modelUser->dien_thoai = isset($user->field_dien_thoai->und) ? $user->field_dien_thoai->und[0]->value : null;
                $modelUser->vi_dien_tu = isset($user->field_vi_dien_tu->und) ? $user->field_vi_dien_tu->und[0]->value : 0;
                $modelUser->hoat_dong = 1;
                $modelUser->kichHoat = 1;
                $modelUser->dia_chi = isset($user->field_dia_chi->und) ? $user->field_dia_chi->und[0]->value : null;
                $modelUser->ho_ten_tai_khoan = isset($user->field_ho_ten_tai_khoan->und) ? $user->field_ho_ten_tai_khoan->und[0]->value : null;
                $modelUser->so_tai_khoan = isset($user->field_ho_ten_tai_khoan->und) ? $user->field_ho_ten_tai_khoan->und[0]->value : null;
                $modelUser->te_ngan_hang = isset($user->field_ten_ngan_hang->und) ? $user->field_ten_ngan_hang->und[0]->value : null;
                $modelUser->user_old_id = $user->uid;

                if($modelUser->save()){
                    // Update đã duyệt
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://order.andin.io/update-da-duyet-for-user',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode([
                            'uid' => $user->uid
                        ]),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    echo $response;

                }

                $index ++;
            }
        }

        return $index;
    }

    //nhan-thanh-toan
    public function actionNhanThanhToan()
    {
        $content = file_get_contents('php://input');
        $data = json_decode($content, true);
        $noiDung = '';

        // Điều chỉnh regex để phù hợp với định dạng mới "...GD <ma_giao_dich> HD..."
        if (preg_match('/GD (\d+) HD/', $data['data'][0]['description'], $matches)) {
            $noiDung = $matches[0];
        }

        if ($noiDung != '') {
            $soTien = intval($data['data'][0]['amount']);

            // Lấy mã giao dịch từ regex match
            $maGiaoDich = intval($matches[1]);

            $giaoDich = GiaoDich::findOne(['id' => $maGiaoDich]);
            if (!is_null($giaoDich)) {
                $giaoDich->updateAttributes([
                    'so_tien_giao_dich' => $soTien,
                    'noi_dung_chuyen_khoan' => $content,
                    'ma_id_casso' => intval($data['data'][0]['id'])
                ]);

                if ($giaoDich->so_tien_giao_dich >= $giaoDich->tong_tien) {
                    $giaoDich->updateAttributes([
                        'trang_thai_giao_dich' => GiaoDich::THANH_CONG,
                    ]);
                    $giaoDich->afterUpdate();
                }

                $hopDong = PhongKhach::findOne($giaoDich->phong_khach_id);
                $hopDong->updateAttributes([
                    'da_thanh_toan' => $hopDong->da_thanh_toan + $soTien
                ]);

                if (!is_null($giaoDich->hoa_don_id)) {
                    $hoaDon = HoaDon::findOne($giaoDich->hoa_don_id);
                    $daThanhToan = $hoaDon->da_thanh_toan;
                    $hoaDon->updateAttributes([
                        'da_thanh_toan' => $daThanhToan + $soTien,
                    ]);

                    if ($daThanhToan + $soTien == $hoaDon->tong_tien) {
                        $hoaDon->updateAttributes([
                            'trang_thai' => HoaDon::DA_THANH_TOAN,
                        ]);
                    } else {
                        $hoaDon->updateAttributes([
                            'trang_thai' => HoaDon::CHUA_THANH_TOAN,
                        ]);
                    }
                }
            }
        }
    }

    private function sendZaloMessage($phoneNumber, $message)
    {
        // Access Token từ Zalo OA
        $accessToken = 'MBSc6K7TZ0jIl28LJjU82rsw9H17pVTiNgrK3oo6ZMjUkpiuHRlaN1xJFZrYii5DEgeH5cA1paKhXpCaSvdaTscM2XnrezvLBOijDrsUtqaDwWyhN_31GY-Q0o9TzwjC0V553Mx7vqKFqWWUUi7yJJ7BNo1Iqv5jLVDlSqlOfGmg-5qUQyIFH33LO2Tjr9Dg3CDQSMpqzWbmu00IQzBKTmNAAnXSmebr4zK_F73a-t0Lqb5hPlx_1N-LEq4qjkWHIPW6Q0UrsIPKlYb7EBx55qMtFqqwiV4gKTyoIH_G-2TJp2bPDzhuB2Ys5t9MkUST4RWU0boMoKKwjXmN8Pli3KMq61C_dl1WPeuu6ppauLnK-JvR4yV26m6e7MTWkzyKUT4jKpdTnKjmj6O3EuwY6oIdUW9abjGVHofPcof6m8u7';

        // API URL
        $url = 'https://openapi.zalo.me/v2.0/oa/message';

        // Dữ liệu cần gửi
        $data = [
            'recipient' => [
                'user_id_by_phone' => $phoneNumber
            ],
            'message' => [
                'text' => $message
            ]
        ];

        // Cấu hình cURL để gọi API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);

        // Thực hiện gọi API
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý phản hồi từ API
        $responseData = json_decode($response, true);
        if (isset($responseData['error']) && $responseData['error'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function actionTestMessage()
    {
        $accessToken = 'FgBrJpQtVJ4qgV53ERrvCJklzaOmfpbwHVktSGkhRmDljA8f7CT87n6OnZ9Er1WZGR6MEakbJ2aVmPOeJQrO0YFbZY8rYtPMGvIgGH2AVaDAzOPkGkLFR0hobnv8dmC70-F84Ms8Fn0knly_NuWSAGxdu3nZbYq-8EYv27ANR04cdFWhI-0H0Z6YpI94unS1Ietd83-SDaj5ZlT36E8tF5lmzm8OdmC3SOlH4tth3JmidFyr9DGP65w7-3CnyYi2VRp8CWlqE01lbli29-4Z3sRqqGeLY0GcIUd-KWYXAavNxEHZ5gSJ57Btv2jxvGSCDlRsCqQSDXuJsSmyGSaq2JoNsWLsvIWjDwUW0cFKM7CRYD96Lkq2E2Q8ymfar7ayE8Av53BXI3PWaROu4uyY94BJeXLYCpickKOngdyz';

        // Dữ liệu cần gửi
        $url = 'https://openapi.zalo.me/v2.0/oa/getfollowers?offset=0&count=5';

        // Cấu hình cURL để gọi API với phương thức GET
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true); // Sử dụng phương thức GET
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);

        // Thực hiện gọi API
        $response = curl_exec($ch);
        curl_close($ch);
        $cauHinh = new CauHinh();
        $cauHinh->ghi_chu = 'test_webhook';
        $cauHinh->name = 'test_webhook';
        $cauHinh->content = $response;
        $cauHinh->save();

        // Xử lý phản hồi từ API
        $responseData = json_decode($response, true);
        if (isset($responseData['error']) && $responseData['error'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetAccessToken()
    {
        $reToken = CauHinh::findOne(['ghi_chu'=>'refresh_token']);
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token']);
        $url = 'https://oauth.zaloapp.com/v4/oa/access_token';
        $secretKey = 'szpDdhiKLTr3fYZSWW56';
        $appId = '3433189854621494610';

        $postData = [
            'refresh_token' => $reToken->content,
            'app_id' => $appId,
            'grant_type' => 'refresh_token'
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'secret_key: ' . $secretKey
        ]);

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        $data = json_decode($response, true);
        if (isset($data['access_token']) && isset($data['refresh_token'])) {
            $acToken->updateAttributes([
                'content' => $data['access_token']
            ]);

            $reToken->updateAttributes([
                'content' => $data['refresh_token']
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function SendZNS($hoaDonID, $giaoDichID)
    {
        $url = 'https://business.openapi.zalo.me/message/template';
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token'])->content;
        $templateID = CauHinh::findOne(['ghi_chu'=>'template_id']);
        $tracking = CauHinh::findOne(['ghi_chu'=>'tracking_id']);
        $trackingID = intval($tracking->content);
        $hoaDon = QuanLyHoaDon::findOne(['id'=>$hoaDonID]);

        $giaoDich = GiaoDich::findOne($giaoDichID);
        $phone = $hoaDon->dien_thoai;
        if (substr($phone, 0, 1) === '0') {
            $phone = '84' . substr($phone, 1);
        }
        $HDs = HoaDon::findAll(['phong_khach_id'=>$hoaDon->phong_khach_id]);
        $tienNo = 0;
        foreach ($HDs as $HD){
            if ($HD->thang == $hoaDon->thang && $HD->nam == $hoaDon->nam)
                break;
            $tienNo += ($HD->tong_tien - $HD->da_thanh_toan);
        }
        $tienDien = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>2])->one();
        $tienNuoc = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>3])->one();
        $tienInternet = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>5])->one();
        $tienRac = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>4])->one();
        $tienGiat = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDonID])
            ->andFilterWhere(['dich_vu_id'=>6])->one();

        $templateData = [
            'thang' => $hoaDon->thang,
            'tien_phong' => number_format($hoaDon->tien_phong,0,',','.'),
            'tien_dien' => number_format($tienDien->thanh_tien,0,',','.'),
            'tien_nuoc' => number_format($tienNuoc->thanh_tien,0,',','.'),
            'tien_internet' => number_format($tienInternet->thanh_tien,0,',','.'),
            'tien_rac' => number_format($tienRac->thanh_tien,0,',','.'),
            'tien_giat' => number_format($tienGiat->thanh_tien,0,',','.'),
            'tien_no' => number_format($tienNo,0,',','.'),
            'tong_tien' => number_format($tienNo + $hoaDon->tong_tien,0,',','.'),
            'noi_dung_chuyen_khoan' => 'GD '.$giaoDichID.' HD '.$hoaDonID,
            'so_tien' => $giaoDich->tong_tien,
            'ho_ten' => $hoaDon->hoten,
            'dien_thoai' => $hoaDon->dien_thoai,
            'phong' => $hoaDon->ten_phong
        ];
        $postData = [
            'phone' => $phone,
            'template_id' => $templateID->content,
            'template_data' => $templateData,
            'tracking_id' => 'TID'.sprintf('%07d',$trackingID)
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'access_token: ' . $acToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        $data = json_decode($response, true);
        if (isset($data['message'])) {
            $tracking->updateAttributes([
                'content' => $trackingID+1
            ]);
            if ($data['message'] != 'noi_dung_chuyen_khoan has invalid format')
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

    public function actionThongBaoThanhToan()
    {
        $thang = (int) date('m');
        $nam = (int) date('Y');
        $ngayHienTai = (int)date('d');
        $gioHienTai = (int)date('H');
        $thoiGianThongBao = CauHinh::findOne(['ghi_chu'=>'thoi_gian_thong_bao'])->content;
        $ngayThongBao = intval($thoiGianThongBao);
//        Kiểm tra có phải ngày 28/2 không, nếu đúng thì gửi thông báo
        $check = $ngayThongBao >= 29 && $ngayHienTai == 28 && $thang == 2;
        if ($ngayThongBao != $ngayHienTai && !$check) {
            return [
                'success' => true,
                'content' => 'Chưa đến hạn thông báo thanh toán hợp đồng'
            ];
        }
        if ($gioHienTai != 8) {
            return [
                'success' => true,
                'content' => 'Chưa đến hạn thông báo thanh toán hợp đồng'
            ];
        }

        //Lấy ra các hóa đơn tháng trước
//        if ($thang == 1){
//            $thang = 12;
//            $nam -= 1;
//        }else{
//            $thang -= 1;
//        }

        $user = User::findOne(1);
        $cauHinh = CauHinh::findOne(['ghi_chu'=>'Link QR'])->content;
        $hoaDons = QuanLyHoaDon::find()->andFilterWhere(['trang_thai'=>HoaDon::CHUA_THANH_TOAN])
            ->andFilterWhere(['active'=>1])
            ->andFilterWhere(['thang'=>$thang])
            ->andFilterWhere(['nam'=>$nam])->all();
        $loi = [];
        foreach ($hoaDons as $hoaDon){
            //Nếu đã tạo giao dịch thì không gửi nữa
            $giaoDich = GiaoDich::find()->andFilterWhere(['hoa_don_id' => $hoaDon->id])
                ->andFilterWhere(['active' => 1])->all();
            if (count($giaoDich) > 0){
                continue;
            }
//          Tinh tong tien con lai phai tra
            $phaiTra = HoaDon::find()
                ->where(['active' => 1, 'phong_khach_id' => $hoaDon->phong_khach_id])
                ->andWhere(['<=', 'id', $hoaDon->id])
                ->sum(new \yii\db\Expression('tong_tien - da_thanh_toan'));

            $phaiTra = $phaiTra ?: 0;

            $model = new GiaoDich();
            $maQR = str_replace('{bank_id}',$user->te_ngan_hang,$cauHinh);
            $maQR = str_replace('{so_tai_khoan}',$user->so_tai_khoan,$maQR);
            $maQR = str_replace('{so_tien}',$phaiTra,$maQR);
            $ten = explode(' ',$user->ho_ten_tai_khoan);
            $maQR = str_replace('{ten_nguoi_nhan}',implode('%20',$ten),$maQR);
            $model->hoa_don_id = $hoaDon->id;
            $model->tong_tien = intval($phaiTra);
            $model->phong_khach_id = $hoaDon->phong_khach_id;
            $model->so_tien_giao_dich = 0;
            $model->trang_thai_giao_dich = GiaoDich::KHOI_TAO;
            $model->khach_hang_id = $hoaDon->khach_hang_id;
            $model->loai_giao_dich = GiaoDich::THANH_TOAN_HOP_DONG;
            $model->ma_qr = '';
            $model->noi_dung_chuyen_khoan = '';
            if ($model->save()){
                $this->GetAccessToken();
                $noiDung = 'GD%20'.$model->id.'%20HD%20'.$hoaDon->id;
                $maQR = str_replace('{noi_dung}',$noiDung,$maQR);
                $model->updateAttributes([
                    'ma_qr' => $maQR
                ]);
                if (!$this->SendZNS($hoaDon->id, $model->id))
                    $loi[$hoaDon->ma_hoa_don] = $hoaDon->hoten.' vui lòng nhấn quan tâm OA trên zalo mobile!';
            }
        }
        if (count($loi)==0){
            return [
                'success' => true,
                'content' => 'Gửi tin nhắn thành công tới tất cả khách hàng'
            ];
        }else{
            return [
                'success' => false,
                'content' => $loi
            ];
        }
    }
    public function actionCreateQuickResponse()
    {
        $content = json_decode(file_get_contents('php://input'));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(isset($content)){
            $bankID = $content->bank_id;
            $soTaiKhoan = $content->so_tai_khoan;
            $soTien = $content->so_tien;
            $tenNguoiNhan = $content->ten_nguoi_nhan;
            $noiDung = $content->noi_dung;
        }else{
            $bankID = $_POST['bank_id'];
            $soTaiKhoan = $_POST['so_tai_khoan'];
            $soTien = $_POST['so_tien'];
            $tenNguoiNhan = $_POST['ten_nguoi_nhan'];
            $noiDung = $_POST['noi_dung'];
        }
        if (empty($bankID)){
            return [
                'success' => false,
                'content' => "Vui lòng nhập mã ngân hàng"
            ];
        }
        if (empty($soTaiKhoan)){
            return [
                'success' => false,
                'content' => "Vui lòng nhập số tài khoản"
            ];
        }
        if (empty($soTien)){
            return [
                'success' => false,
                'content' => "Vui lòng nhập số tiền"
            ];
        }
        if (empty($tenNguoiNhan)){
            return [
                'success' => false,
                'content' => "Vui lòng nhập tên người nhận"
            ];
        }
        $cauHinh = CauHinh::findOne(['ghi_chu'=>'Link QR'])->content;
        $maQR = str_replace('{bank_id}',$bankID,$cauHinh);
        $maQR = str_replace('{so_tai_khoan}',$soTaiKhoan,$maQR);
        $maQR = str_replace('{so_tien}',$soTien,$maQR);
        $ten = explode(' ',$tenNguoiNhan);
        $maQR = str_replace('{ten_nguoi_nhan}',implode('%20',$ten),$maQR);
        $content= explode(' ',$noiDung);
        $maQR = str_replace('{noi_dung}',implode('%20',$content),$maQR);
        return [
            'success' => true,
            'content' => $maQR
        ];
    }
    public function actionCapNhatHoaDon()
    {
        $hopDongs = PhongKhach::findAll(['active' => 1]);
        foreach ($hopDongs as $hopDong){
            $hoaDon = HoaDon::findOne([
                'active' => 1,
                'phong_khach_id' => $hopDong->id,
                'thang' => 2,
                'nam' => 2025,
            ]);
            $hoaDons = HoaDon::find()
                ->andFilterWhere(['active' => 1])
                ->andFilterWhere(['phong_khach_id' => $hopDong->id])
                ->andFilterWhere(['<','id',$hoaDon->id])->all();
            foreach ($hoaDons as $item){
                $item->updateAttributes([
                    'da_thanh_toan' => $item->tong_tien
                ]);
                $item->afterUpdate();
            }
//            $hoaDons = HoaDon::find()
//                ->andFilterWhere(['active' => 1])
//                ->andFilterWhere(['phong_khach_id' => $hopDong->id])
//                ->andFilterWhere(['>','id',$hoaDon->id])->all();
//            foreach ($hoaDons as $hoaDon){
//                $hoaDon->updateAttributes([
//                    'da_thanh_toan' => 0
//                ]);
//            }
        }
        return true;
    }
    public function actionCapNhatSoDien()
    {
        $phongs = DanhMuc::findAll(['active' => 1]);
        $result = [];
        foreach ($phongs as $phong){
            $soDien = 0;
            $arr = [];
            $hoaDons = QuanLyHoaDon::find()
                ->andFilterWhere(['active' => 1])
                ->andFilterWhere(['phong_id' => $phong->id])->all();
            foreach ($hoaDons as $item){
                $chiTiets = ChiTietHoaDon::findAll([
                    'hoa_don_id' => $item->id,
                    'dich_vu_id' => 2
                ]);
                foreach ($chiTiets as $chiTiet){
                    if($chiTiet->so_luong > $soDien){
                        $soDien = $chiTiet->so_luong;
                        $arr['chi_tiet_id'] = $chiTiet->id;
                        $arr['so_luong'] = $chiTiet->so_luong;
                    }
                }
            }
            $result[$phong->name] = $arr;
            $phong->updateAttributes([
                'so_dien' => $soDien
            ]);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $phongs
        ];
    }
}