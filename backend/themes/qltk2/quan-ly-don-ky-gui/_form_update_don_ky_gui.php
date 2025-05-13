<?php
/**
 * @var $donKyGui \backend\models\QuanLyDonKyGui
 */
?>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'form-update-don-ky-gui',
    'options' => ['class' => 'form-horizontal form-size-L']
]) ?>
<?= \yii\bootstrap\Html::hiddenInput('idKyGui', $donKyGui->id); ?>
<?php if (\common\models\myAPI::isAccess2('Cauhinh', 'Index')):?>
<div class="form-group">
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Mã KH', 'maKhachHang', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('maKH', $donKyGui->user_id, ['class' => 'form-control', 'id' => 'maKhachHang', 'placeholder' => 'Nhập mã khách hàng']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Mã vận đơn', 'maVanDon', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('maVanDon', $donKyGui->field_ma_van_don_ky_gui, ['class' => 'form-control', 'id' => 'maVanDon', 'placeholder' => 'Nhập tên khách hàng']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Line VC', 'lineVC', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::dropDownList('lineVC', $donKyGui->line, \backend\models\KyGui::$listLineVC, ['class' => 'form-control', 'prompt' => '', 'id' => 'lineVC']) ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Khối lượng', 'khoiLuong', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('khoiLuong', $donKyGui->field_khoi_luong, ['class' => 'form-control', 'id' => 'khoiLuong', 'type' => 'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Đơn vị tính khối lượng', 'dvtKhoiLuong', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::dropDownList('dvtKhoiLuong', $donKyGui->field_dvt_khoi_luong, \backend\models\KyGui::$listDvtKhoiLuong, ['class' => 'form-control', 'prompt' => '', 'id' => 'dvtKhoiLuong']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Kích thước', 'kichThuoc', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('kichThuoc', $donKyGui->kich_thuoc, ['class' => 'form-control', 'id' => 'kichThuoc', 'placeholder' => 'Kích thước (VD: 1d x 3r x 3)']) ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Phí VC nội địa(NDT)', 'phiVCNoiDia', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('phiVCNoiDia', $donKyGui->phi_van_chuyen_noi_dia, ['class' => 'form-control', 'id' => 'phiVCNoiDia', 'type' => 'number']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Trạng thái', 'trangThai', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::dropDownList('trangThai', $donKyGui->field_trang_thai, \backend\models\KyGui::$listTrangThaiDonKyGui, ['class' => 'form-control', 'prompt' => '', 'id' => 'trangThai']) ?>
    </div>
</div>

<div class="form-group">

    <div class="col-sm-12">
        <?= \yii\bootstrap\Html::label('Ghi chú', 'ghiChu', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textarea('ghiChu', $donKyGui->field_ghi_chu, ['class' => 'form-control', 'id' => 'ghiChu', 'placeholder' => 'Ghi chú']) ?>
    </div>
</div>

<?php else:?>
<div class="form-group">
    <div class="col-sm-12">
        <?= \yii\bootstrap\Html::label('Mã vận đơn', 'maVanDon', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('maVanDon', $donKyGui->field_ma_van_don_ky_gui, ['class' => 'form-control', 'id' => 'maVanDon', 'placeholder' => 'Nhập tên khách hàng']) ?>
    </div>
</div>
<?php endif;?>

<?php \yii\widgets\ActiveForm::end(); ?>
