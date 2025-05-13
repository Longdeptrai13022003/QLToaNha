<?php


namespace backend\controllers;


use backend\models\ChucNang;
use backend\models\PhanQuyen;
use backend\models\QuanLyPhanQuyen;
use backend\models\VaiTro;
use common\models\myAPI;
use common\models\User;
//use WindowsAzure\MediaServices\Models\Job;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class PhanQuyenController extends Controller
{
    public function behaviors()
    {

        $arr_action = ['index', 'getphanquyen', 'save'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
//                'matchCallback' => myAPI::isAccess2($controller, $item)
                'matchCallback' => function ($rule, $action) {
                    $action_name =  strtolower(str_replace('action', '', $action->id));
                    return \Yii::$app->user->id == 1 || myAPI::isAccess2('PhanQuyen', $action_name);
                }
            ];
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex(){
        $vaitro = ArrayHelper::map(
            VaiTro::find()->where(['not in', 'name', ['Chủ tịch', 'Quản lý']])->andWhere(['active' => 1])->all(),
            'id',
            'name'
        );
//        VarDumper::dump($vaitro);
//        exit();
        return $this->render('index', [
            'dsvaitro' => $vaitro
        ]);

    }

    public function actionGetphanquyen(){
        $chucnang = ChucNang::findAll(['nhom' => $_POST['nhom_chuc_nang']]);
        $vaitro = VaiTro::find()->where(['not in', 'name', ['Chủ tịch', 'Quản lý']])->andWhere(['active' => 1])->all();
        $phanquyen = [];
        foreach ($chucnang as $item) {
            foreach ($vaitro as $item_vaitro) {
                $phanquyen[$item->id][$item_vaitro->id] = !is_null(PhanQuyen::findOne(['chuc_nang_id' => $item->id, 'vai_tro_id' => $item_vaitro->id]));
            }
        }

        echo Json::encode([
            'table_phanquyen' => $this->renderAjax('_table_phanquyen', [
                'chucnang' => $chucnang,
                'vaitro' => $vaitro,
                'phanquyen' => $phanquyen
            ])
        ]);
        exit;
    }

    public function actionSave(){
        ini_set('max_execution_time', 999999);

        $quanlyphanquyen = QuanLyPhanQuyen::findAll(['nhom' => $_POST['nhom_chuc_nang']]);
        foreach ($quanlyphanquyen as $item) {
            PhanQuyen::deleteAll(['id' => $item->id]);
        }

        if(isset($_POST['phanquyen']))
            foreach ($_POST['phanquyen'] as $chucnang_id => $item)
                foreach ($item as $vaitro_id => $value) {
                    $phanquyen = new PhanQuyen();
                    $phanquyen->chuc_nang_id = $chucnang_id;
                    $phanquyen->vai_tro_id = $vaitro_id;
                    $phanquyen->save();
                }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return (['message' => myAPI::getMessage('success', 'Đã lưu phân quyền thành công')]);
    }
}