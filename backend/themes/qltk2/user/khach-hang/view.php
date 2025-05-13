<?php
//
//use yii\helpers\Html;
//use yii\widgets\DetailView;
//
///* @var $this yii\web\View */
///* @var $model common\models\User */
//?>
<!--<div class="tabbale-line">-->
<!--    <div class="tab-content">-->
<!--        <div class="tab-pane active">-->
<!--            <div class="row">-->
<!--                <div class="col-md-3">-->
<!--                    --><?php //=Html::a("<img  class='example-image img-responsive' src='hinh-anh/$model->anhdaidien' width='100%'>",
//                        'hinh-anh/'.$model->anhdaidien,['class'=>'example-image-link img-thumbnail img-responsive','data-lightbox'=>'roadtrip',])?>
<!--                </div>-->
<!--                <div class="col-md-9 margin-top-35">-->
<!--                    <p><strong>Họ tên:</strong> --><?php //=$model->hoten?><!--</p>-->
<!--                    <p><strong>Điện thoại:</strong> --><?php //=$model->dien_thoai?><!--</p>-->
<!--                    <p><strong>Tên đăng nhập:</strong> --><?php //=$model->username ?><!--</p>-->
<!--                    <p><strong>Email:</strong> --><?php //=$model->email ?><!--</p>-->
<!--                    <p><strong>Số CCCD:</strong> --><?php //=$model->so_cccd ?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-md-12"><h4 class="text-primary">ẢNH 2 MẶT CCCD</h4></div>-->
<!--                --><?php //if($model->anhcancuoc == ''): ?>
<!--                    <div class="col-md-4">-->
<!--                        --><?php //=Html::a("<img  class='example-image img-responsive' src='hinh-anh/no-image.jpg' width='100%'>",
//                            'hinh-anh/no-image.jpg',['class'=>'example-image-link img-thumbnail img-responsive','data-lightbox'=>'roadtrip','target'=>'_blank'])?>
<!--                    </div>-->
<!--                --><?php //else:?>
<!--                    --><?php //$anhs =explode(',',$model->anhcancuoc)?>
<!--                    --><?php //foreach ($anhs as $anh): ?>
<!--                        <div class="col-md-4">-->
<!--                            --><?php //=Html::a("<img  class='example-image img-responsive' src='hinh-anh/$anh' width='100%'>",
//                                'hinh-anh/'.$anh,['class'=>'example-image-link img-thumbnail img-responsive','data-lightbox'=>'roadtrip','target'=>'_blank'])?>
<!--                        </div>-->
<!--                    --><?php //endforeach;?>
<!--                --><?php //endif;?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>

<div class="user-detail-popup panel panel-default">
    <div class="panel-body">
        <div class="row">
            <!-- Ảnh đại diện -->
            <div class="col-md-3 text-center">
                <?= Html::a(
                    "<img class='user-avatar img-thumbnail' src='hinh-anh/$model->anhdaidien'>",
                    'hinh-anh/' . $model->anhdaidien,
                    ['class' => 'example-image-link', 'data-lightbox' => 'roadtrip']
                ) ?>
            </div>

            <!-- Thông tin chi tiết -->
            <div class="col-md-9">
                <p><i class="fa fa-user"></i> <strong>Họ tên:</strong> <?= $model->hoten ?></p>
                <p><i class="fa fa-phone"></i> <strong>Điện thoại:</strong> <?= $model->dien_thoai ?></p>
                <p><i class="fa fa-user-circle"></i> <strong>Tên đăng nhập:</strong> <?= $model->username ?></p>
                <p><i class="fa fa-envelope"></i> <strong>Email:</strong> <?= $model->email ?: '<span class="text-muted">Chưa cập nhật</span>' ?></p>
                <p><i class="fa fa-id-card"></i> <strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
            </div>
        </div>

        <!-- Ảnh CCCD -->
        <div class="row margin-top-20">
            <div class="col-md-12">
                <h4 class="text-primary"><i class="fa fa-image"></i> Ảnh 2 mặt CCCD</h4>
            </div>

            <?php if (empty($model->anhcancuoc)): ?>
                <div class="col-md-4">
                    <?= Html::a(
                        "<img class='cccd-img img-thumbnail' src='hinh-anh/no-image.jpg'>",
                        'hinh-anh/no-image.jpg',
                        ['class' => 'example-image-link', 'data-lightbox' => 'roadtrip', 'target' => '_blank']
                    ) ?>
                </div>
            <?php else:
                $anhs = explode(',', $model->anhcancuoc);
                foreach ($anhs as $anh): ?>
                    <div class="col-md-4">
                        <?= Html::a(
                            "<img class='cccd-img img-thumbnail' src='hinh-anh/$anh'>",
                            'hinh-anh/' . $anh,
                            ['class' => 'example-image-link', 'data-lightbox' => 'roadtrip', 'target' => '_blank']
                        ) ?>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>
