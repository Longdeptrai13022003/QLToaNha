<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GiaoDich;

/**
 * GiaoDichSearch represents the model behind the search form about `backend\models\GiaoDich`.
 */
class GiaoDichSearch extends GiaoDich
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'khach_hang_id', 'user_id', 'giao_dich_old_id', 'phong_khach_id'], 'integer'],
            [['trang_thai_giao_dich', 'loai_giao_dich', 'active', 'ghi_chu', 'created'], 'safe'],
            [['tong_tien', 'so_tien_giao_dich'], 'number'],
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
        $query = GiaoDich::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'khach_hang_id' => $this->khach_hang_id,
            'tong_tien' => $this->tong_tien,
            'so_tien_giao_dich' => $this->so_tien_giao_dich,
            'user_id' => $this->user_id,
            'created' => $this->created,
            'giao_dich_old_id' => $this->giao_dich_old_id,
            'phong_khach_id' => $this->phong_khach_id,
            'active' => 1,
        ]);

        $query->andFilterWhere(['like', 'trang_thai_giao_dich', $this->trang_thai_giao_dich])
            ->andFilterWhere(['like', 'loai_giao_dich', $this->loai_giao_dich])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
