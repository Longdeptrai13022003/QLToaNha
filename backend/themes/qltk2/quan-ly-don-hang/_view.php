<?php
/**
 * @var $data \backend\models\QuanLyDonHang
 * @var $chiTietDonHang \backend\models\QuanLyChiTietDonHang[]
 * @var $lichSuThanhToan \backend\models\QuanLyGiaoDich[]
 * @var $trangThaiDonHang \backend\models\QuanLyTrangThaiDonHang[]
 */
?>
<div class="row">
    <div class="col-md-8">
        <h4 class="text-primary">THÔNG TIN SẢN PHẨM</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <?php if($data->trang_thai =='Giỏ hàng'):?>
                <th width="1%"><input type="checkbox" class="checkAll" value="<?=$data->id?>" <?= $data->da_chon_de_thanh_toan == 1 ? 'checked' : '' ?>></th>
                <?php endif;?>
                <th width="1%">STT</th>
                <th width="12%">Hình ảnh</th>
                <th>Tên + Thuộc tính</th>
                <th width="10%" class="text-right">TT (VNĐ)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($chiTietDonHang as $index => $item): ?>
                <tr>
                    <?php if($data->trang_thai =='Giỏ hàng'):?>
                    <td><input type="checkbox" class="itemCheckbox" value="<?=$item->id?>" <?= $item->da_chon_de_thanh_toan == 1 ? 'checked' : '' ?>></td>
                    <?php endif;?>
                    <td><?=$index + 1;?></td>
                    <td>
                        <a target="_blank" href="<?=$item->link_product?>">
                            <img width="100px" src="<?=$item->images?>" class="img-responsive img-thumbnail">
                        </a>
                    </td>
                    <td>
                        <p>
                            <a target="_blank" href="<?=$item->link_product?>"><?=$item->product_name?></a><br/>
                            <?=$item->props_name?><br/>
                        </p>
                        <p id="product-info-<?=$item->id?>">
                            <span class="quantity"><?=$item->so_luong?></span> x <span class="price"><?=$item->price_money?></span> = <span class="total"><?=$item->tong_tien_cny?></span>
                        </p>
                        <p class="hidden">
                            <span class="ty_gia"><?=$item->ty_gia?></span>
                        </p>
                        <?php if($data->trang_thai =='Giỏ hàng' && $item->user_id == Yii::$app->user->id):?>
                        <p>
                            <input type="number" class="quantity_textbox form-control" value="<?=$item->so_luong?>" min="1" style="width: 80px;"  data-id-don-hang="<?=$item->id?>">
                        </p>
                        <?php endif;?>
                    </td>
                    <td class="text-right tong_tien"><?=number_format($item->tong_tien, 0, '', '.')?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="bg-warning">
                <td colspan="3"><strong>TỔNG TIỀN HÀNG</strong></td>
                <?php if($data->trang_thai =='Giỏ hàng'):?>
                <td></td>
                <?php endif;?>
                <td class="text-right text-danger h4">
                    <strong><span class="thanh_tien"><?=number_format($data->tong_tien_cny * $data->ty_gia, 0, '', '.')?></span></strong>
                </td>
            </tr>
            </tfoot>
        </table>

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
                <th>Loại giao dịch</th>
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
                    <td><?=$item->loai_giao_dich?></td>
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
            <?php foreach ($trangThaiDonHang as $index => $item): ?>
                <tr>
                    <td><?=$index + 1?></td>
                    <td><?=$item->created?></td>
                    <td><?=$item->hoten?></td>
                    <td><?=$item->trang_thai?></td>
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
                <td><?=$data->trang_thai; ?></td>
            </tr>
            <tr>
                <td>Người mua: </td>
                <td><?=$data->hoten; ?><br/><?=$data->dien_thoai; ?></td>
            </tr>
            <tr>
                <td>Shop: </td>
                <td><?=\yii\bootstrap\Html::a(
                        $data->shop_name,
                        $data->shop_link,
                        ['target' => '_blank']
                    ); ?></td>
            </tr>
            <tr>
                <td>Khối lượng: </td>
                <td><?=$data->khoi_luong ?> <?=$data->dvt_khoi_luong != '' ? '('.$data->dvt_khoi_luong.')' : ''?></td>
            </tr>
            <tr>
                <td>Mã vận đơn: </td>
                <td><?=$data->ma_van_don == '' ? '<span class="text-grey">Chưa có</span>' : $data->ma_van_don; ?></td>
            </tr>
        </table>

        <h4 class="text-danger"><strong>TÀI CHÍNH</strong></h4>
        <table class="table">
            <tr>
                <td>Tiền hàng (NDT)</td>
                <td class="text-right">
                    <span class="h4 text-danger">
                        <?=number_format($data->tong_tien_cny, 0, '', '.')?>
                    </span>
                    <span class="text-grey"><em>(NDT)</em></span>
                </td>
            </tr>

            <tr>
                <td>Tỷ giá</td>
                <td class="text-right">
                    <span class="h5">
                        <?=number_format($data->ty_gia, 0, '', '.')?>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>

            <tr>
                <td>Tiền hàng (VNĐ)</td>
                <td class="text-right">
                    <span class="h4 text-danger"><?=number_format($data->tong_tien_cny * $data->ty_gia, 0, '', '.')?></span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>Phí mua hộ</td>
                <td class="text-right">
                    <span class="h5"><?=number_format($data->phi_mua_hang, 0, '', '.')?></span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>Chiết khấu</td>
                <td class="text-right">
                    <span class="h5"><?=number_format($data->chiet_khau_tien_hang, 0, '', '.')?></span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>Ship nội địa</td>
                <td class="text-right">
                    <span class="h5"><?=number_format($data->ship_noi_dia_vnd, 0, '', '.')?></span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>Tiền cân</td>
                <td class="text-right">
                    <span class="h5"><?=number_format($data->phi_khoi_luong, 0, '', '.')?></span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>TỔNG TIỀN</td>
                <td class="text-right">
                    <span class="h4">
                        <strong><?=number_format($data->thanh_tien, 0, '', '.')?></strong>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>ĐÃ THANH TOÁN</td>
                <td class="text-right">
                    <span class="h4">
                        <strong><?=number_format($data->da_thanh_toan, 0, '', '.')?></strong>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
            <tr>
                <td>CÒN LẠI</td>
                <td class="text-right">
                    <span class="h4 <?=$data->thanh_tien - $data->da_thanh_toan <= 0 ? 'text-success' : 'text-danger'; ?>">
                        <?=number_format($data->thanh_tien - $data->da_thanh_toan, 0, '', '.')?>
                    </span>
                    <span class="text-grey"><em>(VNĐ)</em></span>
                </td>
            </tr>
        </table>
    </div>
</div>




