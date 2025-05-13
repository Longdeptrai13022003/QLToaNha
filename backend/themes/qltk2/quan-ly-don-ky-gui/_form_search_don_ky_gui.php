<?php
/**
 * @var $donKyGui \backend\models\QuanLyDonKyGui
 */
?>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'form-search-don-ky-gui',
    'options' => ['class' => 'form-horizontal form-size-L']
])?>

<?php if (\common\models\User::isViewAll()) :?>
    <h4 class="margin-top-10">THÔNG TIN KHÁCH HÀNG</h4>
    <div class="form-group">
        <div class="col-sm-4">
            <?= \yii\bootstrap\Html::label('Mã KH', 'maKH', ['class' => 'control-label']) ?>
            <?= \yii\bootstrap\Html::textInput('maKH', '', ['class' => 'form-control', 'id' => 'maKH', 'placeholder' => 'Mã KH']) ?>
        </div>
        <div class="col-sm-4">
            <?= \yii\bootstrap\Html::label('Tên KH', 'tenKH', ['class' => 'control-label']) ?>
            <?= \yii\bootstrap\Html::textInput('tenKH', '', ['class' => 'form-control', 'id' => 'tenKH', 'placeholder' => 'Tên KH']) ?>
        </div>
        <div class="col-sm-4">
            <?= \yii\bootstrap\Html::label('Điện thoại KH', 'dienThoaiKH', ['class' => 'control-label']) ?>
            <?= \yii\bootstrap\Html::textInput('dienThoaiKH', '', ['class' => 'form-control', 'id' => 'dienThoaiKH', 'placeholder' => 'SĐT KH']) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            <?= \yii\bootstrap\Html::label('Ngày đặt từ', 'ngayDatTu', ['class' => 'control-label']) ?>
            <?= \common\models\myAPI::dateField2('ngayDatTu', null, '2015:' . date("Y"), ['class' => 'form-control', 'id' => 'ngayDatTu', 'placeholder' => 'Ngày tạo từ']) ?>
        </div>
        <div class="col-sm-4">
            <?= \yii\bootstrap\Html::label('Ngày đặt đến', 'ngayDatDen', ['class' => 'control-label']) ?>
            <?= \common\models\myAPI::dateField2('ngayDatDen', '', '2015:' . date("Y"), ['class' => 'form-control', 'id' => 'ngayDatDen', 'placeholder' => 'Ngày đặt đến']) ?>
        </div>
    </div>
<?php endif; ?>



<h4 class="margin-top-25">THÔNG TIN ĐƠN KÝ GỬI</h4>
<div class="form-group">
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Mã đơn KG', 'maKG', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('maKG', '', ['class' => 'form-control', 'id' => 'maKG', 'placeholder' => 'Mã đơn KG']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Mã vận đơn', 'maVanDon', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('maVanDon', '', ['class' => 'form-control', 'id' => 'maVanDon', 'placeholder' => 'Mã vận đơn']) ?>
    </div>
    <div class="col-sm-4">
        <?= \yii\bootstrap\Html::label('Trạng thái', 'trangThai', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::dropDownList('trangThai', null, \backend\models\KyGui::$listTrangThaiDonKyGui, ['class' => 'form-control', 'prompt' => '', 'id' => 'trangThai']) ?>
    </div>
</div>

<h4 class="margin-top-25">THÔNG TIN THANH TOÁN</h4>
<div class="form-group">
    <div class="col-sm-12">
        <?= \yii\bootstrap\Html::label('Số tiền đã thanh toán', 'daThanhToan', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('daThanhToan', '', ['class' => 'form-control', 'id' => 'daThanhToan', 'placeholder' => 'Đã thanh toán']) ?>
    </div>
</div>

<h4 class="margin-top-25">THÔNG TIN VẬN CHUYỂN</h4>
<div class="form-group">
    <div class="col-sm-6">
        <?= \yii\bootstrap\Html::label('Tên người nhận', 'tenNguoiNhan', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('tenNguoiNhan', '', ['class' => 'form-control', 'id' => 'tenNguoiNhan', 'placeholder' => 'Tên người nhận']) ?>
    </div>
    <div class="col-sm-6">
        <?= \yii\bootstrap\Html::label('Điện thoại người nhận', 'dienThoaiNguoiNhan', ['class' => 'control-label']) ?>
        <?= \yii\bootstrap\Html::textInput('dienThoaiNguoiNhan', '', ['class' => 'form-control', 'id' => 'dienThoaiNguoiNhan', 'placeholder' => 'SĐT người nhận']) ?>
    </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>
