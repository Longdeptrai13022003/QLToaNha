<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%trang_thai_phong}}".
 *
 * @property int $id
 * @property int|null $khach_hang_id
 * @property string|null $trang_thai
 * @property string|null $thoi_gian_tu
 * @property string|null $thoi_gian_den
 * @property int|null $phong_id
 *
 * @property DanhMuc $phong
 * @property User $khachHang
 */
class TrangThaiPhong extends \yii\db\ActiveRecord
{
    const PHONG_TRONG = 'Phòng trống';
    const DANG_CO_KHACH = 'Đang có khách';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trang_thai_phong}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['khach_hang_id', 'phong_id'], 'integer'],
            [['trang_thai'], 'string'],
            [['thoi_gian_tu', 'thoi_gian_den'], 'safe'],
            [['phong_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMuc::className(), 'targetAttribute' => ['phong_id' => 'id']],
            [['khach_hang_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['khach_hang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'khach_hang_id' => 'Khach Hang ID',
            'trang_thai' => 'Trang Thai',
            'thoi_gian_tu' => 'Thoi Gian Tu',
            'thoi_gian_den' => 'Thoi Gian Den',
            'phong_id' => 'Phong ID',
        ];
    }

    /**
     * Gets query for [[Phong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhong()
    {
        return $this->hasOne(DanhMuc::className(), ['id' => 'phong_id']);
    }

    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(User::className(), ['id' => 'khach_hang_id']);
    }
}
