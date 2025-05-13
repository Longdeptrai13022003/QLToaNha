<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ThucHienCongViec;

/**
 * ThucHienCongViecSearach represents the model behind the search form about `backend\models\ThucHienCongViec`.
 */
class ThucHienCongViecSearch extends ThucHienCongViec
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ke_hoach_nvien_pban_id', 'user_id'], 'integer'],
            [['tieu_de', 'noi_dung', 'thoi_gian_thuc_hien', 'thoi_gian_ket_thuc', 'created', 'updated', 'trang_thai'], 'safe'],
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
        $query = ThucHienCongViec::find();

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
            'ke_hoach_nvien_pban_id' => $this->ke_hoach_nvien_pban_id,
            'thoi_gian_thuc_hien' => $this->thoi_gian_thuc_hien,
            'thoi_gian_ket_thuc' => $this->thoi_gian_ket_thuc,
            'user_id' => $this->user_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'tieu_de', $this->tieu_de])
            ->andFilterWhere(['like', 'noi_dung', $this->noi_dung])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
