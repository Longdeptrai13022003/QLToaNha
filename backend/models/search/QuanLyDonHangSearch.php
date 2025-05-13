<?php

namespace backend\models\search;

use backend\models\DonHang;
use backend\models\QuanLyDonHang;
use backend\models\TrangThaiDonHang;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CauHinh;

/**
 * CauhinhSearch represents the model behind the search form about `backend\models\Cauhinh`.
 */
class QuanLyDonHangSearch extends QuanLyDonHang
{
    public $created_from;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'so_luong', 'da_chon_de_thanh_toan', 'loai_giao_hang_id', 'phuong_thuc_thanh_toan_id',
                'parent_id', 'dia_chi_nhan_hang_id', 'shop_id', 'active', 'ty_gia', 'tong_so_luong', 'don_hang_id',
                'qua_han_khieu_nai', 'ma_kien_hang', 'can_nang_tinh_phi'], 'safe'],
            [['created', 'han_cuoi_khieu_nai', 'created_from'], 'safe'],
            [['tong_tien', 'chiet_khau', 'tien_chiet_khau', 'phi_giao_hang_tan_noi', 'thanh_tien', 'da_thanh_toan',
                'hoan_tien', 'ship_noi_dia_cny', 'ship_noi_dia_vnd', 'phi_van_chuyen_hang', 'phi_dong_go',
                'phi_mua_hang', 'khoi_luong', 'ti_le_phan_tram_mua_hang', 'tong_tien_cny', 'tien_hang_chiet_khau',
                'chiet_khau_tien_hang', 'phi_khoi_luong', 'so_tien_hoan_lai', 'phi_giao_hang_den_nha_xe'], 'safe'],
            [['anh_don_hang', 'kieu_chiet_khau', 'trang_thai', 'anh_dia_chi_nhan_hang', 'shop_name', 'ghi_chu',
                'shop_link', 'anh_chi_tiet_don_hang', 'kieu_chiet_khau_tien_hang', 'danh_sach_thuoc_tinh',
                'dvt_khoi_luong', 'hinh_thuc_nhan_hang', 'thong_tin_dia_chi', 'ghi_chu_dia_chi'], 'safe'],
            [['anh_dia_chi', 'website'], 'safe'],
            [['ho_ten_nguoi_thanh_toan', 'dien_thoai_nguoi_thanh_toan', 'hinh_anh_dia_chi', 'ma_van_don', 'dich_vu',
                'ma_van_chuyen_don_hang', 'cong_cu_mua_hang', 'loai_giao_hang', 'phuong_thuc_giao_hang', 'hoten',
                'ho_ten_nguoi_nhan'], 'safe'],
            [['so_dien_thoai_nha_xe', 'dien_thoai', 'dien_thoai_nguoi_nhan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $api = null)
    {
        $listTrangThai = [
            'Chưa mua' => 'Đơn hàng chờ',
            'Đang mua' => 'Đang mua hàng',
            'Đã mua' => 'Đã đặt hàng',
            'Đã nhập kho TQ' => 'Đang ở kho TQ',
            'Đang VC TQ-VN' => 'Đang VC TQ-VN',
            'Nhập kho VN' => 'Đang ở VN',
            'Đang chuyển hàng' => 'Đang chuyển hàng',
            'Đã nhận hàng' => 'Đã giao hàng',
            'Chờ huỷ' => 'Đang chờ huỷ',
            'Đã huỷ' => 'Đã huỷ',
            'Chờ mua' => 'Chờ mua'
        ];
        $query = QuanLyDonHang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!(myAPI::checkOnlyRule(VaiTro::QUAN_LY_HE_THONG, is_null($api) ? Yii::$app->user->id : $api->uid))){
            $query->andFilterWhere(['user_id_goc' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }

        if(!is_null($api)){
            if($api->data->trangThai != 'Tất cả'){
                $query->andFilterWhere(['trang_thai' => isset($listTrangThai[$api->data->trangThai]) ? $listTrangThai[$api->data->trangThai] : $api->data->trangThai]);
            }else
                $query->andWhere('trang_thai <> :t', [':t' => DonHang::GIO_HANG]);
            if(isset($api->data->thongTinTimKiem->maDonHang)){
                if($api->data->thongTinTimKiem->maDonHang != '')
                    $query->andFilterWhere(['id' => $api->data->thongTinTimKiem->maDonHang]);
                if($api->data->thongTinTimKiem->maVanDon != '')
                    $query->andFilterWhere(['ma_van_don' => $api->data->thongTinTimKiem->maVanDon]);
                if($api->data->thongTinTimKiem->tenKH != '')
                    $query->andFilterWhere(['like', 'ho_ten_khach_hang', $api->data->thongTinTimKiem->tenKH]);
                if($api->data->thongTinTimKiem->maKH != '')
                    $query->andFilterWhere(['user_id' => $api->data->thongTinTimKiem->maKH]);
                if($api->data->thongTinTimKiem->thoiGianTu != '')
                    $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDMY2YMD($api->data->thongTinTimKiem->thoiGianTu)]);
                if($api->data->thongTinTimKiem->thoiGianDen != '')
                    $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDMY2YMD($api->data->thongTinTimKiem->thoiGianDen)]);
            }
        }else{
            $query->andWhere('trang_thai <> :t', [':t' => DonHang::GIO_HANG]);
            $query->andFilterWhere(['active' => 1]);
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['like', 'hoten', $this->hoten]);
            $query->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai]);

            if($this->created_from != '')
                $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDMY2YMD($this->created_from)]);
            if($this->created != '')
                $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDMY2YMD($this->created)]);
        }
        return $dataProvider;
    }

    public function searchDonHangKhieuNai($params, $api = null)
    {
        $query = QuanLyDonHang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!(
            myAPI::isAccess([VaiTro::QUAN_LY_HE_THONG], is_null($api) ? Yii::$app->user->id : $api->uid)
            && !myAPI::isAccess([VaiTro::QUAN_LY_KHO], is_null($api) ? Yii::$app->user->id : $api->uid)
        )){
            $query->andFilterWhere(['user_id_goc' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }

        $query->andWhere('(`field_noi_dung_khieu_nai` is not null)');


        return $dataProvider;
    }


    public function searchGioHang($params, $api = null)
    {
        $query = QuanLyDonHang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'active' => 1,
            'trang_thai' => DonHang::GIO_HANG
        ]);


        if(!(myAPI::checkOnlyRule(VaiTro::QUAN_LY_HE_THONG, is_null($api) ? Yii::$app->user->id : $api->uid))){
            $query->andFilterWhere(['user_id_goc' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }
//enum('Chờ xác nhận', 'Đã đặt hàng', 'Chờ chuyển hàng', 'Đã gửi hàng', 'Đã nhận', 'Đã hoàn', 'Đã huỷ', 'Giỏ hàng', 'Chờ mua', 'Đơn hàng chờ', 'Đã giao hàng', 'Đang ở kho TQ', 'Đang mua hàng', 'Đang ở VN', 'Đang chuyển hàng', 'Chuyển hàng Trung - Nhật', 'Chuyển hàng Trung - Hàn', 'Chuyển hàng Trung - Đài', 'Đang chờ huỷ', 'Yêu cầu giao hàng', 'Chờ giao', 'Đang VC TQ-VN', 'Người bán giao', 'Đang mua', 'Chưa mua')
        if(!is_null($api)){
            if(isset($api->data->thongTinTimKiem->name)){
                if($api->data->thongTinTimKiem->name != '')
                    $query->andFilterWhere(['username' => $api->data->thongTinTimKiem->name]);
                if($api->data->thongTinTimKiem->uid != '')
                    $query->andFilterWhere(['user_id' => $api->data->thongTinTimKiem->uid]);
                if($api->data->thongTinTimKiem->dienThoai != '')
                    $query->andFilterWhere(['dien_thoai' => $api->data->thongTinTimKiem->dienThoai]);
                if($api->data->thongTinTimKiem->hoTen != '')
                    $query->andFilterWhere(['like', 'hoten', $api->data->thongTinTimKiem->hoTen]);
            }
        }
        else{
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['like', 'hoten', $this->hoten]);
            $query->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai]);

            if($this->created_from != '')
                $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDMY2YMD($this->created_from)]);
            if($this->created != '')
                $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDMY2YMD($this->created)]);
        }

        return $dataProvider;
    }
}
