<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/3/2016
 * Time: 10:56 AM
 */

namespace backend\controllers;

use backend\models\DanhMuc;
use backend\models\DonVi;
use common\models\myAPI;
use common\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\web\Response;

class AutocompleteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['get-vi-tri-cong-viec', 'get-don-vi'],
                'rules' => [
                    [
                        'actions' => ['get-vi-tri-cong-viec', 'get-don-vi'],
                        'allow' => true,
//                        'matchCallback' => function($rule, $action){
//                            return Yii::$app->user->identity->username == 'adamin';
//                        }
                        'roles' => ['@']
                    ],
                ],
//                'denyCallback' => function ($rule, $action) {
//                    throw new Exception('You are not allowed to access this page', 404);
//                }
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

}
