<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DichVu */
?>

<div class="dich-vu-view panel panel-info">

    <div class="panel-heading">
        <h3 class="panel-title">Chi Tiết Dịch Vụ: <?= $model->ten ?></h3>
    </div>

    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-striped detail-view'],
            'attributes' => [
                'id',
                'ten',
                'don_vi_tinh',
                [
                    'attribute' => 'don_gia',
                    'value' => function($model) {
                        return number_format($model->don_gia, 0, ',', '.') . ' đ';
                    },
                    'format' => 'raw',
                ],

                [
                    'attribute' => 'ghi_chu',
                    'format' => 'ntext',
                    'value' => $model->ghi_chu ?: '<i>(Không có ghi chú)</i>',
                    'format' => 'html',
                ],
            ],
        ]) ?>
    </div>

</div>
