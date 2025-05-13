<?php
/**
 * @var $data \backend\models\QuanLyDonKyGui
 * @var $lichSuThanhToan \backend\models\QuanLyGiaoDich[]
 * @var $trangThaiDonKyGui \backend\models\TrangThaiDonKyGui[]
 */

use backend\models\TrangThaiDonKyGui;

?>
<div class="row">
    <div class="col-md-8">
        <h4 class="text-primary">THÔNG TIN NHẬN HÀNG</h4>
        <p><strong>Người nhận hàng: </strong><?=$data->ho_ten_nguoi_nhan; ?></p>
        <p><strong>Điện thoại: </strong><?=$data->dien_thoai_nguoi_nhan; ?></p>
        <p><strong>Địa chỉ nhận hàng: </strong><?=$data->thong_tin_dia_chi; ?></p>

        <h4 class="text-primary">LỊCH SỬ GIAO DỊCH</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>STT</th>
                <th>Ngày</th>
                <th>Người thực hiện</th>
                <th>Trạng thái</th>
                <th>Số tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lichSuThanhToan as $index => $item): ?>
                <tr>
                    <td><?=$index + 1?></td>
                    <td><?=$item->created?></td>
                    <td><?=$item->ho_ten_user?></td>
                    <td><?=$item->trang_thai_giao_dich?></td>
                    <td class="text-right">
                        <?=number_format($item->tong_tien, 0, '', '.')?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-primary">LỊCH SỬ TRẠNG THÁI</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>STT</th>
                <th>Ngày</th>
                <th>Người thực hiện</th>
                <th>Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($trangThaiDonKyGui as $index => $item): ?>
                <tr>
                    <td><?=$index + 1?></td>
                    <td><?=$item->created?></td>
                    <td><?=\common\models\User::find()->where(['id' => $item->user_id])->select('hoten')->scalar()?></td>
                    <td><?=$item->field_trang_thai?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h4 class="text-primary">THÔNG TIN CHUNG</h4>
        <table class="table">
            <tr>
                <td>Mã đơn: </td>
                <td><?=$data->id; ?></td>
            </tr>
            <tr>
                <td>Ngày đặt: </td>
                <td><?=$data->created; ?></td>
            </tr>
            <tr>
                <td>Trạng thái: </td>
                <td><?=$data->field_trang_thai; ?></td>
            </tr>
            <tr>
                <td>Người tạo đơn: </td>
                <td><?=$data->hoten; ?><br/><?=$data->dien_thoai; ?></td>
            </tr>
            <tr>
                <td>Khối lượng: </td>
                <td><?=$data->field_khoi_luong ?> <?=$data->field_dvt_khoi_luong != '' ? '('.$data->field_dvt_khoi_luong.')' : ''?></td>
            </tr>
            <tr>
                <td>Mã vận đơn: </td>
                <td><?=$data->field_ma_van_don_ky_gui == '' ? '<span class="text-grey">Chưa có</span>' : $data->field_ma_van_don_ky_gui; ?></td>
            </tr>
        </table>

        <h4 class="text-danger"><strong>TÀI CHÍNH</strong></h4>
        <table class="table">
            <tr>
                <td>Đã thanh toán</td>
                <td class="text-right">
                    <span class="h4 text-danger">
                        <?=number_format($data->field_so_tien_da_thanh_toan, 0, '', '.')?>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>

            <tr>
                <td>Còn thiếu</td>
                <td class="text-right">
                    <span class="h4 <?=$data->field_thanh_tien - $data->field_so_tien_da_thanh_toan <= 0 ? 'text-success' : 'text-danger'; ?>">
                        <?=number_format($data->field_thanh_tien - $data->field_so_tien_da_thanh_toan, 0, '', '.')?>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>

            <tr>
                <td>Tiền hoàn</td>
                <td class="text-right">
                    <span class="h4">
                        <strong><?=number_format(\backend\models\KyGui::find()->where(['id'=>$data->id])->select('field_so_tien_hoan_lai')->scalar(), 0, '', '.')?></strong>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
        </table>
    </div>
</div>




