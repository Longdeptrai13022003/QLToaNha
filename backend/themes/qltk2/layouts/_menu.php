<?php

use backend\models\VaiTro;
use common\models\User;
use common\models\myAPI;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 14/01/2019
 * Time: 22:12
 *
 **/

?>

<ul class="nav navbar-nav">

    <li>
        <?=Html::a('<i class="fa fa-home"></i> Tổng quan', \yii\helpers\Url::to(['site/index']))?>
    </li>

    <?php if(myAPI::isAccess2('User', 'Khach-hang')): ?>
    <li>
        <?=Html::a('<i class="fa fa-users"></i> Khách hàng', \yii\helpers\Url::to(['user/khach-hang']))?>
    </li>
    <?php endif; ?>

    <?php if(
        myAPI::isAccess2('PhongKhach', 'index')
    ): ?>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
                <i class="fas fa-file-contract"></i> Hợp đồng <i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-left">
                <?php if(myAPI::isAccess2('PhongKhach', 'create')):?>
                    <li>
                        <?=Html::a('<i class="fa fa-plus"></i> Thêm hợp đồng', \yii\helpers\Url::toRoute('phong-khach/create'))?>
                    </li>
                <?php endif; ?>
                <?php if(myAPI::isAccess2('PhongKhach', 'index')): ?>
                    <li>
                        <?=Html::a('<i class="fa fa-list"></i> Danh sách', \yii\helpers\Url::to(['phong-khach/index']))?>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>


    <?php if(
        myAPI::isAccess2('HoaDon', 'Index')
    ): ?>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
                <i class="fa fa-file-text"></i> Hóa đơn <i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-left">
                <?php if(myAPI::isAccess2('HoaDon', 'create')):?>
                    <li>
                        <?=Html::a('<i class="fa fa-plus"></i> Lập hóa đơn', \yii\helpers\Url::toRoute('hoa-don/create'))?>
                    </li>
                <?php endif; ?>
                <?php if(myAPI::isAccess2('HoaDon', 'index')):?>
                    <li>
                        <?=Html::a('<i class="fa fa-list"></i> Danh sách hóa đơn', \yii\helpers\Url::toRoute('hoa-don/index'))?>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if(myAPI::isAccess2('GiaoDich', 'Index')): ?>
        <li>
            <?=Html::a('<i class="fa fa-money"></i> Giao dịch', \yii\helpers\Url::to(['giao-dich/index']))?>
        </li>
    <?php endif; ?>

    <?php if(myAPI::isAccess2('User','index')): ?>
    <li>
        <?=Html::a('<i class="fa fa-users"></i> Người dùng', \yii\helpers\Url::to(['user/index']))?>
    </li>
    <?php endif; ?>

<!--    --><?php //if(myAPI::isAccess2('DanhMuc','view')): ?>
<!--    <li>-->
<!--        --><?php //=Html::a('<i class="fa fa-dollar"></i> Chi phí', \yii\helpers\Url::to(['danh-muc/view']))?>
<!--    </li>-->
<!--    --><?php //endif; ?>

    <?php if(
        myAPI::isAccess2('DanhMuc','chi-phi')
    ): ?>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
                <i class="fa fa-dollar"></i> Quản lý chi <i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-left">
                <?php if(myAPI::isAccess2('DanhMuc','view')):?>
                    <li>
                        <?=Html::a('<i class="fa fa-dollar"></i> Chi phí', \yii\helpers\Url::to(['danh-muc/chi-phi']))?>
                    </li>
                <?php endif; ?>
                <?php if(myAPI::isAccess2('DanhMuc','moi-gioi')): ?>
                    <li>
                        <?=Html::a('<i class="fa fa-user-plus"></i> Môi giới', \yii\helpers\Url::to(['danh-muc/moi-gioi']))?>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if(
        myAPI::isAccess2('DanhMuc', 'thong-ke-phong')
    ): ?>
        <li class="classic-menu-dropdown">
            <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
                <i class="fa fa-line-chart"></i> Thống kê <i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-left">
                <?php if(myAPI::isAccess2('PhongKhach', 'create')):?>
                    <li>
                        <?=Html::a('<i class="fa fa-home"></i> Báo cáo BĐS', \yii\helpers\Url::toRoute('danh-muc/thong-ke-phong'))?>
                    </li>
                <?php endif; ?>
                <?php if(myAPI::isAccess2('PhongKhach', 'index')): ?>
                    <li>
                        <?=Html::a('<i class="fa fa-money"></i> Công nợ', \yii\helpers\Url::to(['hoa-don/cong-no']))?>
                    </li>
                <?php endif; ?>
                <?php if(myAPI::isAccess2('DanhMuc', 'tong-hop')): ?>
                    <li>
                        <?=Html::a('<i class="fa fa-money"></i> Lợi nhuận', \yii\helpers\Url::to(['danh-muc/tong-hop']))?>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if(
        myAPI::isAccess2('Cauhinh', 'Index') ||
        myAPI::isAccess2('ThietLapGia', 'index')
    ): ?>
        <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-cog"></i> Hệ thống <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <?php if(myAPI::isAccess2('CauHinh', 'Index')):?>
            <li>
                <?=Html::a('<i class="fa fa-cog"></i> Cấu hình', Yii::$app->urlManager->createUrl(['cauhinh']))?>
            </li>
            <?php endif; ?>
            <?php if(myAPI::isAccess2('DanhMuc', 'toa-nha-phong-o')):?>
                <li>
                    <?=Html::a('<i class="fa fa-cogs"></i> Toà nhà / Phòng ở', \yii\helpers\Url::toRoute('danh-muc/toa-nha-phong-o'))?>
                </li>
            <?php endif; ?>
            <?php if(myAPI::isAccess2('DichVu', 'index')):?>
                <li>
                    <?=Html::a('<i class="fa fa-cogs"></i> Dịch vụ', \yii\helpers\Url::toRoute('dich-vu/index'))?>
                </li>
            <?php endif; ?>
            <?php if(myAPI::isAccess2('TrangThai', 'index')):?>
                <li>
                    <?=Html::a('<i class="fa fa-cogs"></i> Trạng thái', \yii\helpers\Url::toRoute('trang-thai/index'))?>
                </li>
            <?php endif; ?>

            <?php if(myAPI::isAccess2('ChucNang', 'Index')):?>
            <li>
                <?=Html::a('<i class="fa fa-bars"></i> Chức năng', Yii::$app->urlManager->createUrl(['chuc-nang']))?>
            </li>
            <?php endif; ?>
            <?php if(myAPI::isAccess2('PhanQuyen', 'Index')):?>
            <li>
                <?=Html::a('<i class="fa fa-users"></i> Phân quyền', Yii::$app->urlManager->createUrl(['phan-quyen']))?>
            </li>
            <?php endif; ?>
        </ul>

    </li>
    <?php endif; ?>
</ul>
