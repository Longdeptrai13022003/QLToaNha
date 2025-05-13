<?php
use \yii\helpers\Html;
/* @var $dichVus \backend\models\ThietLapGia[] */
/* @var $results [] */
/* @var $typeHienThi string */
$domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">.
<style>
    .hoa-don-table {
        margin: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
        border-radius: 10px !important;
    }
    .hoa-don-table .table {
        background: #ffffff !important;
        border-radius: 10px !important;
        margin-bottom: 0 !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5) !important;
        transition: box-shadow 0.2s !important;
        /*table-layout: auto !important;*/
    }
    .hoa-don-table .table:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.8) !important;
    }
    .hoa-don-table thead {
        background: linear-gradient(90deg, #e0f2fe, #dbeafe) !important;
        color: #1e3a8a !important;
        text-align: center !important;
    }
    .hoa-don-table thead th {
        font-size: 1.4rem !important;
        font-weight: 700 !important;
        padding: 20px 10px !important;
        vertical-align: middle !important;
        border-bottom: 2px solid #e2e8f0 !important;
        letter-spacing: 0.5px !important;
        text-align: center !important;
        position: sticky !important;
        background: radial-gradient(circle, #f0f9ff, #c2daf3) !important;
        top: 44px;
        z-index: 1;

    }
    .hoa-don-table thead th i {
        color: #1e3a8a !important;
        display: block !important;
    }
    .hoa-don-table tbody tr {
        transition: background-color 0.2s, transform 0.2s !important;
    }

    .hoa-don-table tbody tr:hover {
        background: #f0f5ff !important;
        transform: translateY(-1px) !important;
    }
    .hoa-don-table tbody td {
        font-size: 1.4rem !important;
        color: #1a202c !important;
        padding: 10px 12px !important;
        border-top: 1px solid #e2e8f0 !important;
    }
    .hoa-don-table .text-right {
        color: #2d3748 !important;
    }
    .hoa-don-table .status-badge {
        padding: 6px 12px !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 1.3rem !important;
        display: inline-block !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }
    .hoa-don-table .status-badge:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.15) !important;
    }
    .hoa-don-table .status-paid {
        background-color: #e6f7ee !important;
        color: #28a745 !important;
    }
    .hoa-don-table .status-unpaid {
        background-color: #fbe9e7 !important;
        color: #dc3545 !important;
    }
    .hoa-don-table .form-control {
        border-radius: 6px !important;
        border: 1px solid #d1d9e0 !important;
        font-size: 1.4rem !important;
        padding: 6px 12px !important;
        transition: border-color 0.3s, box-shadow 0.3s, background-color 0.2s !important;
        background: #f8fafc !important;
        height: 34px !important;
        line-height: 1 !important;
        box-sizing: border-box !important;
    }
    .hoa-don-table .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 6px rgba(59,130,246,0.5) !important;
        background: #ffffff !important;
        outline: none !important;
    }
    .hoa-don-table .row {
        margin: 0 -5px !important;
        row-gap: 8px !important;
    }
    .hoa-don-table .col-md-6 {
        padding: 0 5px !important;
    }
    .hoa-don-table .img-thumbnail {
        border-radius: 6px !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
        width: 100% !important;
        max-width: 80px !important; /* Crop to square */
        height: 80px !important;
        object-fit: cover !important;
    }
    .hoa-don-table .img-thumbnail:hover {
        transform: scale(1.08) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }
    .hoa-don-table .btn-danger {
        background: linear-gradient(45deg, #ef4444, #f87171) !important;
        border: none !important;
        font-size: 1.2rem !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s !important;
    }
    .hoa-don-table .btn-delete {
        border: none !important;
        color: red !important;
        font-size: 1.2rem !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        text-decoration: none !important;
    }
    .hoa-don-table .btn-delete:hover {
        background: linear-gradient(45deg, #dc2626, #ef4444) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(239,68,68,0.3) !important;
        color: white !important;
        border: 1px solid white !important;
    }
    .hoa-don-table .btn-primary {
        background: #f0f5ff !important;
        border: none !important;
        font-size: 1.2rem !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s !important;
        color: #1e3a8a !important;
    }
    .hoa-don-table .btn-primary:hover {
        background: radial-gradient(circle, #3b82f6, #1e3a8a) !important;
        transform: translateY(-1px) !important;
        color: white !important;
        box-shadow: 0 4px 8px rgba(59,130,246,0.3) !important;
    }
    .hoa-don-table input[type="checkbox"] {
        transform: scale(1.5) !important;
        transition: transform 0.2s !important;
        cursor: pointer !important;
    }
    .hoa-don-table input[type="checkbox"]:checked {
        transform: scale(1.8) !important;
    }
    @media (max-width: 767px) {
        .hoa-don-table .table {
            overflow-x: auto !important;
            display: block !important;
        }
        .hoa-don-table thead th,
        .hoa-don-table tbody td {
            font-size: 0.95rem !important;
            padding: 8px !important;
        }
        .hoa-don-table .status-badge {
            font-size: 0.85rem !important;
            padding: 4px 8px !important;
        }
        .hoa-don-table .img-thumbnail {
            max-height: 60px !important;
        }
        .hoa-don-table .form-control {
            font-size: 0.95rem !important;
        }
    }
    .btn-upload{
        width: 100% !important;
        cursor: pointer;
        text-align: center;
    }
    .hoa-don-table .btn-upload input[type="file"] {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        opacity: 0 !important;
        cursor: pointer !important;
    }
</style>

<div class="hoa-don-table">
    <table class="table text-nowrap table-striped table-responsive">
        <thead id="tieu-de">
        <tr>
            <?php if ($typeHienThi != 'hien_thi'): ?>
                <th width="1%"><span class="check-all">
                        <?= Html::checkbox('check_all', false, ['class' => 'chon-tat-ca', 'style' => 'transform: scale(1.5);']) ?>
                    </span></th>
            <?php endif; ?>
            <th width="1%"><i class="fas fa-door-open"></i> Phòng</th>
            <th width="1%"><i class="fas fa-user"></i> Khách hàng</th>
            <th width="1%"><i class="fas fa-money-bill"></i> Tiền phòng</th>
            <th width="1%"><i class="fas fa-image"></i> Ảnh số điện</th>
            <th width="15%"><i class="fas fa-bolt"></i> Điện</th>
            <th width="1%"><i class="fas fa-tint"></i> Nước</th>
            <th width="1%"><i class="fas fa-trash-alt"></i> Rác</th>
            <th width="1%"><i class="fas fa-wifi"></i> Internet</th>
            <th width="1%"><i class="fas fa-tshirt"></i> Giặt</th>
            <th width="10%"><i class="fas fa-plus-circle"></i> Phụ phí</th>
            <th width="1%"><i class="fas fa-calculator"></i> Tổng tiền</th>
            <th width="1%"><i class="fas fa-info-circle"></i> Trạng thái</th>
        </tr>
        </thead>
        <tbody id="hoaDons">
        <?php foreach ($results as $result): ?>
            <tr>
                <?php if ($typeHienThi != 'hien_thi'): ?>
                    <td><?= Html::checkbox('thanhToan[]', false, ['style' => 'transform: scale(1.5);', 'value' => $result['id'], 'class' => 'check-chon']) ?></td>
                <?php endif; ?>
                <td><?= $result['phong'] ?></td>
                <td><?= $result['khach'] ?></td>
                <td class="text-right"><?= $result['tien_phong'] ?></td>
                <td>
                    <?php $src = $result['anhDien'] == '' ? $domain . '/hinh-anh/no-image.jpg' : $domain . '/hinh-anh/' . $result['anhDien'] ?>
                    <div>
                        <?= Html::a('<img class="example-image img-responsive img-thumbnail" src="' . $src . '" width="100%">',
                            $src, ['class' => 'example-image-link', 'data-lightbox' => 'roadtrip', 'target' => '_blank']) ?>
                    </div>
                    <div style="margin-top: 6px;">
                        <?= Html::a('<i class="fa fa-trash"></i> Xóa', '#', ['class' => 'btn btn-delete btn-xs btn-block text-danger xoa-anh']) ?>
                    </div>
                </td>
                <?php if ($typeHienThi == 'hien_thi'): ?>
                    <td class="text-right"><?= $result['Điện'] ?></td>
                    <td class="text-right"><?= $result['Nước'] ?></td>
                <?php elseif ($typeHienThi == 'so_nuoc'): ?>
                    <td>
                        <div class="row">
                            <div class="col-md-6"><?= Html::textInput('dien_dau', $result['dien_dau'], ['class' => 'so-dau form-control text-right hien-thi-so-tien']) ?></div>
                            <div class="col-md-6"><?= Html::textInput('dien_cuoi', $result['dien_cuoi'], ['class' => 'so-cuoi form-control text-right hien-thi-so-tien']) ?></div>
                        </div>
                        <div style="margin-top: 6px;">Tiền điện: <span class="pull-right thanh-tien-dien"><?= $result['Điện'] ?></span></div>
                        <div style="margin-top: 6px;">
                            <label class="btn-upload btn-primary" style="display: inline-block; position: relative;">
                                <i class="fas fa-upload"></i>
                                <?= Html::fileInput('anh_dien', null, ['class' => 'anh-dien', 'style' => 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;']) ?>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6"><?= Html::textInput('nuoc_dau', $result['nuoc_dau'], ['class' => 'so-nuoc-dau form-control text-right hien-thi-so-tien']) ?></div>
                            <div class="col-md-6"><?= Html::textInput('nuoc_cuoi', array_key_exists('nuoc_cuoi', $result) ? $result['nuoc_cuoi'] : '0', ['class' => 'so-nuoc-cuoi form-control text-right hien-thi-so-tien']) ?></div>
                        </div>
                        <div style="margin-top: 6px;">Tiền nước: <span class="pull-right thanh-tien-nuoc"><?= array_key_exists('Nước', $result) ? $result['Nước'] : '0' ?></span></div>
                    </td>
                <?php else: ?>
                    <td>
                        <div class="row">
                            <div class="col-md-6"><?= Html::textInput('dien_dau', $result['dien_dau'], ['class' => 'so-dau form-control text-right hien-thi-so-tien']) ?></div>
                            <div class="col-md-6"><?= Html::textInput('dien_cuoi', $result['dien_cuoi'], ['class' => 'so-cuoi form-control text-right hien-thi-so-tien']) ?></div>
                        </div>
                        <div style="margin-top: 6px;">Tiền điện: <span class="pull-right thanh-tien-dien"><?= $result['Điện'] ?></span></div>
                        <div style="margin-top: 6px;">
                            <label class="btn-upload btn-primary" style="display: inline-block; position: relative;">
                                <i class="fas fa-upload"></i> <span>Tải ảnh số điện</span>
                                <?= Html::fileInput('anh_dien', null, ['class' => 'anh-dien', 'style' => 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;']) ?>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div>Số người: <span class="so-thanh-vien"><?= $result['so_nguoi'] ?></span>
                            <?= Html::a('<i class="fa fa-edit"></i>', '#', ['class' => 'btn btn-primary btn-xs btn-update-member', 'title' => 'Cập nhật số người']) ?>
                        </div>
                        <div style="margin-top: 6px;">Tiền nước: <span class="pull-right thanh-tien-nuoc"><?= array_key_exists('Nước', $result) ? $result['Nước'] : '0' ?></span></div>
                    </td>
                <?php endif; ?>
                <td class="text-right"><?= array_key_exists('Rác', $result) ? $result['Rác'] : '0' ?></td>
                <td class="text-right"><?= array_key_exists('Internet', $result) ? $result['Internet'] : '0' ?></td>
                <td class="text-right"><?= array_key_exists('Giặt', $result) ? $result['Giặt'] : '0' ?></td>
                <td class="text-right"><?= Html::textInput('phu_phi', array_key_exists('Phụ phí', $result) ? $result['Phụ phí'] : '0', ['class' => 'phu-phi form-control text-right hien-thi-so-tien']) ?></td>
                <td class="text-right tong_tien"><?= $result['tong_tien'] ?></td>
                <td class="text-right">
                        <span class="status-badge <?= $result['trang_thai'] == 'GD đã thanh toán' ? 'status-paid' : 'status-unpaid' ?>">
                            <?= $result['trang_thai'] ?>
                        </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>