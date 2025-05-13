<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%trang_thai}}".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $loai_trang_thai
 * @property string|null $ghi_chu
 */
class TrangThai extends \yii\db\ActiveRecord
{
    const TYPE_HOA_DON = 1;
    const TYPE_GIAO_DICH = 2;
    const TYPE_HOP_DONG = 3;
    const TYPE_PHONG = 4;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trang_thai}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_trang_thai'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ten'], 'string', 'max' => 100],
            [['ten'], 'unique', 'targetAttribute' => ['ten', 'loai_trang_thai'], 'message' => 'Trạng thái với tên và loại này đã tồn tại.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Ten',
            'loai_trang_thai' => 'Loai Trang Thai',
            'ghi_chu' => 'Ghi Chu',
        ];
    }
    public static function getTypeList()
    {
        return [
            self::TYPE_HOA_DON => 'Hóa đơn',
            self::TYPE_GIAO_DICH => 'Giao dịch',
            self::TYPE_HOP_DONG => 'Hợp đồng',
            self::TYPE_PHONG => 'Phòng',
        ];
    }

    /**
     * Lấy nhãn (label) của loại trạng thái dựa vào giá trị
     * @return string|null
     */
    public function getTypeLabel()
    {
        return self::getTypeList()[$this->loai_trang_thai] ?? null;
    }
    public function getTypeLabelWithStyle()
    {
        $list = [
            self::TYPE_HOA_DON => ['label' => 'Hóa đơn', 'icon' => '🧾', 'color' => '#007bff', 'tooltip' => 'Trạng thái liên quan đến hóa đơn'],
            self::TYPE_GIAO_DICH => ['label' => 'Giao dịch', 'icon' => '💳', 'color' => '#28a745', 'tooltip' => 'Trạng thái liên quan đến giao dịch'],
            self::TYPE_HOP_DONG => ['label' => 'Hợp đồng', 'icon' => '📄', 'color' => '#fd7e14', 'tooltip' => 'Trạng thái liên quan đến hợp đồng'],
            self::TYPE_PHONG => ['label' => 'Phòng', 'icon' => '🏠', 'color' => '#6f42c1', 'tooltip' => 'Trạng thái liên quan đến phòng'],
        ];

        $type = $list[$this->loai_trang_thai] ?? null;

        if ($type) {
            return "<span title=\"{$type['tooltip']}\" style=\"color: {$type['color']}; font-weight: bold;\">{$type['icon']} {$type['label']}</span>";
        }

        return null;
    }
}
