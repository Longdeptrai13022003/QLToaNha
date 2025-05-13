<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HoaDon;

/**
 * HoaDonSearch represents the model behind the search form about `backend\models\HoaDon`.
 */
class HoaDonSearch extends HoaDon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'thang', 'nam', 'phong_khach_id'], 'integer'],
            [['created', 'chot_hoa_don', 'active','trang_thai', 'ma_hoa_don'], 'safe'],
            [['tien_phong', 'chi_phi_dich_vu', 'tong_tien', 'da_thanh_toan'], 'number'],
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
    public function search($params,$api = null)
    {
        $query = HoaDon::find();

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
            'user_id' => $this->user_id,
            'created' => $this->created,
            'thang' => $this->thang,
            'nam' => $this->nam,
            'phong_khach_id' => $this->phong_khach_id,
            'tien_phong' => $this->tien_phong,
            'chi_phi_dich_vu' => $this->chi_phi_dich_vu,
            'tong_tien' => $this->tong_tien,
            'trang_thai' => $this->trang_thai,
//            'chot_hoa_don' => 1,
            'da_thanh_toan' => $this->da_thanh_toan,
            'active'=>1
        ]);

        $currentMonth = date('n');
        $currentYear = date('Y');
        $query->andWhere([
            'or',
            ['<', 'nam', $currentYear],
            [
                'and',
                ['=', 'nam', $currentYear],
                ['<=', 'thang', $currentMonth]
            ]
        ]);

        $query->andFilterWhere(['like', 'chot_hoa_don', $this->chot_hoa_don])
            ->andFilterWhere(['like','ma_hoa_don',$this->ma_hoa_don]);

        return $dataProvider;
    }
}
