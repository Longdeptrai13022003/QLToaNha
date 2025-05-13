<?php

namespace backend\models\search;

use backend\models\GiaoDich;
use backend\models\QuanLyDiaChiNhanHang;
use backend\models\QuanLyGiaoDich;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VaiTro;

/**
 * QuanLyDiaChiNhanHangSearch represents the model behind the search form about `backend\models\VaiTro`.
 */
class QuanLyDiaChiNhanHangSearch extends QuanLyDiaChiNhanHang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
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
        $query = QuanLyDiaChiNhanHang::find();
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
        $query->andFilterWhere(['active' => 1]);


        if(!(
            myAPI::isAccess([VaiTro::QUAN_LY_HE_THONG], is_null($api) ? Yii::$app->user->id : $api->uid)
            && !myAPI::isAccess([VaiTro::QUAN_LY_KHO], is_null($api) ? Yii::$app->user->id : $api->uid)
        )){
            $query->andFilterWhere(['user_id' => is_null($api) ? Yii::$app->user->id : $api->uid]);
        }

        return $dataProvider;
    }
}
