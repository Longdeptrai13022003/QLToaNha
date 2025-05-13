<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $anhs [] */
/* @var $form yii\widgets\ActiveForm */
/* @var $ds_nhom_ky_nang \backend\models\DanhMuc[] */
use common\models\User;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data',
            'id'=>'form-them-khach-hang'
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'hoten')->label('Họ tên <span class="text-danger">*</span>')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'dien_thoai')->label('Điện thoại <span class="text-danger">*</span>')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->label('Email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'username')->label('Tên đăng nhập <span class="text-danger">*</span>')->textInput(['maxlength' => true, 'autocomplete' => 'false']) ?>
        </div>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'password_hash')->label('Mật khẩu <span class="text-danger">*</span>')->textInput(['maxlength' => true, 'type' => 'password', 'autocomplete' => 'new-password']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'so_cccd')->label('CCCD')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div id="anh-dai-dien">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'anhdaidien')->label('Ảnh đại diện')->fileInput(['class'=>'form-control']) ?>

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
    <div id="anh-can-cuoc" class="margin-top-10">
        <div class="row">
            <div class="col-md-4">
                <label>Ảnh cccd mặt trước</label>
                <?= Html::fileInput('anhcancuoc1',null,['class'=>'form-control']) ?>
            </div>
            <div class="col-md-4">
                <label>Ảnh cccd mặt sau</label>
                <?= Html::fileInput('anhcancuoc2',null,['class'=>'form-control']) ?>
            </div>
            <div class="col-md-4"></div>
            <?php if (!$model->isNewRecord):?>
                <?php $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content; ?>
                <div class="row">
                    <?php if($model->anhcancuoc == '' || $model->anhcancuoc == 'no-image.jpg'):?>
                        <div class="col-md-4">
                            &nbsp;&nbsp;&nbsp;
                            <?= Html::img($domain.'/hinh-anh/no-image.jpg',[
                                'width' => '300px',
                                'class' => 'img-thumbnail',
                                'id' => 'hinh-anh'
                            ])?>
                        </div>
                    <?php else: ?>
                        <?php $anhs =explode(',',$model->anhcancuoc)?>
                        <?php foreach ($anhs as $index => $anh):?>
                            <div class="col-md-4">
                                &nbsp;&nbsp;&nbsp;
                                <?php if($anh != 'no-image.jpg' && $anh != ''):?>
                                    <?= Html::img($domain.'/hinh-anh/'.$anh,[
                                        'width' => '300px',
                                        'class' => 'img-thumbnail img-responsive',
                                        'id' => 'hinh-anh',
                                    ])?>
                                    <?=Html::a('<i class="fa fa-trash"></i> Xóa','#', [
                                        'class' => 'text-danger margin-top-5',
                                        'id' => 'btn-xoa-anh-dai-dien',
                                        'data-value' => $model->id,
                                        'loai-anh' => 'anhcancuoc'.$index
                                    ]) ?>
                                <?php else: ?>
                                    <?= Html::img($domain.'/hinh-anh/no-image.jpg',[
                                        'width' => '3000px',
                                        'class' => 'img-thumbnail img-responsive',
                                        'id' => 'hinh-anh'
                                    ])?>
                                <?php endif;?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif;?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <?=Html::hiddenInput('Vaitrouser[]',7)?>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
