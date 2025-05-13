<?php
/**
 * @var $yeuCauGiaoHang \backend\models\PhieuYeuCauGiao
 */
?>
<?php \yii\widgets\ActiveForm::begin(['id' => 'form-luu-ma-van-don'])?>
    <?=\yii\bootstrap\Html::hiddenInput('idPhieu', $yeuCauGiaoHang->id); ?>
    <?=\yii\bootstrap\Html::label('Mã vận đơn', 'ma-van-don') ?>
    <?=\yii\bootstrap\Html::textInput('maVanDon', $yeuCauGiaoHang->field_ma_van_don, ['class' => 'form-control', 'id' => 'ma-van-don']) ?>

<?php \yii\widgets\ActiveForm::end(); ?>
