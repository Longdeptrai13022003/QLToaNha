<?php
use yii\helpers\Url;
/* @var $searchModel backend\models\search\DanhMucSearch */
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'STT',
        'headerOptions' => ['width' => '1%'],
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'headerOptions' => ['width' => '20%'],
        'filter' => \yii\helpers\Html::activeDropDownList(
            $searchModel, 'type',
            [
                \backend\models\DanhMuc::TOA_NHA => \backend\models\DanhMuc::TOA_NHA,
                \backend\models\DanhMuc::PHONG_O => \backend\models\DanhMuc::PHONG_O,
            ],
            ['class'=>'form-control','prompt'=>'Tất cả']
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'active',
        'headerOptions' => ['width' => '20%'],
        'label' => 'Toà nhà',
        'value' => function($data){
    /** @var \backend\models\DanhMuc $data */
            return $data->parent_id != '' ? \backend\models\DanhMuc::findOne($data->parent_id)->name : '';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'don_gia',
        'value' => function($data){
            return number_format($data->don_gia, 0, '', '.');
        },
        'contentOptions' => ['class' => 'text-right'],
        'headerOptions' => ['width' => '10%']
    ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::to(['get-lich-dat','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
        },
        'label' => 'Xem',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','width' => '1%'],
        'headerOptions' => ['class' => 'text-center','width' => '1%']
    ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-edit"></i>',Url::to(['update-toa-nha-phong-o','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
        },
        'label' => 'Sửa',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','width' => '1%'],
        'headerOptions' => ['class' => 'text-center','width' => '1%']
    ],
    [
        'header' => 'Xóa',
        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-trash"></i>','#', ['class' => 'text-danger','id'=>'xoa-phong','data-value'=>$data->id]);
        },
        'format' => 'raw'
    ]
];
