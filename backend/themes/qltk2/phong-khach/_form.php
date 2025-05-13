<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\PhongKhach */
/* @var $khach \common\models\User */
/* @var $sale \common\models\User */
/* @var $packages [] */
/* @var $gios [] */
/* @var $phuts [] */
/* @var $fileHDs \backend\models\FileHopDong[] */
/* @var $phong \backend\models\DanhMuc */
/* @var $form yii\widgets\ActiveForm */
/* @var $toanhaids ArrayHelper */
/* @var $domain string */
/* @var $phongids ArrayHelper */
/* @var $giaoDichs backend\models\GiaoDich */

$domain = Url::base(true);
$anhHopDongs = [];
if (!$model->isNewRecord && !is_null($model->anh_hop_dong)) {
    $anhHopDongs = json_decode($model->anh_hop_dong, true);
}

// Register custom CSS
$this->registerCss("
    .phong-khach-form {
        background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%) !important;
        padding: 10px !important;
        margin: 0 !important;
        min-height: 100vh !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    
    .phong-khach-form .form-section {
        background: #ffffff !important;
        padding: 12px !important;
        border-radius: 8px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }
    .phong-khach-form .form-section:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 16px rgba(0,0,0,0.12) !important;
    }
    .phong-khach-form .section-header {
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        color: #1e40af !important;
        padding: 6px 10px !important;
        margin-bottom: 10px !important;
        background: linear-gradient(90deg, #e0f2fe, #dbeafe) !important;
        border-radius: 6px !important;
        letter-spacing: 0.5px !important;
    }
    .phong-khach-form .form-group {
        margin-bottom: 10px !important;
    }
    .phong-khach-form .form-group label {
        font-weight: 600 !important;
        color: #1a202c !important;
        font-size: 1.1rem !important;
        margin-bottom: 4px !important;
        letter-spacing: 0.2px !important;
    }
    .phong-khach-form .form-group label i {
        margin-right: 6px !important;
        color: #3b82f6 !important;
    }
    .phong-khach-form .form-control {
        border-radius: 6px !important;
        font-size: 1.3rem !important;
        transition: border-color 0.3s, box-shadow 0.3s, background-color 0.2s !important;
        background: #f8fafc !important;
        height: 34px !important;
        line-height: 1 !important;
        vertical-align: middle !important;
        box-sizing: border-box !important;
    }
    .phong-khach-form .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 6px rgba(59,130,246,0.5) !important;
        background: #ffffff !important;
        outline: none !important;
    }
    .phong-khach-form .btn {
        font-size: 1.2rem !important;
        padding: 8px 14px !important;
        border-radius: 6px !important;
        transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s !important;
        font-weight: 500 !important;
    }
    .phong-khach-form .btn-primary {
        background: linear-gradient(45deg, #3b82f6, #60a5fa) !important;
        border: none !important;
    }
    .phong-khach-form .btn-primary:hover {
        background: linear-gradient(45deg, #2563eb, #3b82f6) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(59,130,246,0.3) !important;
    }
    .phong-khach-form .btn-success {
        background: linear-gradient(45deg, #22c55e, #4ade80) !important;
        border: none !important;
    }
    .phong-khach-form .btn-success:hover {
        background: linear-gradient(45deg, #16a34a, #22c55e) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(34,197,94,0.3) !important;
    }
    .phong-khach-form .btn-danger {
        background: linear-gradient(45deg, #ef4444, #f87171) !important;
        border: none !important;
        font-size: 1rem !important;
    }
    .phong-khach-form .btn-danger:hover {
        background: linear-gradient(45deg, #dc2626, #ef4444) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(239,68,68,0.3) !important;
    }
    .phong-khach-form .img-thumbnail {
        width: 100% !important;
        max-height: 150px !important;
        border-radius: 6px !important;
        margin: 4px !important;
        object-fit: cover !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }
    .phong-khach-form .img-thumbnail:hover {
        transform: scale(1.08) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }
    .phong-khach-form .thumbnail {
        border: none !important;
        padding: 0 !important;
        background: transparent !important;
    }
    .phong-khach-form table td {
        vertical-align: middle !important;
        padding: 6px 10px !important;
        font-size: 1.1rem !important;
    }
    .phong-khach-form .table {
        background: #ffffff !important;
        border-radius: 6px !important;
        margin-bottom: 0 !important;
        border: 1px solid #e2e8f0 !important;
    }
    .phong-khach-form .table tr td:first-child {
        font-weight: bold !important;
    }
    .phong-khach-form .table tr td.text-right {
        font-size: 1.4rem !important;
    }
    .phong-khach-form .text-danger {
        color: red !important;
    }
    .phong-khach-form .row {
        margin: 0 -8px !important;
        row-gap: 10px !important;
    }
    .phong-khach-form .col-md-8, .phong-khach-form .col-md-4, .phong-khach-form .col-md-3, .phong-khach-form .col-md-6 {
        padding: 0 8px !important;
    }
    .phong-khach-form .flex-group {
        display: flex !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
    }
    .phong-khach-form .date-time-container {
        display: flex !important;
        gap: 8px !important;
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        padding: 8px !important;
        flex-wrap: wrap !important;
    }
    .phong-khach-form .date-time-section {
        flex: 1 !important;
        min-width: 200px !important;
    }
    .phong-khach-form .date-time-section label {
        font-weight: 600 !important;
        color: #1a202c !important;
        margin-bottom: 4px !important;
    }
    .phong-khach-form .date-time-section input,
    .phong-khach-form .date-time-section select {
        width: 100% !important;
        height: 34px !important;
        margin: 0 !important;
        margin-bottom: 8px !important;
        padding: 6px 12px !important;
        box-sizing: border-box !important;
        border: 1px solid #d1d9e0 !important;
        border-radius: 6px !important;
    }
    .phong-khach-form .date-time-section select {
        padding: 6px 8px !important;
    }
    .phong-khach-form .date-time-section select option {
        font-size: 0.95rem !important;
    }
    .phong-khach-form .date-time-section input:focus,
    .phong-khach-form .date-time-section select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 6px rgba(59,130,246,0.5) !important;
        outline: none !important;
    }
    .phong-khach-form .time-group {
        display: flex !important;
        gap: 6px !important;
        margin-bottom: 8px !important;
    }
    .phong-khach-form .time-group div {
        flex: 1 !important;
    }
    .phong-khach-form .time-group label {
        font-size: 0.9rem !important;
        color: #4b5563 !important;
        margin-bottom: 4px !important;
    }
    .phong-khach-form .margin-top-25 {
        margin-top: 0 !important;
    }
    .phong-khach-form .padding-top-35 {
        padding-top: 0 !important;
        margin-top: 10px !important;
    }
    .phong-khach-form .file-upload-wrapper {
        position: relative !important;
        background: #f8fafc !important;
        border: 2px dashed #3b82f6 !important;
        border-radius: 8px !important;
        padding: 20px !important;
        text-align: center !important;
        transition: background 0.2s, border-color 0.2s !important;
        cursor: pointer !important;
    }
    .phong-khach-form .file-upload-wrapper:hover,
    .phong-khach-form .file-upload-wrapper.dragover {
        background: #e0f2fe !important;
        border-color: #2563eb !important;
    }
    .phong-khach-form .file-upload-wrapper input[type='file'] {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        opacity: 0 !important;
        cursor: pointer !important;
    }
    .phong-khach-form .file-upload-text {
        font-size: 1.1rem !important;
        color: #1a202c !important;
        margin: 8px 0 0 !important;
    }
    .phong-khach-form .file-upload-text span {
        color: #3b82f6 !important;
        font-weight: 600 !important;
    }
    .phong-khach-form .file-upload-icon {
        font-size: 1.5rem !important;
        color: #3b82f6 !important;
        margin-bottom: 8px !important;
    }
    .phong-khach-form .file-upload-count {
        font-size: 0.9rem !important;
        color: #2d3748 !important;
        margin-top: 8px !important;
        display: none;
    }
    .phong-khach-form .select2-container--default .select2-selection--single {
        height: 34px !important;
        border: 1px solid #d1d9e0 !important;
        border-radius: 6px !important;
        background: #f8fafc !important;
        font-size: 0.95rem !important;
        padding: 6px 12px !important;
        box-sizing: border-box !important;
    }
    .phong-khach-form .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 22px !important;
        color: #1a202c !important;
    }
    .phong-khach-form .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px !important;
        right: 6px !important;
    }
    .phong-khach-form .select2-container--default .select2-selection--single:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 6px rgba(59,130,246,0.5) !important;
        background: #ffffff !important;
    }
    .phong-khach-form .selected-card {
        display: flex !important;
        align-items: center !important;
        background: #ffffff !important;
        border-radius: 6px !important;
        padding: 8px !important;
        margin-top: 6px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3) !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
        font-size: 1.1rem !important;
        color: #1a202c !important;
    }
    .phong-khach-form .selected-card:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.12) !important;
    }
    .phong-khach-form .selected-card-icon {
        font-size: 1.2rem !important;
        color: #3b82f6 !important;
        margin-right: 8px !important;
    }
    .phong-khach-form .selected-card-content {
        flex: 1 !important;
    }
    .phong-khach-form .selected-card-close {
        font-size: 1.1rem !important;
        color: #ef4444 !important;
        text-decoration: none !important;
        margin-left: 8px !important;
    }
    .phong-khach-form .selected-card-close:hover {
        color: #dc2626 !important;
    }
    @media (max-width: 767px) {
        .phong-khach-form {
            padding: 8px !important;
        }
        .phong-khach-form .form-section {
            padding: 10px !important;
        }
        .phong-khach-form .btn {
            width: 100% !important;
            margin-bottom: 8px !important;
        }
        .phong-khach-form .date-time-container {
            flex-direction: column !important;
            gap: 10px !important;
        }
        .phong-khach-form .date-time-section {
            min-width: 100% !important;
        }
        .phong-khach-form .time-group {
            gap: 6px !important;
        }
        .phong-khach-form .date-time-section input,
        .phong-khach-form .date-time-section select {
            font-size: 0.95rem !important;
        }
        .phong-khach-form .date-time-section select option {
            font-size: 0.95rem !important;
        }
        .phong-khach-form .img-thumbnail {
            max-height: 80px !important;
        }
        .phong-khach-form .file-upload-wrapper {
            padding: 15px !important;
        }
        .phong-khach-form .selected-card {
            flex-wrap: wrap !important;
            padding: 6px !important;
        }
        .phong-khach-form .selected-card-content {
            flex: 1 1 100% !important;
        }
        .phong-khach-form .selected-card-close {
            margin-left: auto !important;
        }
    }
");

// Register dependencies
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css');

// Register JavaScript for file upload count, Select2, and môi giới visibility
$this->registerJs("
    $(document).ready(function() {
        // Initialize Select2
        $('#phongkhach-phong_id').select2({
            placeholder: '-- Chọn phòng --',
            allowClear: true,
            width: '100%'
        });

        // File upload count
        var fileInput = document.querySelector('input[name=\"file_hop_dong[]\"]');
        var countDisplay = document.querySelector('.file-upload-count');
        var fileWrapper = document.querySelector('.file-upload-wrapper');
        if (!fileInput || !countDisplay || !fileWrapper) {
            console.error('File upload elements not found:', {
                fileInput: !!fileInput,
                countDisplay: !!countDisplay,
                fileWrapper: !!fileWrapper
            });
            return;
        }
        function updateFileCount(files) {
            console.log('Files selected:', files.length);
            var count = files ? files.length : 0;
            if (count > 0) {
                countDisplay.textContent = count + ' file' + (count > 1 ? 's' : '') + ' đã chọn';
                countDisplay.style.setProperty('display', 'block', 'important');
            } else {
                countDisplay.textContent = '';
                countDisplay.style.setProperty('display', 'none', 'important');
            }
        }
        fileInput.addEventListener('change', function(e) {
            console.log('Change event triggered');
            updateFileCount(e.target.files);
        });
        fileWrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
            console.log('Dragover');
        });
        fileWrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            console.log('Dragleave');
        });
        fileWrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            console.log('Drop event');
            var files = e.dataTransfer.files;
            fileInput.files = files;
            updateFileCount(files);
            $(fileInput).trigger('change');
        });

        // Toggle môi giới section based on #sale-da-chon content
        function toggleMoiGioiSection() {
            var saleSelected = $('#sale-da-chon').text().trim().length > 0;
            $('#block-moi-gioi').css('display', saleSelected ? 'block' : 'none');
        }
        toggleMoiGioiSection(); // Initial check

        // Observe changes to #sale-da-chon
        var saleDaChon = document.querySelector('#sale-da-chon');
        var observer = new MutationObserver(toggleMoiGioiSection);
        observer.observe(saleDaChon, { childList: true, subtree: true, characterData: true });

        // Fallback click handlers for #btn-chon-sale and #xoa-sale-da-chon
        $('#btn-chon-sale').click(function() {
            setTimeout(toggleMoiGioiSection, 500); // Delay for AJAX/modal
        });
        $(document).on('click', '#xoa-sale-da-chon', function() {
            setTimeout(toggleMoiGioiSection, 500); // Delay for AJAX/modal
        });
    });
");
?>

<div class="phong-khach-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
            'enctype' => 'multipart/form-data',
            'id' => 'form-them-hop-dong'
        ]
    ]); ?>
    <?= Html::activeHiddenInput($model, 'khach_hang_id') ?>
    <?= Html::activeHiddenInput($model, 'sale_id', ['id' => 'phongkhach-sale_id']) ?>
    <?= $model->isNewRecord ? '' : Html::HiddenInput('hop_dong_id', $model->id, ['id' => 'hop_dong_id']) ?>

    <div class="row">
        <!-- Left Section: Form Inputs -->
        <div class="col-md-8">
            <div class="form-section">
                <div class="section-header">Thông tin hợp đồng</div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <?= $form->field($model, 'loai_hop_dong')->dropDownList($packages, ['prompt' => 'Tất cả'])->label('Chọn gói thuê <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?= $form->field($model, 'ma_hop_dong')->textInput(['value' => $model->ma_hop_dong, 'readonly' => 'readonly'])->label('Mã hợp đồng <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Khách hàng <span class="text-danger">*</span></label>
                            <div class="flex-group">
                                <?= Html::a('<i class="fa fa-check-circle"></i> Chọn KH', '#', [
                                    'class' => 'btn btn-primary btn-sm flex-fill',
                                    'id' => 'btn-chon-khach-hang',
                                    'title' => 'Chọn khách hàng'
                                ]) ?>
                                <?= Html::a('<i class="fa fa-plus"></i> Thêm KH', '#', [
                                    'class' => 'btn btn-primary btn-sm flex-fill',
                                    'id' => 'btn-them-khach-hang',
                                    'title' => 'Thêm khách hàng'
                                ]) ?>
                            </div>
                            <?php if (!$model->isNewRecord): ?>
                                <div class="selected-card">
                                    <i class="fas fa-user selected-card-icon"></i>
                                    <div class="selected-card-content">
                                        <strong>Khách:</strong> <?= htmlspecialchars($khach->hoten) ?> (<?= htmlspecialchars($khach->dien_thoai) ?>)
                                    </div>
                                    <a href="#" class="selected-card-close" id="xoa-khach-da-chon">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <span id="khach-hang-da-chon"></span>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Sale</label>
                            <div class="flex-group">
                                <?= Html::a('<i class="fa fa-check-circle"></i> Chọn Sale', '#', [
                                    'class' => 'btn btn-primary btn-sm flex-fill',
                                    'id' => 'btn-chon-sale',
                                    'title' => 'Chọn sale'
                                ]) ?>
                                <?= Html::a('<i class="fa fa-plus"></i> Thêm Sale', '#', [
                                    'class' => 'btn btn-primary btn-sm flex-fill',
                                    'id' => 'btn-them-sale',
                                    'title' => 'Thêm sale'
                                ]) ?>
                            </div>
                            <div id="sale-da-chon">
                                <?php if (!$model->isNewRecord && $model->sale_id != null): ?>
                                    <div class="selected-card">
                                        <i class="fas fa-user-tie selected-card-icon"></i>
                                        <div class="selected-card-content">
                                            <strong>Sale:</strong> <?= htmlspecialchars($sale->hoten) ?> (<?= htmlspecialchars($sale->dien_thoai) ?>)
                                        </div>
                                        <a href="#" class="selected-card-close" id="xoa-sale-da-chon">
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-header">Phòng ở & Thời gian</div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <?= Html::label('<i class="fas fa-building"></i> Tòa nhà <span class="text-danger">*</span>', 'toa-nha-selection') ?>
                            <?= Html::dropDownList('toa_nha_id', $model->isNewRecord ? null : $phong->parent_id, $toanhaids, [
                                'prompt' => '-- Chọn --',
                                'class' => 'form-control',
                                'id' => 'toa-nha-id',
                                'style' => 'height: 34px;'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <?= Html::label('<i class="fas fa-door-open"></i> Chọn phòng <span class="text-danger">*</span>', 'phongkhach-phong_id') ?>
                            <?= Html::activeDropDownList($model, 'phong_id', $model->isNewRecord ? [] : $phongids, [
                                'class' => 'form-control',
                                'id' => 'phongkhach-phong_id'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><i class="fas fa-clock"></i> Thời gian <span class="text-danger">*</span></label>
                            <div class="date-time-container">
                                <div class="date-time-section">
                                    <label>Từ ngày</label>
                                    <?= \common\models\myAPI::activeDateField2($form, $model, 'thoi_gian_hop_dong_tu', '', '2020:2050', [
                                        'class' => 'form-control tu_ngay',
                                        'value' => $model->thoi_gian_hop_dong_tu,
                                        'readonly' => true
                                    ]) ?>
                                    <div class="time-group">
                                        <div>
                                            <label>Giờ</label>
                                            <?= Html::dropDownList('gio_vao', $model->isNewRecord ? date('H') : DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_tu)->format('H'), $gios, [
                                                'class' => 'form-control',
                                                'id' => 'gio_vao'
                                            ]) ?>
                                        </div>
                                        <div>
                                            <label>Phút</label>
                                            <?= Html::dropDownList('phut_vao', $model->isNewRecord ? date('i') : DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_tu)->format('i'), $phuts, [
                                                'class' => 'form-control',
                                                'id' => 'phut_vao'
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="date-time-section">
                                    <label>Đến ngày</label>
                                    <?= \common\models\myAPI::activeDateField2($form, $model, 'thoi_gian_hop_dong_den', '', '2020:2050', [
                                        'class' => 'form-control den_ngay',
                                        'value' => $model->thoi_gian_hop_dong_den,
                                        'readonly' => true
                                    ]) ?>
                                    <div class="time-group">
                                        <div>
                                            <label>Giờ</label>
                                            <?= Html::dropDownList('gio_ra', $model->isNewRecord ? date('H') : DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_den)->format('H'), $gios, [
                                                'class' => 'form-control',
                                                'id' => 'gio_ra'
                                            ]) ?>
                                        </div>
                                        <div>
                                            <label>Phút</label>
                                            <?= Html::dropDownList('phut_ra', $model->isNewRecord ? date('i') : DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_den)->format('i'), $phuts, [
                                                'class' => 'form-control',
                                                'id' => 'phut_ra'
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-header">Tài liệu & Ghi chú</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?= Html::label('File(s) hợp đồng') ?>
                            <div class="file-upload-wrapper">
                                <i class="fas fa-upload file-upload-icon"></i>
                                <?= Html::fileInput('file_hop_dong[]', null, ['multiple' => 'multiple', 'class' => 'custom-file-input']) ?>
                                <p class="file-upload-text">Kéo & thả file hoặc <span>nhấn để chọn</span></p>
                                <p class="file-upload-text">Hỗ trợ định dạng <span>ảnh </span>(.jpg, jpeg, .png, .webp,...), <span>tài liệu </span>(.doc, .docx, .pdf,...)</p>
                                <p class="file-upload-count"></p>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (!$model->isNewRecord): ?>
                                <?php foreach ($anhHopDongs as $anhHopDong): ?>
                                    <?php
                                    $ext = strtolower(pathinfo($anhHopDong, PATHINFO_EXTENSION));
                                    $isDocument = in_array($ext, ['pdf', 'doc', 'docx']);
                                    $fileUrl = $domain . '/hinh-anh/' . rawurlencode($anhHopDong);
                                    $icon = ($ext === 'pdf') ? 'pdf.png' : 'word.png';
                                    ?>
                                    <div class="col-sm-6 col-md-4 text-center" style="margin-bottom: 12px;">
                                        <div class="thumbnail">
                                            <?php if ($isDocument): ?>
                                                <a href="<?= $fileUrl ?>" download title="Tải xuống <?= Html::encode($anhHopDong) ?>">
                                                    <?= Html::img("{$domain}/hinh-anh/{$icon}", [
                                                        'width' => '50px',
                                                        'class' => 'img-responsive center-block',
                                                        'alt' => 'Tài liệu'
                                                    ]) ?>
                                                </a>
                                                <div class="caption text-center">
                                                    <p class="text-muted small" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= Html::encode($anhHopDong) ?>">
                                                        <?= Html::encode($anhHopDong) ?>
                                                    </p>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?= $fileUrl ?>" class="example-image-link" data-lightbox="roadtrip" target="_blank">
                                                    <?= Html::img($fileUrl, [
                                                        'class' => 'img-thumbnail',
                                                        'alt' => 'Ảnh hợp đồng'
                                                    ]) ?>
                                                </a>
                                            <?php endif; ?>
                                            <?= Html::a('<i class="fa fa-trash"></i> Xóa', '#', [
                                                'class' => 'btn btn-danger btn-xs btn-block btn-xoa-anh-json',
                                                'data-value' => $anhHopDong,
                                                'data-loai' => 'anh_hop_dong',
                                                'style' => 'margin-top: 6px;'
                                            ]) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'style' => 'resize: vertical;'])->label('Ghi chú:') ?>
                    </div>
                </div>
            </div>

            <?php if (!$model->isNewRecord && $model->sale_id != null): ?>
            <div class="form-section" id="block-moi-gioi" style="display: block;">
                <?php else: ?>
                <div class="form-section" id="block-moi-gioi" style="display: none;">
                    <?php endif; ?>
                    <div class="section-header">Thông tin môi giới</div>
                    <table class="table text-nowrap">
                        <tr>
                            <td>Môi giới: <span class="text-danger">*</span></td>
                            <td>
                                <?= Html::activeTextInput($model, 'moi_gioi', [
                                    'class' => 'form-control text-right hien_thi_tien',
                                    'value' => number_format($model->moi_gioi, 0, ',', '.')
                                ]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Kiểu môi giới: <span class="text-danger">*</span></td>
                            <td id="kieu_moi_gioi" class="text-right">
                                <?= Html::activeDropDownList($model, 'kieu_moi_gioi', [
                                    '%' => '%',
                                    'số tiền' => 'Số tiền'
                                ], ['class' => 'form-control']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Số tiền môi giới: </td>
                            <td id="so_tien_moi_gioi" class="text-right">
                                <?= $model->isNewRecord ? '' : number_format($model->so_tien_moi_gioi, 0, '', '.') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Đã thanh toán MG: </td>
                            <td id="tien-moi-gioi" class="text-right">
                                <?= Html::activeTextInput($model, 'da_thanh_toan_moi_gioi', [
                                    'class' => 'form-control text-right hien_thi_tien',
                                    'value' => number_format($model->da_thanh_toan_moi_gioi, 0, ',', '.')
                                ]) ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="block-thong-tin" class="form-section"></div>

            </div>

            <!-- Right Section: Calendar and Pricing -->
            <div class="col-md-4">
                <div class="form-section">
                    <div class="section-header">Lịch</div>
                    <div id="calendar"></div>
                </div>
                <div class="form-section">
                    <div class="section-header">Chi phí</div>
                    <table class="table text-nowrap">
                        <tr id="block-don-gia">
                            <td>Đơn giá: </td>
                            <td id="don_gia" class="text-right">
                                <?= $model->isNewRecord ? '' : number_format($model->don_gia, 0, '', '.') ?>
                            </td>
                        </tr>
                        <tbody id="block-so-thang">
                        <?php if (!$model->isNewRecord && $model->loai_hop_dong == 'thang'): ?>
                            <tr>
                                <td>Số tháng: </td>
                                <td id="so_thang" class="text-right"><?= $model->so_thang_hop_dong ?></td>
                            </tr>
                            <tr>
                                <td>Tổng tiền: </td>
                                <td id="tong_tien" class="text-right">
                                    <?= number_format($model->don_gia * $model->so_thang_hop_dong, 0, '', '.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                        <tr>
                            <td>Chiết khấu: <span class="text-danger">*</span></td>
                            <td>
                                <?= Html::activeTextInput($model, 'chiet_khau', [
                                    'class' => 'form-control text-right hien_thi_tien',
                                    'value' => number_format($model->chiet_khau, 0, ',', '.')
                                ]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Kiểu chiết khấu: <span class="text-danger">*</span></td>
                            <td id="kieu_chiet_khau" class="text-right">
                                <?= Html::activeDropDownList($model, 'kieu_chiet_khau', [
                                    '%' => '%',
                                    'số tiền' => 'Số tiền'
                                ], ['class' => 'form-control']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Số tiền chiết khấu: </td>
                            <td id="so_tien_chiet_khau" class="text-right">
                                <?= $model->isNewRecord ? '' : number_format($model->so_tien_chiet_khau, 0, '', '.') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-danger"><strong>THÀNH TIỀN: </strong></td>
                            <td id="thanh_tien_sau_chiet_khau" class="text-right text-danger">
                                <?= $model->isNewRecord ? '' : number_format($model->don_gia * $model->so_thang_hop_dong - $model->so_tien_chiet_khau, 0, '', '.') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tiền cọc: </td>
                            <td id="tien-coc" class="text-right">
                                <?= Html::activeTextInput($model, 'coc_truoc', [
                                    'class' => 'form-control text-right hien_thi_tien',
                                    'value' => number_format($model->coc_truoc, 0, ',', '.')
                                ]) ?>
                                <?= Html::hiddenInput('change', $model->isNewRecord ? '' : $model->coc_truoc, ['id' => 'coc-ban-dau']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>CÒN LẠI: </td>
                            <td id="con-lai-phai-tra" class="text-right">
                                <?= $model->isNewRecord ? '' : number_format($model->thanh_tien - $model->coc_truoc, 0, '', '.') ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 text-right">
                    <?php if (!Yii::$app->request->isAjax): ?>
                        <div class="form-group">
                            <?= Html::a('<i class="fa fa-floppy-o"></i> Lưu lại', '#', [
                                'class' => $model->isNewRecord ? 'btn btn-success btn-save-hop-dong' : 'btn btn-success btn-update-hop-dong',
                                'style' => 'margin-right: 8px;'
                            ]) ?>
                            <?= Html::a('<i class="fa fa-arrow-left"></i> Quay lại danh sách', '#', [
                                'class' => 'btn btn-primary',
                                'id' => 'btn-quay-lai-danh-sach'
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

<!--        <div class="row" style="margin-top: 12px;">-->
<!--            <div class="col-md-12 text-right">-->
<!--                --><?php //if (!Yii::$app->request->isAjax): ?>
<!--                    <div class="form-group">-->
<!--                        --><?php //= Html::a('<i class="fa fa-floppy-o"></i> Lưu lại', '#', [
//                            'class' => $model->isNewRecord ? 'btn btn-success btn-save-hop-dong' : 'btn btn-success btn-update-hop-dong',
//                            'style' => 'margin-right: 8px;'
//                        ]) ?>
<!--                        --><?php //= Html::a('<i class="fa fa-arrow-left"></i> Quay lại danh sách', '#', [
//                            'class' => 'btn btn-primary',
//                            'id' => 'btn-quay-lai-danh-sach'
//                        ]) ?>
<!--                    </div>-->
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--        </div>-->

        <?php ActiveForm::end(); ?>
    </div>