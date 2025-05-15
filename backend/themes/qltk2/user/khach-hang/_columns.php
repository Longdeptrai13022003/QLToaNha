<?php
//use yii\helpers\Url;
///* @var $searchModel \backend\models\search\QuanLyKhachHangSearch */
//
//return [
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'header' => 'STT',
//        'headerOptions' => ['class' => 'text-primary', 'width' => '1%']
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Ảnh đại diện',
//        'attribute'=>'anhdaidien',
//        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
//        'contentOptions' => ['class' => 'text-center'],
//        'value' => function ($model) {
//            $imageWebPath = Yii::getAlias('@web/hinh-anh/') . $model->anhdaidien;
//            $imageFilePath = Yii::getAlias('@webroot/hinh-anh/') . $model->anhdaidien;
//            return is_file($imageFilePath) ? \yii\helpers\Html::img($imageWebPath, ['width' => '100px', 'id' => 'hinh-anh', 'class' => 'img-thumbnail']) : '';
//        },
//        'format'=>'raw',
//        'filter'=>false
//    ],
//
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Họ tên',
//        'attribute'=>'hoten',
//        'headerOptions' => ['width' => 'auto'],
//        'filter' => \yii\helpers\Html::activeTextInput(
//            $searchModel, 'hoten', [
//                'class' => 'form-control',
//                'placeholder' => 'Họ tên'
//            ]
//        )
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Số CCCD',
//        'attribute'=>'so_cccd',
//        'headerOptions' => ['width' => '10%'],
//        'filter' => \yii\helpers\Html::activeTextInput(
//            $searchModel, 'so_cccd', [
//                'class' => 'form-control',
//                'placeholder' => 'Số CCCD KH'
//            ]
//        )
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Điện thoại',
//        'attribute'=>'dien_thoai',
//        'headerOptions' => ['width' => '10%'],
//        'filter' => \yii\helpers\Html::activeTextInput(
//            $searchModel, 'dien_thoai', [
//                'class' => 'form-control',
//                'placeholder' => 'Điện thoại KH'
//            ]
//        )
//    ],
////    [
////        'class'=>'\kartik\grid\DataColumn',
////        'label' => 'Tên đăng nhập',
////        'headerOptions' => ['width' => '1%'],
////        'attribute'=>'username',
////        'filter' => \yii\helpers\Html::activeTextInput(
////            $searchModel, 'username', [
////                'class' => 'form-control',
////                'placeholder' => 'Tên đăng nhập'
////            ]
////        )
////    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Email',
//        'headerOptions' => ['width' => '10%'],
//        'attribute'=>'email',
//        'filter' => \yii\helpers\Html::activeTextInput(
//            $searchModel, 'email', [
//                'class' => 'form-control',
//                'placeholder' => 'Email'
//            ]
//        )
//    ],
//    [
//        'header' => 'Xem',
//        'value' => function($data) {
//            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::toRoute(['user/view', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'select2']);
//        },
//        'format' => 'raw',
//        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
//        'contentOptions' => ['class' => 'text-center']
//    ],
//    [
//        'header' => 'Sửa',
//        'value' => function($data) {
//            return \yii\bootstrap\Html::a('<i class="fa fa-edit"></i>',Url::toRoute(['user/update-khach-hang', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'select2']);
//        },
//        'format' => 'raw',
//        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
//        'contentOptions' => ['class' => 'text-center']
//    ],
//    [
//        'header' => 'Huỷ',
//        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
//        'contentOptions' => ['class' => 'text-center'],
//        'value' => function($data){
//            if($data->status == 10)
//                return \yii\bootstrap\Html::a('<i class="fa fa-ban"></i>', '#', ['class' => 'text-danger btn-huy-khoi-phuc-hoat-dong', 'data-value' => $data->id]);
//            return '';
//        },
//        'format' => 'raw'
//    ]
//];
//?>
<!---->
<?php
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $searchModel \backend\models\search\QuanLyKhachHangSearch */

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary text-center align-middle', 'width' => '3%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Ảnh đại diện',
        'attribute' => 'anhdaidien',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '8%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function ($model) {
            $imageWebPath = Yii::getAlias('@web/hinh-anh/') . $model->anhdaidien;
            $imageFilePath = Yii::getAlias('@webroot/hinh-anh/') . $model->anhdaidien;
            return is_file($imageFilePath)
                ? Html::img($imageWebPath, [
                    'style' => 'max-width:80px;',
                    'class' => 'img-thumbnail img-fluid',
                    'id' => 'hinh-anh'
                ])
                : '';
        },
        'format' => 'raw',
        'filter' => false
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
        'label' => 'Căn cước công dân',
        'attribute' => 'so_cccd',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '15%'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($model) {
            return empty($model->so_cccd) ? '' : '<i class="fa fa-id-card"></i> ' . $model->so_cccd;
        },
        'filter' => Html::activeTextInput(
            $searchModel, 'so_cccd', [
                'class' => 'form-control',
                'placeholder' => 'Số CCCD KH'
            ]
        ),
        'format' => 'raw',
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
        'header' => 'Xem',
        'value' => function($data) {
            return \yii\bootstrap\Html::a(
                '<i class="fa fa-eye"></i>', // Icon Xem
                Url::toRoute(['user/view', 'id' => $data->id]),
                ['class' => 'btn', 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Xem thông tin']
            );
        },
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '5%'],
        'contentOptions' => ['class' => 'text-center align-middle']
    ],
    [
        'header' => 'Sửa',
        'value' => function($data) {
            return \yii\bootstrap\Html::a(
                '<i class="fa fa-edit"></i>', // Icon Sửa
                Url::toRoute(['user/update-khach-hang', 'id' => $data->id]),
                ['class' => 'btn btn-sm', 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Sửa thông tin']
            );
        },
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center align-middle', 'width' => '5%'],
        'contentOptions' => ['class' => 'text-center align-middle']
    ],
    [
        'header' => 'Xóa',
        'headerOptions' => ['class' => 'text-center', 'width' => '5%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function($data){
            if ($data->status == 10) {
                return \yii\bootstrap\Html::a(
                    '<i class="fa fa-trash"></i>',
                    '#',
                    [
                        'class' => 'btn text-danger btn-sm btn-huy-khoi-phuc-hoat-dong',
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
