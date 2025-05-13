<?php

namespace backend\models;

use common\models\myActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%vai_tro}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property PhanQuyen[] $phanQuyens
 * @property Vaitrouser[] $vaitrousers
 */
class VaiTro extends ActiveRecord
{
  const ID_VAI_TRO_KHACH_HANG = 7;
  const QUAN_LY = 'Quản lý';
    const NHAN_VIEN = 'Nhân viên';
    const QUAN_LY_HE_THONG = 'Quản lý hệ thống';
    const TRUONG_PHONG = 'Trưởng phòng';
    const TRUONG_NHOM = 'Trưởng nhóm';
    const CHU_TICH = 'Chủ Tịch';
    const KHACH_HANG = 'Khách hàng';
    const QUAN_LY_KHO = 'Quản lý kho';
    const SALE = 'Sale';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qlcvsd_vai_tro';
    }

    public static $arr_vai_tro = [
        self::QUAN_LY_HE_THONG => self::QUAN_LY_HE_THONG,
        self::TRUONG_PHONG => self::TRUONG_PHONG,
        self::NHAN_VIEN => self::NHAN_VIEN,
        self::TRUONG_NHOM => self::TRUONG_NHOM,
        self::CHU_TICH => self::CHU_TICH,
        self::KHACH_HANG => self::KHACH_HANG,
        self::QUAN_LY_KHO => self::QUAN_LY_KHO,
        self::SALE => self::SALE
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên vai trò',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhanQuyens()
    {
        return $this->hasMany(PhanQuyen::className(), ['vai_tro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVaitrousers()
    {
        return $this->hasMany(Vaitrouser::className(), ['vaitro_id' => 'id']);
    }
}
