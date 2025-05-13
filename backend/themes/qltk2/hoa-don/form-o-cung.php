<?php
use yii\bootstrap\ActiveForm;
use \yii\helpers\Html;
/* @var $chiTiets \backend\models\QuanLyOCung[] */
/* @var $hoaDonID int */
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .o-cung-table {
            margin: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border-radius: 10px !important;
        }
        .o-cung-table .table {
            background: #ffffff !important;
            border-radius: 10px !important;
            margin-bottom: 0 !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            transition: box-shadow 0.2s !important;
        }
        .o-cung-table .table:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.15) !important;
        }
        .o-cung-table thead {
            background: linear-gradient(90deg, #e0f2fe, #dbeafe) !important;
            color: #064e3b !important;
            text-align: center !important;
        }
        .o-cung-table thead th {
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            padding: 15px 10px !important;
            vertical-align: middle !important;
            border-bottom: 2px solid #e2e8f0 !important;
            letter-spacing: 0.5px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 1 !important;
        }
        .o-cung-table thead th i {
            margin-right: 5px !important;
        }
        .o-cung-table tbody tr {
            transition: background-color 0.2s, transform 0.2s !important;
        }
        .o-cung-table tbody tr:nth-child(even) {
            background: #f8fafc !important;
        }
        .o-cung-table tbody tr:hover {
            background: #f0f5ff !important;
            transform: translateY(-1px) !important;
        }
        .o-cung-table tbody td {
            font-size: 1.3rem !important;
            color: #1a202c !important;
            padding: 10px 12px !important;
            border-top: 1px solid #e2e8f0 !important;
            vertical-align: middle !important;
        }
        .o-cung-table .form-control {
            border-radius: 6px !important;
            border: 1px solid #d1d9e0 !important;
            font-size: 1.3rem !important;
            padding: 8px 12px !important;
            transition: border-color 0.3s, box-shadow 0.3s, background-color 0.2s !important;
            background: #f8fafc !important;
            height: 36px !important;
            box-sizing: border-box !important;
        }
        .o-cung-table .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 6px rgba(59,130,246,0.5) !important;
            background: #ffffff !important;
            outline: none !important;
        }
        .o-cung-table .text-primary i, .o-cung-table .text-danger i {
            font-size: 1.4rem !important;
            transition: transform 0.2s !important;
        }
        .o-cung-table .text-primary:hover i, .o-cung-table .text-danger:hover i {
            transform: scale(1.2) !important;
        }
        .o-cung-table .btn-primary {
            background: linear-gradient(45deg, #059669, #34d399) !important;
            font-size: 1.3rem !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            color: #ffffff !important;
            border: none !important;
            transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s !important;
        }
        .o-cung-table .btn-primary:hover {
            background: linear-gradient(45deg, #047857, #059669) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(5,150,105,0.3) !important;
        }
        #loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 60px;
            height: 60px;
            border: 8px solid #e2e8f0;
            border-radius: 50% !important;
            border-top: 8px solid #3b82f6;
            animation: spin 0.8s linear infinite;
            transform: translate(-50%, -50%);
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @media (max-width: 767px) {
            .o-cung-table .table {
                overflow-x: auto !important;
                display: block !important;
            }
            .o-cung-table thead th,
            .o-cung-table tbody td {
                font-size: 1.1rem !important;
                padding: 8px !important;
            }
            .o-cung-table .form-control {
                font-size: 1.1rem !important;
                height: 32px !important;
            }
            .o-cung-table .btn-primary {
                font-size: 1.2rem !important;
                padding: 8px 16px !important;
            }
            .o-cung-table .text-primary i, .o-cung-table .text-danger i {
                font-size: 1.2rem !important;
            }
        }
    </style>

<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'enctype' => 'multipart/form-data',
        'id' => 'form-o-cung'
    ]
]); ?>
    <div class="o-cung-table">
        <table class="table text-nowrap">
            <?= Html::hiddenInput('hoaDonID', $hoaDonID) ?>
            <thead>
            <tr>
                <th><i class="fas fa-user"></i> Họ tên</th>
                <th><i class="fas fa-phone"></i> Điện thoại</th>
                <th><i class="fas fa-plus-circle"></i> Thêm</th>
                <th><i class="fas fa-trash-alt"></i> Xóa</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($chiTiets) > 0): ?>
                <?php foreach ($chiTiets as $index => $chiTiet): ?>
                    <tr>
                        <?= Html::hiddenInput('id[]', $chiTiet->nguoi_o_cung_id) ?>
                        <td><?= Html::textInput('ho_ten[]', $chiTiet->ho_ten, ['class' => 'form-control']) ?></td>
                        <td><?= Html::textInput('dien_thoai[]', $chiTiet->dien_thoai, ['class' => 'form-control']) ?></td>
                        <td class="text-center">
                            <?= Html::a('<i class="fas fa-plus"></i>', '#', ['class' => 'text-primary them-o-cung']) ?>
                        </td>
                        <td class="text-center">
                            <?= Html::a('<i class="fas fa-trash"></i>', '#', ['class' => 'text-danger xoa-o-cung']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?= Html::textInput('ho_ten[]', '', ['class' => 'form-control']) ?></td>
                    <td><?= Html::textInput('dien_thoai[]', '', ['class' => 'form-control']) ?></td>
                    <td class="text-center">
                        <?= Html::a('<i class="fas fa-plus"></i>', '#', ['class' => 'text-primary them-o-cung']) ?>
                    </td>
                    <td class="text-center">
                        <?= Html::a('<i class="fas fa-trash"></i>', '#', ['class' => 'text-danger xoa-o-cung']) ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div id="loading"></div>
    <div class="text-right" style="margin-top: 15px;">
        <?= Html::a('<i class="fas fa-save"></i> Lưu', '#', ['class' => 'btn btn-primary', 'id' => 'save-o-cung']) ?>
    </div>
<?php ActiveForm::end(); ?>