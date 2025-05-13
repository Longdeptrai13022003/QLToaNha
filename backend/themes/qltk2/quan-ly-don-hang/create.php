<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DonHang */
/** @var $khach_hang [] */

?>
<div class="san-pham-create">
    <?= $this->render('_form', [
        'model' => $model,
        'khach_hang' => $khach_hang
    ]) ?>
</div>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/rong-vang/don-hang/form-san-pham.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
