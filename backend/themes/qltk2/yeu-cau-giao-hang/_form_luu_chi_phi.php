<?php
/**
 * @var $yeuCauGiaoHang \backend\models\PhieuYeuCauGiao
 */
?>
<?php \yii\widgets\ActiveForm::begin(['id' => 'form-luu-chi-phi-khac'])?>
    <?=\yii\bootstrap\Html::hiddenInput('idPhieu', $yeuCauGiaoHang->id); ?>
    <?=\yii\bootstrap\Html::label('Phí ship đóng gói', 'phi-dong-goi') ?>
    <?=\yii\bootstrap\Html::textInput('phiDongGoi', $yeuCauGiaoHang->phi_dong_goi, ['class' => 'phiDongGoi form-control','id' => 'phi-dong-goi' , 'type' => 'number']) ?>

<?php \yii\widgets\ActiveForm::end(); ?>
