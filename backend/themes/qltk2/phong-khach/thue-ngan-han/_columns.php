<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $searchModel \backend\models\search\QuanLyPhongSearch*/
/* @var $toanhaids [] */
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'headerOptions' => ['width' => '1%'],
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Phòng',
        'attribute'=>'name',
        'headerOptions' => ['width' => '1%'],
        'filter' => \yii\helpers\Html::activeTextInput(
            $searchModel, 'name', [
                'class' => 'form-control',
                'placeholder' => 'Phòng'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Tòa nhà',
        'attribute'=>'ten_toa_nha',
        'headerOptions' => ['width' => '1%'],
        'filter' => Html::activeDropDownList(
            $searchModel,
            'parent_id',
            $toanhaids,
            ['class' => 'form-control', 'prompt' => 'Tất cả']
        ),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Khách hàng',
        'attribute'=>'hoten',
        'headerOptions' => ['width' => 'auto'],
        'value' => function ($data) {
            return $data->hoten == null ? '' : $data->hoten.'<br/><i class="fa fa-phone"></i> '.$data->dien_thoai;
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
        'label' => 'Thời gian hợp đồng',
        'attribute'=>'thoi_gian_hop_dong_tu',
        'headerOptions' => ['width' => '1%'],
        'value' => function ($data) {
            if ($data->thoi_gian_hop_dong_tu == null){
                return '';
            }
            $hienThiTu = DateTime::createFromFormat('Y-m-d H:i:s', $data->thoi_gian_hop_dong_tu)->format('d/m/Y');
            $hienThi = DateTime::createFromFormat('Y-m-d H:i:s', $data->thoi_gian_hop_dong_den)->format('d/m/Y');
            return $data->hoten == null ? '' : 'Từ <strong>'.$hienThiTu.'</strong> đến <strong>'.$hienThi.'</strong>';
        },
        'format'=>'raw',
        'filter' => false
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Trạng thái',
        'attribute'=>'selected',
        'headerOptions' => ['width' => '1%'],
        'value' => function ($data) {
            return $data->selected == 0 ? '<span class="text-success">Đang chờ khách</span>' : '<span class="text-danger">Đang có khách</span>';
        },
        'format'=>'raw',
        'filter' => \yii\helpers\Html::activeDropDownList(
            $searchModel, 'selected',
            [
                0 => 'Chờ khách',
                1 => 'Có khách'
            ],
            [
                'class' => 'form-control',
                'placeholder' => 'Phòng',
                'prompt' => 'Tất cả'
            ]
        )
    ],
    [
        'header' => 'Chọn',
        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($data) {
            return $data->selected == 0 ? '<input type="checkbox" name="phong-id[]" class="check-chon" loai="mo" style="transform: scale(1.5);" value="'.$data->id.'">' : '';
        },
        'format'=>'raw',
    ],
    [
        'header' => 'Chọn',
        'headerOptions' => ['class' => 'text-center', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($data) {
            return $data->selected == 1 ? '<input type="checkbox" name="phong-id[]" class="check-chon" loai="dong" style="transform: scale(1.5);" value="'.$data->id.'">' : '';
        },
        'format'=>'raw',
    ],
];
