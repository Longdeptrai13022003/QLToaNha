<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $toanhaids ArrayHelper */

$thangs = [];
for ($i = 1; $i <= 12; $i++){
    $thangs[$i] = 'Tháng '.$i;
}
$nams = [];
for ($i = 2000; $i <= 2050; $i++){
    $nams[$i] = $i;
}
?>
<div class="row">
    <div class="col-md-4">
        <p><?=Html::label('Tháng','thang',['class'=>'form-label'])?></p>
        <?= Html::dropDownList('thang',date('n'),$thangs,['class'=>'form-control','id'=>'thang'])?>
    </div>
    <div class="col-md-4">
        <p><?=Html::label('Năm','nam',['class'=>'form-label'])?></p>
        <?= Html::dropDownList('nam',date('Y'),$nams,['class'=>'form-control','id'=>'nam'])?>
    </div>
    <div class="col-md-4">
        <p><?=Html::label('Tòa nhà','toa_nha',['class'=>'form-label'])?></p>
        <?= Html::dropDownList('toa_nha',null,$toanhaids,['class'=>'form-control','id'=>'toa_nha','prompt'=>'--Chọn--'])?>
    </div>

    <div class="col-md-12">
        <div class="margin-top-35">
            <?= Html::a('<i class="fa fa-save"></i> In danh sách','#',['class'=>'btn btn-success btn-in-nhieu pull-right','loai-in'=>'nhieu'])?>
        </div>
    </div>
</div>
