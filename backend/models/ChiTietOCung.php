<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%chi_tiet_o_cung}}".
 *
 * @property int $id
 * @property int|null $hoa_don_id
 * @property int|null $nguoi_o_cung_id
 *
 * @property HoaDon $hoaDon
 * @property NguoiOCung $nguoiODung
 */
class ChiTietOCung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chi_tiet_o_cung}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hoa_don_id', 'nguoi_o_cung_id'], 'integer'],
            [['hoa_don_id'], 'exist', 'skipOnError' => true, 'targetClass' => HoaDon::className(), 'targetAttribute' => ['hoa_don_id' => 'id']],
            [['nguoi_o_cung_id'], 'exist', 'skipOnError' => true, 'targetClass' => NguoiOCung::className(), 'targetAttribute' => ['nguoi_o_cung_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hoa_don_id' => 'Hoa Don ID',
            'nguoi_o_cung_id' => 'Nguoi O Dung ID',
        ];
    }

    /**
     * Gets query for [[HoaDon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDon()
    {
        return $this->hasOne(HoaDon::className(), ['id' => 'hoa_don_id']);
    }

    /**
     * Gets query for [[NguoiODung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiODung()
    {
        return $this->hasOne(NguoiOCung::className(), ['id' => 'nguoi_o_cung_id']);
    }
}
