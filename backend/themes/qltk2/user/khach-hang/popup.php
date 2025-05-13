<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $error [] */
/* @var $anhs [] */
/* @var $form yii\widgets\ActiveForm */
use common\models\User;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id'=>'form-khach-hang',
            'autocomplete' => 'off',
            'enctype'=> 'multipart/form-data',
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <label>Họ tên <span class="text-danger">*</span></label>
            <?= Html::textInput('hoten','',['class'=>'form-control','maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <label>Điện thoại <span class="text-danger">*</span></label>
            <?= Html::textInput('dienthoai','',['class'=>'form-control','maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <label>Email <span class="text-danger">*</span></label>
            <?= Html::textInput('email','',['class'=>'form-control','maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <label>Tên đăng nhập <span class="text-danger">*</span></label>
            <?= Html::textInput('tendangnhap','',['class'=>'form-control','maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <label>Mật khẩu <span class="text-danger">*</span></label>
            <?= Html::textInput('matkhau','',['class'=>'form-control','maxlength' => true,'type' => 'password', 'autocomplete' => 'new-password']) ?>
        </div>
    </div>

    <div id="anh-dai-dien">
        <div class="row">
            <div class="col-md-4">
                <label>Ảnh đại diện</label>
                <?= Html::fileInput('anhdaidien',null,['class'=>'form-control'])?>

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
                <?= Html::fileInput('anhcancuoc1',null,['class'=>'form-control','name'=>'anhcancuoc1']) ?>
            </div>
            <div class="col-md-4">
                <label>Ảnh cccd mặt sau</label>
                <?= Html::fileInput('anhcancuoc2',null,['class'=>'form-control','name'=>'anhcancuoc2']) ?>
            </div>
            <div class="col-md-4"></div>
            <?php if (!$model->isNewRecord):?>
                <?php $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content; ?>
                <div class="row">
                    <?php if($model->anhcancuoc == '' || $model->anhcancuoc == 'no-image.jpg'):?>
                        <div class="col-md-4">
                            &nbsp;&nbsp;&nbsp;
                            <?= Html::img($domain.'/anh-can-cuoc/no-image.jpg',[
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
                                    <div>
                                        <?= Html::img($domain.'/anh-can-cuoc/'.$anh,[
                                            'width' => '300px',
                                            'class' => 'img-thumbnail img-responsive',
                                            'id' => 'hinh-anh',
                                        ])?>
                                    </div>
                                    <div class = "margin-top-5">
                                        <?=Html::a('<i class="fa fa-trash"></i> Xóa','#', [
                                            'class' => 'text-danger margin-top-5',
                                            'id' => 'btn-xoa-anh-dai-dien',
                                            'data-value' => $model->id,
                                            'loai-anh' => 'anhcancuoc'.$index
                                        ]) ?>
                                    </div>
                                <?php else: ?>
                                    <?= Html::img($domain.'/anh-can-cuoc/no-image.jpg',[
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
