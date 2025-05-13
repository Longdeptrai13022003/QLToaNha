<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $toanhaids ArrayHelper */
/* @var $hoaDons backend\models\QuanLyHoaDon[] */
/* @var $thangs [] */
/* @var $nams [] */
/* @var $toaNhaID int */
/* @var $hoanThanh int */
/* @var $congNo int */
/* @var $conNo string */
/* @var $daThanhToan string */

$this->title = 'Thống kê công nợ';
$this->params['breadcrumbs'][] = $this->title;

$thangTruoc = date('n');
?>
<div class="hoa-don-cong-no">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-2 margin-top-10">
            <?= Html::label('Tòa nhà','toa-nha-id')?>
            <?= Html::dropDownList('toa_nha_id',$toaNhaID,$toanhaids,['class'=>'form-control drop-select','id'=>'toa-nha-id']);?>
        </div>
        <div class="col-md-2 margin-top-10">
            <?= Html::label('Phòng','phong-id')?>
            <?= Html::dropDownList('phong_id',null,[],['prompt'=>'-- Chọn --','class'=>'form-control drop-select','id'=>'phong-id']);?>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-4">
                    <p><?=Html::label('Tháng','thang',['class'=>'form-label'])?></p>
                    <?= Html::dropDownList('thang',$thangTruoc,$thangs,['class'=>'form-control drop-select','id'=>'thang_tk'])?>
                </div>
                <div class="col-md-4">
                    <p><?=Html::label('Năm','nam',['class'=>'form-label'])?></p>
                    <?= Html::dropDownList('nam',date('Y'),$nams,['class'=>'form-control drop-select','id'=>'nam_tk'])?>
                </div>
                <div class="col-md-2">
                    <div class="margin-top-35">
                        <?= Html::a('<','#',['class'=>'btn btn-default change-month','loai' => 0])?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="margin-top-35">
                        <?= Html::a('>','#',['class'=>'btn btn-default change-month','loai' => 1])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="margin-top-35">
                <?= Html::a('Hoàn thành','#',['class'=>'btn btn-primary','id'=>'loai-hoa-don','loai' => 'hoan thanh'])?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="margin-top-20">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Hoàn thành: <span class="small-font hoan-thanh"><?= $hoanThanh?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Đã TT: <span class="small-font da-thanh-toan"><?= $daThanhToan?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Công nợ: <span class="small-font cong-no"><?= $congNo?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Còn nợ: <span class="small-font con-no"><?= $conNo?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="list-hoa-don">
        <table class="table table-striped text-nowrap">
            <thead>
            <tr>
                <th width="1%">STT</th>
                <th width="1%">Hợp đồng</th>
                <th width="1%">Phòng</th>
                <th>Khách</th>
                <th width="1%">Tổng tiền</th>
                <th width="1%">Trạng thái</th>
                <th width="1%">Còn nợ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($hoaDons as $index => $hoaDon): ?>
                <tr>
                    <td><?= $index + 1?></td>
                    <td><?= $hoaDon->ma_hop_dong?></td>
                    <td><?= $hoaDon->ten_phong?></td>
                    <td><?= $hoaDon->hoten.'</br>'.$hoaDon->dien_thoai ?></td>
                    <td><?= number_format($hoaDon->tong_tien, 0, ',', '.')?></td>
                    <td><?= $hoaDon->da_thanh_toan == 0 ? 'Chưa thanh toán' : ($hoaDon->da_thanh_toan < $hoaDon->tong_tien ? 'TT một phần' : 'Đã thanh toán')?></td>
                    <td><?= number_format($hoaDon->tong_tien - $hoaDon->da_thanh_toan, 0, ',', '.')?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/thong-ke.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
