<?php

namespace backend\models;

use common\models\myActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%LogGetListSanPham}}".
 *
 * @property integer $id
 * @property string $content
 * @property string $keyword
 * @property string $link
 * @property string $type
 * @property int $user_id
 * @property int $danh_muc_id
 * @property string $created
 * @property string $domain
 */
class LogGetListSanPham extends ActiveRecord
{
  //enum('Get SP From Link', 'Get List SP')
  const GET_SP_FROM_LINK = 'Get SP From Link';
  const GET_LIST_SP = 'Get List SP';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log_get_list_san_pham}}';
    }

    /**LogGetListSanPham
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'created', 'user_id', 'danh_muc_id', 'keyword', 'type', 'link', 'domain'], 'safe'],
        ];
    }
}
