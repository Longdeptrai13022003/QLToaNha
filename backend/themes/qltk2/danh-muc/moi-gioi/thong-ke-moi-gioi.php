<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $toanhaids ArrayHelper */
/* @var $thangs [] */
/* @var $nams [] */
/* @var $toaNhaID int */
/* @var $hoanThanh int */
/* @var $congNo int */
/* @var $conNo string */
/* @var $daThanhToan string */

$this->title = 'Thống kê môi giới';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hoa-don-create">
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
                    <?= Html::dropDownList('thang',date('n'),$thangs,['class'=>'form-control drop-select','id'=>'thang_tk'])?>
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
    <div id="thanh-cong"></div>
    <div id="list-hoa-don">

    </div>
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/moi-gioi.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>