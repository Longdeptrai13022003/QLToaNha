<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FileHopDong;

/**
 * FileHopDongSearch represents the model behind the search form about `backend\models\FileHopDong`.
 */
class FileHopDongSearch extends FileHopDong
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phong_khach_id', 'user_id'], 'integer'],
            [['file', 'created'], 'safe'],
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
        $query = FileHopDong::find();

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
            'phong_khach_id' => $this->phong_khach_id,
            'created' => $this->created,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
