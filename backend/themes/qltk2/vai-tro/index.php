<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\NhommauSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vai trò');
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
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm mới vai trò', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới Chức năng','class'=>'btn btn-default'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách vai trò',
                'after' => false,
                'showFooter' => false,
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.min.css'); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.theme.min.css'); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/rong-vang/vai-tro/index-vai-tro.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
