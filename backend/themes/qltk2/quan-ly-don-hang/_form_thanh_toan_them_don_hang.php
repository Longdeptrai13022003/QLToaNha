<?php
/**
 * @var $donHang \backend\models\DonHang
 */
?>
<?php \yii\widgets\ActiveForm::begin(['id' => 'form-update-status-hang-load'])?>
    <?=\yii\bootstrap\Html::hiddenInput('idDonHang', $donHang->id); ?>
    <?=\yii\bootstrap\Html::label('Số tiền TT thêm', 'so-tien-thanh-toan-them') ?>
    <?=\yii\bootstrap\Html::textInput('soTienThanhToanThem', $donHang->thanh_tien - $donHang->da_thanh_toan, ['class' => 'form-control', 'id' => 'so-tien-thanh-toan-them', 'type' => 'number']) ?>

    <h4 class="margin-top-25">THÔNG TIN CHI PHÍ LIÊN QUAN</h4>
    <table class="table">
        <tr>
            <td>Tiền hàng</td>
            <td class="text-right"><?=number_format($donHang->tong_tien, 0, '', '.')?> <span class="text-grey">VNĐ</span></td>
        </tr>
        <tr>
            <td>Phí mua hộ</td>
            <td class="text-right"><?=number_format($donHang->phi_mua_hang, 0, '', '.')?> <span class="text-grey">VNĐ</span></td>
        </tr>
        <tr>
            <td>VC nội địa</td>
            <td class="text-right">
                <?=number_format($donHang->ship_noi_dia_vnd, 0, '', '.')?> <span class="text-grey">VNĐ</span><br/>
                 <span class="text-grey"><?=number_format($donHang->ship_noi_dia_cny, 0, '', '.')?> CNY</span><br/>
            </td>
        </tr>
        <tr>
            <td>Phí cân nặng</td>
            <td class="text-right">
                <?=number_format($donHang->phi_khoi_luong, 0, '', '.')?> <span class="text-grey">VNĐ</span><br/>
            </td>
        </tr>
        <tr>
            <td><strong>THÀNH TIỀN</strong></td>
            <td class="text-right text-danger h4">
                <strong>
                    <?=number_format($donHang->thanh_tien, 0, '', '.')?>
                </strong>
                <span class="text-grey">VNĐ</span>
            </td>
        </tr>
        <tr>
            <td><strong>Đã thanh toán</strong></td>
            <td class="text-right">
                <?=number_format($donHang->da_thanh_toan, 0, '', '.')?> <span class="text-grey">VNĐ</span><br/>
            </td>
        </tr>
        <tr>
            <td><strong>Còn lại</strong></td>
            <td class="text-right h4 <?=$donHang->thanh_tien - $donHang->da_thanh_toan > 0 ? 'text-danger' : 'text-success'?>">
                <?=number_format($donHang->thanh_tien - $donHang->da_thanh_toan, 0, '', '.')?> <span class="text-grey">VNĐ</span><br/>
            </td>
        </tr>
    </table>
<?php \yii\widgets\ActiveForm::end(); ?>
