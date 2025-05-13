<?php
/**
 * @var $data \backend\models\QuanLyDonHang[]
 * @var $title string
 * @var $type string
 */

$tongTien = 0;
$daThanhToan = 0;
$conLai = 0;

?>
<h1 style="text-align: center"><?=$title?></h1>
<table style="border-collapse: collapse; width: 100%" border="">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="24%">Thông tin đặt hàng</th>
        <th width="20%">Kiện hàng</th>
        <th width="28%">Chi phí</th>
        <th width="27%">Tài chính</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $index => $item): ?>
        <?php $tongTien +=$item->thanh_tien; ?>
        <?php $daThanhToan +=$item->da_thanh_toan; ?>
        <?php $conLai +=($item->thanh_tien - $item->da_thanh_toan); ?>

        <?php $chiTietSanPham = \backend\models\QuanLyChiTietDonHang::findAll(['don_hang_id' => $item->id]); ?>

        <tr>
            <td rowspan="<?=count($chiTietSanPham) + 1?>" style="vertical-align: top; padding: 5px"><?=$index + 1; ?></td>
            <td style="vertical-align: top; padding: 5px">
                <p>Mã đơn: <strong><?=$item->id; ?></strong></p>
                <p>Ngày đặt: <?= date("d/m/Y", strtotime($item->created)); ?></p>
                <p>Người đặt:<?=$item->hoten; ?></p>
                <p>ĐT: <?=$item->dien_thoai; ?></p>
            </td>
            <td style="vertical-align: top; padding: 5px">
                <p><strong><?=$item->trang_thai?></strong></p>
                <p>Mã VĐ: <?=$item->ma_van_don; ?></p>
                <p>Cân nặng: <?=$item->khoi_luong; ?> <?=$item->dvt_khoi_luong?></p>
            </td>
            <td style="vertical-align: top; padding: 5px">
                <table style="width: 100%; border-collapse: collapse; border: none" border="">
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Tiền hàng: </td>
                        <td style="text-align: right">
                            <?=number_format($item->tong_tien, 0, '', '.')?> <span style="color: #a1a1a1; font-size: 10px">VNĐ</span><br/>
                            <span style="color: #a1a1a1"><?=number_format($item->tong_tien_cny)?></span>
                            <span style="color: #a1a1a1; font-size: 10px">NDT</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Ship TQ: </td>
                        <td style="text-align: right">
                            <?=$item->ship_noi_dia_vnd ?> <span style="color: #a1a1a1; font-size: 10px">VNĐ</span><br/>
                                <span style="color: #a1a1a1;">
                                    <?=$item->ship_noi_dia_cny?>
                                </span>
                                <span style="font-size: 10px; color: #a1a1a1;">
                                    NDT
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Mua hộ: </td>
                        <td style="text-align: right">
                            <?=$item->phi_mua_hang?> <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Tiền cân nặng:</td>
                        <td style="text-align: right">
                            <?=$item->phi_khoi_luong?> <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top; padding: 5px">
                <table style="width: 100%; border-collapse: collapse; border: none" border="">
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Thành tiền</td>
                        <td style="text-align: right">
                            <strong><?=number_format($item->thanh_tien, 0, '', '.'); ?></strong>
                            <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Đã TT</td>
                        <td style="text-align: right">
                            <strong><?=number_format($item->da_thanh_toan, 0, '', '.'); ?></strong>
                            <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding: 5px">Còn lại</td>
                        <td style="text-align: right">
                            <strong><?=number_format($item->thanh_tien - $item->da_thanh_toan, 0, '', '.'); ?></strong>
                            <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php foreach ($chiTietSanPham as $item2): ?>
            <tr>
                <td colspan="3" style="padding: 5px; vertical-align: top">
                    <div style="display: inline-block; vertical-align: top">
                        <img src="<?=$item2->images?>" width="80px">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 10px">
                        <p><?=$item2->props_name?></p>
                        <?=$item2->so_luong?> x <?=$item2->price_money?> = <?=$item2->tong_tien_cny?> <span style="color: #a1a1a1">NDT</span>
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top; padding: 5px">
                    <?=number_format($item2->tong_tien, 0, '', '.')?>
                    <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php endforeach; ?>
    <tr>
        <th colspan="4" style="text-align: center; padding: 3px">TỔNG THÀNH TIỀN</th>
        <td style="text-align: right; padding: 3px">
            <strong><?=number_format($tongTien, 0, '', '.')?></strong>
            <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
        </td>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center; padding: 3px">ĐÃ THANH TOÁN</th>
        <td style="text-align: right">
            <strong><?=number_format($daThanhToan, 0, '', '.')?> </strong>
            <span style="color: #a1a1a1; font-size: 10px">VNĐ</span>
        </td>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center; padding: 3px">CÒN LẠI</th>
        <td style="text-align: right"><?=number_format($tongTien - $daThanhToan, 0, '', '.')?></td>
    </tr>
    </tbody>
</table>
