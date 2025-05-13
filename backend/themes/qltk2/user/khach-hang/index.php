<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\search\QuanLyKhachHangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Khách hàng';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);

?>

<style>
    .table .img-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        overflow: hidden;
    }


    .text-center {
        text-align: center !important;
    }

    .align-middle {
        vertical-align: middle !important;
    }
    table tbody tr:hover {
        background-color: #beebff;
        cursor: pointer;
    }
    /* Kiểu chung cho các nút */
    .btn-action {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 8px 12px;
        font-size: 18px;
        border-radius: 5px !important;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Hiệu ứng hover chung cho tất cả các nút */
    .btn-action:hover {
        transform: scale(1.1); /* Phóng to khi hover */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Tăng bóng đổ khi hover */
    }

    /* Nút Xem */
    .btn-view {
        background-color: #6c757d; /* Màu xám nhạt */
        color: white;
    }

    .btn-view:hover {
        background-color: #5a6268; /* Màu xám đậm hơn khi hover */
        color: white;
    }

    /* Nút Sửa */
    .btn-edit {
        background-color: #f8c923; /* Màu vàng nhạt */
        color: white;
    }

    .btn-edit:hover {
        background-color: #e6b91e; /* Màu vàng đậm hơn khi hover */
        color: white;
    }

    /* Nút Xóa */
    .btn-delete {
        background-color: #dc3545; /* Màu đỏ nhẹ */
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333; /* Màu đỏ đậm hơn khi hover */
        color: white;
    }


    .user-detail-popup {
        padding: 20px !important;
        border-radius: 8px !important;
        background: #f9f9fc !important;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1) !important;
        margin-top: 20px !important;
        font-size: 14px !important;
    }

    .user-avatar {
        width: 100% !important;
        height: 200px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
    }

    .user-info p {
        margin-bottom: 8px !important;
    }

    .user-info i {
        margin-right: 6px !important;
        color: #5c5c5c !important;
    }

    .margin-top-30 {
        margin-top: 30px !important;
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
<div class="user-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
//                    Html::a('<i class="fa fa-search"></i> Tìm kiếm', [''], ['class'=>'btn btn-success btn-search-khach-hang', 'style'=>'width: 120px;']).
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm khách hàng', ['them-khach-hang'],
                        ['role'=>'modal-remote','title'=> 'Bổ sung Thành viên','class'=>'btn btn-primary']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới']).
                    Html::a('Xuất Excel', ['export-excel'], ['class' => 'btn btn-success'])
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => true,
            'tableOptions' => ['class' => 'table table-borderd table-stripped text-nowrap'],
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách khách hàng'
            ],

        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/user.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>

