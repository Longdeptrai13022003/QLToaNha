<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileHopDong */
/* @var $form yii\widgets\ActiveForm */
/* @var $KhachHang \yii\helpers\ArrayHelper */

$users = \backend\models\QuanLyKhachHang::findAll(['status'=>10]);
$toanhas = \backend\models\DanhMuc::findAll(['parent_id'=>null]);
$khachHang = ArrayHelper::map($users, 'id', function($user) {
    return $user->hoten . ' + ' . $user->dien_thoai;
});
$toanhaids = ArrayHelper::map($toanhas, 'id', function($toanha) {
    return $toanha->name;
});
?>
<style>
    .custom_margin{
        margin-top: 36px;
    }
    .custom_mt{
        margin-top: 13px;
    }
    .mt_danhsach{
        margin-top: 8px;
    }
</style>
<div>

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'user_id')->label('Khách hàng')->dropDownList($khachHang) ?>
        </div>
        <div class="col-md-4 pt-1">
            <?= Html::a('<i class="fa fa-plus"></i> Thêm khách hàng','#',[
                'class' => 'btn btn-primary custom_margin',
                'id' => 'btn-them-khach-hang'
            ])?>
        </div>
    </div>

    <div class="row custom_mt">
        <div class="col-md-4">
            <label class="form-label">Tòa nhà</label>
            <?php if(count($toanhaids)==1):?>
                <?= Html::dropDownList('toanhaid',null,$toanhaids,['class'=>'form-control toanha_input']);?>
            <?php else:?>
                <?= Html::dropDownList('toanhaid',null,$toanhaids,['prompt'=>'__Chọn__','class'=>'form-control toanha_input']);?>
            <?php endif;?>
        </div>
        <div class="col-md-4">
            <label class="form-label">Phòng ở</label>
            <?= Html::dropDownList('phongoid',null,['1'=>'example'],['prompt'=>'__Chọn__','class'=>'form-control']);?>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>Đơn giá: </strong></label>
            <p></p>
        </div>
    </div>

    <div class="row custom_mt">
        <div class="col-md-4">
            <label class="form-label"><strong>Mã hợp đồng: </strong></label>
            <?= Html::textInput('hopdongid','',['class'=>'form-control']) ?>
        </div>
        <div class="col-md-4">
            <label class="form-label">Từ ngày</label>
            <?= \common\models\myAPI::dateField2('tungay',date('d-m-Y'),'2024:2030')?>
        </div>
        <div class="col-md-4">
            <label class="form-label">Đến ngày</label>
            <?= \common\models\myAPI::dateField2('denngay',date('d-m-Y'),'2024:2030')?>
        </div>
    </div>

    <div class="row custom_mt">
        <div class="col-md-4">
            <label class="form-label" for="tiencoc">Tiền cọc</label>
            <?= Html::textInput('tiencoc',0,['class'=>'form-control', 'id'=>'tiencoc']);?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'file')->label('File đính kèm')->fileInput() ?>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>Tổng tiền: </strong></label>
            <p></p>
        </div>
    </div>
    <div class="custom_mt">
        <label class="form-label">Ghi chú</label>
        <?= Html::textarea('ghichu','',['class'=>'form-control','rows'=>3]);?>
    </div>

    <div class="row custom_mt">
        <div class="col-md-9"></div>
        <div class="col-md-1">
            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                    <?= Html::submitButton('Lưu lại',['class'=>'btn btn-success']) ?>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2 mt_danhsach">
            <?= Html::a('<i class="fa fa-list"></i> Quay lại danh sách','#',[
                'class' => 'btn btn-primary',
                'id' => 'btn-luu-hop-dong'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
