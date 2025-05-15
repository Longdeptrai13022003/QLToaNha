<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchModel \backend\models\search\HoaDonSearch*/
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions' => ['width' => '1%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Mã hóa đơn',
        'attribute'=>'ma_hoa_don',
        'headerOptions' => ['width' => '8%'],
        'filter' => Html::activeTextInput(
            $searchModel, 'ma_hoa_don',
            [
                'placeholder' => 'Mã hóa đơn',
                'class' => 'form-control'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Phòng',
        'attribute'=>'ten_phong',
        'headerOptions' => ['width' => '8%'],
        'value' => function ($data) {
            return $data->ten_phong.'/'.$data->ten_toa_nha;
        },
        'format'=>'raw',
        'filter' => Html::activeTextInput(
            $searchModel,'ten_phong',[
                'class'=>'form-control',
                'placeholder'=>'Tên phòng'
            ]
        ).Html::activeTextInput(
                $searchModel,'ten_toa_nha',[
                    'class'=>'form-control',
                    'placeholder'=>'Tên tòa nhà'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'label' => 'Khách hàng',
        'headerOptions' => ['width' => 'auto'],
        'value' => function ($data) {
            return '<strong>'.$data->hoten.'</strong> (<i class="fa fa-phone"></i> '.$data->dien_thoai.')';
        },
        'format'=>'raw',
        'filter' => Html::activeTextInput(
            $searchModel,'hoten',[
                'class'=>'form-control',
                'placeholder'=>'Tên khách'
            ]
        ).Html::activeTextInput(
                $searchModel,'dien_thoai',[
                    'class'=>'form-control',
                    'placeholder'=>'Điện thoại'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Người thực hiện',
        'attribute'=>'nguoi_thuc_hien',
        'headerOptions' => ['width' => '1%'],
        'filter' => Html::activeTextInput(
            $searchModel,'nguoi_thuc_hien',[
                'class'=>'form-control',
                'placeholder'=>'Thực hiện'
            ]
        )

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thang',
        'label' => 'Tháng',
        'headerOptions' => ['width' => '10%'],
        'value' => function ($data) {
            return '<span class="pull-left">'.$data->thang.'</span>';
        },
        'format'=>'raw',
//        'filter' => false
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nam',
        'label' => 'Năm',
        'headerOptions' => ['width' => '10%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'label' => 'Trạng thái',
        'headerOptions' => ['width' => '10%'],
        'filter' => Html::activeDropDownList(
            $searchModel,
            'trang_thai',
            [\backend\models\HoaDon::CHUA_THANH_TOAN => \backend\models\HoaDon::CHUA_THANH_TOAN, \backend\models\HoaDon::DA_THANH_TOAN => \backend\models\HoaDon::DA_THANH_TOAN],
            ['class' => 'form-control', 'prompt' => 'Tất cả']
        ),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header' => 'Xem',
        'value' => function($data) {
            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::toRoute(['hoa-don/view', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'select2']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header' => 'In',
        'value' => function($data) {
            return \yii\bootstrap\Html::a('<i class="fa fa-print"></i>','#', ['class'=>'btn-print','data-value'=>$data->id,'loai-in'=>'mot']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header' => 'Xóa',
        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function($data){
            if($data->active == 1)
                return \yii\bootstrap\Html::a('<i class="fa fa-ban"></i>', '#', ['class' => 'text-danger', 'data-value' => $data->id,'id'=>"btn-huy-hoa-don"]);
            return '';
        },
        'format' => 'raw'
    ]

];   