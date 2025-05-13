<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cauhinh}}".
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 * @property string $ghi_chu
 */
class CauHinh extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cauhinh}}';
    }

    /**Cauhinh
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'name'], 'safe'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Nội dung'),
            'ghi_chu' => Yii::t('app', 'Ký hiệu'),
            'name' => Yii::t('app', 'Tên'),
        ];
    }

    public static function getTyGiaDaiViet(){
      return self::findOne(['ghi_chu' => 'ty_gia_dai_viet'])->content;
    }

    public static function getTyLeLoiNhuan(){
      return self::findOne(['ghi_chu' => 'ty_le_loi_nhuan'])->content;
    }

    public static function getListSanPhamByKeyword($keyword, $pageNumber, $idCategory, $uid){
      $params = [
        'site' => 'vn',
        'keyword' => $keyword == '' ? DanhMuc::findOne($idCategory)->name : $keyword,
        'pageSize' => CauHinh::findOne(['ghi_chu' => 'so_luong_san_pham_mot_trang'])->content,
        'page' => $pageNumber
      ];

      $strParams = http_build_query($params);

      $curl = curl_init();

      curl_setopt_array($curl, [
        CURLOPT_URL => "https://shopee-e-commerce-data.p.rapidapi.com/shopee/search/items/v2?".$strParams,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
          "X-RapidAPI-Host: shopee-e-commerce-data.p.rapidapi.com",
          "X-RapidAPI-Key: ".self::findOne(['ghi_chu' => 'key_api_shopee_rapid'])->content
        ],
      ]);

      $response = curl_exec($curl);

      $model = new LogGetListSanPham();
      $model->content = json_encode($response);
      $model->user_id = $uid;
      $model->keyword = $keyword;
      if($idCategory != '' && !is_null($idCategory))
        $model->danh_muc_id = $idCategory;
      $model->save();

      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return false;
      } else {
        $results = json_decode($response);
        if(isset($results->code)){
          if($results->code == 200)
            return $results->data->items;
        }
        return false;
      }
//echo json_encode();
    }

    public static  function getTyLeLoiNhuanFromPrice($price, $cauHihTyLeLoiNhuan){
//100:2
//200:3
//-1:4
      $tyLeLoiNhuan = null;
      $arrCauHinhTyleLoiNhuan = explode('<br />', nl2br($cauHihTyLeLoiNhuan));
      foreach ($arrCauHinhTyleLoiNhuan as $index => $item){
        $arrItem = explode(':', $item);
        if($price < $arrItem[0]){
          $tyLeLoiNhuan = $arrItem[1];
          break;
        }
      }
      if(is_null($tyLeLoiNhuan)){
        $lastItem = $arrCauHinhTyleLoiNhuan[$index];
        $tyLeLoiNhuan = explode(':', $lastItem)[1];
      }
      return $tyLeLoiNhuan;
    }
}
