<?php

namespace backend\models\search;

use app\models\QuanLyPhieuYeuCauGiaoHang;
use backend\models\GiaoDich;
use backend\models\QuanLyGiaoDich;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ChucNang;
use yii\helpers\VarDumper;

/**
 * ChucNangSearch represents the model behind the search form about `backend\models\ChucNang`.
 */
class QuanLyPhieuYeuCauGiaoHangSearch extends QuanLyPhieuYeuCauGiaoHang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_active', 'field_dia_chi_nhan_hang_id', 'user_id'], 'safe'],
            [['field_danh_sach_don_hang', 'field_hinh_thuc_nhan_hang', 'field_phan_loai', 'field_ds_ma_van_don_ky_gui', 'thong_tin_dia_chi'], 'safe'],
            [['field_phi_giao_hang_den_nha_xe', 'field_tong_tien', 'field_thanh_tien', 'field_so_tien_hoan_lai', 'field_so_tien_da_thanh_toan','phi_dong_goi'], 'safe'],
            [['created'], 'safe'],
            [['field_ma_van_don', 'field_so_dien_thoai_nha_xe', 'hoten', 'ho_ten_nguoi_nhan'], 'safe'],
            [['dien_thoai', 'dien_thoai_nguoi_nhan'], 'safe'],
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
    public function search($params, $api = null, $selects = [])
    {
        $query = QuanLyPhieuYeuCauGiaoHang::find();
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(count($selects) > 0)
            $query->select($selects);
        if(!(
            myAPI::isAccess([VaiTro::QUAN_LY_HE_THONG], is_null($api) ? Yii::$app->user->id : $api->uid)
            && !myAPI::isAccess([VaiTro::QUAN_LY_KHO], is_null($api) ? Yii::$app->user->id : $api->uid)
        )){
            $query->andFilterWhere(['user_id' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }

        if(is_null($api)){
            $query->andFilterWhere(['field_active' => 1]);
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['field_phi_giao_hang_den_nha_xe' => $this->field_phi_giao_hang_den_nha_xe]);
            $query->andFilterWhere(['phi_dong_goi' => $this->phi_dong_goi]);
            $query->andFilterWhere(['field_ma_van_don' => $this->field_ma_van_don]);
            $query->andFilterWhere(['user_id' => $this->user_id]);
            $query->andFilterWhere(['like', 'hoten', $this->hoten]);
            $query->andFilterWhere(['like', 'ho_ten_nguoi_nhan', $this->ho_ten_nguoi_nhan]);
            $query->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai]);
            $query->andFilterWhere(['like', 'dien_thoai_nguoi_nhan', $this->dien_thoai_nguoi_nhan]);

        }

        return $dataProvider;
    }
}
