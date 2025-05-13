<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $error [] */
/* @var $anhs [] */
/* @var $form yii\widgets\ActiveForm */
/* @var $ds_nhom_ky_nang \backend\models\DanhMuc[] */
use common\models\User;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id'=>'form-khach-hang',
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data'
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= \yii\bootstrap\Html::label('Họ tên <span class="text-danger">*</span>')?>
            <?= \yii\bootstrap\Html::textInput('hoten',$model->hoten,['class' => 'form-control'])?>
            <div class="text-danger"><?= $error['loi_ho_ten']?></div>
        </div>
        <div class="col-md-4">
            <?= \yii\bootstrap\Html::label('Điện thoại <span class="text-danger">*</span>')?>
            <?= \yii\bootstrap\Html::textInput('dien_thoai',$model->dien_thoai,['class' => 'form-control'])?>
        </div>
        <div class="col-md-4">
            <?= \yii\bootstrap\Html::label('Email <span class="text-danger">*</span>')?>
            <?= \yii\bootstrap\Html::textInput('email',$model->email,['class' => 'form-control'])?>
        </div>
        <div class="col-md-4 margin-top-10">
            <?= \yii\bootstrap\Html::label('Tên đăng nhập <span class="text-danger">*</span>')?>
            <?= \yii\bootstrap\Html::textInput('username','',['class' => 'form-control'])?>

        </div>
        <div class="col-md-4 margin-top-10">
            <?= \yii\bootstrap\Html::label('Mật khẩu <span class="text-danger">*</span>')?>
            <?= \yii\bootstrap\Html::passwordInput('matkhau','',['class' => 'form-control'])?>
        </div>
    </div>

    <div id="anh-dai-dien">
        <div class="row">
            <div class="col-md-4 margin-top-10">
                <?= \yii\bootstrap\Html::label('Ảnh đại diện')?>
                <?= Html::fileInput('anhdaidien',null,['class'=>'form-control']) ?>
            </div>
        </div>
    </div>
    <div id="anh-can-cuoc" class="margin-top-10">
        <div class="row">
            <div class="col-md-4">
                <label>Ảnh cccd mặt trước</label>
                <?= Html::fileInput('anhcancuoc1',null,['class'=>'form-control']) ?>
            </div>
            <div class="col-md-4">
                <label>Ảnh cccd mặt sau</label>
                <?= Html::fileInput('anhcancuoc2',null,['class'=>'form-control']) ?>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <div>
        <?=Html::hiddenInput('Vaitrouser[]',7)?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
