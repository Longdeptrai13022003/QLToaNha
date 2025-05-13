<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GiaoDich */
/* @var $hopDong backend\models\PhongKhach */
/* @var $khach \common\models\User */
/* @var $phong \backend\models\DanhMuc */
/* @var $toaNha \backend\models\DanhMuc */
?>
<div class="giao-dich-update">
    <h4 class="text-primary">THÔNG TIN GIAO DỊCH</h4>
    <table class="table text-nowrap">
        <tbody>
        <tr>
            <td><strong>Hợp đồng:</strong></td>
            <td><?= $hopDong->ma_hop_dong?></td>
            <td><strong>Số tiền:</strong></td>
            <td><span class="pull-right"><?= number_format($model->tong_tien,0,',','.')?></span></td>
        </tr>
        <tr>
            <td><strong>Khách hàng:</strong></td>
            <td><?= $khach->hoten.' ('.$khach->dien_thoai.')'?></td>
            <td><strong>Trạng thái:</strong></td>
            <td><?= $model->tong_tien == $model->so_tien_giao_dich ? 'Đã thanh toán' : 'Chưa thanh toán'?></td>
        </tr>
        <tr>
            <td><strong>Phòng:</strong></td>
            <td><?= $phong->name?></td>
            <td><strong>Tòa nhà:</strong></td>
            <td><?= $toaNha->name?></td>
        </tr>
        </tbody>
    </table>
</div>
