<?php
/**
 * Created by PhpStorm.
 * User: hungluong
 * Date: 7/31/17
 * Time: 9:38 AM
 */?>
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
/** @var $signup \backend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';

?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>  <?=\common\models\myAPI::TEN_PHAN_MEM?> - ĐĂNG KÝ</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/vendor/yiisoft/yii2-jui/assets/theme/jquery.ui.css" rel="stylesheet" type="text/css"/>

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/pages/css/login2.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="#" style="font-size: 18pt; text-decoration: none">
         <?=\common\models\myAPI::TEN_PHAN_MEM?> - ĐĂNG KÝ
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::begin(['id' => 'signup-form', 'enableClientValidation' => false, 'options' => ['class' => 'login-form']]); ?>
    <div class="form-title">
        <span class="form-title">Đăng ký tài khoản</span>
    </div>
    <?=Yii::$app->session->getFlash('thongbao');?>

    <?=$form->field($signup, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label('Tên đăng nhập',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'password')->textInput(['type' => 'password', 'placeholder' => 'Mật khẩu', 'autocomplete' => "new-password"])->label('Mật khẩu',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'password_repeat')->textInput(['type' => 'password', 'placeholder' => 'Nhập lại mật khẩu', 'autocomplete' => "new-password"])->label('Mật khẩu',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'hoten')->textInput(['placeholder' => 'Họ tên'])->label('',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'dien_thoai')->textInput(['placeholder' => 'Điện thoại'])->label('',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'dia_chi')->textInput(['placeholder' => 'Địa chỉ'])->label('Địa chỉ',['class' => 'control-label visible-ie8 visible-ie9']);?>
    <?=$form->field($signup, 'email')->textInput(['placeholder' => 'Email'])->label('Email',['class' => 'control-label visible-ie8 visible-ie9']);?>

    <div class="form-group margin-top-20 margin-bottom-20">
        <label class="check">
            <input type="checkbox" name="tnc"/>
            <span class="loginblue-font">Tôi đồng ý với </span>
            <a href="javascript:;" class="loginblue-link">các điều khoản được đưa ra</a>
        </label>
        <div id="register_tnc_error"></div>
    </div>
    <div class="form-actions">
        <a href="<?=\yii\helpers\Url::toRoute(['site/login'])?>" class="btn btn-default">Quay lại đăng nhập</a>
        <button type="submit" value="dangkytaikhoan" id="register-submit-btn" class="btn btn-primary uppercase pull-right"><strong>Đăng ký</strong></button>
    </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
    <!-- END LOGIN FORM -->

</div>
<div class="copyright">
    <a href="https://andin.io" target="_blank">Phần mềm được phát triển bởi Nhóm ĐATN DDL</a>
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/respond.min.js"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->


<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/vendor/yiisoft/yii2-jui/assets/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/vendor/yiisoft/yii2-jui/assets/jquery.ui.datepicker.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/vendor/yiisoft/yii2-jui/assets/jquery.ui.datepicker-i18n.js" type="text/javascript"></script>

<script src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/global/scripts/login.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
</body>
<!-- END BODY -->
</html>
