<?php
/**
 * @var $kyGui \backend\models\QuanLyDonKyGui[]
 */
?>

<?php \yii\widgets\ActiveForm::begin(['id' => 'form-update-status-hang-loat'])?>
<div class="form-group">
    <label id="chon-trang-thai">Chọn trạng thái mới</label>
    <?=\yii\bootstrap\Html::dropDownList('trang_thai', null, \backend\models\KyGui::$listTrangThaiDonKyGui, ['class' => 'form-control', 'id' => 'chon-trang-thai'])?>
</div>

<h4 class="text-primary"><strong>DANH SÁCH ĐƠN KÝ GỬI CẦN CẬP NHẬT TRẠNG THÁI</strong></h4>
<table class="table table-bordered text-nowrap">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="1%">Mã đơn ký gửi</th>
        <th width="1%">Ngày tạo đơn KG</th>
        <th>Người tạo đơn</th>
        <th width="1%">Trạng thái hiện tại</th>
        <th width="1%">Xoá</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($kyGui as $index => $itemKG): ?>
    <tr>
        <td><?=$index + 1?><?=\yii\bootstrap\Html::hiddenInput('ky_gui['.$itemKG->id.']', $itemKG->id)?></td>
        <td><?=$itemKG->id?></td>
        <td><?=$itemKG->created?></td>
        <td><?=$itemKG->hoten?></td>
        <td><?=$itemKG->field_trang_thai?></td>
        <td class="text-center"><?=\yii\bootstrap\Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger remove-list-don-ky-gui-update'])?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php \yii\widgets\ActiveForm::end(); ?>
