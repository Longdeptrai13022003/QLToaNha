<?php

namespace backend\models\search;

use backend\models\QuanLyUser;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cauhinh;

/**
 * CauhinhSearch represents the model behind the search form about `backend\models\Cauhinh`.
 */
class QuanLyUserSearch extends QuanLyUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
        [['id', 'status', 'VIP', 'hoat_dong'], 'safe'],
        [['created_at', 'updated_at', 'birth_day'], 'safe'],
        [['vi_dien_tu'], 'safe'],
        [['vai_tro'], 'safe'],
        [['username', 'password_hash', 'email', 'password', 'hoten', 'anhdaidien'], 'safe'],
        [['password_reset_token'], 'safe'],
        [['auth_key'], 'safe'],
        [['dien_thoai'], 'safe'],
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
    public function search($params, $idSearch = null)
    {
        $query = QuanLyUser::find();

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
        ]);

        $query->andFilterWhere(['status' => 10]);
        $query->andFilterWhere(['like', 'vai_tro', $this->vai_tro]);
        $query->andFilterWhere(['!=', 'vai_tro', VaiTro::KHACH_HANG]);
//        $query->andFilterWhere(['<>', 'vai_tro', 'Khách hàng']);

        if($this->vi_dien_tu_tu != ''){
            $query->andFilterWhere(['>=', 'vi_dien_tu', $this->vi_dien_tu]);
        }
        if($this->vi_dien_tu_den != ''){
            $query->andFilterWhere(['<=', 'vi_dien_tu', $this->vi_dien_tu]);
        }

        $query->andFilterWhere(['like', 'hoten', $this->hoten])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchKhachHang($params, $idSearch = null)
    {
        $query = QuanLyUser::find();

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
        ]);

        $query->andFilterWhere(['like', 'hoten', $this->hoten])
            ->andFilterWhere(['like', 'dien_thoai', $this->dien_thoai])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
