<?php

/* @var $searchModel \backend\models\search\QuanLyGiaoDichSearch*/

use backend\models\GiaoDich;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_hop_dong',
        'label' => 'Hợp đồng',
        'headerOptions' => ['width' => '1%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_hoa_don',
        'label' => 'Hóa đơn',
        'headerOptions' => ['width' => '1%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_phong',
        'label' => 'Phòng',
        'headerOptions' => ['width' => '8%'],
        'value' => function($data) {
            return $data->ten_phong.'/'.$data->ten_toa_nha;
        },
        'format' => 'raw',
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
        'attribute'=>'hoten',
        'label' => 'Khách hàng',
        'headerOptions' => ['width' => 'auto'],
        'value' => function($data) {
            return '<strong>'.$data->hoten. '</strong> (<i class="fa fa-phone"></i> '.$data->dien_thoai.')';
        },
        'format' => 'raw',
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
        'attribute'=>'created',
        'label' => 'Ngày thực hiện',
        'headerOptions' => ['width' => '1%'],
        'value' => function($data) {
            $parts = explode(' ',$data->created);
            return '<center>'.implode('/',array_reverse(explode('-',$parts[0]))).'</center>';
        },
        'format' => 'raw',
        'filter' => Html::activeTextInput(
                $searchModel,'created',[
                    'class'=>'form-control',
                    'placeholder'=>'Thời gian từ',
                    'id'=>'thoi-gian-tu'
                ]
            ).Html::activeTextInput(
                $searchModel,'ghi_chu',[
                    'class'=>'form-control',
                    'placeholder'=>'Thời gian đến',
                    'id'=>'thoi-gian-den'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nguoi_thuc_hien',
        'label' => 'Người thực hiện',
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
        'attribute'=>'tong_tien',
        'label' => 'Số tiền',
        'headerOptions' => ['width' => '1%'],
        'value' => function($data) {
            return '<div class = "pull-right">'.number_format($data->tong_tien,0,',','.').'</div>';
        },
        'format' => 'raw',
        'filter' => false
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai_giao_dich',
        'label' => 'Trạng thái',
        'headerOptions' => ['width' => '1%'],
        'value' => function($data) {
            if ($data->trang_thai_giao_dich == GiaoDich::THANH_CONG)
                return '<span class="text-success"><i class="fa fa-check-circle"></i> '.GiaoDich::THANH_CONG.'</span>';
            elseif ($data->trang_thai_giao_dich == GiaoDich::KHONG_THANH_CONG)
                return '<span class="text-danger"><i class="fa fa-ban"></i> '.GiaoDich::KHONG_THANH_CONG.'</span>';
            else
                return '<span class="text-warning"><i class="fa fa-refresh"></i> '.GiaoDich::KHOI_TAO.'</span>';
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeDropDownList(
            $searchModel,
            'trang_thai_giao_dich',
            [
                GiaoDich::KHOI_TAO=>GiaoDich::KHOI_TAO,
//                GiaoDich::CHO_XAC_MINH=>GiaoDich::CHO_XAC_MINH,
                GiaoDich::THANH_CONG=>GiaoDich::THANH_CONG,
                GiaoDich::KHONG_THANH_CONG=>GiaoDich::KHONG_THANH_CONG,
//                GiaoDich::CHO_DUYET_HUY=>GiaoDich::CHO_DUYET_HUY,
//                GiaoDich::DA_HUY=>GiaoDich::DA_HUY
            ],
            ['class'=>'form-control','prompt' => 'Tất cả']
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_id_casso',
        'label' => 'Loại giao dịch',
        'headerOptions' => ['width' => '1%'],
        'value' => function($data) {
            return $data->hoa_don_id == null ? 'Giao dịch hợp đồng' : 'Giao dịch hóa đơn';
        },
        'format' => 'raw',
        'filter' => false
//        'filter' => \yii\helpers\Html::activeDropDownList(
//            $searchModel,
//            'ma_id_casso',
//            [
//                1 => 'Giao dịch hợp đồng',
//                0 => 'Giao dịch hóa đơn'
//            ],
//            ['class'=>'form-control','prompt' => 'Tất cả']
//        )
    ],
    [
        'header' => 'Xem',
        'value' => function($data) {
            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::toRoute(['giao-dich/view', 'id' => $data->id]), ['role' => 'modal-remote', 'data-toggle' => 'tooltip','id'=>'select2']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Duyệt',
        'value' => function($data) {
            return $data->trang_thai_giao_dich != GiaoDich::KHOI_TAO ? '' : Html::a('<i class="fa fa-check-circle"></i> Duyệt','#',['class'=>'btn-duyet-trang-thai text-success pull-left','data-pjax' => 0,'data-value'=>$data->id,'loai'=>1]).'<br/>'.
                Html::a('<i class="fa fa-ban"></i> Hủy','#',['class'=>'btn-duyet-trang-thai text-danger pull-left','data-pjax' => 0,'data-value'=>$data->id,'loai'=>0]);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Gửi tin',
        'value' => function($data) {
            return $data->trang_thai_giao_dich != GiaoDich::KHOI_TAO ? '' : Html::a('<i class="fa fa-send"></i>','#',['class'=>'text-primary text-center btn-gui-tin','data-pjax' => 0,'data-value'=>$data->id]);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Hủy',
        'value' => function($data) {
            return $data->trang_thai_giao_dich != GiaoDich::KHOI_TAO ? '' : \yii\bootstrap\Html::a('<i class="fa fa-trash"></i>','#', ['class' => 'text-danger','id'=>'btn-huy-giao-dich','data-value'=>$data->id]);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center']
    ],
];