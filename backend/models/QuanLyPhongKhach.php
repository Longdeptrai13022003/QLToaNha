<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "qlcvsd_quan_ly_phong_khach".
 *
 * @property int $id
 * @property int|null $khach_hang_id
 * @property int|null $phong_id
 * @property int|null $toa_nha_id
 * @property int|null $user_id
 * @property int|null $sale_id
 * @property string|null $created
 * @property string|null $thoi_gian_hop_dong_tu
 * @property string|null $thoi_gian_hop_dong_den
 * @property float|null $coc_truoc
 * @property string|null $trang_thai
 * @property string|null $ma_hop_dong
 * @property int|null $so_thang_hop_dong
 * @property float|null $don_gia
 * @property float|null $moi_gioi
 * @property int|null $active
 * @property int|null $phong_cu_id
 * @property float $chiet_khau
 * @property string $kieu_chiet_khau
 * @property string $kieu_moi_gioi
 * @property string $ghi_chu
 * @property float $so_tien_chiet_khau
 * @property float $so_tien_moi_gioi
 * @property float $thanh_tien
 * @property float $da_thanh_toan
 * @property float $da_thanh_toan_moi_gioi
 * @property string $ten_phong
 * @property string $ten_toa_nha
 * @property string $hoten
 * @property string $dien_thoai
 * @property string $hoten_sale
 * @property string $dien_thoai_sale
 */
class QuanLyPhongKhach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_phong_khach}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','khach_hang_id', 'phong_id','toa_nha_id', 'user_id', 'so_thang_hop_dong', 'active', 'phong_cu_id'], 'safe'],
            [['created','thanh_tien','da_thanh_toan','ten_phong','ten_toa_nha','hoten','dien_thoai'], 'safe'],
            [['thoi_gian_hop_dong_tu', 'thoi_gian_hop_dong_den','coc_truoc','khach_hang_id','ma_hop_dong'], 'safe'],
            [['coc_truoc', 'chiet_khau','da_thanh_toan','ghi_chu','hoten_sale','dien_thoai_sale'], 'safe'],
            [['trang_thai', 'kieu_chiet_khau','don_gia','so_tien_chiet_khau','thanh_tien'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'khach_hang_id' => 'Khach Hang ID',
            'phong_id' => 'Phong ID',
            'user_id' => 'User ID',
            'created' => 'Created',
            'thoi_gian_hop_dong_tu' => 'Thoi Gian Hop Dong Tu',
            'thoi_gian_hop_dong_den' => 'Thoi Gian Hop Dong Den',
            'coc_truoc' => 'Tiền cọc',
            'trang_thai' => 'Trang Thai',
            'ma_hop_dong' => 'Mã hợp đồng',
            'so_thang_hop_dong' => 'So Thang Hop Dong',
            'don_gia' => 'Don Gia',
            'active' => 'Active',
            'phong_cu_id' => 'Phong Cu ID',
            'chiet_khau' => 'Chiết khấu',
            'kieu_chiet_khau' => 'Kieu Chiet Khau',
            'so_tien_chiet_khau' => 'So Tien Chiet Khau',
            'da_thanh_toan' => 'Da thanh toan'
        ];
    }
}