<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TrangThai;

/* @var $this yii\web\View */
/* @var $model backend\models\TrangThai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trang-thai-form panel panel-info">

    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-edit"></i>
            <?= $model->isNewRecord ? ' Tạo Trạng thái Mới' : ' Cập Nhật Trạng Thái' ?>
        </h3>
    </div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"form-group\">\n{label}\n<div class=\"col-sm-9\">{input}\n{hint}\n{error}</div>\n</div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'ten')->textInput(['maxlength' => true, 'placeholder' => 'Nhập tên trạng thái']) ?>
        <?php

        echo $form->field($model, 'loai_trang_thai')->dropDownList(
            TrangThai::getTypeList(),
            ['prompt' => '--- Chọn loại trạng thái ---']
        );
        ?>
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <?= Html::submitButton(
                        ($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Tạo mới' : '<i class="glyphicon glyphicon-floppy-disk"></i> Cập nhật'),
                        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                    ) ?>
                    <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Quay lại', ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

</div>
