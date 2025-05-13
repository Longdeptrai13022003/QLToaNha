<?php

use common\models\User;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 14/01/2019
 * Time: 22:12
 *
 **/
if(User::isViewAll()){
    $data = Yii::$app->db->createCommand('SELECT qlcvsd_slcv_hoan_thanh_chua_duyet() AS so_luong')->queryAll();
    $soluongDaHTChoDuyet = isset($data[0]['so_luong']) ? $data[0]['so_luong'] : 0;
}else
    $soluongDaHTChoDuyet = 0;

?>
<ul class="nav navbar-nav">
    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-bars"></i> Danh mục <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
                <?=Html::a('Danh mục', \yii\helpers\Url::to(['danh-muc/index']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bars"></i> Thang điểm trình độ', \yii\helpers\Url::to(['diem-trinh-do/index']))?>
            </li>
        </ul>
    </li>

    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-user-circle-o"></i> Vị trí công việc <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
                <?=Html::a('<i class="fa fa-upload"></i> Import dữ liệu', \yii\helpers\Url::to(['danh-muc/import-vi-tri-cong-viec']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-plus"></i> Tạo mới', \yii\helpers\Url::to(['danh-muc/tao-vi-tri-cong-viec']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bars"></i> Vị trí công việc', \yii\helpers\Url::to(['danh-muc/vi-tri-cong-viec']))?>
            </li>
        </ul>
    </li>

    <li>
        <?=Html::a('<i class="fa fa-home"></i> Phòng ban', \yii\helpers\Url::to(['phong-ban/index']))?>
    </li>

    <li>
        <?=Html::a('<i class="fa fa-users"></i> Nhân sự', \yii\helpers\Url::to(['user/index']))?>
    </li>

    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-calendar"></i> <?=(($soluongDaHTChoDuyet ) > 0 ? "<span class='badge badge-danger'>$soluongDaHTChoDuyet</span>" : "") ?> Kế hoạch <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
                <?=Html::a('<i class="fa fa-cogs"></i> Lập kế hoạch', \yii\helpers\Url::to(['quan-ly-cong-viec/lap-ke-hoach']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Kế hoạch tập đoàn', Yii::$app->urlManager->createUrl(['quan-ly-cong-viec/tap-doan']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Kế hoạch đơn vị', Yii::$app->urlManager->createUrl(['quan-ly-cong-viec/don-vi']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Đã HT chờ duyệt '.($soluongDaHTChoDuyet > 0 ? "<span class='badge badge-danger'>{$soluongDaHTChoDuyet}</span>" : ""), Yii::$app->urlManager->createUrl(['quan-ly-cong-viec/cho-duyet-hoan-thanh']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Kế hoạch cá nhân', Yii::$app->urlManager->createUrl(['quan-ly-cong-viec/cong-viec-ca-nhan']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Kế hoạch phát sinh', Yii::$app->urlManager->createUrl(['quan-ly-cong-viec/cong-viec-phat-sinh']))?>
            </li>
        </ul>
    </li>
    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-plug"></i><?= $dataCVChoLanhDaoDuyet + $slCVPhongBanChoDuyet + $soLuongCVChoNhanCaNhan + $dataCVPhongBanChoNhan +$dataCVPhongBanThamVanChoNhan
                ? "<span class='badge badge-danger'>".($dataCVChoLanhDaoDuyet + $slCVPhongBanChoDuyet + $soLuongCVChoNhanCaNhan + $dataCVPhongBanChoNhan +$dataCVPhongBanThamVanChoNhan )."</span>" : ""?> Thực hiện công việc <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
                <?=Html::a('<i class="fa fa-cogs"></i> Lập đề xuất', \yii\helpers\Url::toRoute('thuc-hien-cong-viec/index'))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i>'.($slCVPhongBanChoDuyet > 0 ? "<span class='badge badge-danger'>{$slCVPhongBanChoDuyet}</span>" : "").' Duyệt đề xuất', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/de-nghi']));?>
            </li>
            <li class="divider"></li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> '.($dataCVPhongBanChoNhan > 0 ? "<span class='badge badge-danger'>{$dataCVPhongBanChoNhan}</span>" : "").' Công việc phòng ban', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/don-vi-can-lam']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-user-circle-o"></i> '.($soLuongCVChoNhanCaNhan > 0 ? "<span class='badge badge-danger'>{$soLuongCVChoNhanCaNhan}</span>" : "").' Công việc cá nhân', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/cong-viec-ca-nhan']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-check-square"></i> Duyệt CVCN hoàn thành', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/cong-viec-ca-nhan-da-hoan-thanh']))?>
            </li>
            <li class="divider"></li>
            <li>
                <?=Html::a('<i class="fa fa-question-circle-o"></i> '.($dataCVPhongBanThamVanChoNhan > 0 ? "<span class='badge badge-danger'>{$dataCVPhongBanThamVanChoNhan}</span>" : "").' Công việc tham vấn', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/de-nghi-tham-van']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-calendar-check-o"></i>  '.($dataCVChoLanhDaoDuyet > 0 ? "<span class='badge badge-danger'>{$dataCVChoLanhDaoDuyet}</span>" : "").' Công việc cần duyệt', Yii::$app->urlManager->createUrl(['thuc-hien-cong-viec/cong-viec-can-duyet']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-comments-o"></i> Phản hồi', Yii::$app->urlManager->createUrl(['phan-hoi/index']))?>
            </li>
        </ul>
    </li>
    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-bar-chart-o"></i> Báo cáo <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
<!--                --><?//=Html::a('<i class="fa fa-bar-chart-o"></i> Công việc mục tiêu', \yii\helpers\Url::to(['bao-cao/thuc-hien-cong-viec']))?>
                <?=Html::a('<i class="fa fa-bar-chart-o"></i> Công việc mục tiêu', \yii\helpers\Url::to(['thong-ke/bao-cao-cong-viec-muc-tieu']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Thực hiện KH đơn vị', Yii::$app->urlManager->createUrl(['bao-cao/cong-viec-don-vi']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bar-chart"></i> Thực hiện KH cá nhân', Yii::$app->urlManager->createUrl(['bao-cao/bao-cao-vi-tri-cong-viec']))?>
            </li>
        </ul>
    </li>
    <li>
        <?=Html::a('<i class="fa fa-files-o"></i> Thư viện', \yii\helpers\Url::to(['tai-lieu/index']))?>
    </li>
    <li class="classic-menu-dropdown">
        <a data-toggle="dropdown" href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
            <i class="fa fa-cog"></i> Hệ thống <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu pull-left">
            <li>
                <?=Html::a('<i class="fa fa-file-pdf-o"></i> Hướng dẫn sử dụng', \yii\helpers\Url::toRoute(['tai-lieu/huong-dan-su-dung']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-cogs"></i> Cấu hình', Yii::$app->urlManager->createUrl(['cauhinh']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-users"></i> Vai trò', Yii::$app->urlManager->createUrl(['vai-tro']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-bars"></i> Chức năng', Yii::$app->urlManager->createUrl(['chuc-nang']))?>
            </li>
            <li>
                <?=Html::a('<i class="fa fa-users"></i> Phân quyền', Yii::$app->urlManager->createUrl(['phan-quyen']))?>
            </li>
        </ul>
    </li>

</ul>
