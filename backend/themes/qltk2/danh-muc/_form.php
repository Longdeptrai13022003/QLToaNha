<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DanhMuc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="danh-muc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'viet_tat')->textInput(['maxlength' => true])->label('Viết tắt') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
