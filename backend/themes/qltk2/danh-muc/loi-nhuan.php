<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $toanhaids ArrayHelper */
/* @var $toaNhaID int */
/* @var $tongThu string */
/* @var $tongChi string */
/* @var $loiNhuan string */

$this->title = 'Thống kê lợi nhuận';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="margin-bottom-15">
            <?= Html::label('Tòa nhà','toa-nha-id')?>
            <?= Html::dropDownList('toa_nha_id',$toaNhaID,$toanhaids,['class'=>'form-control drop-select','id'=>'toa-nha-id','prompt'=>'-- Tất cả --']);?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    Tổng thu: <span class="small-font tong_thu"><?=number_format((int)str_replace('.', '', $tongThu), 0, ',', ',')?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    Tổng chi: <span class="small-font tong_chi"><?=number_format((int)str_replace('.', '', $tongChi), 0, ',', ',')?></span>
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
                    Lợi nhuận: <span class="small-font loi_nhuan"><?=number_format((int)str_replace('.', '', $loiNhuan), 0, ',', ',')?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="chartdiv"></div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/assets/js-view/loi-nhuan.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/amcharts5/index.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/amcharts5/xy.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/amcharts5/themes/Animated.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>

