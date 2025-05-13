<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TrangThaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trạng thái';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="trang-thai-index">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="glyphicon glyphicon-list-alt"></i> Quản lý Trạng Thái</h3>
        </div>

        <div class="box-body">
            <div id="ajaxCrudDatatable">
                <?= GridView::widget([
                    'id' => 'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax' => true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'toolbar' => [
                        ['content' =>
                            Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="hidden-xs">Thêm mới</span>', ['create'], [
                                'role' => 'modal-remote',
                                'title' => 'Thêm mới trạng thái',
                                'class' => 'btn btn-primary',
                            ]) . ' ' .
                            Html::a('<i class="glyphicon glyphicon-repeat"></i> <span class="hidden-xs">Khôi phục</span>', [''], [
                                'data-pjax' => 1,
                                'class' => 'btn btn-default',
                                'title' => 'Reset bảng',
                            ]) . ' ' .
                            '{toggleData} {export}'
                        ],
                    ],
                    'striped' => true,
                    'hover' => false,
                    'condensed' => true,
                    'responsive' => true,
                    'panel' => [
                        'type' => 'primary',
                        'heading' => '<i class="glyphicon glyphicon-th-large"></i> Danh sách Trạng thái',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
