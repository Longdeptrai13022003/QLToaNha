<?php
/**
 * @var $data \backend\models\QuanLyDonHang[]
 * @var $title string
 * @var $type string
 */

$soLuong = 0;
$tongTienNDT = 0;
$tongTien = 0;
$index3 = 0;
?>
<h1 style="text-align: center"><?=$title?></h1>
<table style="border-collapse: collapse; width: 100%" border="">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="39%">Sản phẩm</th>
        <th width="15%">Khách hàng</th>
        <th width="9%">SL</th>
        <th width="9%">Đơn giá NDT</th>
        <th width="9%">Tổng tiền NDT</th>
        <th width="9%">Tỷ giá</th>
        <th width="9%">Tổng tiền VNĐ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $index => $item): ?>
        <?php $chiTietSanPham = \backend\models\QuanLyChiTietDonHang::findAll(['don_hang_id' => $item->id]); ?>

        <?php foreach ($chiTietSanPham as $index2 => $item2): ?>
            <?php $tongTien +=$item2->tong_tien; ?>
            <?php $soLuong +=$item2->so_luong; ?>
            <?php $tongTienNDT +=$item2->tong_tien_cny; ?>
            <tr>
                <td><?=$index3 + 1; ?></td>
                <td style="padding: 5px; vertical-align: top">
                    <div style="display: inline-block; vertical-align: top; width: 25%">
                        <img src="<?=$item2->images?>" width="80px">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 10px; width: 65%">
                        <span style="font-size: 11px"><?=$item2->product_name?></span>
                        <p style="font-size: 11px"><?=$item2->props_name?></p>
                    </div>
                </td>
                <td style="vertical-align: top; padding: 5px">
                    <?=$item->hoten; ?>
                    <p><?=$item->dien_thoai; ?></p>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=$item2->so_luong?>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=$item2->price_money?>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=$item2->tong_tien_cny?>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=number_format($item->ty_gia, 0, '', '.')?>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=number_format($item2->tong_tien, 0, '', '.')?>
                </td>
            </tr>
            <?php $index3++; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr>
        <th colspan="3" style="text-align: center; padding: 3px">TỔNG</th>
        <td style="text-align: right; padding: 3px">
            <strong><?=number_format($soLuong, 0, '', '.')?></strong>
        </td>
        <td style="text-align: right; padding: 3px"></td>
        <td style="text-align: right; padding: 3px">
            <strong><?=$tongTienNDT?></strong>
        </td>
        <td style="text-align: right; padding: 3px"></td>
        <td style="text-align: right; padding: 3px">
            <strong><?=number_format($tongTien, 0, '', '.')?></strong>
        </td>
    </tr>
    </tbody>
</table>
