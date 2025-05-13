<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\GiaNuoc */
?>
<div class="gia-nuoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'luong_nuoc',
            'don_gia',
            'thue',
        ],
    ]) ?>

</div>
