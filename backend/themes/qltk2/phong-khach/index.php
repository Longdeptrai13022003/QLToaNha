<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\QuanLyPhongKhachSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách hợp đồng';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
    /* Căn giữa các cột */
    .text-center {
        text-align: center !important; /* Đảm bảo căn giữa */
    }

    /* Căn giữa theo chiều dọc */
    .align-middle {
        vertical-align: middle !important; /* Căn giữa theo chiều dọc */
    }
    table tbody tr:hover {
        background-color: #beebff; /* Màu nền nhẹ khi hover */
        cursor: pointer;  /* Thay đổi con trỏ khi di chuột */
    }
    .cccd-wrapper {
        width: 100% !important;
        height: 200px !important;
        overflow: hidden !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
        margin-bottom: 10px !important;
    }

    .cccd-img {
        width: 100% !important;
        height: 180px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
    }
</style>
<div class="phong-khach-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm mới hợp đồng', ['create'],
                    ['class'=>'btn btn-primary', 'data-pjax' => 0]).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => true,
            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap'],
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách hợp đồng',
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
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/hop-dong.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.min.css');?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap/js/bootstrap.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/moment.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>