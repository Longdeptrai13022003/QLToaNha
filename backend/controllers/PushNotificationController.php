<?php


namespace backend\controllers;


use yii\web\Controller;

class PushNotificationController extends Controller
{
    public function actionTest(){
        \Yii::$app->webpusher->userPush("hello user", [87]);
    }
}
