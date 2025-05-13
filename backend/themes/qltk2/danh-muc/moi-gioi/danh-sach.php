<?php
use yii\helpers\Html;
/* @var $hopDongs backend\models\QuanLyPhongKhach[] */
/* @var $loai string */
?>
<table class="table table-striped text-nowrap">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="1%">Hợp đồng</th>
        <th width="1%">Phòng</th>
        <th>Môi giới</th>
        <th width="1%">Tổng tiền</th>
        <th width="1%">Trạng thái</th>
        <th width="1%">Còn nợ</th>
        <?php if($loai != 'con no'): ?>
        <th width="10%">Đã thanh toán</th>
        <?php endif;?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($hopDongs as $index => $hopDong): ?>
        <tr>
            <?= Html::hiddenInput('hopDongID',$hopDong->id,['class'=>'hopDongID'])?>
            <td><?= $index + 1?></td>
            <td><?= $hopDong->ma_hop_dong?></td>
            <td><?= $hopDong->ten_phong?></td>
            <td><?= $hopDong->hoten_sale.'</br>'.$hopDong->dien_thoai_sale ?></td>
            <td><?= number_format($hopDong->so_tien_moi_gioi, 0, ',', '.')?></td>
            <td><?= $hopDong->da_thanh_toan_moi_gioi == 0 ? 'Chưa thanh toán' : ($hopDong->da_thanh_toan_moi_gioi < $hopDong->so_tien_moi_gioi ? 'TT một phần' : 'Đã thanh toán')?></td>
            <td><?= number_format($hopDong->so_tien_moi_gioi - $hopDong->da_thanh_toan_moi_gioi, 0, ',', '.')?></td>
            <?php if($loai != 'con no'): ?>
                <th width="10%">
                    <?= Html::textInput('da_thanh_toan',number_format($hopDong->da_thanh_toan_moi_gioi,0,',','.'),['class'=>'form-control text-right da_thanh_toan'])?>
                </th>
            <?php endif;?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>