<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quan_ly_chi_tiet_don_hang}}".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $so_luong
 * @property float|null $don_gia
 * @property float|null $tong_tien
 * @property string|null $skuid
 * @property string|null $selectedPid
 * @property float|null $ti_le_loi_nhuan
 * @property string|null $cong_thuc_loi_nhuan
 * @property int|null $don_hang_id
 * @property int|null $user_id
 * @property string|null $created
 * @property string|null $props_names
 * @property string|null $images
 * @property string|null $itemID
 * @property string|null $props_ids
 * @property int|null $da_chon_de_thanh_toan
 * @property string|null $product_name
 * @property string|null $updated
 * @property int|null $user_updated_id
 * @property int|null $shop_id
 * @property int|null $ty_gia
 * @property float|null $tong_tien_cny
 * @property float|null $price_money
 * @property string|null $props_name
 * @property string|null $created_don_hang
 * @property string|null $props_name_vn
 * @property string|null $sku2info
 * @property string|null $notes
 * @property string|null $vids
 * @property float|null $phi_kiem_dem
 * @property float|null $ho_tro_kiem_dem
 * @property float|null $chiet_khau
 * @property float|null $kieu_chiet_khau
 * @property string|null $link_product
 * @property string|null $shop_link
 * @property string|null $trang_thai
 * @property string|null $ghi_chu_don_hang
 * @property string|null $domain
 * @property string|null $website
 * @property string|null $name
 * @property string|null $string_json
 * @property string|null $shop_name
 * @property string|null $string_json_vi
 */
class QuanLyChiTietDonHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quan_ly_chi_tiet_don_hang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'so_luong', 'don_hang_id', 'user_id', 'da_chon_de_thanh_toan', 'user_updated_id'], 'integer'],
            [['don_gia', 'tong_tien', 'ti_le_loi_nhuan', 'tong_tien_cny', 'price_money', 'phi_kiem_dem', 'ho_tro_kiem_dem'], 'number'],
            [['cong_thuc_loi_nhuan', 'props_names', 'images', 'product_name', 'sku2info', 'notes', 'vids', 'link_product', 'shop_link',
                'name', 'string_json', 'string_json_vi'], 'string'],
            [['created', 'updated', 'trang_thai', 'shop_name', 'shop_id', 'ty_gia', 'created_don_hang', 'chiet_khau', 'kieu_chiet_khau', 'ghi_chu_don_hang'], 'safe'],
            [['skuid', 'selectedPid', 'itemID', 'props_ids', 'domain'], 'string', 'max' => 100],
            [['props_name', 'props_name_vn'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'tong_tien' => 'Tong Tien',
            'skuid' => 'Skuid',
            'selectedPid' => 'Selected Pid',
            'ti_le_loi_nhuan' => 'Ti Le Loi Nhuan',
            'cong_thuc_loi_nhuan' => 'Cong Thuc Loi Nhuan',
            'don_hang_id' => 'Don Hang ID',
            'user_id' => 'User ID',
            'created' => 'Created',
            'props_names' => 'Props Names',
            'images' => 'Images',
            'itemID' => 'Item ID',
            'props_ids' => 'Props Ids',
            'da_chon_de_thanh_toan' => 'Da Chon De Thanh Toan',
            'product_name' => 'Product Name',
            'updated' => 'Updated',
            'user_updated_id' => 'User Updated ID',
            'tong_tien_cny' => 'Tong Tien Cny',
            'price_money' => 'Price Money',
            'props_name' => 'Props Name',
            'props_name_vn' => 'Props Name Vn',
            'sku2info' => 'Sku2info',
            'notes' => 'Notes',
            'vids' => 'Vids',
            'phi_kiem_dem' => 'Phi Kiem Dem',
            'ho_tro_kiem_dem' => 'Ho Tro Kiem Dem',
            'link_product' => 'Link Product',
            'shop_link' => 'Shop Link',
            'domain' => 'Domain',
            'name' => 'Name',
        ];
    }
}
