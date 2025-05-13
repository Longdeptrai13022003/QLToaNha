<?php
/**
 * @var $yeuCauGiaoHang \backend\models\PhieuYeuCauGiao
 */
?>
<?php \yii\widgets\ActiveForm::begin(['id' => 'form-luu-sdt-nha-xe'])?>
    <?=\yii\bootstrap\Html::hiddenInput('idPhieu', $yeuCauGiaoHang->id); ?>
    <?=\yii\bootstrap\Html::label('SĐT nhà xe', 'sdt-nha-xe') ?>
    <?= \yii\bootstrap\Html::textInput('soDienThoaiNhaXe', $yeuCauGiaoHang->field_so_dien_thoai_nha_xe, ['class' => 'form-control', 'id' => 'sdt-nha-xe', 'type' => 'number']) ?>
    <?=\yii\bootstrap\Html::label('Phí ship ra nhà xe', 'phi-ship-ra-nha-xe') ?>
    <?=\yii\bootstrap\Html::textInput('phiGiaoHangDenNhaXe', $yeuCauGiaoHang->field_phi_giao_hang_den_nha_xe, ['class' => 'form-control','id' => 'phi-ship-ra-nha-xe' , 'type' => 'number']) ?>
    <?=\yii\bootstrap\Html::label('Phí ship đóng gói', 'phi-dong-goi') ?>
    <?=\yii\bootstrap\Html::textInput('phiDongGoi', $yeuCauGiaoHang->phi_dong_goi, ['class' => 'form-control','id' => 'phi-dong-goi' , 'type' => 'number']) ?>

<?php \yii\widgets\ActiveForm::end(); ?>
