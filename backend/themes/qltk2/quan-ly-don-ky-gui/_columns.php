<?php

use common\models\myAPI;
use common\models\User;
use backend\models\KyGui;
use backend\models\DiaChiNhanHang;
use backend\models\Vaitrouser;
use yii\helpers\Url;

/* @var $searchModel backend\models\search\QuanLyDonKyGuiSearch */

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Chọn',
        'headerOptions' => ['width' => '1%'],
        'attribute'=>'da_chon_thuc_hien_chuc_nang',
        'value' => function($data){
            return \yii\bootstrap\Html::checkbox('chon['.$data->id.']', $data->da_chon_thuc_hien_chuc_nang == 1, ['class' => 'chon-don-ky-gui', 'value' => $data->id]);
        },
        'contentOptions' => ['class' => 'td-chon text-center'],
        'format' => 'raw'
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions' => ['width' => '1%'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin đơn ký gửi',
        'attribute'=>'id',
        'headerOptions' => ['width' => '25%'],
        'value' => function($data){
            return implode('',[
                '<p><i class="fa fa-code"></i> <strong>KG:</strong><span class="badge badge-success">'.$data->id.'</span></p>',
                '</p><i class="fa fa-code"></i><strong>Mã vận đơn: </strong>'.$data->field_ma_van_don_ky_gui.'</p>',
                '<p><i class="fa fa-road"></i> <strong>Tuyến VC: </strong>'.$data->ten_tuyen_van_chuyen.'</p>',
                '<p><i class="fa fa-forward"></i> <strong>Line VC: </strong>'.$data->line.'</p>',
                '<p><i class="fa fa-balance-scale"></i> <strong>Khối lượng: </strong>'.$data->field_khoi_luong." ".$data->field_dvt_khoi_luong.'</p>',
                '<p><i class="fa fa-money"></i> <strong>Thành tiền: </strong><span>'.number_format($data->field_thanh_tien, 0, ',', '.')." VNĐ".'</span></p>',
            ]);
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'id', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Mã đơn ký gửi'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'field_ma_van_don_ky_gui', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Mã vận đơn'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin khách hàng',
        'attribute'=>'user_id',
        'headerOptions' => ['width' => '25%'],
        'value' => function($data){
            return implode('',[
                '<p><i class="fa fa-code"></i> <strong>Mã KH:</strong><span>'.$data->user_id.'</span></p>',
                '<p><i class="fa fa-user"></i> <strong>KH: </strong>'.$data->hoten.'</p>',
                '</p><i class="fa fa-phone"></i> <strong>Điện thoại: </strong>'.$data->dien_thoai.'</p>',
                '<div class="divider"></div>',
                '<i class="fa fa-calendar"></i> '.date("d/m/Y H:i:s", strtotime($data->created))
            ]);
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'user_id', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Mã KH'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'hoten', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Tên KH'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'ĐT KH'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'created_from', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Ngày đặt từ..',
                    'id' => 'ngay-dat-tu'
                ]
            ).\yii\bootstrap\Html::activeTextInput(
                $searchModel, 'created', [
                    'class' => 'form-control hidden',
                    'id' => 'ngay-dat-den',
                    'placeholder' => 'đến...'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Đơn ký gửi',
        'headerOptions' => ['width' => '20%'],
        'attribute'=>'field_trang_thai',
        'value' => function ($data) {
            $isAccess = myAPI::isAccess2('QuanLyDonKyGui', 'Change-status-don-ky-gui');
            $content = [
                '<div class="thong-bao"></div>',
                $isAccess ? \yii\bootstrap\Html::label('Trạng thái: ').\yii\bootstrap\Html::dropDownList(
                        'TrangThaiDonKyGui['.$data->id.']',
                        $data->field_trang_thai,
                        \backend\models\KyGui::$listTrangThaiDonKyGui,
                        ['class' => 'form-control change-trang-thai-don-ky-gui', 'data-value' => $data->id, 'empty' => '']
                    ) : '',
                $data->field_trang_thai == 'Đơn hàng chờ' ? \yii\bootstrap\Html::label('Mã vận đơn: ').\yii\bootstrap\Html::textInput(
                        'maVanDon',
                        $data->field_ma_van_don_ky_gui,
                        [
                            'class' => 'form-control change-ma-van-don-ky-gui',
                            'data-value' => $data->id,
                        ]
                    ) : '',
                $data->field_trang_thai == 'Đơn hàng chờ' ? \yii\bootstrap\Html::label('Ghi chú: ').\yii\bootstrap\Html::textarea(
                        'maVanDon',
                        $data->field_ghi_chu,
                        [
                            'class' => 'form-control change-ghi-chu-don-ky-gui',
                            'data-value' => $data->id,
                        ]
                    ) : '',
            ];

            return implode('', array_filter($content));
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin thanh toán',
        'attribute'=>'field_so_tien_da_thanh_toan',
        'contentOptions' => ['class' => 'text-right'],
        'headerOptions' => ['width' => '20%'],
        'value' => function($data){
            $tr = '<tr><td><strong>Đã thanh toán: </strong></td> <td><span class="h5 text-danger"><strong>'.number_format($data->field_so_tien_da_thanh_toan, 0, '', '.').'</strong></span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span>';
            $tr .= '<tr><td><strong>Còn thiếu: </strong></td> <td><span class="h5">'.number_format($data->field_thanh_tien - $data->field_so_tien_da_thanh_toan, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $tr .= '<tr><td><strong>Tiền hoàn: </strong></td> <td><span class="h5">'.number_format(KyGui::find()->where(['id'=>$data->id])->select('field_so_tien_hoan_lai')->scalar(), 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span>';
            $str = '<table class="table-bordered table">'.$tr.'</table>';

            return $str;
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
            $searchModel, 'field_so_tien_da_thanh_toan', [
                'class' => 'form-control hidden',
                'placeholder' => 'Đã thanh toán'
            ]
        )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin vận chuyển',
        'headerOptions' => ['width' => '24%'],
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
                    'class' => 'form-control hidden',
                    'placeholder' => 'Họ tên người nhận'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai_nguoi_nhan', [
                    'class' => 'form-control hidden',
                    'placeholder' => 'Điện thoại người nhận'
                ]
            )
    ],
    [
        'value' => function($data){
            return implode('', array_filter(
                [
                    '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-eye"></i> Xem','#', ['class' => 'text-primary btn-xem-chi-tiet-don-ky-gui', 'data-value' => $data->id]).'</p>',
                    myAPI::isAccess2('QuanLyDonKyGui', 'Sua-don-ky-gui') && $data->field_trang_thai === KyGui::DON_HANG_CHO ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-pencil-square-o"></i> Sửa', '#', ['class' => 'text-primary btn-sua-don-ky-gui', 'data-value' => $data->id]).'</p>' : '',
                    myAPI::isAccess2('QuanLyDonKyGui', 'Delete-don-ky-gui') ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-trash"></i> Xoá', '#', ['class' => 'text-danger btn-xoa-don-ky-gui', 'data-value' => $data->id]).'</p>' : '',
                ]
            ));
        },
        'label' => 'Chức năng',
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center', 'width' => '7%'],
        'contentOptions' => ['class' => 'text-center']
    ],
];
