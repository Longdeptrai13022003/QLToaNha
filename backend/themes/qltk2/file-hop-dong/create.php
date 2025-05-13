<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FileHopDong */
$this->title = 'Thêm hợp đồng'
?>

<div class="file-hop-dong-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/user.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
