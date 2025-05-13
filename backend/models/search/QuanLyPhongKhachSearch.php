<?php

namespace backend\models\search;

use backend\models\PhongKhach;
use backend\models\QuanLyPhongKhach;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PhongKhachSearch represents the model behind the search form about `backend\models\PhongKhach`.
 */
class QuanLyPhongKhachSearch extends QuanLyPhongKhach
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'khach_hang_id', 'phong_id', 'user_id', 'so_thang_hop_dong', 'phong_cu_id','sale_id'], 'integer'],
            [['created', 'thoi_gian_hop_dong_tu', 'thoi_gian_hop_dong_den', 'trang_thai', 'ma_hop_dong', 'active','chiet_khau'], 'safe'],
            [['coc_truoc', 'don_gia','so_tien_moi_gioi'], 'number'],
            [['hoten', 'dien_thoai','ten_phong','ten_toa_nha','dien_thoai_sale','hoten_sale'], 'string'],
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
        $query = QuanLyPhongKhach::find();

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
        if($this->coc_truoc!=null){
            if($this->coc_truoc==1)
                $query->andFilterWhere(['>','coc_truoc',0]);
            else if($this->coc_truoc==0)
                $query->andFilterWhere(['=','coc_truoc',0]);
        }

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
            'active' => 1,
            'trang_thai' => PhongKhach::DA_DUYET,
        ]);

        $query->andFilterWhere(['like', 'ma_hop_dong', $this->ma_hop_dong])
            ->andFilterWhere(['like', 'hoten', $this->hoten])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'hoten_sale', $this->hoten_sale])
            ->andFilterWhere(['like', 'dien_thoai_sale', $this->dien_thoai_sale])
            ->andFilterWhere(['like', 'ten_phong', $this->ten_phong])
            ->andFilterWhere(['like', 'ten_toa_nha', $this->ten_toa_nha]);

        return $dataProvider;
    }
}
