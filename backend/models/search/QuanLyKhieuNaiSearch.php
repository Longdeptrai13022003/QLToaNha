<?php

namespace backend\models\search;

use app\models\QuanLyPhieuYeuCauGiaoHang;
use backend\models\GiaoDich;
use backend\models\QuanLyGiaoDich;
use backend\models\QuanLyKhieuNai;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ChucNang;

/**
 * ChucNangSearch represents the model behind the search form about `backend\models\ChucNang`.
 */
class QuanLyKhieuNaiSearch extends QuanLyKhieuNai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_don_hang_id', 'field_active', 'user_id'], 'integer'],
            [['field_noi_dung_khieu_nai', 'field_trang_thai_khieu_nai', 'field_nguoi_nhap_phan_hoi', 'field_anh_khieu_nai'], 'string'],
            [['created'], 'safe'],
            [['titlte', 'hoten', 'username'], 'string', 'max' => 100],
            [['dien_thoai'], 'string', 'max' => 20],
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
        $query = QuanLyKhieuNai::find();
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

        if(!is_null($api)){

        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(count($selects) > 0)
            $query->select($selects);
        if(!User::isViewAll(is_null($api) ? null : $api->uid)){
            $query->andFilterWhere(['user_id' => $api->uid]);
        }
        return $dataProvider;
    }
}
