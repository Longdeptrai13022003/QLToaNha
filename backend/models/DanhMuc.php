<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%danh_muc}}".
 *
 * @property integer $id
 * @property integer $dai_han
 * @property string $name
 * @property string $type
 * @property string $ghi_chu
 * @property string $hinh_anh
 * @property integer $hide
 * @property integer $parent_id
 * @property integer $don_gia
 * @property string $gia_dich_vu
 * @property string $gia_thue_ngan
 * @property integer $gia_dien
 * @property integer $gia_nuoc
 * @property integer $gia_nuoc_nguoi
 * @property integer $so_dien
 * @property integer $so_nuoc
 * @property integer $thu_tu
 * @property integer $selected
 *
 * @property DanhMuc $parent
 * @property DanhMuc[] $danhMucs
 * @property User[] $users
 */
class DanhMuc extends ActiveRecord
{
    const TOA_NHA = 'Toà nhà';
    const PHONG_O = 'Phòng ở';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qlcvsd_danh_muc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['thu_tu', 'don_gia','don_gia_khoi', 'parent_id','gia_dich_vu','gia_thue_ngan','dai_han','gia_dien','gia_nuoc','so_dien','so_nuoc','gia_nuoc_nguoi'], 'safe'],
            [['type'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên',
            'don_gia' => 'Đơn giá',
            'don_gia_khoi' => 'Đơn giá/khối',
            'type' => 'Phân loại',
        ];
    }
}
