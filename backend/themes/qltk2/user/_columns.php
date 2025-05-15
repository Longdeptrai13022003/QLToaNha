<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $searchModel Backend\models\search\QuanLyUserSearch */

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary text-center align-middle', 'width' => '3%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ảnh đại diện',
        'attribute'=>'anhdaidien',
        'headerOptions' => ['width' => '1%'],
        'value' => function ($data) {
            $domain = \backend\models\CauHinh::findOne(['ghi_chu' => 'domain'])->content;
            return \yii\helpers\Html::img($data->anhdaidien == '' ? $domain.'/hinh-anh/no-image.jpg' : $domain.'/hinh-anh/'.$data->anhdaidien,[
                'width' => '150px',
                'class' => 'img-thumbnail',
                'id' => 'hinh-anh'
            ]);
        },
        'format'=>'raw',
        'filter'=>false
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Họ tên',
        'attribute' => 'hoten',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '20%'],
        'contentOptions' => ['class' => 'align-middle'],
        'filter' => Html::activeTextInput(
            $searchModel, 'hoten', [
                'class' => 'form-control',
                'placeholder' => 'Họ tên'
            ]
        )
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Điện thoại',
        'attribute' => 'dien_thoai',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '10%'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($model) {
            return '<i class="fa fa-phone"></i> ' . $model->dien_thoai;
        },
        'filter' => Html::activeTextInput(
            $searchModel, 'dien_thoai', [
                'class' => 'form-control',
                'placeholder' => 'Điện thoại KH'
            ]
        ),
        'format' => 'raw',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Tên đăng nhập',
        'attribute' => 'username',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '20%'],
        'contentOptions' => ['class' => 'align-middle'],
        'filter' => Html::activeTextInput(
            $searchModel, 'username', [
                'class' => 'form-control',
                'placeholder' => 'Tên đăng nhập'
            ]
        )
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Email',
        'attribute' => 'email',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => 'auto'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($model) {
            $email = $model->email ? $model->email : 'Chưa có email';
            return '<i class="fa fa-envelope"></i> ' . $email;
        },
        'filter' => Html::activeTextInput(
            $searchModel, 'email', [
                'class' => 'form-control',
                'placeholder' => 'Email'
            ]
        ),
        'format' => 'raw',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Vai trò',
        'attribute' => 'vai_tro',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '10%'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($data) {
            $roles = explode(',', $data->vai_tro);
            $roleLines = array_map('trim', $roles);
            return '<i class="fa fa-user-tag"></i> ' . implode('<br>', $roleLines);
        },
        'format' => 'raw',
        'filter' => Html::dropDownList(
            'QuanLyUserSearch[vai_tro]',
            $searchModel->vai_tro,
            \backend\models\VaiTro::$arr_vai_tro,
            [
                'class' => 'form-control',
                'prompt' => 'Tất cả'
            ]
        )
    ],
    [
        'header' => 'Sửa',
        'value' => function($data) {
            return \yii\bootstrap\Html::a(
                '<i class="fa fa-edit"></i>',
                Url::toRoute(['user/update', 'id' => $data->id]),
                [
                    'class' => 'text-primary btn-sm',
                    'role' => 'modal-remote',
                    'data-toggle' => 'tooltip',
                    'title' => 'Sửa thông tin'
                ]
            );
        },
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '5%'],
        'contentOptions' => ['class' => 'text-center align-middle']
    ],
    [
        'header' => 'Xóa',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '5%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function($data){
            if ($data->status == 10) {
                return \yii\bootstrap\Html::a(
                    '<i class="fa fa-trash"></i>',
                    '#',
                    [
                        'class' => 'text-danger btn-sm btn-huy-khoi-phuc-hoat-dong',
                        'data-value' => $data->id,
                        'data-toggle' => 'tooltip',
                        'title' => 'Xóa thông tin',
                    ]
                );
            }
            return '';
        },
        'format' => 'raw',
    ]
];
?>