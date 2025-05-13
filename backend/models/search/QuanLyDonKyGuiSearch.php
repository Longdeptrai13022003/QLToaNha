<?php

namespace backend\models\search;

use backend\models\DonHang;
use backend\models\KyGui;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyDonKyGui;
use backend\models\TrangThaiDonHang;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CauHinh;
use yii\helpers\VarDumper;

/**
 * CauhinhSearch represents the model behind the search form about `backend\models\Cauhinh`.
 */
class QuanLyDonKyGuiSearch extends QuanLyDonKyGui
{
    public $created_from;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_active', 'field_dia_chi_nhan_hang_id', 'field_tuyen_van_chuyen_id', 'field_ty_gia',
                'field_co_anh', 'field_khach_hang_id', 'user_id'], 'safe'],
            [['field_tong_tien_cny', 'field_tong_tien', 'field_so_tien_da_thanh_toan', 'field_khoi_luong',
                'field_phi_can_nang', 'field_thanh_tien', 'field_danh_sach_khoi_luong', 'field_so_tien_hoan_lai'], 'safe'],
            [['field_trang_thai', 'field_ghi_chu', 'field_hinh_anh', 'field_dvt_khoi_luong', 'field_hinh_thuc_nhan_hang', 'thong_tin_dia_chi'], 'safe'],
            [['field_han_cuoi_khieu_nai', 'created' ,'created_from'], 'safe'],
            [['field_ma_van_don_ky_gui', 'field_ma_khach', 'field_so_dien_thoai_nha_xe', 'field_danh_sach_ma_ky_gui',
                'hoten', 'username', 'ho_ten_nguoi_nhan'], 'safe'],
            [['field_ma_van_chuyen_don_hang', 'dien_thoai', 'dien_thoai_nguoi_nhan'], 'safe'],
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
        $query = QuanLyDonKyGui::find();

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
            $query->andFilterWhere(['field_khach_hang_id' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }

        $arrTrangThai = [
            'Đơn hàng chờ' => KyGui::DON_HANG_CHO,
            'Nhập kho TQ' => KyGui::DANG_O_KHO_TQ,
            'Đang ở kho TQ' => KyGui::DANG_O_KHO_TQ,
            'Vận chuyển TQ - VN' => 'Đang VC TQ-VN',
            'Đang VC TQ-VN' => 'Đang VC TQ-VN',
            'Nhập kho VN' => KyGui::DANG_O_VIET_NAM,
            'Đang ở VN' => KyGui::DANG_O_VIET_NAM,
            'Đã giao' => KyGui::DA_GIAO,
            'Đã giao hàng' => KyGui::DA_GIAO,
            'Kiểm hoá' => 'Kiểm hoá',
            'Đã huỷ' => KyGui::DA_HUY
        ];

        //enum('Đã đặt hàng', '', 'Đang ở VN', 'Đang chuyển hàng', 'Chuyển hàng Trung - Nhật', 'Chuyển hàng Trung - Hàn', 'Chuyển hàng Trung - Đài', 'Đã giao hàng', 'Đang chờ huỷ', 'Đã huỷ', 'Yêu cầu giao hàng', 'Chờ giao', 'Đang VC TQ-VN', 'Người bán giao', 'Kiểm hoá')
        if(!is_null($api)){
            if(isset($api->data->thongTinTimKiem->maKH)){
                if($api->data->thongTinTimKiem->trangThaiDH != 'Tất cả đơn hàng' && $api->data->thongTinTimKiem->trangThaiDH != 'null'  && !is_null($api->data->thongTinTimKiem->trangThaiDH)  )
                    if(isset($arrTrangThai[$api->data->thongTinTimKiem->trangThaiDH]))
                        $query->andFilterWhere(['field_trang_thai' => $arrTrangThai[$api->data->thongTinTimKiem->trangThaiDH]]);
            }
            else
                if($api->data->trangThai != 'Tất cả đơn hàng'){
                    $query->andFilterWhere(['field_trang_thai' => $arrTrangThai[$api->data->trangThai]]);
                }
//            else
//                $query->andWhere('field_trang_thai <> :t', [':t' => DonHang::GIO_HANG]);
            if(isset($api->data->thongTinTimKiem->maKH)){
//                if($api->data->thongTinTimKiem->maDonHang != '')
//                    $query->andFilterWhere(['id' => $api->data->thongTinTimKiem->maDonHang]);
                if($api->data->thongTinTimKiem->maVanDon != '')
                    $query->andFilterWhere(['field_ma_van_don_ky_gui' => $api->data->thongTinTimKiem->maVanDon]);
                if($api->data->thongTinTimKiem->maKH != '')
                    $query->andFilterWhere(['field_khach_hang_id' => $api->data->thongTinTimKiem->maKH]);
                if($api->data->thongTinTimKiem->thoiGianTu != '')
                    $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDMY2YMD($api->data->thongTinTimKiem->thoiGianTu)]);
                if($api->data->thongTinTimKiem->thoiGianDen != '')
                    $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDMY2YMD($api->data->thongTinTimKiem->thoiGianDen)]);
            }
        }
        else{
            $query->andFilterWhere(['field_active' => 1]);
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['field_ma_van_don_ky_gui' => $this->field_ma_van_don_ky_gui]);
            $query->andFilterWhere(['user_id' => $this->user_id]);
            if($this->field_so_tien_da_thanh_toan == 0)
                $query->andFilterWhere(['field_so_tien_da_thanh_toan' => null]);
            else
                $query->andFilterWhere(['=','field_so_tien_da_thanh_toan' , $this->field_so_tien_da_thanh_toan]);
            $query->andFilterWhere(['like', 'hoten', $this->hoten]);
            $query->andFilterWhere(['like', 'ho_ten_nguoi_nhan', $this->ho_ten_nguoi_nhan]);
            $query->andFilterWhere(['like', 'field_trang_thai', $this->field_trang_thai]);
            $query->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai]);
            $query->andFilterWhere(['like', 'dien_thoai_nguoi_nhan', $this->dien_thoai_nguoi_nhan]);

            if($this->created_from != '')
                $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDMY2YMD($this->created_from)]);
            if($this->created != '')
                $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDMY2YMD($this->created)]);
        }

        return $dataProvider;
    }

}
