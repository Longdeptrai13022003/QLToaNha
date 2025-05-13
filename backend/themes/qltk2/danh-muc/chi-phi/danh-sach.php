<?php
use yii\helpers\Html;
/* @var $chiTiets backend\models\ChiTietChiPhi[] */
?>
<table class="table table-striped text-nowrap">
    <thead>
    <tr>
        <th width="1%">STT</th>
        <th width="20%">Danh mục</th>
        <th>Ghi chú</th>
        <th width="20%">Thành tiền</th>
        <th width="20%">Đã thanh toán</th>
        <th width="1%">Thêm</th>
        <th width="1%">Xóa</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($chiTiets as $index => $chiTiet): ?>
        <tr>
            <?= Html::hiddenInput('chiTietID',$chiTiet->id,['class'=>'chiTietID'])?>
            <td><?= $index + 1?></td>
            <td><?= Html::textInput('ten_chi_phi',$chiTiet->ten_chi_phi,['class'=>'form-control ten_chi_phi'])?></td>
            <td><?= Html::textInput('ghi_chu',$chiTiet->ghi_chu,['class'=>'form-control ghi_chu'])?></td>
            <?php if($chiTiet->chi_phi_id == 1):?>
                <?= Html::hiddenInput('moi_gioi',"0",['class'=>'moi_gioi'])?>
                <td><span class="pull-right"><?=number_format($chiTiet->so_tien, 0, ',', '.')?></span></td>
                <td><span class="pull-right"><?=number_format($chiTiet->da_thanh_toan, 0, ',', '.')?></span></td>
            <?php else:?>
                <?= Html::hiddenInput('moi_gioi',"1",['class'=>'moi_gioi'])?>
                <td><?= Html::textInput('tong_tien',number_format($chiTiet->so_tien, 0, ',', '.'),['class'=>'form-control tong_tien display-number text-right'])?></td>
                <td><?= Html::textInput('da_thanh_toan',number_format($chiTiet->da_thanh_toan, 0, ',', '.'),['class'=>'form-control da_thanh_toan display-number text-right'])?></td>
            <?php endif;?>
            <td><center><?=Html::a('<i class="fa fa-plus"></i>','#',['class'=>'text-primary them-chi-phi'])?></center></td>
            <td><center><?=Html::a('<i class="fa fa-trash"></i>','#',['class'=>'text-danger xoa-chi-phi'])?></center></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>