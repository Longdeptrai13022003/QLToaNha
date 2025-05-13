<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $searchModel \backend\models\search\TrangThaiSearch*/

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '1%'
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'width' => '1%'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Mã trạng thái',
        'vAlign'=>'middle',
        'attribute'=>'id',
        'headerOptions' => ['width' => '10%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'id',
            [
                'placeholder' => 'Mã trạng thái',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Tên trạng thái',
        'vAlign'=>'middle',
        'attribute'=>'ten',
        'headerOptions' => ['width' => '20%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'ten',
            [
                'placeholder' => 'Tên trạng thái',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Loại trạng thái',
        'vAlign'=>'middle',
        'format' => 'raw',
        'attribute'=>'loai_trang_thai',
        'headerOptions' => ['width' => '20%'],
        'value' => function ($model) {
            return $model->getTypeLabelWithStyle();
        },
        'filter' => \yii\helpers\Html::activeDropDownList(
            $searchModel,
            'loai_trang_thai',
            \backend\models\TrangThai::getTypeList(),
            ['class' => 'form-control', 'prompt' => 'Tất cả']
        ),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ghi chú',
        'vAlign'=>'middle',
        'attribute'=>'ghi_chu',
        'headerOptions' => ['width' => '30%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'ghi_chu',
            [
                'placeholder' => 'Ghi chú',
                'class' => 'form-control'
            ]
        )
    ],
//    [
//        'header' => 'Sửa',
//        'value' => function($data) {
//            return \yii\bootstrap\Html::a('<i class="fa fa-edit"></i>',Url::toRoute(['trang-thai/update', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'select2']);
//        },
//        'format' => 'raw',
//        'headerOptions' => ['width' => '10%', 'class' => 'text-center'],
//        'contentOptions' => ['class' => 'text-center']
//    ],
//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'header' =>'Xoá',
//        'dropdown' => false,
//        'vAlign'=>'middle',
//        'template' => '{delete}',
//        'headerOptions' => ['width' => 'auto'],
//        'urlCreator' => function($action, $model, $key, $index) {
//            return Url::to([$action,'id'=>$key]);
//        },
//        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
//            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//            'data-request-method'=>'post',
//            'data-toggle'=>'tooltip',
//            'data-confirm-title'=>'Are you sure?',
//            'data-confirm-message'=>'Are you sure want to delete this item'],
//    ],
    [
        'header' => 'Thao tác',
        'format' => 'raw',
        'headerOptions' => ['width' => '15%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function($data) {
            $update = \yii\bootstrap\Html::a('<i class="fa fa-edit"></i>',
                Url::toRoute(['trang-thai/update', 'id' => $data->id]),
                ['role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Sửa', 'class'=>'btn btn-sm btn-primary']);

            $delete = \yii\bootstrap\Html::a('<i class="fa fa-trash"></i>',
                Url::toRoute(['trang-thai/delete', 'id' => $data->id]),
                [
                    'role' => 'modal-remote',
                    'title' => 'Xóa',
                    'data-confirm' => false,
                    'data-method' => false,
                    'data-request-method' => 'post',
                    'data-toggle' => 'tooltip',
                    'data-confirm-title' => 'Bạn chắc chứ?',
                    'data-confirm-message' => 'Bạn có chắc chắn muốn xóa trạng thái "'.$data->ten.'" không?',
                    'class' => 'btn btn-sm btn-danger',
                ]);

            return $update . ' ' . $delete;
        },
    ],

];   