<?php
use yii\helpers\Url;
use \yii\helpers\Html;
/* @var $searchModel backend\models\search\QuanLyPhongSearch */
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
        'headerOptions' => ['width' => '1%'],
        'label' => 'Tên phòng',
        'filter' => Html::activeTextInput(
            $searchModel, 'name',
            ['class' => 'form-control']
        ),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'selected',
        'headerOptions' => ['width' => '20%'],
        'label' => 'Trạng thái',
        'filter' => Html::activeDropDownList(
            $searchModel, 'selected',
            [
                3 => 'Có khách',
                1 => 'Đang đợi khách',
                2 => 'Sắp hết hạn'
            ],
            ['class' => 'form-control','prompt'=>'Tất cả']
        ),
        'value' => function ($data) {
            if(is_null($data->ma_hop_dong)){
                return '<center><span class="text-primary">Đang đợi khách</span></center>';
            }else{
                $inputTime = strtotime($data->thoi_gian_hop_dong_den);
                $limitTime = strtotime("+1 month +30 days");
                $currentTime = time();

                if($inputTime > $limitTime){
                    return '<center><span class="text-success">Có khách</span><br><span class="text-primary">Thời hạn: '.date('d/m/Y H:i:s', strtotime($data->thoi_gian_hop_dong_den)).'</span></center>';
                }else{
                    $daysLeft = ceil(($inputTime - $currentTime) / (60 * 60 * 24)) + 1;
                    return '<center><span class="text-danger">Sắp hết hạn</span></br><span class="text-primary">Còn '.$daysLeft.' ngày</span></center>';
                }
            }
        },
        'format'=>'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Khách hàng',
        'attribute'=>'hoten',
        'headerOptions' => ['width' => 'auto'],
        'value' => function ($data) {
            return $data->ma_hop_dong == null ? '' : $data->hoten.' <i class="fa fa-phone"></i> '.$data->dien_thoai;
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
        'attribute'=>'ma_hop_dong',
        'headerOptions' => ['width' => '10%'],
        'label' => 'Mã hợp đồng',
        'filter' => Html::activeTextInput(
            $searchModel, 'name',
            ['class' => 'form-control']
        ),
    ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::to(['get-lich-dat','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
        },
        'label' => 'Chi tiết',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','width' => '1%'],
        'headerOptions' => ['class' => 'text-center','width' => '1%']
    ],
];
