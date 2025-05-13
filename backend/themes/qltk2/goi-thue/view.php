<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\GoiThue */
?>

<div class="goi-thue-view panel panel-info">

    <div class="panel-heading">
        <h3 class="panel-title">Chi Tiết Gói Thuê: <?= $model->ten ?></h3>
    </div>

    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-striped detail-view'],
            'attributes' => [
                'id',
                'ten',
                'ky_hieu',
                [
                    'attribute' => 'don_gia',
                    'value' => function($model) {
                        return number_format($model->don_gia, 0, ',', '.') . ' đ';
                    },
                    'format' => 'raw',
                ],

            ],
        ]) ?>
    </div>

</div>
