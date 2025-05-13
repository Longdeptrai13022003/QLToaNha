<?php
use \yii\helpers\Html;
/* @var $results [] */
?>
<table class="table text-nowrap">
    <thead>
    <tr>
        <th width="1%">Chọn&nbsp;&nbsp;<span class="check-all">
                <?=Html::checkbox('check_all',false,['class'=>'chon-tat-ca','style'=>'transform: scale(1.5);'])?>
        </span></th>
        <th width="1%">Phòng</th>
        <th>Khách hàng</th>
        <th width="1%">Thời gian từ</th>
        <th width="1%">Thời gian đến</th>
        <th width="1%">Đơn giá</th>
        <th width="1%">Đã TT</th>
        <th width="1%">Chiết khấu</th>
        <th width="1%">Còn lại</th>
        <th width="1%">Trạng thái</th>
    </tr>
    </thead>
    <tbody id="hoaDons">
    <?php foreach ($results as $result):?>
        <tr>
            <td><?= Html::checkbox('thanhToan[]',false,['style'=>'transform: scale(1.5);','value' => $result['id'],'class'=>'check-chon'])?></td>
            <td><?=$result['phong']?></td>
            <td><?=$result['khach']?></td>
            <td><?=$result['thoi_gian_tu']?></td>
            <td><?=$result['thoi_gian_den']?></td>
            <td><?=$result['don_gia']?></td>
            <td><span class="pull-right"><?=$result['da_thanh_toan']?></span></td>
            <td><span class="pull-right"><?=$result['chiet_khau']?></span></td>
            <td><span class="pull-right"><?=$result['tong_tien']?></span></td>
            <td><span class="pull-right"><?=$result['trang_thai']?></span></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>