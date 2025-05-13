<?php
/** @var $this View */
use yii\helpers\Html;
use yii\web\View;
use common\models\User;?>

<!-- BEGIN HEADER -->
<div class="page-header -i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?=Yii::$app->urlManager->createUrl('site/index')?>" class="text-default">
                <?=Html::img('hinh-anh/LivingApartment.png', ['width' => '70px'])?>
            </a>
        </div>
        <!-- END LOGO -->

        <!-- BEGIN HORIZANTAL MENU -->
        <div class="hor-menu hidden-sm hidden-xs">
            <?=$this->render('_menu'); ?>
        </div>
        <!-- END HORIZANTAL MENU -->

        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <?php $dataPhanHoi = Yii::$app->db->createCommand('SELECT qlcvsd_dem_sl_phan_hoi_moi(:id) AS so_luong', [
                ':id' => Yii::$app->user->id
        ])->queryOne();
        if(isset($dataPhanHoi['so_luong']))
            $so_luong = $dataPhanHoi['so_luong'];
        else
            $so_luong = 0;
        if($so_luong > 0){
            $listPhanHoi = \backend\models\PhanHoiThucHienCv::findAll(['nguoi_nhan_id' => Yii::$app->user->id, 'dong_phan_hoi' => 0]);
        }

        $so_luong_cv_toi_han= 0;
        $s_luong_cv_qua_han= 0;
        if(\common\models\User::isViewAll()){
            $id = '';
        }
        else{
            $phongBanNV = \backend\models\PhongBanNhanVien::findOne(['nhan_vien_id' => Yii::$app->user->id, 'truong_phong' => 1, 'active' => 1]);
            if(!is_null($phongBanNV))
                $id = $phongBanNV->phong_ban_id;
            else
                $id = '';
            if($id!= ''){
                $soNgayToiHan = \backend\models\Cauhinh::findOne(['ghi_chu' => 'gan_toi_han'])->content;
                $so_luong_cv_toi_han = Yii::$app->db->createCommand('SELECT qlcv_so_luong_cv_toi_han(:phong_ban_id, :so_ngay) AS so_luong;', [':phong_ban_id' => $id, ':so_ngay' => $soNgayToiHan])->queryAll();
                $so_luong_cv_toi_han = isset($so_luong_cv_toi_han[0]['so_luong']) ? $so_luong_cv_toi_han[0]['so_luong'] : 0;
                if($so_luong_cv_toi_han > 0){
                    $dsCVToiHan = \backend\models\QuanLyNhacViecThucHien::find()
                    ->andFilterWhere(['phong_ban_thuc_hien_id' => $id])
                        ->andFilterWhere(['<=', 'so_ngay_con_lai', $soNgayToiHan])
                        ->andWhere('so_ngay_con_lai > 0')
                        ->all();
                }

                $s_luong_cv_qua_han = Yii::$app->db->createCommand('SELECT qlcvsd_so_luong_cv_qua_han(:phong_ban_id) AS so_luong;', [':phong_ban_id' => $id])->queryAll();
                $s_luong_cv_qua_han = isset($s_luong_cv_qua_han[0]['so_luong']) ? $s_luong_cv_qua_han[0]['so_luong'] : 0;
                if($s_luong_cv_qua_han > 0){
                    $dsCVQuaHan = \backend\models\QuanLyNhacViecThucHien::find()
                        ->andWhere("trang_thai <> 'Đã hoàn thành' and trang_thai <> 'Hủy' and so_ngay_con_lai < 0 and phong_ban_thuc_hien_id = :phong_ban_id", [
                                ':phong_ban_id' => $id
                        ])
                        ->all();
                }
            }
        }

        $dsCvChoNhan = \backend\models\NguoiThucHienCongViec::findAll(['nguoi_thuc_hien_id' => Yii::$app->user->id, 'active' => 1, 'trang_thai' => 'Chờ xác nhận']);
        $soLuongCVChoNhanCaNhan = count($dsCvChoNhan);
        ?>
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-primary"><?=$so_luong?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold"><?=$so_luong?> Phản hồi</span> chờ xác nhận </h3>
                            <?=Html::a('Xem thêm', \yii\helpers\Url::toRoute(['phan-hoi/index']))?>
                        </li>
                        <?php if($so_luong > 0): ?>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <?php foreach ($listPhanHoi as $item): ?>
                                    <li>
                                        <a href="javascript:;" class="btn-xem-va-phan-hoi" data-value="<?=$item->id?>" data-nguoi_nhan="<?=$item->nguoi_nhan_id?>">
                                            <span class="time"><?=date('d/m/Y', strtotime($item->created)); ?></span>
                                            <span class="details">
                                                <?=$item->noi_dung_phan_hoi?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="dropdown dropdown-extended dropdown-notification" id="cong-viec-toi-han">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-warning"><?=$so_luong_cv_toi_han?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold"><?=$so_luong_cv_toi_han?> Công việc</span> tới hạn </h3>
                            <?=Html::a('Xem thêm', \yii\helpers\Url::toRoute(['phan-hoi/index']))?>
                        </li>
                        <?php if($so_luong_cv_toi_han > 0): ?>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <?php foreach ($dsCVToiHan as $itemCVToiHan): ?>
                                        <li>
                                            <a href="javascript:;" class="xem-chi-tiet-cong-viec" data-value="<?=$itemCVToiHan->thuc_hien_cong_viec_id?>" data-phong-ban-thuc-hien="<?=$itemCVToiHan->phong_ban_thuc_hien_id?>">
                                                <span class="time"><?=date('d/m/Y', strtotime($itemCVToiHan->thoi_gian_ket_thuc)); ?></span>
                                                <span class="details">
                                                <?=$itemCVToiHan->tieu_de?>
                                            </span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <li class="dropdown dropdown-extended dropdown-notification" id="cong-viec-qua-han">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-danger"><?=$s_luong_cv_qua_han?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold"><?=$s_luong_cv_qua_han?> Công việc</span> quá hạn </h3>
                            <?=Html::a('Xem thêm', \yii\helpers\Url::toRoute(['phan-hoi/index']))?>
                        </li>
                        <?php if($s_luong_cv_qua_han > 0): ?>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <?php foreach ($dsCVQuaHan as $itemCVQuaHan): ?>
                                                <li>
                                                    <a href="javascript:;" class="xem-chi-tiet-cong-viec" data-value="<?=$itemCVQuaHan->thuc_hien_cong_viec_id?>" data-phong-ban-thuc-hien="<?=$itemCVQuaHan->phong_ban_thuc_hien_id?>">
                                                        <span class="time"><?=date('d/m/Y', strtotime($itemCVQuaHan->thoi_gian_ket_thuc)); ?></span>
                                                        <span class="details">
                                                            <?=$itemCVQuaHan->tieu_de?>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <li class="dropdown dropdown-extended dropdown-notification" id="cong-viec-ca-nhan">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-danger"><?=$soLuongCVChoNhanCaNhan?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold"><?=$soLuongCVChoNhanCaNhan?> Công việc</span> cần thực hiện </h3>
                            <?=Html::a('Xem thêm', \yii\helpers\Url::toRoute(['phan-hoi/index']))?>
                        </li>
                        <?php if($soLuongCVChoNhanCaNhan > 0): ?>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <?php foreach ($dsCvChoNhan as $itemCVCaNhan): ?>
                                                <li>
                                                    <?php /** @var $itemCVCaNhan \backend\models\NguoiThucHienCongViec */ ?>
                                                    <a href="javascript:;" class="xem-chi-tiet-cong-viec" data-value="<?=$itemCVCaNhan->thuc_hien_cong_viec_id?>" data-ca-nhan-thuc-hien="<?=$itemCVCaNhan->nguoi_thuc_hien_id?>">
                                                        <span class="time"><?=$itemCVCaNhan->thucHienCongViec->thoi_gian_ket_thuc != '' ? date('d/m/Y', strtotime($itemCVCaNhan->thucHienCongViec->thoi_gian_ket_thuc)) : ""; ?></span>
                                                        <span class="details">
                                                            <?=$itemCVCaNhan->thucHienCongViec->tieu_de; ?>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>

                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/layout/img/avatar3_small.jpg"/>
                        <span class="username username-hide-on-mobile">
                            <?=Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->hoten; ?>
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <?=Html::a('<i class="fa fa-user"></i> '.(Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->hoten), '#')?>
                        </li>
                        <li>
                            <?=Html::a('<i class="icon-key"></i> Đăng xuất', Yii::$app->urlManager->createUrl('site/logout'))?>
                        </li>
                        <li>
                            <?=Html::a('<i class="icon-key"></i> Đổi mật khẩu', '#', ['class' => 'btn-doimatkhau'])?>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>
