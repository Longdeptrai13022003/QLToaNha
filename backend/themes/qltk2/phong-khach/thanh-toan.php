<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model \backend\models\PhongKhach */
/* @var $khach \common\models\User */
$tienPhong = $model->don_gia*$model->so_thang_hop_dong;
$phiDichVu = $model->thanh_tien + $model->so_tien_chiet_khau - $tienPhong;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype'=> 'multipart/form-data',
        'id'=>'form-thanh-toan'
    ]
]); ?>
<div>
    <?= Html::hiddenInput('con_lai',$tienPhong + $phiDichVu - $model->da_thanh_toan - $model->so_tien_chiet_khau,['id'=>'con_lai']) ?>
    <?= Html::hiddenInput('phong_khach_id',$model->id,['id'=>'phong_khach_id']) ?>
    <h4 class="text-primary">THÔNG TIN KHÁCH HÀNG</h4>
    <table class="table text-nowrap">
        <tr>
            <td><strong>Họ tên: </strong></td>
            <td><?= $khach->hoten?></td>
            <td><strong>Điện thoại: </strong></td>
            <td><?= $khach->dien_thoai?></td>
        </tr>
        <tr>
            <td><strong>CCCD: </strong></td>
            <td><?= $khach->so_cccd?></td>
        </tr>
    </table>
    <h4 class="text-primary">THÔNG TIN HỢP ĐỒNG</h4>
    <table class="table text-nowrap">
        <tr>
            <td><strong>Đơn giá phòng: </strong></td>
            <td><span class="pull-right"><?=number_format($model->don_gia, 0, ',', '.')?></span></td>
            <td><strong>Tổng tiền: </strong></td>
            <td><span class="pull-right"><?=number_format($model->thanh_tien, 0, ',', '.')?></span></td>
        </tr>
        <tr>
            <td><strong>Số tháng: </strong></td>
            <td><span class="pull-right"><?=$model->so_thang_hop_dong?></span></td>
            <td><strong>Chiết khấu: </strong></td>
            <td><span class="pull-right"><?=number_format($model->so_tien_chiet_khau, 0, ',', '.') ?></span></td>
        </tr>
        <tr>
            <td><strong>Tổng tiền phòng: </strong></td>
            <td><span class="pull-right"><?=number_format($tienPhong, 0, ',', '.')?></span></td>
            <td><strong>Đã thanh toán: </strong></td>
            <td><span class="pull-right"><?=number_format($model->da_thanh_toan, 0, ',', '.') ?></span></td>
        </tr>
        <tr>
            <td><strong>Tiền dịch vụ: </strong></td>
            <td><span class="pull-right"><?=number_format($phiDichVu, 0, ',', '.') ?></span></td>
            <td><strong>Còn lại: </strong></td>
            <td><span class="pull-right"><?=number_format($model->thanh_tien-$model->da_thanh_toan, 0, ',', '.') ?></span></td>
        </tr>
    </table>
</div>
<h4 class="text-primary">THÔNG TIN GIAO DỊCH</h4>
<table class="table text-nowrap">
    <tr>
        <td><strong>Số tiền giao dịch: </strong></td>
        <td><?=Html::input('text','so_tien',0,['class'=>'form-control text-right','id'=>'so_tien'])?></td>
    </tr>
    <tr>
        <td><strong>Ảnh chuyển khoản: </strong></td>
        <td>
            <?= Html::fileInput('anh_chuyen_khoan[]',null,['multiple'=>'multiple', 'class'=>'form-control', 'id'=>'anh-chuyen-khoan'])?>
        </td>
    </tr>
</table>
<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/hop-dong.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
