<?php
namespace backend\controllers;

//use common\models\AccessRules;
use backend\models\DanhMuc;
use backend\models\DonHang;
use backend\models\KyGui;
use backend\models\PhieuYeuCauGiao;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyDonKyGui;
use backend\models\search\QuanLyKhachHangSearch;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Security;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\myFuncs;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    //
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login','logout', 'index', 'error', 'doimatkhau', 'loadform', 'update-profile'
                ],
                'rules' => [
                    [
                        'actions' => ['error', 'login'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['signup', 'forgot-password'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout', 'doimatkhau', 'loadform', 'index', 'update-profile'],
                        'allow' => true,
//                        'matchCallback' => function($rule, $action){
//                            return Yii::$app->user->identity->username == 'adamin';
//                        }
                        'roles' => ['@']
                    ],

                ],
//                'denyCallback' => function ($rule, $action) {
//                    throw new Exception('You are not allowed to access this page', 404);
//                }
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
//x
        return $this->render('index');
//        if(myAPI::isAccess2('QuanLyCongViec', 'don-vi'))
//            return $this->redirect(Url::toRoute(['quan-ly-cong-viec/don-vi']));
//        else
//            return $this->redirect(Url::toRoute(['quan-ly-cong-viec/cong-viec-ca-nhan']));
    }

    public function actionLogin()
    {
      $contentAPI = json_decode(file_get_contents('php://input'));

      if(isset($contentAPI->uid)){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
          'success' => false,
          'content' => 'Tài khoản không hợp lệ, vui lòng đăng nhập'
        ];
      }
      else{
        if (!Yii::$app->user->isGuest) {
          return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(['username' => $model->username]);
//            $cookies = Yii::$app->response->cookies;
            $hash = Yii::$app->security->generateRandomString();
            $user->updateAttributes(['auth_web' => $hash]);
//            $cookies->add(new Cookie([
//                'name' => 'token',
//                'value' => $hash
//            ]));
//            $cookies->add(new Cookie([
//                'name' => 'username',
//                'value' => Yii::$app->security->generateRandomString()
//            ]));
//            $cookies->add(new Cookie([
//                'name' => 'userId',
//                'value' => $user->username
//            ]));

            $newRandomKey = Yii::$app->security->generateRandomString();
            Yii::$app->session->set('new_auth_key', $newRandomKey);
            Yii::$app->session->set('password_hash', \common\models\User::findOne(Yii::$app->user->id)->password_hash);

            setcookie("token", $hash);
            setcookie("username", Yii::$app->security->generateRandomString());
            setcookie("userId", $user->username);

            return $this->goBack();
        } else {
          return $this->renderPartial('login', [
            'model' => $model,
          ]);
        }
      }
    }

    public function actionLogout()
    {
        User::updateAll(['auth_web' => ''], ['id' => Yii::$app->user->id]);
        Yii::$app->user->logout();
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('token');
        $cookies->remove('userId');
        $cookies->remove('username');
        unset($cookies['token']);
        unset($cookies['userId']);
        unset($cookies['username']);
        return $this->goHome();
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            if(Yii::$app->request->isAjax){
                echo myFuncs::getMessage($exception->getMessage(),'danger', "Lỗi!");
                exit;
            }
            return $this->render('error', ['exception' => $exception]);
        }
      return $this->render('error', ['exception' => '']);
    }

    public function actionDoimatkhau(){
        $sercurity = new Security();
        $user = User::findOne(Yii::$app->user->getId());
//        $user->password_hash = $_POST['matkhaucu'];

        if(!Yii::$app->security->validatePassword($_POST['matkhaucu'], $user->password_hash))
            throw new HttpException(500, myAPI::getMessage('danger', 'Mật khẩu cũ không đúng!'));
        else{
            $matkhaumoi = $sercurity->generatePasswordHash(trim($_POST['matkhaumoi']));
            User::updateAll(['password_hash' => $matkhaumoi], ['id' => Yii::$app->user->getId()]);
            echo Json::encode(['message' => myAPI::getMessage('success', 'Đã đổi mật khẩu thành công')]);
        }
    }
    public function actionUpdateProfile(){
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $ngaySinh = (new \DateTime($_POST['ngaySinh']))->format('Y-m-d');
        $ngaySinh = \DateTime::createFromFormat('d/m/Y', $_POST['ngaySinh'])->format('Y-m-d');
        $user = User::findOne(Yii::$app->user->id);
        $user->updateAttributes([
            'hoten' => $_POST['hoTen'],
            'birth_day' => $ngaySinh,
            'ho_ten_tai_khoan' => $_POST['tenTaiKhoan'],
            'so_tai_khoan' => $_POST['soTaiKhoan'],
            'te_ngan_hang' => $_POST['tenNganHang'],
        ]);
        return [
            'title' => 'Thông báo',
            'success' => true,
            'content' => 'Cập nhật thông tin người dùng thành công'
        ];
    }

    public function actionForgotPassword()
    {
        if (isset($_POST['User']['email'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(filter_var($_POST['User']['email'], FILTER_VALIDATE_EMAIL)){
                $user = User::findOne(['email' => $_POST['User']['email']]);
                if(is_null($user))
                    return ['success' => false, 'content' => 'Không tồn tại tài khoản này', 'title' => 'Thông báo'];
                else if($user->status != 10)
                    return  ['success' => false, 'content' => 'Tài khoản đã bị khoá, vui lòng liên hệ quản trị viên để biết thêm thông tin', 'title' => 'Thông báo'];
                else{
                    $newPass = Yii::$app->security->generateRandomString(6);
                    myAPI::sendMail('Mật khẩu mới của bạn trong hệ thống '.myAPI::TEN_PHAN_MEM.' là: <strong>'.$newPass.'</strong><br/>Vui lòng đăng nhập và đổi mật khẩu mới nhằm đảm bảo tính bảo mật! Xin cảm ơn!',
                        '['.myAPI::TEN_PHAN_MEM.'] MẬT KHẨU MỚI',
                        $user->email);
                    $user->updateAttributes(['password_hash' => Yii::$app->security->generatePasswordHash($newPass)]);
                    return [
                        'success' => true,
                        'content' => 'Mật khẩu mới được gửi về email '.$user->email.'. Vui lòng truy cập email để lấy mật khẩu mới!',
                        'title' => 'Thông báo'
                    ];
                }
            }
            else
                return ['success' => false, 'content' => 'Email không hợp lệ', 'title' => 'Thông báo'];
        }
        return $this->renderPartial('forgot-password', [
            'model' => new User()
        ]);
    }

    //loadform
    public function actionLoadform(){
        $content = '';
        $title = '';
        if($_POST['type'] == 'load_form_update_trang_thai_don_hang_loat'){
            $content = $this->renderAjax('../quan-ly-don-hang/_form_update_status_don_hang_loat', [
                'donHang' => QuanLyDonHang::findAll(['da_chon_thuc_hien_chuc_nang' => 1, 'active' => 1])
            ]);
            $title = 'Cập nhật trạng thái đơn hàng loạt';
        }
        else if($_POST['type'] == 'load_form_thanh_toan_them_don_hang'){
            $content = $this->renderAjax('../quan-ly-don-hang/_form_thanh_toan_them_don_hang', [
                'donHang' => DonHang::findOne($_POST['idDonHang'])
            ]);
            $title = 'Thanh toán thêm ĐH '.$_POST['idDonHang'];
        }
        else if($_POST['type'] == 'load_form_nhap_ma_van_don'){
            $content = $this->renderAjax('../yeu-cau-giao-hang/_form_luu_ma_van_don', [
                'yeuCauGiaoHang' => PhieuYeuCauGiao::findOne($_POST['idPhieu'])
            ]);
            $title = 'Cập nhật mã vận đơn của phiếu YCG'.$_POST['idPhieu'];
        }
        else if($_POST['type'] == 'load_form_luu_sdt_nha_xe'){
            $content = $this->renderAjax('../yeu-cau-giao-hang/_form_luu_sdt_nha_xe', [
                'yeuCauGiaoHang' => PhieuYeuCauGiao::findOne($_POST['idPhieu'])
            ]);
            $title = 'Cập nhật SĐT & phí ship ra nhà xe của phiếu YCG'.$_POST['idPhieu'];
        }
        else if($_POST['type'] == 'load_form_search_don_ky_gui'){
            $content = $this->renderAjax('../quan-ly-don-ky-gui/_form_search_don_ky_gui');
            $title = 'Tìm kiếm đơn ký gửi';
        }
        else if($_POST['type'] == 'load_form_update_trang_thai_don_ky_gui_loat'){
            $content = $this->renderAjax('../quan-ly-don-ky-gui/_form_update_status_don_ky_gui_hang_loat', [
                'kyGui' => QuanLyDonKyGui::findAll(['da_chon_thuc_hien_chuc_nang' => 1, 'field_active' => 1])
            ]);
            $title = 'Cập nhật trạng thái đơn ký gửi hàng loạt';
        }
        else if($_POST['type'] == 'load_form_luu_chi_phi'){
            $content = $this->renderAjax('../yeu-cau-giao-hang/_form_luu_chi_phi', [
                'yeuCauGiaoHang' => PhieuYeuCauGiao::findOne($_POST['idPhieu'])
            ]);
            $title = 'Cập nhật phí đóng gói của YCG'.$_POST['idPhieu'];
        }
        else if($_POST['type'] == 'load_form_sua_don_ky_gui'){
            $content = $this->renderAjax('../quan-ly-don-ky-gui/_form_update_don_ky_gui', [
                'donKyGui' => QuanLyDonKyGui::find()->where(['id' => $_POST['idKyGui']])->one()
            ]);
            $title = 'Sửa đơn KG'.$_POST['idKyGui'];
        }
        else if($_POST['type'] == 'load_form_search_khach_hang'){
            $content = $this->renderAjax('../user/khach-hang/_form_search_khach_hang');
            $title = 'Tìm kiếm người dùng';

        }
        else if($_POST['type'] == 'load_form_khach_hang'){
            if (isset($_POST['model']) && isset($_POST['error'])) {
                $model = new User();
                $model->attributes = $_POST['model'];
                $error = $_POST['error'];
            } else {
                $model = new User();
                $error = ['loi_ho_ten' => ''];
            }
            $content = $this->renderAjax('../user/khach-hang/_form_them_khach_hang',[
                'model'=>$model,
                'error'=>$error
            ]);
            $title = 'Thêm khách hàng';
        }
        else if($_POST['type'] == 'thong_ke_thu_chi'){
            $content = $this->renderAjax('../danh-muc/_form_thong_ke_thu_chi');
            $title = 'Thống kê thu - chi';
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title' => $title,
            'content' => $content
        ];
    }

    public function actionSignup()
    {
        $model = new \backend\models\SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if(!isset($_POST['tnc']))
                Yii::$app->session->setFlash('thongbao', myAPI::getMessage('danger', 'Vui lòng đồng ý với các điều khoản được đưa ra'));
            else{
                $model->dongy = 1;
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
            }
        }
        return $this->renderPartial('signup', [
            'signup' => $model,
        ]);
    }
}
