<?php
use yii\helpers\Url;
use common\models\myAPI;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($data) {
            return [
                'class' => 'chon-thanh-toan',
                'value' => $data->id,
                'checked' => $data->da_chon_de_thanh_toan == 1,
            ];
        },
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ảnh SP',
        'headerOptions' => ['width' => '3%'],
        'attribute'=>'anh_don_hang',
        'value' => function($data){
            $imageUrl = strpos($data->anh_don_hang, ']') !== false ? json_decode($data->anh_don_hang) : $data->anh_don_hang;
            $imageUrl = is_array($imageUrl) ? (count($imageUrl) > 0 ? $imageUrl[0] : '') : $imageUrl;
          return \yii\helpers\Html::a(
            \yii\helpers\Html::img($imageUrl, ['width' => '100px']),
              $imageUrl, ['target' => '_blank', 'class' => 'link-anh-don-hang']
          );
        },
      'format' => 'raw',
        'filter' => \yii\helpers\Html::activeTextInput(
                $searchModel, 'hoten', [
                    'class' => 'form-control',
                    'placeholder' => 'Họ tên',
                ]
            ).\yii\bootstrap\Html::activeTextInput(
                $searchModel, 'dien_thoai', [
                    'class' => 'form-control',
                    'placeholder' => 'Điện thoại'
                ]
            )
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Thông tin đặt hàng',
        'attribute'=>'hoten',
        'value' => function($data){
            return implode('',[
                '<p><i class="fa fa-code"></i> <strong>Mã khách hàng: </strong><span class="badge badge-success">'.$data->user_id_goc.'</span></p>',
                '<p><i class="fa fa-user"></i> <strong>Họ tên: </strong>'.$data->hoten.'</p>',
                '</p><i class="fa fa-phone"></i> <strong>ĐT: </strong>'.$data->dien_thoai.'</p>',
                '<div class="divider"></div>',
                '<i class="fa fa-calendar"></i> '.date("d/m/Y H:i:s", strtotime($data->created))
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
    'label' => 'Tổng tiền',
    'headerOptions' => ['width' => '20%'],
    'contentOptions' => ['class' => 'text-right'],
    'attribute'=>'thanh_tien',
    'filter' => false,
    'value' => function($data){
        $tr = '<tr><td><strong>Tiền hàng: </strong></td> <td><span class="h5">'.number_format($data->tong_tien_cny * $data->ty_gia, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span><br/><span class="text-grey">'.number_format($data->tong_tien_cny, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">NDT</span></span></td></tr>';
        $tr .= '<tr><td><strong>Phí mua hàng: </strong></td> <td><span class="h5">'.number_format($data->phi_mua_hang, 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
        $tr .= '<tr><td><strong>Tổng giá trị: </strong></td> <td><span class="h5">'.number_format($data->phi_mua_hang + ($data->tong_tien_cny * $data->ty_gia), 0, '', '.').'</span> <span class="text-grey font-12px"><span class="text-grey">VNĐ</span></span></td></tr>';
        $str = '<table class="table-bordered table">'.$tr.'</table>';

        return $str;
//      return implode('', [
//        '<p><strong>Tổng tiền: </strong>'.number_format($data->tong_tien_cny, 0, '', '.').' <span class="text-grey font-12px">NDT</span></p>',
//        '<p><strong>Tổng tiền: </strong>'.number_format($data->tong_tien_cny * $data->ty_gia, 0, '', '.').' <span class="text-grey font-12px">VNĐ</span></p>',
//      ]);
    },
    'format' => 'raw'
  ],
  [
    'value' => function($data){
      return implode('', [
          '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-eye"></i> Chi tiết','#', ['class' => 'text-primary btn-xem-chi-tiet-don-hang', 'data-value' => $data->id]).'</p>',
           myAPI::isAccess2('QuanLyDonHang', 'Delete-don-hang') ? '<p>'.\yii\bootstrap\Html::a('<i class="fa fa-trash"></i> Xoá', '#', ['class' => 'text-danger btn-xoa-don-hang', 'data-value' => $data->id]).'</p>' : ''
      ]);
    },
    'label' => 'Chức năng',
    'format' => 'raw',
    'headerOptions' => ['class' => 'text-center', 'width' => '3%']
  ],
];
