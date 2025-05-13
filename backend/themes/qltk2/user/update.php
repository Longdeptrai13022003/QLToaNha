<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'vaitros' => $vaitros,
        'vaitrouser' => $vaitrouser,
    ]) ?>

</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/user.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
