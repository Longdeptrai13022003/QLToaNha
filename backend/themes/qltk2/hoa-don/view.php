<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HoaDon */
/* @var $khach \common\models\User */
/* @var $phong \backend\models\DanhMuc */
/* @var $toaNha \backend\models\DanhMuc */
/* @var $giaoDichs \backend\models\GiaoDich[] */
/* @var $dichVus [] */
/* @var $thucHiens [] */
/* @var $anhDien string */
?>
<div class="hoa-don-view">
    <div class="tabbale-line">
        <div class="tab-content">
            <div class="tab-pane active">
                <h4 class="text-primary">THÔNG TIN KHÁCH HÀNG</h4>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table text-nowrap">
                            <tr>
                                <td><strong>Họ tên:</strong></td>
                                <td><?=$khach->hoten?></td>
                            </tr>
                            <tr>
                                <td><strong>Điện thoại:</strong></td>
                                <td><?=$khach->dien_thoai?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table text-nowrap">
                            <tr>
                                <td><strong>CCCD:</strong></td>
                                <td><?=$khach->so_cccd ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h4 class="text-primary">THÔNG TIN HÓA ĐƠN</h4>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table text-nowrap">
                            <tr>
                                <td><strong>Tòa nhà:</strong></td>
                                <td><?=$toaNha->name?></td>
                            </tr>
                            <tr>
                                <td><strong>Phòng ở:</strong></td>
                                <td><?= $phong->name ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table text-nowrap">
                            <tr>
                                <td><strong>Thời gian:</strong></td>
                                <td><?=$model->thang.'/'.$model->nam ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h4 class="text-primary">CHI PHÍ DỊCH VỤ</h4>
                <table class="table text-nowrap">
                    <?php foreach ($dichVus as $key => $dichVu):?>
                        <tr>
                            <td><strong><?= $key?></strong></td>
                            <td><span class="pull-right"><?= number_format($dichVu, 0, ',', '.')?></span></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td><strong>Tiền phòng:</strong></td>
                        <td><span class="pull-right"><?=number_format($model->tien_phong, 0, ',', '.') ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Tổng tiền:</strong></td>
                        <td><span class="pull-right"><?=number_format($model->tong_tien, 0, ',', '.')?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Đã thanh toán:</strong></td>
                        <td><span class="pull-right"><?=number_format($model->da_thanh_toan, 0, ',', '.')?></span></td>
                    </tr>
                </table>
                <h4 class="text-primary">SỐ ĐIỆN THÁNG</h4>
                <div class="row">
                    <div class="col-md-6">
                        <?=Html::a('<img  class="example-image img-responsive" src="'.$anhDien.'" width="100%">',
                            $anhDien,['class'=>'example-image-link img-thumbnail img-responsive','data-lightbox'=>'roadtrip','target' => '_blank'])?>
                    </div>
                </div>
                <h4 class="text-primary">THÔNG TIN GIAO DỊCH</h4>
                <table class="table text-nowrap">
                    <thead>
                    <tr>
                        <th>Người thực hiện</th>
                        <th>Thời gian giao dịch</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($giaoDichs as $index => $giaoDich): ?>
                    <tr>
                        <?php
                        $parts = explode(' ',$giaoDich->created);
                        $ngay = implode('/',array_reverse(explode('-',$parts[0])));
                        ?>
                        <td><?=$thucHiens[$index]?></td>
                        <td><?= $ngay ?> <?= $parts[1]?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
