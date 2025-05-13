<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%nguoi_o_cung}}".
 *
 * @property int $id
 * @property string|null $ho_ten
 * @property string|null $dien_thoai
 * @property int|null $hop_dong_id
 *
 * @property ChiTietOCung[] $chiTietOCungs
 * @property PhongKhach $hopDong
 */
class NguoiOCung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nguoi_o_cung}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hop_dong_id'], 'integer'],
            [['ho_ten'], 'string', 'max' => 100],
            [['dien_thoai'], 'string', 'max' => 20],
            [['hop_dong_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhongKhach::className(), 'targetAttribute' => ['hop_dong_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ho_ten' => 'Ho Ten',
            'dien_thoai' => 'Dien Thoai',
            'hop_dong_id' => 'Hop Dong ID',
        ];
    }

    /**
     * Gets query for [[ChiTietOCungs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChiTietOCungs()
    {
        return $this->hasMany(ChiTietOCung::className(), ['nguoi_o_dung_id' => 'id']);
    }

    /**
     * Gets query for [[HopDong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHopDong()
    {
        return $this->hasOne(PhongKhach::className(), ['id' => 'hop_dong_id']);
    }
}
