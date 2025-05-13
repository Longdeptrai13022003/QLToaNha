<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $IDs [] */
/* @var $phongs [] */
/* @var $conNos [] */
/* @var $phaiTras [] */
/* @var $khachs [] */

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype'=> 'multipart/form-data',
        'id'=>'form-tao-giao-dich'
    ]
]); ?>
<div class="block-giao-dich">
    <?=Html::hiddenInput('gui_thong_bao','',['id'=>'gui_thong_bao'])?>
    <table class="table text-nowrap">
        <thead>
        <tr>
            <th>Phòng</th>
            <th>Khách</th>
            <th>Phải trả tháng này</th>
            <th>Còn nợ</th>
            <th>Tổng cộng</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($IDs as $index => $ID): ?>
            <input type="hidden" name="hoaDonIDs[]" value="<?=$ID?>">
            <tr>
                <td><?= $phongs[$index]->name?></td>
                <td><?= $khachs[$index]->hoten?></td>
                <td><span class="pull-right"><?=number_format(intval(implode('',explode('.',$phaiTras[$index])))-$conNos[$index], 0, ',', '.')?></span></td>
                <td><span class="pull-right"><?=number_format($conNos[$index], 0, ',', '.')?></span></td>
                <td><input name="phai_tra[]" class="form-control displayIn" value="<?=$phaiTras[$index]?>"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pull-right">
        <?=Html::a('Tạo giao dịch','#',['class' => 'btn btn-success btn-giao-dich','data-value'=>'giao_dich']).
        Html::a('Thông báo Zalo','#',['class' => 'btn btn-primary btn-giao-dich','data-value'=>'gui_zalo'])?>
    </div>
</div>
<br/>
<?php ActiveForm::end(); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/hoa-don.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
