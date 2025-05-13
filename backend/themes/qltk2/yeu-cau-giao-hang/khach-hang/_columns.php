<?php

use common\models\myAPI;
use common\models\User;
use app\models\QuanLyPhieuYeuCauGiaoHang;
use backend\models\KyGui;
use backend\models\DiaChiNhanHang;
use backend\models\Vaitrouser;
use yii\helpers\Url;

/* @var $searchModel backend\models\search\QuanLyPhieuYeuCauGiaoHangSearch */

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions' => ['width' => '1%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin phiếu yêu cầu giao hàng',
        'attribute'=>'id',
        'headerOptions' => ['width' => '25%'],
        'value' => function ($data) {
            $html = '<p><i class="fa fa-code"></i> <strong>Mã phiếu:</strong><span class="badge badge-success">' . $data->id . '</span></p>';
            $html .= '<p><i class="fa fa-code"></i> <strong>Mã vận đơn: </strong>' . $data->field_ma_van_don . '</p>';
            $html .= '<p><i class="fa fa-truck"></i> <strong>Hình thức nhận hàng: </strong>' . $data->field_hinh_thuc_nhan_hang . '</p>';
            $html .= '<p><i class="fa fa-phone"></i> <strong>Số điện thoại nhà xe: </strong>' . $data->field_so_dien_thoai_nha_xe . '</p>';
            return $html;
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'id', [
                    'class' => 'form-control',
                    'placeholder' => 'Mã phiếu'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'field_ma_van_don', [
                    'class' => 'form-control',
                    'placeholder' => 'Mã vận đơn'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Địa chỉ nhận hàng',
        'headerOptions' => ['width' => '25%'],
        'value' => function($data){
            return implode('',[
                '<p><i class="fa fa-user"></i> <strong>Người nhận: </strong>'.$data->ho_ten_nguoi_nhan.'</p>',
                '</p><i class="fa fa-phone"></i> <strong>Điện thoại: </strong>'.$data->dien_thoai_nguoi_nhan.'</p>',
                '</p><i class="fa fa-address-book"></i> <strong>Địa chỉ: </strong>'.DiaChiNhanHang::find()->where(['id'=>$data->field_dia_chi_nhan_hang_id])->scalar().'</p>',
            ]);
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'ho_ten_nguoi_nhan', [
                    'class' => 'form-control',
                    'placeholder' => 'Họ tên người nhận'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai_nguoi_nhan', [
                    'class' => 'form-control',
                    'placeholder' => 'Điện thoại người nhận'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Chi phí',
        'headerOptions' => ['width' => '30%'],
        'value' => function ($data) {
            $tr = '<tr><td><p><strong>Phí giao hàng đến nhà xe: </strong> </td> <td class="text-right"><span class="h5 text-grey"><strong>' . number_format($data->field_phi_giao_hang_den_nha_xe, 0, '', '.') . '</strong></span> <span class="text-grey font-12px">VNĐ</span></p></td></tr>';
            $tr .= '<tr><td><p><strong>Phí đóng gói: </strong> </td> <td class="text-right"><span class="h5 text-grey"><strong>' . number_format($data->phi_dong_goi, 0, '', '.') . '</strong></span> <span class="text-grey font-12px">VNĐ</span></p></td></tr>';
            $tr .= '<tr><td><p><strong>Tổng tiền: </strong> </td> <td class="text-right"><span class="h5 text-danger"><strong>' . number_format($data->phi_dong_goi + $data->field_phi_giao_hang_den_nha_xe, 0, '', '.') . '</strong></span> <span class="text-grey font-12px">VNĐ</span></p></td></tr>';
            $tr .= '<tr><td><p><strong>Đã thanh toán: </strong> </td> <td class="text-right"><span class="h5 text-success"><strong>' . number_format($data->field_so_tien_da_thanh_toan, 0, '', '.') . '</strong></span> <span class="text-grey font-12px">VNĐ</span></p></td></tr>';
            $str = '<table class="table-bordered table">' . $tr . '</table>';

            return $str;
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'field_phi_giao_hang_den_nha_xe', [
                    'class' => 'form-control',
                    'placeholder' => 'Phí giao hàng đến nhà xe'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'phi_dong_goi', [
                    'class' => 'form-control',
                    'placeholder' => 'Phí đóng gói'
                ],

            )
    ],
    [
        'value' => function($data) {
            return implode('', array_filter(
                [
                    myAPI::isAccess2('YeuCauGiaoHang', 'Luu-ma-van-don-phieu-yeu-cau-giao') ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-ticket"></i> Nhập mã vận đơn', '#', ['class' => 'text-primary btn-nhap-ma-van-don', 'data-value' => $data->id]).'</p>' : '',
                    myAPI::isAccess2('YeuCauGiaoHang', 'Luu-sdt-nha-xe') && $data->field_hinh_thuc_nhan_hang === 'Gửi xe khách' ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-address-card-o"></i> Nhập SĐT nhà xe & chi phí khác', '#', ['style' => 'color: orange;' , 'class' => 'btn-luu-sdt-nha-xe', 'data-value' => $data->id]).'</p>' : '',
                    myAPI::isAccess2('YeuCauGiaoHang', 'Luu-sdt-nha-xe') && $data->field_hinh_thuc_nhan_hang === 'Chuyển phát nhanh' ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-credit-card-alt"></i> Nhập chi phí khác', '#', ['style' => 'color: orange;' , 'class' => 'btn-luu-chi-phi-khac', 'data-value' => $data->id]).'</p>' : '',
                ]
            ));
        },
        'label' => 'Chức năng',
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center', 'width' => '20%']
    ],
];
