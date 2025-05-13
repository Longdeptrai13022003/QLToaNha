<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\QuanLyPhongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $toanhaids [] */

$this->title = 'Thêm hợp đồng ngắn hạn';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
    table tbody tr:hover {
        background-color: #009cff21;
    }
</style>
<div class="thue-ngan-han-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>'<span class="btn-hanh-dong"></span>'.
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => false,
            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap'],
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách Toà nhà / phòng ở',
            ]
        ])?>
    </div>
    <div class="text-right btn-hanh-dong"></div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/thue-ngan-han.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>