<?php
/**
 * Created by PhpStorm.
 * User: hungluong
 * Date: 7/24/17
 * Time: 8:57 AM
 */?>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'modal-updateProfile',
    'size' => \yii\bootstrap\Modal::SIZE_DEFAULT,
    'header' => '<h4 class="modal-title"><i class="fas fa-user"></i> Thông tin cá nhân</h4>',
    'footer' => \common\models\myAPI::getBtnCloseModal() .
        \yii\bootstrap\Html::a('<i class="fas fa-save"></i> Lưu lại', '#', [
            'class' => 'btn btn-primary btn-saveProfile'
        ])
]); ?>

<?php $form = \yii\bootstrap\ActiveForm::begin([
    'options' => [
        'id' => 'form-updateProfile',
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<style>
    body {
        font-family: 'Helvetica Neue', sans-serif;
        background-color: #f8f9fa !important;
    }

    .modal-content {
        background-color: #ffffff !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
    }

    .modal-header {
        background-color: #007bff !important;
        color: white !important;
        font-weight: bold !important;
        border-radius: 8px 8px 0 0 !important;
    }

    .modal-title {
        font-size: 1.5rem !important;
    }
    .modal-footer .btn-primary, .btn-default{
        border-radius: 4px !important;
    }

    .form-group label {
        color: #555 !important;
        font-weight: 600 !important;
    }

    .form-control {
        background-color: #f1f1f1 !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
        color: #333 !important;
    }

    .form-control:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    }

    .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }


    h4.margin-top-20 {
        margin-top: 20px !important;
        color: #333 !important;
    }

    th, td {
        text-align: left !important;
    }
    .profile-picture {
        width: 150px;
        height: 150px;
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-picture img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<div class="thongbao"></div>
<div class="row">
    <!-- Cột bên trái: Ảnh đại diện -->
    <div class="col-sm-4">
        <div class="profile-picture text-center">
            <?php
            // Kiểm tra người dùng đăng nhập, hiển thị ảnh hoặc ảnh mặc định
            $avatar = Yii::$app->user->isGuest
                ? '/hinh-anh/no-image.jpg'
                : \yii\helpers\Url::to('@web/hinh-anh/' . Yii::$app->user->identity->anhdaidien);
            ?>
            <img src="<?= $avatar ?>" alt="Avatar" class="img-responsive img-circle" style="margin:0 auto; max-width: 100%;">
        </div>
    </div>

    <!-- Cột bên phải: Thông tin chung -->
    <div class="col-sm-8">
        <div class="form-group">
            <?= \yii\bootstrap\Html::label('Họ tên: ', 'hoTen', ['class' => 'col-sm-3 control-label']) ?>
            <div class="col-sm-9">
                <?= \yii\bootstrap\Html::textInput('hoTen', \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('hoten')->scalar(), ['class' => 'form-control', 'id' => 'hoTen']) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Tên đăng nhập: </label>
            <div class="col-sm-9">
                <p class="form-control-static"><?= \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('username')->scalar() ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Điện thoại: </label>
            <div class="col-sm-9">
                <p class="form-control-static"><?= \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('dien_thoai')->scalar() ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Email: </label>
            <div class="col-sm-9">
                <p class="form-control-static"><?= \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('email')->scalar() ?></p>
            </div>
        </div>
        <div class="form-group">
            <?= \yii\bootstrap\Html::label('Ngày sinh: ', 'ngaySinh', ['class' => 'col-sm-3 control-label']) ?>
            <div class="col-sm-9">
                <?= \common\models\myAPI::dateField2('ngaySinh', \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('birth_day')->scalar(), '1900:' . date("Y"), ['class' => 'form-control', 'id' => 'ngaySinh']) ?>
            </div>
        </div>
        <h4 class="margin-top-20">TÀI KHOẢN NGÂN HÀNG</h4>
        <div class="form-group">
            <?= \yii\bootstrap\Html::label('Tên tài khoản: ', 'tenTaiKhoan', ['class' => 'col-sm-3 control-label']) ?>
            <div class="col-sm-9">
                <?= \yii\bootstrap\Html::textInput('tenTaiKhoan', \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('ho_ten_tai_khoan')->scalar(), ['class' => 'form-control', 'id' => 'tenTaiKhoan', 'placeholder' => 'Tên tài khoản']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= \yii\bootstrap\Html::label('Số tài khoản: ', 'soTaiKhoan', ['class' => 'col-sm-3 control-label']) ?>
            <div class="col-sm-9">
                <?= \yii\bootstrap\Html::textInput('soTaiKhoan', \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('so_tai_khoan')->scalar(), ['class' => 'form-control', 'id' => 'soTaiKhoan', 'placeholder' => 'Số tài khoản']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= \yii\bootstrap\Html::label('Tên ngân hàng: ', 'tenNganHang', ['class' => 'col-sm-3 control-label']) ?>
            <div class="col-sm-9">
                <?= \yii\bootstrap\Html::textInput('tenNganHang', \common\models\User::find()->where(['id' => Yii::$app->user->id])->select('te_ngan_hang')->scalar(), ['class' => 'form-control', 'id' => 'tenNganHang', 'placeholder' => 'Tên ngân hàng']) ?>
            </div>
        </div>
    </div>
</div>

<?php \yii\bootstrap\ActiveForm::end(); ?>
<?php \yii\bootstrap\Modal::end(); ?>
