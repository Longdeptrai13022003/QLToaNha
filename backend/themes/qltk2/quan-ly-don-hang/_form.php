<?php

use backend\models\QuanLyKhachHang;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\myAPI;
use common\models\User;
use backend\models\DonHang;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use backend\models\CauHinh;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $model backend\models\DonHang */
/** @var $khach_hang [] */

$this->title = 'Thêm đơn hàng';

?>

<div class="san-pham-form">

    <?php $form = ActiveForm::begin([
        'options'=> ['id'=>'form-san-pham',
            'autocomplete'=>"off",
            'enctype' => 'multipart/form-data']
    ]); ?>
    <?=Html::activeHiddenInput($model, 'id'); ?>
    <?php if(myAPI::isAccess2('QuanLyDonHang', 'Gio-hang')): ?>
        <h4 class="text-danger">THÔNG TIN ĐƠN HÀNG</h4><hr/>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'user_id')->label('Khách hàng')->dropDownList($khach_hang,['prompt'=>'--Chọn--']) ?>
            </div>
            <div class="col-md-4">
                <div class="form-group padding-top-50">
                    <label for="ty_gia_hien_tai">Tỷ giá trung việt hiện tại</label>
                    <?= Html::textInput(
                        'ty_gia_hien_tai',
                        CauHinh::find()->select('content')->where(['ghi_chu' => 'ty_gia_trung_viet'])->scalar(),
                        ['class' => 'form-control', 'disabled' => true]
                    ) ?>
                </div>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'tong_tien')->label('Tổng tiền') ?>
            </div>
        </div>
    <?php endif; ?>

    <h4 class="text-danger">THÔNG TIN SẢN PHẨM</h4><hr/>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-nowrap">
            <thead>
            <tr>
                <th width="1%">STT</th>
                <th width="10%">Tên sản phẩm</th>
                <th width="10%">Link sản phẩm</th>
                <th>Thuộc tính</th>
                <th width="5%">Tổng tiền</th>
                <th width="5%" style="text-align: center"><?=Html::a('<i class="fas fa-plus-circle fa-2x"></i>', '#', ['class' => 'btn-them-dong'])?></th>
            </tr>
            </thead>
            <tbody class="outside">
            </tbody>
        </table>
    </div>



    <?=Html::a('<i class="fa fa-save"></i> Lưu lại', '#', ['class' => 'btn btn-primary btn-luu-don-hang']) ?>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets2/js-view/rong-vang/don-hang/index-don-hang.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
