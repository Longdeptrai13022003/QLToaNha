<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ChucNang */
?>
<div class="chuc-nang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'nhom',
            'controller_action',
        ],
    ]) ?>

</div>
