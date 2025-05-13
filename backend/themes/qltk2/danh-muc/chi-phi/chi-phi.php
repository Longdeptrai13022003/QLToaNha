<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $toanhaids ArrayHelper */
/* @var $toaNhaID int */
/* @var $thangs [] */
/* @var $nams [] */

$this->title = 'Chi phí dự án'
?>
<div class="hoa-don-create">
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-2 margin-top-10">
            <?= Html::label('Tòa nhà','toa-nha-id')?>
            <?= Html::dropDownList('toa_nha_id',$toaNhaID,$toanhaids,['class'=>'form-control drop-select','id'=>'toa-nha-id']);?>
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
    </div>
    <div class="margin-top-35">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Tổng chi: <span class="small-font tong-chi"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Đã thanh toán: <span class="small-font da_thanh_Toan"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Còn lại: <span class="small-font con_lai"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="thanh-cong"></div>
        <div id="list-chi-phi">

        </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/chi-phi.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
