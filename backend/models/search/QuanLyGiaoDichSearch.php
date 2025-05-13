<?php

namespace backend\models\search;

use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyGiaoDich;
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
class QuanLyGiaoDichSearch extends QuanLyGiaoDich
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'khach_hang_id', 'active', 'phong_khach_id', 'user_id', 'hoa_don_id', 'ma_id_casso', 'giao_dich_old_id'], 'integer'],
            [['trang_thai_giao_dich', 'loai_giao_dich', 'ghi_chu', 'noi_dung_chuyen_khoan', 'ma_hop_dong','ten_phong','nguoi_thuc_hien','ten_toa_nha', 'hoten', 'dien_thoai', 'ma_hoa_don'], 'string'],
            [['tong_tien', 'so_tien_giao_dich'], 'number'],
            [['created', 'ma_qr', 'anh_chuyen_khoan'], 'safe'],
            [['ma_hop_dong','ten_phong','ten_toa_nha', 'hoten', 'ma_hoa_don','nguoi_thuc_hien'], 'string', 'max' => 100],
            [['anh_chuyen_khoan'], 'string', 'max' => 300],
            [['dien_thoai'], 'string', 'max' => 20],
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
    public function search($params)
    {
        $query = QuanLyGiaoDich::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!empty($this->created) && !empty($this->ghi_chu)) {
            $start = explode('/',$this->created);
            $end = explode('/',$this->ghi_chu);
            $startDate = date('Y-m-d 00:00:00', strtotime(implode('-',array_reverse($start))));

            $endDate = date('Y-m-d 23:59:59', strtotime(implode('-',array_reverse($end))));

            $query->andFilterWhere(['>=', 'created', $startDate])
                ->andFilterWhere(['<=', 'created', $endDate])
                ->andFilterWhere(['active' => 1]);
        }
        if (!is_null($this->ma_id_casso)) {
            if ($this->ma_id_casso == 1) {
                $query->andFilterWhere(['hoa_don_id'=> null]);
            } elseif ($this->ma_id_casso == 0) {
                $query->andFilterWhere(['IS NOT', 'hoa_don_id', null]);
            }
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'khach_hang_id' => $this->khach_hang_id,
            'tong_tien' => $this->tong_tien,
            'so_tien_giao_dich' => $this->so_tien_giao_dich,
            'user_id' => $this->user_id,
            'giao_dich_old_id' => $this->giao_dich_old_id,
            'phong_khach_id' => $this->phong_khach_id,
            'active' => 1,
        ]);

        $query->andFilterWhere(['=', 'trang_thai_giao_dich', $this->trang_thai_giao_dich])
            ->andFilterWhere(['!=', 'trang_thai_giao_dich', GiaoDich::HOAN_THANH])
            ->andFilterWhere(['=', 'loai_giao_dich', $this->loai_giao_dich])
            ->andFilterWhere(['like', 'ma_hop_dong', $this->ma_hop_dong])
            ->andFilterWhere(['like', 'ten_phong', $this->ten_phong])
            ->andFilterWhere(['like', 'hoten', $this->hoten])
            ->andFilterWhere(['like', 'nguoi_thuc_hien', $this->nguoi_thuc_hien])
            ->andFilterWhere(['like', 'ma_hoa_don', $this->ma_hoa_don])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'ten_toa_nha', $this->ten_toa_nha]);

        return $dataProvider;
    }
//    public function search($params, $api = null, $selects = [])
//    {
//        $query = QuanLyGiaoDich::find();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => [
//              'defaultOrder' => ['id' => SORT_DESC]
//            ],
//            'pagination' => [
//                'pageSize' => 20
//            ]
//        ]);
//
//        $this->load($params);
//
//        if(!is_null($api)){
//            if(in_array($api->field_loai_giao_dich, [GiaoDich::NAP_TIEN, GiaoDich::THANH_TOAN_DON_HANG, GiaoDich::HOAN_TIEN_DON_HANG, GiaoDich::RUT_TIEN]))
//                $query->andFilterWhere(['loai_giao_dich' => $api->field_loai_giao_dich]);
//            else if($api->field_loai_giao_dich != 'Tất cả')
//                $query->andFilterWhere(['trang_thai_giao_dich' => $api->field_loai_giao_dich]);
//            else if(isset($api->thongTinTimKiem->maDonHang)){
//                if($api->thongTinTimKiem->maDonHang != '')
//                    $query->andFilterWhere(['id' => $api->thongTinTimKiem->maDonHang]);
//                if($api->thongTinTimKiem->thoiGianTu != '')
//                    $query->andFilterWhere(['>=', 'date(created)', myAPI::convertDateSaveIntoDb($api->thongTinTimKiem->thoiGianTu)]);
//                if($api->thongTinTimKiem->thoiGianDen != '')
//                    $query->andFilterWhere(['<=', 'date(created)', myAPI::convertDateSaveIntoDb($api->thongTinTimKiem->thoiGianDen)]);
//                if($api->thongTinTimKiem->maKH != '')
//                    $query->andFilterWhere(['khach_hang_id' => $api->thongTinTimKiem->maKH]);
//                if($api->thongTinTimKiem->tenKH != '')
//                    $query->andFilterWhere(['like', 'ho_ten_khach_hang', $api->thongTinTimKiem->tenKH]);
//                if($api->thongTinTimKiem->dienThoai != '')
//                    $query->andFilterWhere(['dien_thoai_khach_hang' => $api->thongTinTimKiem->dienThoai]);
//                if($api->thongTinTimKiem->loaiGiaoDich != '' && $api->thongTinTimKiem->loaiGiaoDich != 'Tất cả')
//                    $query->andFilterWhere(['loai_giao_dich' => $api->thongTinTimKiem->loaiGiaoDich]);
//            }
//        }
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//        if(count($selects) > 0)
//            $query->select($selects);
//        if(!(
//            myAPI::isAccess([VaiTro::QUAN_LY_HE_THONG], is_null($api) ? Yii::$app->user->id : $api->uid)
//            && !myAPI::isAccess([VaiTro::QUAN_LY_KHO], is_null($api) ? Yii::$app->user->id : $api->uid)
//        )){
//            $query->andFilterWhere(['khach_hang_id_goc' => is_null($api) ? Yii::$app->user->id : $api->uid]);
//        }
//        return $dataProvider;
//    }

}
