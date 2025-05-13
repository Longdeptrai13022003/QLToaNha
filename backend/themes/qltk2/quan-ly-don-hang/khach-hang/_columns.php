<?php

use common\models\myAPI;
use backend\models\Vaitrouser;
use yii\helpers\Url;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Chọn',
        'headerOptions' => ['width' => '1%'],
        'attribute'=>'da_chon_thuc_hien_chuc_nang',
        'value' => function($data){
            return \yii\bootstrap\Html::checkbox('chon['.$data->id.']', $data->da_chon_thuc_hien_chuc_nang == 1, ['class' => 'chon-don-hang', 'value' => $data->id]);
        },
        'contentOptions' => ['class' => 'td-chon text-center'],
        'format' => 'raw'
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ảnh SP',
        'attribute'=>'anh_don_hang',
        'value' => function($data){
            $imageUrl = strpos($data->anh_don_hang, ']') !== false ? json_decode($data->anh_don_hang) : $data->anh_don_hang;
            if(!is_array($imageUrl))
                return \yii\helpers\Html::a(
                    \yii\helpers\Html::img($imageUrl, ['width' => '100px']),
                    $imageUrl, ['target' => '_blank', 'class' => 'link-anh-don-hang']
                );
            else{
                $imageUrlStr = '';
                foreach ($imageUrl as $item)
                    $imageUrlStr .= '<div class="col-md-4"><img class="img-responsive img-thumbnail" src="'.$item.'" width="50px" /></div>';
                return '<div class="row">'.$imageUrlStr.'</div>';
            }
        },
        'format' => 'raw'
    ],


    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin đặt hàng',
        'attribute'=>'hoten',
        'headerOptions' => ['width' => '1%'],
        'value' => function($data){
            return implode('',[
                '<p><i class="fa fa-code"></i> <strong>Mã đơn: </strong><span class="badge badge-success">'.$data->id.'</span></p>',
                '<p><i class="fa fa-user"></i> <strong>Họ tên: </strong>'.$data->hoten.'</p>',
                '</p><i class="fa fa-phone"></i> <strong>ĐT: </strong>'.$data->dien_thoai.'</p>',
                '<div class="divider"></div>',
                '<i class="fa fa-calendar"></i> '.date("d/m/Y H:i:s", strtotime($data->created))
            ]);
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'id', [
                    'class' => 'form-control',
                    'placeholder' => 'Mã đơn'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'hoten', [
                    'class' => 'form-control',
                    'placeholder' => 'Tên KH'
                ]
            ).\yii\helpers\Html::activeTextInput(
                $searchModel, 'dien_thoai', [
                    'class' => 'form-control',
                    'placeholder' => 'ĐT KH'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Điểm nhận hàng',
        'headerOptions' => ['width' => '3%'],
        'value' => function($data){
            return implode('', [
                '<p><strong>Địa chỉ: </strong><span>'.$data->thong_tin_dia_chi.'</span></p>',
                '<p><strong>Người nhận: </strong><span>'.$data->ho_ten_nguoi_nhan.'</span></p>',
                '<p><strong>ĐT nhận: </strong><span>'.$data->dien_thoai_nguoi_nhan.'</span></p>',
            ]);
        },
        'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'created_from', [
                    'class' => 'form-control',
                    'placeholder' => 'Ngày đặt từ..',
                    'id' => 'ngay-dat-tu'
                ]
            ).\yii\bootstrap\Html::activeTextInput(
                $searchModel, 'created', [
                    'class' => 'form-control',
                    'id' => 'ngay-dat-den',
                    'placeholder' => 'đến...'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Kiện hàng',
        'headerOptions' => ['width' => '10%'],
        'attribute'=>'phuong_thuc_giao_hang',
        'value' => function($data){
            return implode('', (
                myAPI::isAccess2('QuanLyDonHang', 'Change-status-don-hang') ||
                myAPI::isAccess2('QuanLyDonHang', 'Update-ma-van-don') ||
                myAPI::isAccess2('QuanLyDonHang', 'Sua-khoi-luong')
            ) ? array_filter([
                '<div class="thong-bao"></div>',
                myAPI::isAccess2('QuanLyDonHang', 'Change-status-don-hang') ? \yii\bootstrap\Html::label('Trạng thái: ').\yii\bootstrap\Html::dropDownList(
                    'TrangThaiDonHang['.$data->id.']',
                    $data->trang_thai,
                    \backend\models\DonHang::$listTrangThaiDonHang,
                    ['class' => 'form-control change-trang-thai-don-hang', 'data-value' => $data->id, 'empty' => '']
                ) : '',
                myAPI::isAccess2('QuanLyDonHang', 'Sua-phi-mua-ho') ? \yii\bootstrap\Html::label('Phí mua hộ: ').\yii\bootstrap\Html::textInput(
                    'muaHo['.$data->id.']',
                    $data->phi_mua_hang,
                    ['class' => 'form-control mua-ho-input', 'data-value' => $data->id, 'placeholder' => 'Phí mua hộ']
                ) : ''
            ]) : array_filter([
                '<p class="status-don-hang">'.$data->trang_thai.'</p>',
                '<p>Mã VĐ: '.$data->ma_van_don.'</p>',
                '<p>Cân nặng: '.$data->khoi_luong.' '.$data->dvt_khoi_luong.'</p>'
            ]));
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Vận chuyển',
        'headerOptions' => ['width' => '10%'],
        'attribute'=>'phuong_thuc_giao_hang',
        'value' => function($data){
            return implode('', (
                myAPI::isAccess2('QuanLyDonHang', 'Change-status-don-hang') ||
                myAPI::isAccess2('QuanLyDonHang', 'Update-ma-van-don') ||
                myAPI::isAccess2('QuanLyDonHang', 'Sua-khoi-luong')
            ) ? array_filter([
                '<div class="thong-bao"></div>',

                myAPI::isAccess2('QuanLyDonHang', 'Update-ma-van-don') ? \yii\bootstrap\Html::label('Mã VĐ: ').\yii\bootstrap\Html::textInput(
                    'maVanDon['.$data->id.']',
                    $data->ma_van_don,
                    ['class' => 'form-control ma-van-don-input', 'data-value' => $data->id, 'placeholder' => 'Mã vận đơn']
                ) : '',
                myAPI::isAccess2('QuanLyDonHang', 'Sua-khoi-luong') ? \yii\bootstrap\Html::label('Khối lượng: ').\yii\bootstrap\Html::textInput(
                    'khoiLuong['.$data->id.']',
                    $data->khoi_luong,
                    ['class' => 'form-control khoi-luong-input', 'data-value' => $data->id, 'placeholder' => 'Khối lượng (kg)']
                ) : '',
                myAPI::isAccess2('QuanLyDonHang', 'Update-van-chuyen-noi-dia') ? \yii\bootstrap\Html::label('VC nội địa (NDT): ').\yii\bootstrap\Html::textInput(
                    'vanChuyenNoiDia['.$data->id.']',
                    $data->ship_noi_dia_cny,
                    ['class' => 'form-control ship-noi-dia-input', 'data-value' => $data->id, 'placeholder' => 'VC nội địa (NDT)']
                ) : '',
            ]) : array_filter([
                '<p><strong>Mã VĐ:</strong> '.$data->ma_van_don.'</p>',
                '<p><strong>Cân nặng:</strong> '.$data->khoi_luong.' '.$data->dvt_khoi_luong.'</p>',
                '<p><strong>Ship NĐ:</strong> '.$data->ship_noi_dia_vnd.' <span class="text-grey">VNĐ</span><br/><span class="text-grey">'.$data->ship_noi_dia_cny.' NDT</span></p>',
            ]));
        },
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Chi phí',
        'headerOptions' => ['width' => '3%'],
        'contentOptions' => ['class' => 'text-right'],
        'value' => function($data){
            /** @var $data \backend\models\QuanLyDonHang */
            $tr = '<tr><td><strong>Tiền hàng: </strong></td> <td><span class="h5 text-danger"><strong>'.number_format($data->tong_tien, 0, '', '.').'</strong></span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span><br/><span class="text-grey">'.number_format($data->tong_tien_cny, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">NDT</span></span></td></tr>';
            $tr .= '<tr><td><strong>Mua hộ: </strong></td> <td><span class="h5">'.number_format($data->phi_mua_hang, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $tr .= '<tr><td><strong>Ship NĐ: </strong></td> <td><span class="h5">'.number_format($data->ship_noi_dia_vnd, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span><br/><span class="text-grey">'.number_format($data->ship_noi_dia_cny, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">NDT</span></span></td></tr>';
            $tr .= '<tr><td><strong>Tiền cân: </strong></td> <td><span class="h5">'.number_format($data->phi_khoi_luong, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $str = '<table class="table-bordered table">'.$tr.'</table>';

            return $str;
        },
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Tài chính',
        'headerOptions' => ['width' => '3%'],
        'contentOptions' => ['class' => 'text-right'],
        'attribute'=>'thanh_tien',
        'value' => function($data){
            $tr = '<tr><td><strong>Thành tiền: </strong></td> <td><span class="h5 text-danger"><strong>'.number_format($data->thanh_tien, 0, '', '.').'</strong></span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $tr .= '<tr><td><strong>Đã TT: </strong></td> <td><span class="h5">'.number_format($data->da_thanh_toan, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $tr .= '<tr><td><strong>Còn lại: </strong></td> <td><span class="h5 '.($data->thanh_tien - $data->da_thanh_toan <= 0 ? 'text-success' : 'text-danger').'">'.number_format($data->thanh_tien - $data->da_thanh_toan, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
            $str = '<table class="table-bordered table">'.$tr.'</table>';

            return $str;
        },
        'format' => 'raw'
    ],

    [
        'value' => function($data){
            return implode('', array_filter(
                [
                    '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-eye"></i> Xem','#', ['class' => 'text-primary btn-xem-chi-tiet-don-hang', 'data-value' => $data->id]).'</p>',
                    myAPI::isAccess2('QuanLyDonHang', 'Thanh-toan-them-don-hang') ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-money"></i> Thanh toán','#', ['class' => 'text-warning thanh-toan-don-hang', 'data-value' => $data->id]).'</p>' : '',
                    myAPI::isAccess2('QuanLyDonHang', 'Delete-don-hang') && $data->trang_thai === 'Chờ mua' || $data->trang_thai === 'Đơn hàng chờ'  ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-trash"></i> Xoá', '#', ['class' => 'text-danger btn-xoa-don-hang', 'data-value' => $data->id]).'</p>' : ''
                ]
            ));
        },
        'label' => 'Chức năng',
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center', 'width' => '3%']
    ],
];
