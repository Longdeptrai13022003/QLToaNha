<?php
/**
 * Created by PhpStorm.
 * User: hungluong
 * Date: 6/27/18
 * Time: 17:23
 * @var $this \yii\web\View
 */
$this->title = 'Phân quyền'
?>
<?php $form = \yii\bootstrap\ActiveForm::begin([
        'options' => [
                'id' => 'form-phanquyen'
        ]
]) ?>
<div class="row">
    <div class="col-md-6">
        <label>Nhóm chức năng</label>
        <?=\yii\bootstrap\Html::dropDownList('nhom_chuc_nang', null, \yii\helpers\ArrayHelper::map(
            \backend\models\ChucNang::find()->groupBy('nhom')->all(), 'nhom', 'nhom'
        ), ['class' => 'form-control', 'prompt' => '', 'id' => 'nhom-chuc-nang'])?>
    </div>

</div>

<div id="table-phan-quyen">

</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-select/bootstrap-select.min.css');?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/select2/select2.css');?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-select/bootstrap-select.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/select2/select2.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/index-phanquyen.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>

