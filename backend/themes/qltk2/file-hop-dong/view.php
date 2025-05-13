<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FileHopDong */
?>
<div class="file-hop-dong-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'phong_khach_id',
            'file',
            'created',
            'user_id',
        ],
    ]) ?>

</div>
