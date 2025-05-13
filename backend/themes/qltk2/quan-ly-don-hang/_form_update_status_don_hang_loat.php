<?php
/**
 * @var $donHang \backend\models\QuanLyDonHang[]
 */
?>

<?php \yii\widgets\ActiveForm::begin(['id' => 'form-update-status-hang-load'])?>
<div class="form-group">
    <label id="chon-trang-thai">Chọn trạng thái mới</label>
    <?=\yii\bootstrap\Html::dropDownList('trang_thai', null, \backend\models\DonHang::$listTrangThaiDonHang, ['class' => 'form-control', 'id' => 'chon-trang-thai'])?>
</div>

<h4 class="text-primary"><strong>DANH SÁCH ĐƠN HÀNG CẦN CẬP NHẬT TRẠNG THÁI</strong></h4>
<table class="table table-bordered text-nowrap">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="1%">Mã đơn</th>
        <th width="1%">Ngày tạo ĐH</th>
        <th>Người mua hàng</th>
        <th width="1%">Trạng thái hiện tại</th>
        <th width="1%">Xoá</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($donHang as $index => $itemDH): ?>
    <tr>
        <td><?=$index + 1?><?=\yii\bootstrap\Html::hiddenInput('don_hang['.$itemDH->id.']', $itemDH->id)?></td>
        <td><?=$itemDH->id?></td>
        <td><?=$itemDH->created?></td>
        <td><?=$itemDH->hoten?></td>
        <td><?=$itemDH->trang_thai?></td>
        <td class="text-center"><?=\yii\bootstrap\Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger remove-list-don-hang-update'])?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php \yii\widgets\ActiveForm::end(); ?>
