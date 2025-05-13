<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\GiaoDich */
/* @var $hopDong backend\models\PhongKhach */
/* @var $khach \common\models\User */
/* @var $user \common\models\User */
/* @var $phong \backend\models\DanhMuc */
/* @var $toaNha \backend\models\DanhMuc */
/* @var $thang string */
?>
<div class="giao-dich-view">
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
            <td><strong>Thanh toán:</strong></td>
            <td><?= $model->tong_tien == $model->so_tien_giao_dich ? 'Đã thanh toán' : 'Chưa thanh toán'?></td>
        </tr>
        <tr>
            <td><strong>Phòng:</strong></td>
            <td><?= $phong->name?></td>
            <?php
            $parts = explode(' ',$model->created);
            $ngay = implode('/',array_reverse(explode('-',$parts[0])));
            ?>
            <td><strong>Ngày tạo:</strong></td>
            <td><?= $ngay ?> <?= $parts[1]?></td>
        </tr>
        <tr>
            <td><strong>Tòa nhà:</strong></td>
            <td><?= $toaNha->name?></td>
            <td><strong>Người thực hiện:</strong></td>
            <td><?= isset($user->hoten) ? $user->hoten : ''?></td>
        </tr>
        <tr>
            <?php if ($thang != ''): ?>
                <td><strong>Hóa đơn:</strong></td>
            <td><?= $thang?></td>
            <?php endif;?>
            <td><strong>Trạng thái:</strong></td>
            <td><?= $model->trang_thai_giao_dich?></td>
        </tr>
        </tbody>
    </table>
    <h4 class="text-primary">ẢNH CHUYỂN KHOẢN</h4>
    <div class="row">
        <div class="col-md-4">
            <?=Html::a("<img  class='example-image img-responsive' src=".(is_null($model->anh_chuyen_khoan) || $model->anh_chuyen_khoan=='' ? 'hinh-anh/no-image.jpg' : 'hinh-anh/'.$model->anh_chuyen_khoan)." width='100%'>",
                (is_null($model->anh_chuyen_khoan) || $model->anh_chuyen_khoan=='' ? 'hinh-anh/no-image.jpg' : 'hinh-anh/'.$model->anh_chuyen_khoan),['class'=>'example-image-link img-thumbnail img-responsive','data-lightbox'=>'roadtrip','target'=>'_blank'])?>
        </div>
    </div>
</div>