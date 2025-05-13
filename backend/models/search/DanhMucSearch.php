<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DanhMuc;

/**
 * DanhMucSearch represents the model behind the search form about `backend\models\DanhMuc`.
 */
class DanhMucSearch extends DanhMuc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'safe'],
            [['type'], 'safe'],
            [['hide', 'parent_id'], 'safe'],
            [['name'], 'safe'],
            [['parent_id'], 'safe'],
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
    public function search($params, $arrNhom = [])
    {
        $query = DanhMuc::find();

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
            'active' => 1
        ]);
        if(count($arrNhom) > 0)
            $query->andFilterWhere(['in', 'type', $arrNhom]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
