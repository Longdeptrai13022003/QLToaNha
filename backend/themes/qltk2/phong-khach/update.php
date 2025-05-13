<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PhongKhach */
/* @var $khach \common\models\User */
/* @var $sale \common\models\User */
/* @var $phong \backend\models\DanhMuc */
/* @var $fileHDs \backend\models\FileHopDong[] */
/* @var $toanhaids ArrayHelper */
/* @var $phongids ArrayHelper */
/* @var $packages [] */
/* @var $gios [] */
/* @var $phuts [] */
/* @var $dataProviderKhach \backend\models\QuanLyKhachHang[] */
/* @var $searchModelKhach \backend\models\search\QuanLyKhachHangSearch */
/* @var $dataProviderSale \backend\models\QuanLySale[] */
/* @var $domain string */
/* @var $searchModelSale \backend\models\search\QuanLySaleSearch */
$this->title = 'Sửa hợp đồng khách: '.$khach->hoten;
?>
<style>
    table.table-khach-hang tbody tr:hover,
    table.table-sale tbody tr:hover {
        background-color: #009cff21;
    }
</style>
<div class="phong-khach-update">

    <?= $this->render('_form', [
        'model' => $model,
        'khach' => $khach,
        'phong' => $phong,
        'fileHDs' => $fileHDs,
        'phongids' => $phongids,
        'searchModel' => $searchModelKhach,
        'toanhaids' => $toanhaids,
        'dataProvider' => $dataProviderKhach,
        'packages' => $packages,
        'gios' => $gios,
        'phuts' => $phuts,
        'sale' => $sale,
        'domain' => $domain
    ]) ?>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'header'=>'Thêm khách hàng',
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",
])?>
<?php Modal::end(); ?>

<div class="modal fade" id="modal-danh-sach-khach-hang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Danh sách khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="user-index">
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crud-datatable',
                            'dataProvider' => $dataProviderKhach,
                            'filterModel' => $searchModelKhach,
                            'pjax'=>true,
                            'columns' => [
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Chọn',
                                    'attribute'=>'anhdaidien',
                                    'headerOptions' => ['width' => '1%'],
                                    'value' => function ($data) {
                                        return '<label>'.Html::radio('chon_khach_hang',false,['class'=>'chon-khach-hang-radio-btn','value'=>$data->id]).' Chọn</label>';
                                    },
                                    'format'=>'raw',
                                    'filter'=>false
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Họ tên',
                                    'attribute'=>'hoten',
                                    'headerOptions' => ['width' => 'auto'],
                                    'contentOptions'=>['class'=>'td-ho-ten']
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Điện thoại',
                                    'attribute'=>'dien_thoai',
                                    'headerOptions' => ['width' => '1%'],
                                    'contentOptions'=>['class'=>'td-dien-thoai']
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Tên đăng nhập',
                                    'headerOptions' => ['width' => '1%'],
                                    'attribute'=>'username',
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Email',
                                    'headerOptions' => ['width' => '1%'],
                                    'attribute'=>'email',
                                ],
                            ],
                            'toolbar'=> [],
                            'striped' => false,
                            'condensed' => true,
                            'responsive' => true,
                            'responsiveWrap' => false,
                            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap table-khach-hang'],
                            'panel' => [
                                'type' => 'primary',
                                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách khách hàng'
                            ],

                        ])?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Đóng lại</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-danh-sach-sale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Danh sách Sale</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="user-index">
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crud-datatable-sale',
                            'dataProvider' => $dataProviderSale,
                            'filterModel' => $searchModelSale,
                            'pjax'=>true,
                            'columns' => [
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Chọn',
                                    'attribute'=>'anhdaidien',
                                    'headerOptions' => ['width' => '1%'],
                                    'value' => function ($data) {
                                        return '<label>'.Html::radio('chon_khach_hang',false,['class'=>'chon-sale-radio-btn','value'=>$data->id]).' Chọn</label>';
                                    },
                                    'format'=>'raw',
                                    'filter'=>false
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Họ tên',
                                    'attribute'=>'hoten',
                                    'headerOptions' => ['width' => 'auto'],
                                    'contentOptions'=>['class'=>'td-ho-ten']
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Điện thoại',
                                    'attribute'=>'dien_thoai',
                                    'headerOptions' => ['width' => '1%'],
                                    'contentOptions'=>['class'=>'td-dien-thoai']
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Tên đăng nhập',
                                    'headerOptions' => ['width' => '1%'],
                                    'attribute'=>'username',
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label' => 'Email',
                                    'headerOptions' => ['width' => '1%'],
                                    'attribute'=>'email',
                                ],
                            ],
                            'toolbar'=> [],
                            'striped' => false,
                            'condensed' => true,
                            'responsive' => true,
                            'responsiveWrap' => false,
                            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap table-sale'],
                            'panel' => [
                                'type' => 'primary',
                                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách khách hàng'
                            ],

                        ])?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Đóng lại</button>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/hop-dong.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.min.css');?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap/js/bootstrap.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/moment.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
