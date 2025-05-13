<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DanhMuc */
/* @var $donGia [] */
?>
<div class="danh-muc-update">

    <?= $this->render('_form', [
        'model' => $model,
        'donGia'=>$donGia,
    ]) ?>

</div>
