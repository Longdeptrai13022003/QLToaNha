<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QuanLyPhong as QuanLyPhongModel;

/**
 * QuanLyPhongSearch represents the model behind the search form about `backend\models\QuanLyPhongSearch`.
 */
class QuanLyPhongSearch extends QuanLyPhongModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'selected', 'parent_id','thoi_gian_hop_dong_tu','thoi_gian_hop_dong_den'], 'safe'],
            [['hoten', 'dien_thoai', 'name','active','ten_toa_nha','ma_hop_dong','active_phong'], 'safe'],
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
        $query = QuanLyPhongModel::find();

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

        if ($this->selected == 1) {
            $query->andWhere(['ma_hop_dong' => null]);
        } elseif ($this->selected == 3) {
            $query->andWhere(['>', 'thoi_gian_hop_dong_den', date('Y-m-d H:i:s', strtotime('+1 month +30 days'))]);
        } elseif ($this->selected == 2) {
            $query->andWhere(['<', 'thoi_gian_hop_dong_den', date('Y-m-d H:i:s', strtotime('+1 month +30 days'))]);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'active_phong' => 1
        ]);

        $query->andFilterWhere(['like', 'hoten', $this->hoten])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'ma_hop_dong', $this->dien_thoai])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andWhere(['or', ['active' => 1], ['active' => null]])
            ->andWhere(['is not', 'parent_id', null]);

        return $dataProvider;
    }
}
