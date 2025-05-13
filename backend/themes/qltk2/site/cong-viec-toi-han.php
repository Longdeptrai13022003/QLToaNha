<?php
/**
 ** hungd
 ** 4/20/2020 11:14 PM
 ** cong-viec-toi-han.php
 ** qlcv-sao-do
 * @var $data \backend\models\QuanLyNhacViecThucHien[]
 */
$this->title = $title;
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-nowrap">
        <thead>
        <tr>
            <th width="1%">STT</th>
            <th>Tiêu đề</th>
            <th width="1%">Ngày hết hạn</th>
            <th width="1%">Còn lại (ngày)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $index => $item): ?>
        <tr>
            <td><?=$index + 1?></td>
            <td><?=$item->tieu_de?></td>
            <td class="text-center"><?=date("d/m/Y", strtotime($item->ngay_het_han)); ?></td>
            <td class="text-right"><?=$item->so_ngay_con_lai?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
