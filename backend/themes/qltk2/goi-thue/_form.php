<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoiThue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goi-thue-form panel panel-info">

    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-edit"></i>
            <?= $model->isNewRecord ? ' Tạo Gói Thuê Mới' : ' Cập Nhật Gói Thuê' ?>
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

        <?= $form->field($model, 'ten')->textInput(['maxlength' => true, 'placeholder' => 'Nhập tên gói thuê']) ?>
        <?= $form->field($model, 'ky_hieu')->textInput(['maxlength' => true, 'placeholder' => 'Nhập ký hiệu']) ?>
        <?= $form->field($model, 'don_gia')->textInput(['type'=>'number','step'=>'1000','placeholder' => 'Nhập đơn giá']) ?>

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
