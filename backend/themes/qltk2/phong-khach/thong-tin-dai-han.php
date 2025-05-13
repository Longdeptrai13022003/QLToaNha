<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $oCungs \backend\models\NguoiOCung[] */
?>
<style>
    .section-header {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: #1e40af !important;
        padding: 6px 10px !important;
        margin-bottom: 10px !important;
        background: linear-gradient(90deg, #e0f2fe, #dbeafe) !important;
        border-radius: 6px !important;
        letter-spacing: 0.5px !important;
    }
    table td {
        vertical-align: middle !important;
        padding: 6px 10px !important;
        font-size: 1.1rem !important;
    }
    .table {
        background: #ffffff !important;
        border-radius: 6px !important;
        margin-bottom: 0 !important;
        border: 1px solid #e2e8f0 !important;
    }
</style>
<div class="row">
    <div class="col-md-7">
        <h4 class="section-header">Thông tin người ở cùng</h4>
        <table class="table text-nowrap table-striped">
            <thead>
            <tr>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Thêm</th>
                <th>Xóa</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($oCungs)>0):?>
            <?php foreach ($oCungs as $oCung):?>
            <tr>
                <?= Html::hiddenInput('oCungID[]',$oCung->id) ?>
                <td><?= Html::textInput('ho_ten[]',$oCung->ho_ten,['class'=>'form-control'])?></td>
                <td><?= Html::textInput('dien_thoai[]',$oCung->dien_thoai,['class'=>'form-control'])?></td>
                <td><center><?= Html::a('<i class="fa fa-plus"></i>','#',['class' => 'text-primary btn-them-o-cung'])?></center></td>
                <td><center><?= Html::a('<i class="fa fa-trash"></i>','#',['class' => 'text-danger btn-xoa-o-cung'])?></center></td>
            </tr>
            <?php endforeach; ?>
            <?php else:?>
            <tr>
                <td><?= Html::textInput('ho_ten[]',null,['class'=>'form-control'])?></td>
                <td><?= Html::textInput('dien_thoai[]',null,['class'=>'form-control'])?></td>
                <td><center><?= Html::a('<i class="fa fa-plus"></i>','#',['class' => 'text-primary btn-them-o-cung'])?></center></td>
                <td><center><?= Html::a('<i class="fa fa-trash"></i>','#',['class' => 'text-danger btn-xoa-o-cung'])?></center></td>
            </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
    <div class="col-md-5">
        <h4 class="section-header">Chi phí dịch vụ <span id="ten_phong"></span></h4>
        <table class="table text-nowrap table-striped">
            <thead>
            <tr>
                <th>Dịch vụ</th>
                <th>Giá</th>
            </tr>
            </thead>
            <tbody id="bang_gia">
            </tbody>
        </table>
    </div>
</div>