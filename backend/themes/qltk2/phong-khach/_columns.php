<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $searchModel \backend\models\search\QuanLyPhongKhachSearch*/

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center align-middle']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Mã hợp đồng',
        'attribute'=>'ma_hop_dong',
        'headerOptions' => ['width' => '1%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'filter' => \yii\helpers\Html::activeTextInput(
            $searchModel, 'ma_hop_dong', [
                'class' => 'form-control',
                'placeholder' => 'Mã HĐ'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Khách hàng',
        'attribute'=>'khach_hang_id',
        'headerOptions' => ['width' => '20%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($data) {
            return '<strong>'.$data->hoten.'</strong>'.' <span>(<i class="fa fa-phone"></i> '.$data->dien_thoai.')</span>';
        },
        'format'=>'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
            $searchModel, 'hoten', [
                'class' => 'form-control',
                'placeholder' => 'Tên khách'
            ]
        ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai', [
                    'class' => 'form-control',
                    'placeholder' => 'Điện thoại'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Sale',
        'attribute'=>'sale_id',
        'headerOptions' => ['width' => '20%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'align-middle'],
        'value' => function ($data) {
            return $data->hoten_sale == null ? '' : '<strong>'.$data->hoten_sale.'</strong> (<i class="fa fa-phone"></i> '.$data->dien_thoai_sale.')';
        },
        'format'=>'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
            $searchModel, 'hoten_sale', [
                'class' => 'form-control',
                'placeholder' => 'Tên sale'
            ]
        ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai_sale', [
                    'class' => 'form-control',
                    'placeholder' => 'Điện thoại sale'
                ]
            )
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Phí MG',
//        'attribute'=>'so_tien_moi_gioi',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.number_format($data->so_tien_moi_gioi, 0, ',', '.').'</span>';
//        },
//        'format'=>'raw',
//        'filter' => false
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Đã TT MG',
//        'attribute'=>'da_thanh_toan_moi_gioi',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.number_format($data->da_thanh_toan_moi_gioi, 0, ',', '.').'</span>';
//        },
//        'format'=>'raw',
//        'filter' => false
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Phòng',
        'attribute'=>'phong_id',
        'headerOptions' => ['width' => '10%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function ($data) {
            return $data->ten_phong.'/'.$data->ten_toa_nha;
        },
        'format'=>'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'ten_phong', [
                    'class' => 'form-control',
                    'placeholder' => 'Số phòng'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'ten_toa_nha', [
                    'class' => 'form-control',
                    'placeholder' => 'Tên tòa nhà'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Đơn giá',
        'attribute'=>'don_gia',
        'headerOptions' => ['width' => '5%', 'class'=>'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function ($data) {
            return '<span class="pull-right">'.number_format($data->don_gia, 0, ',', '.').'</span>';
        },
        'format'=>'raw',
        'filter' => false
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thời gian hợp đồng',
        'attribute'=>'thoi_gian_hop_dong_tu',
        'headerOptions' => ['width' => 'auto', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function ($data) {
            $hienThiTu = DateTime::createFromFormat('Y-m-d H:i:s', $data->thoi_gian_hop_dong_tu)->format('d/m/Y');
            $hienThi = DateTime::createFromFormat('Y-m-d H:i:s', $data->thoi_gian_hop_dong_den)->format('d/m/Y');
            return 'Từ <strong>'.$hienThiTu.'</strong> đến <strong>'.$hienThi.'</strong>';
        },
        'format'=>'raw',
        'filter' => '<div class="row"><div class="col-md-6">'.Html::activeTextInput(
            $searchModel,'thoi_gian_hop_dong_tu',[
                'class'=>'form-control',
                'placeholder'=>'Từ-từ',
                'id'=>'thoi-gian-tu-tu'
                ]
            ).'</div><div class="col-md-6">'.Html::activeTextInput(
                $searchModel,'chiet_khau',[
                    'class'=>'form-control',
                    'placeholder'=>'Từ-đến',
                    'id'=>'thoi-gian-tu-den'
                ]
            ).'</div></div><div class="row"><div class="col-md-6">'.Html::activeTextInput(
                $searchModel,'thoi_gian_hop_dong_den',[
                    'class'=>'form-control',
                    'placeholder'=>'Đến-từ',
                    'id'=>'thoi-gian-den-tu'
                ]
            ).'</div><div class="col-md-6">'.Html::activeTextInput(
                $searchModel,'created',[
                    'class'=>'form-control',
                    'placeholder'=>'Đến-đến',
                    'id'=>'thoi-gian-den-den'
                ]
            ).'</div></div>'
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Số tháng',
//        'attribute'=>'so_thang_hop_dong',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.sprintf('%02d',$data->so_thang_hop_dong).'</span>';
//        },
//        'format'=>'raw',
//        'filter' => false
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Tiền CK',
//        'attribute'=>'so_tien_chiet_khau',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.number_format($data->so_tien_chiet_khau, 0, ',', '.').'</span>';
//        },
//        'format'=>'raw',
//        'filter' => false
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thành tiền',
        'attribute'=>'thanh_tien',
        'headerOptions' => ['width' => '1%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function ($data) {
            return '<span class="pull-right">'.number_format($data->thanh_tien, 0, ',', '.').'</span>';
        },
        'format'=>'raw',
        'filter' => false
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Đã TT',
//        'attribute'=>'thanh_tien',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.number_format($data->da_thanh_toan, 0, ',', '.').'</span>';
//        },
//        'format'=>'raw',
//        'filter' => Html::activeDropDownList(
//            $searchModel,
//            'coc_truoc',
//            [1 => 'Đã cọc', 0 => 'Chưa cọc'],
//            ['class' => 'form-control', 'prompt' => 'Tất cả']
//        ),
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Còn lại',
//        'attribute'=>'coc_truoc',
//        'headerOptions' => ['width' => '1%'],
//        'value' => function ($data) {
//            return '<span class="pull-right">'.number_format($data->thanh_tien - $data->da_thanh_toan, 0, ',', '.').'</span>';
//        },
//        'format'=>'raw',
//        'filter' => false
//    ],
    [
        'header' => 'Thanh toán',
        'value' => function($data) {
            return $data->thanh_tien == $data->da_thanh_toan ? '' : \yii\bootstrap\Html::a('<i class="fa fa-money"></i>',Url::toRoute(['phong-khach/thanh-toan', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'btn-purchase']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
//    [
//        'header' => 'TT MG',
//        'value' => function($data) {
//            return $data->so_tien_moi_gioi == $data->da_thanh_toan_moi_gioi ? '' : \yii\bootstrap\Html::a('<i class="fa fa-money"></i>',Url::toRoute(['phong-khach/thanh-toan-moi-gioi', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'btn-purchase']);
//        },
//        'format' => 'raw',
//        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
//        'contentOptions' => ['class' => 'text-center']
//    ],
    [
        'header' => 'Xem',
        'value' => function($data) {
            return Html::a('<i class="fa fa-eye"></i>',Url::toRoute(['phong-khach/view', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'btn-view']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
    [
        'header' => 'Sửa',
        'value' => function($data) {
            return Html::a('<i class="fa fa-edit"></i>','#', ['data-value'=>$data->id, 'data-pjax' => 0,'id'=>'btn-sua-hop-dong']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
    [
        'header' => 'Xác nhận',
        'value' => function($data) {
            return Html::a('Tháng trước','#',['class'=>'text-primary btn-hoan-thanh','data-value'=>$data->id,'loai'=>'truoc']).'<br/>'.
                Html::a('Tháng này','#',['class'=>'text-success btn-hoan-thanh','data-value'=>$data->id,'loai'=>'nay']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center align-middle'],
    ],
    [
        'header' => 'Xóa',
        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center align-middle'],
        'value' => function($data){
            if($data->active == 1)
                return Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger btn-xoa-hop-dong', 'data-value' => $data->id]);
            return '';
        },
        'format' => 'raw'
    ]

];   