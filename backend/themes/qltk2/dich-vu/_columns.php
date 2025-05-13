<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $searchModel \backend\models\search\DichVuSearch*/

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
        'label' => 'Mã dịch vụ',
        'vAlign'=>'middle',
        'attribute'=>'id',
        'headerOptions' => ['width' => '10%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'id',
            [
                'placeholder' => 'Mã dịch vụ',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Tên dịch vụ',
        'vAlign'=>'middle',
        'attribute'=>'ten',
        'headerOptions' => ['width' => '20%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'ten',
            [
                'placeholder' => 'Tên dịch vụ',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Đơn vị tính',
        'vAlign'=>'middle',
        'attribute'=>'don_vi_tinh',
        'headerOptions' => ['width' => '20%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'don_vi_tinh',
            [
                'placeholder' => 'Đơn vị tính',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Đơn giá',
        'vAlign'=>'middle',
        'attribute'=>'don_gia',
        'headerOptions' => ['width' => '20%'],
        'value' => function($data) {
            return number_format($data->don_gia,0,',','.').'đ';
        },
        'filter' => Html::activeTextInput(
            $searchModel, 'don_gia',
            [
                'placeholder' => 'Đơn giá',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ghi chú',
        'vAlign'=>'middle',
        'attribute'=>'ghi_chu',
        'headerOptions' => ['width' => '20%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'ghi_chu',
            [
                'placeholder' => 'Ghi chú',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions' => ['width' => 'auto'],
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];   