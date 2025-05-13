<?php
/**
 * @var $data []
 * @var $chiTietDonHang \backend\models\QuanLyChiTietDonHang[]
 * @var $lichSuThanhToan \backend\models\QuanLyGiaoDich[]
 * @var $trangThaiDonHang \backend\models\QuanLyTrangThaiDonHang[]
 */
?>
<h4 class="text-primary">THÔNG TIN SẢN PHẨM</h4>
<?php foreach ($chiTietDonHang as $item): ?>
    <div class="border">
        <div class="row">
            <div class="col-md-2">
                <a href="<?=$item->link_product?>">
                    <img src="<?=$item->images?>" class="img-responsive img-thumbnail">
                </a>
            </div>
            <div class="col-md-10">

            </div>
        </div>
    </div>
<?php endforeach; ?>

<h4 class="text-primary">THÔNG TIN CHUNG</h4>

<h4 class="text-primary">LỊCH SỬ GIAO DỊCH</h4>

<h4 class="text-primary">LỊCH SỬ TRẠNG THÁI</h4>
