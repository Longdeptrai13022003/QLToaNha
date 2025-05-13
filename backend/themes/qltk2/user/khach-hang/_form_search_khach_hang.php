<?php
/**
 * @var $user \common\models\User
 */
?>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'form-search-nguoi-dung',
    'options' => ['class' => 'form-horizontal form-size-L']
])?>
<h4 class="margin-top-10">THÔNG TIN KHÁCH HÀNG</h4>
<div class="form-group">
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::textInput('maKH', '', ['class' => 'form-control', 'id' => 'maKH', 'placeholder' => 'Mã KH']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::textInput('tenKH', '', ['class' => 'form-control', 'id' => 'tenKH', 'placeholder' => 'Tên KH']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::textInput('dienThoaiKH', '', ['class' => 'form-control', 'id' => 'dienThoaiKH', 'placeholder' => 'SĐT KH']) ?>
    </div>
    <div class="col-sm-4 margin-top-20">
        <?= \yii\bootstrap\Html::textInput('username', '', ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Tên đăng nhập']) ?>
    </div>
    <div class="col-sm-4 margin-top-20">
        <?= \yii\bootstrap\Html::textInput('email', '', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) ?>
    </div>
    <div class="col-sm-4 margin-top-20">
        <?= \yii\bootstrap\Html::textInput('vi_dien_tu', '', ['class' => 'form-control', 'id' => 'vi_dien_tu', 'placeholder' => 'Ví điện tử']) ?>
    </div>

</div>
<?php \yii\widgets\ActiveForm::end(); ?>
