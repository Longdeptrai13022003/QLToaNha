<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\QuanLyThucHienCongViecSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Giỏ hàng';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="block-don-hang-da-chon-de-thanh-toan" class="margin-bottom-5"></div>
<div class="nhommau-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'summary' => "Hiển thị {begin} - {end} Trên tổng số {totalCount}",
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'emptyText' => 'Chưa có dữ liệu',
            'columns' => require(__DIR__.'/_columns.php'),
            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap'],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fa fa-trash"></i> Xóa giỏ hàng', [''], ['class'=>'btn btn-danger btn-sm btn-delete-gio-hang']).
                    Html::a('<i class="fa fa-money"></i> Thanh toán', [''], ['class'=>'btn btn-warning btn-sm btn-thanh-toan']).
                    Html::textInput('total', '0', ['class'=>'form-control', 'readonly' => true, 'id' => 'total-amount', 'style' => 'display:inline-block; width:auto; margin-left: 10px;'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => false,
            'rowOptions' => function($model, $key, $index, $grid){
                /** @var \backend\models\QuanLyDonHang $model */
                return [
                    'class' => 'row-don-hang '.$model->da_chon_de_thanh_toan ? 'row-selected' : '',
                    'data-value' => $model->id,
                ];
            },
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Giỏ hàng',
                'after' => false,
                'showFooter' => false,
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.min.css'); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.theme.min.css'); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/rong-vang/don-hang/index-quan-ly-don-hang.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
