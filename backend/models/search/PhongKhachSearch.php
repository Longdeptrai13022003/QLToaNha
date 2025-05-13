<?php

namespace backend\models\search;

use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PhongKhach;

/**
 * PhongKhachSearch represents the model behind the search form about `backend\models\PhongKhach`.
 */
class PhongKhachSearch extends PhongKhach
{
    public $created_form;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'khach_hang_id', 'phong_id', 'user_id', 'so_thang_hop_dong', 'phong_cu_id'], 'integer'],
            [['created', 'thoi_gian_hop_dong_tu', 'thoi_gian_hop_dong_den', 'trang_thai', 'ma_hop_dong', 'active','chiet_khau'], 'safe'],
            [['coc_truoc', 'don_gia'], 'number'],
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
        $query = PhongKhach::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $query->joinWith(['khachHang', 'phong']);

        $this->load($params);
        if($this->coc_truoc!=null){
            if($this->coc_truoc==1)
                $query->andFilterWhere(['>','coc_truoc',0]);
            else if($this->coc_truoc==0)
                $query->andFilterWhere(['=','coc_truoc',0]);
        }
        $query->andFilterWhere(['like', 'qlcvsd_user.hoten', $this->khach_hang_id])
            ->andFilterWhere(['like', 'qlcvsd_user.dien_thoai', $this->don_gia])
            ->andFilterWhere(['qlcvsd_phong_khach.active' => 1]);

        if($this->thoi_gian_hop_dong_tu != '' && $this->chiet_khau != ''){
            $query->andFilterWhere(['>=','thoi_gian_hop_dong_tu',myAPI::convertDMY2YMD($this->thoi_gian_hop_dong_tu)]);
            $query->andFilterWhere(['<=','thoi_gian_hop_dong_tu',myAPI::convertDMY2YMD($this->chiet_khau)]);
        }
        if($this->thoi_gian_hop_dong_den != '' && $this->created != ''){
            $query->andFilterWhere(['>=','thoi_gian_hop_dong_den',myAPI::convertDMY2YMD($this->thoi_gian_hop_dong_den)]);
            $query->andFilterWhere(['<=','thoi_gian_hop_dong_den',myAPI::convertDMY2YMD($this->created)]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'phong_id' => $this->phong_id,
            'user_id' => $this->user_id,
            'so_thang_hop_dong' => $this->so_thang_hop_dong,
            'qlcvsd_phong_khach.active' => 1,
        ]);

        $query->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'ma_hop_dong', $this->ma_hop_dong]);

        return $dataProvider;
    }
}
