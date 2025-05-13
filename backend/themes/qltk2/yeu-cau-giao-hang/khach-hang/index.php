<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\QuanLyPhieuYeuCauGiaoHangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý phiếu yêu cầu giao hàng';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
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

            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => false,
            'rowOptions' => function($model, $key, $index, $grid){
                /** @var \app\models\QuanLyPhieuYeuCauGiaoHang $model */
                return [
//                    'class' => 'row-don-hang '.$model->da_chon_thuc_hien_chuc_nang ? 'row-selected' : '',
                    'data-value' => $model->id,
                ];
            },
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách phiếu yêu cầu giao hàng',
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
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/rong-vang/yeu-cau-giao-hang/index.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
