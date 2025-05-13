<?php

namespace backend\models\search;

use backend\models\HoaDon;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QuanLyHoaDon;

/**
 * HoaDonSearch represents the model behind the search form about `backend\models\HoaDon`.
 */
class QuanLyHoaDonSearch extends QuanLyHoaDon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phong_khach_id', 'active', 'chot_hoa_don', 'thang', 'user_id', 'nam'], 'integer'],
            [['chi_phi_dich_vu', 'da_thanh_toan', 'tien_phong', 'tong_tien', 'thanh_tien'], 'number'],
            [['created','trang_thai'], 'safe'],
            [['ma_hoa_don','ten_phong','ten_toa_nha','hoten','dien_thoai','nguoi_thuc_hien'], 'string'],
            [['dien_thoai'], 'string', 'max' => 20],
            [['dien_thoai','ma_hoa_don','ten_phong','ten_toa_nha','nguoi_thuc_hien'], 'string', 'max' => 100],
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
        $query = QuanLyHoaDon::find();

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
            ->andFilterWhere(['!=', 'trang_thai', HoaDon::HOAN_THANH])
            ->andFilterWhere(['like','ma_hoa_don',$this->ma_hoa_don])
            ->andFilterWhere(['like','nguoi_thuc_hien',$this->nguoi_thuc_hien])
            ->andFilterWhere(['like','hoten',$this->hoten])
            ->andFilterWhere(['like','ten_phong',$this->ten_phong])
            ->andFilterWhere(['like','ten_toa_nha',$this->ten_toa_nha])
            ->andFilterWhere(['like','dien_thoai',$this->dien_thoai]);

        return $dataProvider;
    }
}
