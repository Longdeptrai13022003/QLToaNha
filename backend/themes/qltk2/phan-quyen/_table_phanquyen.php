<?php
/**
 * Created by PhpStorm.
 * User: hungluong
 * Date: 6/28/18
 * Time: 09:34
 * @var $vaitro \backend\models\VaiTro[]
 * @var $chucnang \backend\models\ChucNang[]
 * @var $phanquyen \backend\models\PhanQuyen[]
 */?>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-nowrap margin-top-10">
        <thead>
        <tr>
            <th width="3%">STT</th>
            <th>Chức năng</th>
            <?php foreach ($vaitro as $item): ?>
            <th width="3%">
                <?=$item->name?>
            </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($chucnang as $index => $item):?>
        <tr>
            <td>
                <?=$index + 1?>
            </td>
            <td>
                <?=$item->name?>
            </td>
            <?php foreach ($vaitro as $item_vaitro): ?>
            <td class="text-center">
                <label class="form-control">
                    <?=\yii\helpers\Html::checkbox("phanquyen[{$item->id}][{$item_vaitro->id}]", $phanquyen[$item->id][$item_vaitro->id])?>
                </label>
            </td>
            <?php endforeach;?>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="margin-top-10">
    <?=\yii\helpers\Html::button('<i class="fa fa-save"></i> Lưu lại', ['class' => 'btn btn-primary btn-luu-phan-quyen'])?>
</div>
