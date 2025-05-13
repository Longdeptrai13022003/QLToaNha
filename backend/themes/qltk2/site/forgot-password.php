<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

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
    <title><?=\common\models\myAPI::TEN_PHAN_MEM?> - QUÊN MẬT KHẨU</title>
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
    <link href="<?=Yii::$app->request->baseUrl ?>/backend/assets/js-view/jquery-confirm-v3.3.0/jquery-confirm-master/css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
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
        <?=\common\models\myAPI::TEN_PHAN_MEM?><br/>
        QUÊN MẬT KHẨU
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::begin(['id' => 'forgot-password-form', 'enableClientValidation' => false, 'class' => 'login-form']); ?>
    <div class="form-title">
        <span class="form-title">Xin chào!.</span>
        <span class="form-subtitle">Vui lòng nhập email nhận mật khẩu mới.</span>
    </div>

    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <?=Html::activeTextInput($model, 'email',['autofocus' => true, 'class' => 'form-control form-control-solid placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Email'])?>
    </div>

    <div class="form-actions">
        <a href="#" class="btn btn-primary cap-mat-khau-moi btn-block uppercase">Cấp mật khẩu mới</a>
    </div>

    <div class="create-account">
        <p>
            <?= Html::a('Bạn chưa có tài khoản? <strong>Đăng ký ngay</strong>', \yii\helpers\Url::toRoute(['site/signup']))?><br/>
            <strong><?= Html::a('Đăng nhập?', \yii\helpers\Url::toRoute(['site/login']))?></strong>
        </p>
    </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">
    <?=date("Y"); ?> © <?=\common\models\myAPI::TEN_PHAN_MEM?> - NHÓM ĐATN DDL<sup>™</sup>
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
<script src="<?=Yii::$app->request->baseUrl ?>/backend/assets/js-view/forgot-password.js" type="text/javascript"></script>
<script src="<?=Yii::$app->request->baseUrl ?>/backend/assets/js-view/jquery-confirm-v3.3.0/jquery-confirm-master/dist/jquery-confirm.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
</body>
<!-- END BODY -->
</html>
