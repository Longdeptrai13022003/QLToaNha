<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cauhinh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cauhinh-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'name')->label('Tên');?>

    <?php if($model->ckeditor == 1): ?>
        <?= $form->field($model, 'content')->widget(\dosamigos\ckeditor\CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'full'
        ]) ?>
    <?php else: ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?php endif ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
