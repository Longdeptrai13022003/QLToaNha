<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $hoaDons [] */

?>
<style>
    @media print {
        .newpage {
            page-break-after: always;
            /*height: 270mm;*/
            position: relative;
        }

        .print-foot {
            position: absolute; bottom: 0px; right: 0px;
        }

        table *{
            font-family: "Times New Roman";
        }
    }
</style>
<?php foreach ($hoaDons as $index => $hoaDon):?>
    <div class="newpage">
        <?= (new \backend\models\HoaDon())->printBill($hoaDon) ?>
    </div>
<!--    <div class="print-foot">-->
<!--        --><?php //= ($index+1)?><!--/--><?php //= count($hoaDons) ?>
<!--    </div>-->
<?php endforeach;?>