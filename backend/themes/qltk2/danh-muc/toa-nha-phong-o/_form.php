<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DanhMuc */
/* @var $form yii\widgets\ActiveForm */
/* @var $donGia [] */
?>

<div class="danh-muc-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data',
            'id'=>'form-danh-muc'
        ]
    ]); ?>
    <?= $model->isNewRecord ? '' : Html::hiddenInput('id',$model->id)?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Tên toà nhà / phòng ở <span class="text-danger">*</span>') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'type')->dropDownList([
                \backend\models\DanhMuc::TOA_NHA => \backend\models\DanhMuc::TOA_NHA,
                \backend\models\DanhMuc::PHONG_O => \backend\models\DanhMuc::PHONG_O
            ], ['prompt' => '-- Chọn --'])->label('Phân loại <span class="text-danger">*</span>') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'parent_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\DanhMuc::findAll(['type' => \backend\models\DanhMuc::TOA_NHA]), 'id', 'name'), ['prompt' => '-- Chọn --']
            )->label('Toà nhà') ?>
        </div>
        <h4>&nbsp;&nbsp;&nbsp;<span class="text-primary">ĐƠN GIÁ PHÒNG</span></h4>
        <div class="col-md-3">
            <div class="margin-top-10">
                <?= Html::label('Theo tháng','thang')?>
                <?= Html::textInput('thang',$model->isNewRecord ? '' : number_format($model->don_gia, 0, ',', '.'), ['class'=>'form-control text-right don_gia'])?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="margin-top-10">
                <?= Html::label('3 giờ','3_gio')?>
                <?= Html::textInput('3_gio',$model->isNewRecord ? '' : number_format($donGia['3_gio'], 0, ',', '.'), ['class'=>'form-control text-right don_gia'])?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="margin-top-10">
                <?= Html::label('6 giờ','6_gio')?>
                <?= Html::textInput('6_gio',$model->isNewRecord ? '' : number_format($donGia['6_gio'], 0, ',', '.'), ['class'=>'form-control text-right don_gia'])?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="margin-top-10">
                <?= Html::label('Theo ngày','ngay')?>
                <?= Html::textInput('ngay',$model->isNewRecord ? '' : number_format($donGia['ngay'], 0, ',', '.'), ['class'=>'form-control text-right don_gia'])?>
            </div>
        </div>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::a($model->isNewRecord ? 'Thêm mới' : 'Sửa','#', ['class' => $model->isNewRecord ? 'btn btn-success save-phong' : 'btn btn-primary update-phong']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
