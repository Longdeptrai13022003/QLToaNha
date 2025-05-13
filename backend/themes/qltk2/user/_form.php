<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $ds_nhom_ky_nang \backend\models\DanhMuc[] */
use common\models\User;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data',
            'id' => 'form-them-user'
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'hoten')->label('Họ tên <span class="text-danger">*</span>')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dien_thoai')->label('Điện thoại <span class="text-danger">*</span>')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->label('Email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'username')->label('Tên đăng nhập <span class="text-danger">*</span>')->textInput(['maxlength' => true, 'autocomplete' => 'false', 'readonly'=>$model->isNewRecord ? false : true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password')->label('Mật khẩu <span class="text-danger">*</span>')->textInput(['maxlength' => true, 'type' => 'password', 'autocomplete' => 'new-password']) ?>
        </div>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'password_hash')->label('Mật khẩu <span class="text-danger">*</span>')->textInput(['maxlength' => true, 'type' => 'password', 'autocomplete' => 'new-password']) ?>
        </div>
    </div>

    <div id="anh-dai-dien">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'anhdaidien')->label('Ảnh đại diện')->fileInput() ?>

                <?php if (!$model->isNewRecord):?>
                    <?php $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content; ?>
                    <div>
                        <?= Html::img($model->anhdaidien == '' ? $domain.'/hinh-anh/no-image.jpg' : $domain.'/hinh-anh/'.$model->anhdaidien,[
                            'width' => '150px',
                            'class' => 'img-thumbnail',
                            'id' => 'hinh-anh'
                        ])?>

                        <?php if($model->anhdaidien != 'no-image.jpg' && $model->anhdaidien != ''): ?>
                            <?=Html::a('<i class="fa fa-trash"></i> Xóa','#', [
                                'class' => 'text-danger',
                                'id' => 'btn-xoa-anh-dai-dien',
                                'data-value' => $model->id,
                                'loai-anh' => 'anhdaidien'
                            ]) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?=Html::label('Vai trò');?>
        <?=Html::checkboxList('Vaitrouser[]', $vaitros, \yii\helpers\ArrayHelper::map(
            \backend\models\VaiTro::find()->all(), 'id', 'name'
        ), ['prompt' => '', 'class' => 'list-block'])?>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
