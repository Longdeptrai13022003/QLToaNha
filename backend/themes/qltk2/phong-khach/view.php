<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PhongKhach */
/* @var $khach \common\models\User */
/* @var $phong \backend\models\DanhMuc */
/* @var $toanha \backend\models\DanhMuc */
/* @var $user \common\models\User */
/* @var $giaoDichs \backend\models\GiaoDich[] */
?>
<div class="tabbale-line">
    <div class="tab-content">
        <div class="tab-pane active">
            <h4 class="text-primary">THÔNG TIN HỢP ĐỒNG</h4>
            <div class="row">
                <div class="col-md-6">
                    <table class="table text-nowrap">
                        <tr>
                            <td><strong>Mã hợp đồng:</strong></td>
                            <td><?=$model->ma_hop_dong?></td>
                        </tr>
                        <tr>
                            <td><strong>Người thực hiện:</strong></td>
                            <td><?= is_null($user) ? 'Tài khoản không còn' : $user->hoten ?></td>
                        </tr>
                        <tr>
                            <?php $phan = explode(' ',$model->created);
                            $ngay = explode('-',$phan[0]);
                            $hienThiNgay = implode('/',array_reverse($ngay));?>
                            <td><strong>Thời gian thực hiện:</strong></td>
                            <td><?=$hienThiNgay.' '.$phan[1] ?></td>
                        </tr>
                        <tr>
                            <?php
                            if ($model->thoi_gian_hop_dong_tu == null){
                                $hienThi = '';
                            }
                            $hienThiTu = DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_tu)->format('d/m/Y H:i:s');
                            $hienThi = DateTime::createFromFormat('Y-m-d H:i:s', $model->thoi_gian_hop_dong_den)->format('d/m/Y H:i:s');?>
                            <td><strong>Thời gian hợp đồng:</strong></td>
                            <td><strong>Từ </strong><?=$hienThiTu ?> <br/><strong>đến</strong> <?=$hienThi ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tòa nhà:</strong> </td>
                            <td><?=$toanha->name ?></td>
                        </tr>
                        <tr>
                            <td><strong>Phòng:</strong></td>
                            <td><?=$phong->name ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table text-nowrap">
                        <tr>
                            <td><strong>Đơn giá:</strong></td>
                            <td><span class="pull-right"><?=number_format($phong->don_gia, 0, ',', '.')?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Số tháng:</strong></td>
                            <td><span class="pull-right"><?=sprintf('%02d',$model->so_thang_hop_dong) ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Tổng tiền:</strong></td>
                            <td><span class="pull-right"><?=number_format($model->don_gia * $model->so_thang_hop_dong, 0, ',', '.')?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Chiết khấu:</strong></td>
                            <td><span class="pull-right"><?=number_format($model->so_tien_chiet_khau, 0, ',', '.')?>
                            <?= $model->kieu_chiet_khau == '%' ? '('.$model->chiet_khau.'%)' : ''?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Thành tiền:</strong></td>
                            <td><span class="pull-right"><?=number_format($model->thanh_tien, 0, ',', '.')?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Cọc trước:</strong></td>
                            <td><span class="pull-right"><?=number_format($model->coc_truoc, 0, ',', '.')?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <h4 class="text-primary">FILE HỢP ĐỒNG</h4>
            <div class="row">
                
            </div>
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
                            <td><strong>Email:</strong></td>
                            <td><?=$khach->email ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><h4 class="text-primary">ẢNH 2 MẶT CCCD</h4></div>
                <?php if($khach->anhcancuoc == ''): ?>
                    <div class="col-md-4">
                        <?=Html::a("<img  class='cccd-img example-image img-responsive' src='hinh-anh/no-image.jpg' width='100%'>",
                            'hinh-anh/no-image.jpg',['class'=>'example-image-link img-thumbnail','data-lightbox'=>'roadtrip','target'=>'_blank'])?>
                    </div>
                <?php else:?>
                    <?php $anhs =explode(',',$khach->anhcancuoc)?>
                    <?php foreach ($anhs as $anh): ?>
                        <div class="col-md-4">
                            <?=Html::a("<img  class='cccd-img example-image img-responsive' src='hinh-anh/$anh' width='100%'>",
                                'hinh-anh/'.$anh,['class'=>'example-image-link img-thumbnail','data-lightbox'=>'roadtrip','target'=>'_blank'])?>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
            <h4 class="text-primary">LỊCH SỬ THANH TOÁN</h4>
            <table class="table text-nowrap">
                <thead>
                <tr>
                    <td>Thời gian thực hiện</td>
                    <td>Số tiền thanh toán</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($giaoDichs as $giaoDich):?>
                    <?php $phan = explode(' ',$giaoDich->created);
                    $ngay = explode('-',$phan[0]);
                    $hienThiNgay = implode('/',array_reverse($ngay));?>
                <tr>
                    <td><?= $hienThiNgay?></td>
                    <td><span class="pull-right"><?= number_format($giaoDich->so_tien_giao_dich, 0, ',', '.')?></span></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
