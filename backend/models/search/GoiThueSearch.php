<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GoiThue;

/**
 * GoiThueSearch represents the model behind the search form about `backend\models\GoiThue`.
 */
class GoiThueSearch extends GoiThue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'don_gia'], 'integer'],
            [['ten', 'ky_hieu'], 'safe'],
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
        $query = GoiThue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'don_gia' => $this->don_gia,
        ]);

        $query->andFilterWhere(['like', 'ten', $this->ten])
            ->andFilterWhere(['like', 'ky_hieu', $this->ky_hieu]);

        return $dataProvider;
    }
}
