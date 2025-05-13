<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%chi_tiet_chi_phi}}".
 *
 * @property int $id
 * @property int|null $chi_phi_id
 * @property int|null $phieu_chi_id
 * @property float|null $so_tien
 * @property string|null $ghi_chu
 * @property string|null $ten_chi_phi
 *
 * @property ChiPhi $chiPhi
 * @property PhieuChi $phieuChi
 */
class ChiTietChiPhi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chi_tiet_chi_phi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chi_phi_id', 'phieu_chi_id'], 'integer'],
            [['so_tien'], 'number'],
            [['ghi_chu', 'ten_chi_phi'], 'string', 'max' => 100],
            [['chi_phi_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChiPhi::className(), 'targetAttribute' => ['chi_phi_id' => 'id']],
            [['phieu_chi_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhieuChi::className(), 'targetAttribute' => ['phieu_chi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chi_phi_id' => 'Chi Phi ID',
            'phieu_chi_id' => 'Phieu Chi ID',
            'so_tien' => 'So Tien',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[ChiPhi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChiPhi()
    {
        return $this->hasOne(ChiPhi::className(), ['id' => 'chi_phi_id']);
    }

    /**
     * Gets query for [[PhieuChi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhieuChi()
    {
        return $this->hasOne(PhieuChi::className(), ['id' => 'phieu_chi_id']);
    }
}
