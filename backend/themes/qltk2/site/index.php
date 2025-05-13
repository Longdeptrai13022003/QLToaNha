<?php
$this->title = 'Phần mềm quản lý tòa nhà';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .header img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .header h1 {
        font-size: 24px;
        color: #0d47a1;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        color: #2c3e50;
        font-weight: bold;
    }

    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .dashboard-card {
        background: linear-gradient(135deg, #942bcf, #f16d6d);
        border-radius: 16px !important;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        transition: all 0.4s ease;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .dashboard-card h3 {
        font-size: 24px;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .dashboard-card p {
        font-size: 16px;
        color: #ffffff;
    }

    .dashboard-footer {
        text-align: center;
        margin-top: 40px;
        color: #95a5a6;
        font-size: 15px;
    }
</style>

<div class="dashboard-container">
    <div class="header">
        <img src="hinh-anh/building.png" alt="logo">
        <h1>Công ty cho thuê phòng trọ Living Apartment</h1>
    </div>
    <div class="dashboard-header">
        <p>Chào mừng bạn đến với hệ thống quản lý tòa nhà chuyên nghiệp</p>
    </div>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <h3>Tòa nhà</h3>
            <p>Quản lý danh sách tòa nhà</p>
        </div>
        <div class="dashboard-card">
            <h3>Căn hộ</h3>
            <p>Thông tin căn hộ và cư dân</p>
        </div>
        <div class="dashboard-card">
            <h3>Hợp đồng</h3>
            <p>Quản lý hợp đồng cho thuê</p>
        </div>
        <div class="dashboard-card">
            <h3>Hóa đơn</h3>
            <p>Quản lý hóa đơn điện, nước, dịch vụ</p>
        </div>
        <div class="dashboard-card">
            <h3>Giao dịch</h3>
            <p>Quản lý giao dịch hoá đơn</p>
        </div>
        <div class="dashboard-card">
            <h3>Chi phí</h3>
            <p>Thông tin các khoản phí cần chi</p>
        </div>
        <div class="dashboard-card">
            <h3>Nhân sự</h3>
            <p>Danh sách nhân viên, bảo vệ, kỹ thuật</p>
        </div>
        <div class="dashboard-card">
            <h3>Báo cáo</h3>
            <p>Thống kê, xuất báo cáo tổng hợp</p>
        </div>
    </div>

    <div class="dashboard-footer">
        © <?= date('Y') ?> DDL - Phần mềm quản lý tòa nhà
    </div>
</div>

