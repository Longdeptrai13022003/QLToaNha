<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $error [] */
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'error' => $error
    ]) ?>

</div>
