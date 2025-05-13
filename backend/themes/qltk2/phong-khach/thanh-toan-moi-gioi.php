<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model \backend\models\PhongKhach */
/* @var $sale \common\models\User */

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype'=> 'multipart/form-data',
        'id'=>'form-thanh-toan-moi-gioi'
    ]
]); ?>
<div>
    <?= Html::hiddenInput('phong_khach_id',$model->id,['id'=>'phong_khach_id']) ?>
    <?= Html::hiddenInput('con_lai',$model->so_tien_moi_gioi-$model->da_thanh_toan_moi_gioi,['id'=>'con_lai']) ?>
    <h4 class="text-primary">THÔNG TIN SALE</h4>
    <table class="table text-nowrap">
        <tr>
            <td><strong>Họ tên: </strong></td>
            <td><?= $sale->hoten?></td>
            <td><strong>Điện thoại: </strong></td>
            <td><?= $sale->dien_thoai?></td>
        </tr>
        <tr>
            <td><strong>Email: </strong></td>
            <td><?= $sale->email?></td>
        </tr>
    </table>
    <h4 class="text-primary">THÔNG TIN MÔI GIỚI</h4>
    <table class="table text-nowrap">
        <tr>
            <td><strong>Giá hợp đồng: </strong></td>
            <td><span class="pull-right"><?=number_format($model->thanh_tien, 0, ',', '.')?></span></td>
            <td><strong>Môi giới: </strong></td>
            <td><span class="pull-right"><?=number_format($model->moi_gioi, 0, ',', '.')?>
                    <?=$model->kieu_moi_gioi == '%' ? ' (%)' : ''?></span></td>
        </tr>
        <tr>
            <td><strong>Tổng phí môi giới: </strong></td>
            <td><span class="pull-right"><?=number_format($model->so_tien_moi_gioi, 0, ',', '.')?></span></td>
            <td><strong>Đã thanh toán: </strong></td>
            <td><span class="pull-right"><?=number_format($model->da_thanh_toan_moi_gioi, 0, ',', '.') ?></span></td>
        </tr>
        <tr>
            <td><strong>Còn lại: </strong></td>
            <td><span class="pull-right"><?=number_format($model->so_tien_moi_gioi-$model->da_thanh_toan_moi_gioi, 0, ',', '.')?></span></td>
        </tr>
    </table>
</div>
<h4 class="text-primary">THANH TOÁN MÔI GIỚI</h4>
<table class="table text-nowrap">
    <tr>
        <td><strong>Số tiền giao dịch: </strong></td>
        <td><?=Html::input('text','so_tien',0,['class'=>'form-control','id'=>'so_tien'])?></td>
    </tr>
</table>
<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/hop-dong.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
