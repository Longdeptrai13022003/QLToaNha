<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $phongs [] */
$count = 1;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype'=> 'multipart/form-data',
        'id'=>'form-mo-phong'
    ]
]); ?>
    <div>
        <table class="table text-nowrap" id="bang-gia">
            <thead>
            <tr>
                <th width="1%">STT</th>
                <th width="1%">Phòng</th>
                <th width="1%">Giờ vào/ra</th>
                <th>Tiền phòng</th>
                <th>Điện</th>
                <th>Nước</th>
                <th>Dịch vụ khác</th>
                <th width="1%">Thành tiền</th>
                <th width="1%">Đã cọc</th>
                <th width="1%">Còn lại</th>
                <th>Ghi chú</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($phongs as $index => $phong):?>
            <tr>
                <td><?= $count++?></td>
                <td><?= $phong?></td>
                <td><?= '12/12/2024 12:12:12<br/>12/12/2024 12:12:12'?></td>
                <td><div class="text-right"><?= '1.200.000'?></div></td>
                <td><?= Html::textInput('tien_dien[]',0,['class'=>'form-control text-right number-display'])?></td>
                <td><?= Html::textInput('tien_dien[]',0,['class'=>'form-control text-right number-display'])?></td>
                <td><?= Html::textInput('tien_dien[]',0,['class'=>'form-control text-right number-display'])?></td>
                <td><div class="text-right"><?= '1.200.000'?></div></td>
                <td><div class="text-right"><?= '1.200.000'?></div></td>
                <td><div class="text-right"><?= '1.200.000'?></div></td>
                <td><?= Html::textInput('ghi_chu[]',null,['class'=>'form-control'])?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="text-right"><?= Html::a('<i class="fa fa-save"></i> Lưu','#',['class'=>'btn btn-success', 'id'=>'btn-luu-mo-phong'])?></div>
    </div>
<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/thue-ngan-han.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/user.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>