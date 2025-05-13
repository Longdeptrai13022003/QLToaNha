<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TrangThai */
?>

<div class="trang-thai-view panel panel-info">

    <div class="panel-heading">
        <h3 class="panel-title">Chi Tiết Trạng Thái: <?= $model->ten ?></h3>
    </div>

    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-striped detail-view'],
            'attributes' => [
                'id',
                'ten',
                [
                    'attribute' => 'loai_trang_thai',
                    'format' => 'html',
                    'value' => $model->getTypeLabelWithStyle(),
                ],
                [
                    'attribute' => 'ghi_chu',
                    'format' => 'html',
                    'value' => $model->ghi_chu ?: '<i>(Không có ghi chú)</i>',
                ],
            ],
        ]) ?>
    </div>

</div>
