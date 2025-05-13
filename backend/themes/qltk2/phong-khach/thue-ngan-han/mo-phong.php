<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $phongs [] */
/* @var $gios [] */
/* @var $phuts [] */

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype'=> 'multipart/form-data',
        'id'=>'form-mo-phong'
    ]
]); ?>
<div>
    <table class="table text-nowrap">
        <thead>
        <tr>
            <th width="1%">Phòng</th>
            <th>Khách hàng</th>
            <th width="15%">Ngày vào</th>
            <th width="15%">Ngày ra</th>
            <th width="10%">Thành tiền/cọc trước</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($phongs as $index => $phong):?>
        <tr>
            <td>
                <span class="ten-phong"><?=$phong ?></span><?= Html::hiddenInput('phongID[]',$index,['class' => 'phong-id']) ?>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::textInput('hoten[]',null,['class'=>'form-control ho-ten','placeholder'=>'Họ tên']) ?><br/>
                    </div>
                    <div class="col-md-6">
                        <?= Html::textInput('dien_thoai[]',null,['class'=>'form-control dien-thoai','placeholder'=>'Điện thoại']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= Html::textInput('CCCD[]',null,['class'=>'form-control cccd','placeholder'=>'CCCD']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::fileInput('anh_cccd'.$index.'[]',null,['class'=>'form-control','multiple' => true]) ?>
                    </div>
                </div>
            </td>
            <td>
                <?= \common\models\myAPI::dateField2('ngay-vao[]',date('d-m-Y'),'2020:2050',['class'=>'form-control ngay-vao'])?><br/>
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::dropDownList('gio-vao[]',date('H'),$gios,['class'=>'form-control gio-vao'])?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::dropDownList('phut-vao[]',date('i'),$phuts,['class'=>'form-control phut-vao'])?>
                    </div>
                </div>
            </td>
            <td>
                <?= \common\models\myAPI::dateField2('ngay-ra[]',date('Y-m-d'),'2020:2050',['class'=>'form-control ngay-ra'])?><br/>
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::dropDownList('gio-ra[]',date('H'),$gios,['class'=>'form-control gio-ra'])?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::dropDownList('phut-ra[]',date('i'),$phuts,['class'=>'form-control phut-ra'])?>
                    </div>
                </div>
            </td>
            <td>
                <div class="text-right text-danger margin-top-10 thanh-tien">
                    0
                </div>
                <div>
                    <?= Html::textInput('tien-coc[]',null,['class'=>'form-control number-display text-right margin-top-25','placeholder'=>'cọc trước']) ?>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="pull-right"><?= Html::a('<i class="fa fa-save"></i> Lưu','#',['class'=>'btn btn-success', 'id'=>'btn-luu'])?></div><br/>
</div>
<?php ActiveForm::end(); ?>