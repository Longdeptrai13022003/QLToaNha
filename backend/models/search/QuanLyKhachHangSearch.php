<?php

namespace backend\models\search;

use backend\models\GiaoDich;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyKhachHang;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DanhMuc;
use yii\helpers\VarDumper;

/**
 * DanhMucSearch represents the model behind the search form about `backend\models\DanhMuc`.
 */
class QuanLyKhachHangSearch extends QuanLyKhachHang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'VIP', 'hoat_dong', 'kichHoat', 'user_old_id'], 'safe'],
            [['created_at', 'updated_at', 'birth_day'], 'safe'],
            [['vi_dien_tu', 'vi_dien_tu_tu'], 'safe'],
            [['username', 'password_hash', 'email', 'password', 'hoten', 'anhdaidien', 'ho_ten_tai_khoan', 'so_tai_khoan'], 'safe'],
            [['password_reset_token'], 'safe'],
            [['auth_key'], 'safe'],
            [['dien_thoai'], 'safe'],
            [['dia_chi'], 'safe'],
            [['te_ngan_hang'], 'safe'],
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
        $query = QuanLyKhachHang::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 10
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

//            if(!(myAPI::checkOnlyRule(VaiTro::QUAN_LY_HE_THONG, is_null($api) ? Yii::$app->user->id : $api->uid))){
//                $query->andFilterWhere(['nguoi_phu_trach_id' => is_null($api) ? Yii::$app->user->id : $api->uid]);
//            }


        if(!is_null($api)){
            if(isset($api->data->thongTinTimKiem)){
                if(isset($api->data->thongTinTimKiem->hoTen))
                    if($api->data->thongTinTimKiem->hoTen != '')
                        $query->andFilterWhere(['like', 'hoten', $api->data->thongTinTimKiem->hoTen]);
                if(isset($api->data->thongTinTimKiem->name))
                    if($api->data->thongTinTimKiem->name != '')
                        $query->andFilterWhere(['like', 'username', $api->data->thongTinTimKiem->name]);
                if(isset($api->data->thongTinTimKiem->dienThoai))
                    if($api->data->thongTinTimKiem->dienThoai != '')
                        $query->andFilterWhere(['like', 'dien_thoai', $api->data->thongTinTimKiem->dienThoai]);
                if(isset($api->data->thongTinTimKiem->uid))
                    if($api->data->thongTinTimKiem->uid != '')
                        $query->andFilterWhere(['user_old_id' => $api->data->thongTinTimKiem->uid]);
            }
//            if(in_array($api->field_loai_giao_dich, [GiaoDich::NAP_TIEN, GiaoDich::THANH_TOAN_DON_HANG, GiaoDich::HOAN_TIEN_DON_HANG, GiaoDich::RUT_TIEN]))
//                $query->andFilterWhere(['loai_giao_dich' => $api->field_loai_giao_dich]);
//            else if($api->field_loai_giao_dich != 'Tất cả')
//                $query->andFilterWhere(['trang_thai_giao_dich' => $api->field_loai_giao_dich]);
        }else{
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['status' => 10]);
            $query->andFilterWhere(['like', 'hoten', $this->hoten]);
            $query->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai]);
            $query->andFilterWhere(['like', 'so_cccd', $this->so_cccd]);
            $query->andFilterWhere(['like', 'username', $this->username]);
            $query->andFilterWhere(['like', 'email', $this->email]);
            $query->andFilterWhere(['vi_dien_tu' => $this->vi_dien_tu]);
        }

        return $dataProvider;
    }

}
