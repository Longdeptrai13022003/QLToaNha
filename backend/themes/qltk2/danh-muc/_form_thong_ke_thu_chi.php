<?php
use common\models\myAPI;
use backend\models\DonHang;
?>
<?php $form = \yii\widgets\ActiveForm::begin(['options' => ['id' => 'form-thong-ke']]) ?>


<div class="thong-bao"></div>
<div class="col-md-6">
    <div class="form-group">
        <?=\yii\helpers\Html::label('Từ ngày <span>*</span>')?>
        <?=myAPI::dateField2('from_ngay_thong_ke',null,'2023:'.date("Y"), ['class' => 'form-control', 'id' => 'from_ngay_thong_ke'])?>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <?=\yii\helpers\Html::label('Đến ngày <span>*</span>')?>
        <?=myAPI::dateField2('to_ngay_thong_ke',null,'2023:'.date("Y"), ['class' => 'form-control', 'id' => 'to_ngay_thong_ke'])?>
    </div>
</div>


<?php \yii\widgets\ActiveForm::end(); ?>

