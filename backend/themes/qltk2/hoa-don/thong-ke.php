<?php
use yii\helpers\Html;
/* @var $hoaDons backend\models\QuanLyHoaDon[] */
?>
<table class="table table-striped text-nowrap">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="1%">Hợp đồng</th>
        <th width="1%">Phòng</th>
        <th>Khách</th>
        <th width="1%">Tổng tiền</th>
        <th width="1%">Trạng thái</th>
        <th width="1%">Còn nợ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($hoaDons as $index => $hoaDon): ?>
        <tr>
            <td><?= $index + 1?></td>
            <td><?= $hoaDon->ma_hop_dong?></td>
            <td><?= $hoaDon->ten_phong?></td>
            <td><?= $hoaDon->hoten.'</br>'.$hoaDon->dien_thoai ?></td>
            <td><?= number_format($hoaDon->tong_tien, 0, ',', '.')?></td>
            <td><?= $hoaDon->da_thanh_toan == 0 ? 'Chưa thanh toán' : ($hoaDon->da_thanh_toan < $hoaDon->tong_tien ? 'TT một phần' : 'Đã thanh toán')?></td>
            <td><?= number_format($hoaDon->tong_tien - $hoaDon->da_thanh_toan, 0, ',', '.')?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>