<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GiaoDich */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="giao-dich-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'khach_hang_id')->textInput() ?>

    <?= $form->field($model, 'trang_thai_giao_dich')->dropDownList([ 'Khởi tạo' => 'Khởi tạo', 'Chờ xác minh' => 'Chờ xác minh', 'Thành công' => 'Thành công', 'Không thành công' => 'Không thành công', 'Chờ duyệt huỷ' => 'Chờ duyệt huỷ', 'Đã huỷ' => 'Đã huỷ', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'loai_giao_dich')->dropDownList([ 'Nạp tiền' => 'Nạp tiền', 'Thanh toán đơn hàng' => 'Thanh toán đơn hàng', 'Hoàn tiền đơn hàng' => 'Hoàn tiền đơn hàng', 'Rút tiền' => 'Rút tiền', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'tong_tien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'so_tien_giao_dich')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'giao_dich_old_id')->textInput() ?>

    <?= $form->field($model, 'phong_khach_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
