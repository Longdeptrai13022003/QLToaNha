<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\GiaDien;
use common\models\myAPI;
use Yii;
use backend\models\GiaNuoc;
use backend\models\search\GiaNuoc as GiaNuocSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * GiaNuocController implements the CRUD actions for GiaNuoc model.
 */
class GiaNuocController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = true;
    public $contentAPI = null;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index','create','view','update','get-bang-gia','get-tien-nuoc'
        ];
        $rules = [];
        $this->contentAPI = json_decode(file_get_contents('php://input'));
        if(isset($this->contentAPI->uid)){
            $this->enableCsrfValidation = false;
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('GiaNuoc', $action_name, $this->contentAPI->uid);
                    }
                ];
            }
        }else
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
//                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return myAPI::isAccess2('GiaNuoc', $action_name);
                    }
                ];
            }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' =>$rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GiaNuoc models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new GiaNuocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single GiaNuoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "GiaNuoc #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new GiaNuoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GiaNuoc();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new GiaNuoc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new GiaNuoc",
                    'content'=>'<span class="text-success">Create GiaNuoc success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new GiaNuoc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing GiaNuoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update GiaNuoc #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "GiaNuoc #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update GiaNuoc #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing GiaNuoc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing GiaNuoc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the GiaNuoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiaNuoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiaNuoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetBangGia()
    {
        $giaNuoc = GiaNuoc::findOne($_POST['id']);
        $mucSuDungs = explode('-',$giaNuoc->luong_nuoc);
        $donGias = explode('-',$giaNuoc->don_gia);
        $content = [];
        foreach ($mucSuDungs as $index => $mucSuDung){
            $muc = [];
            if ($index == count($mucSuDungs)-1){
                $muc[] = 'Trên '.$mucSuDung.' m³/người/tháng';
            }elseif ($index == 0){
                $muc[] = 'Dưới '.$mucSuDungs[$index+1].' m³/người/tháng';
            }else{
                $muc[] = 'Từ '.$mucSuDung.'-'.$mucSuDungs[$index+1].' m³/người/tháng';
            }
            $muc[] = number_format($donGias[$index], 0, ',', '.').' đồng/m³';
            $content[] = $muc;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $content
        ];
    }

    public function actionGetTienNuoc()
    {
        $toiDa = CauHinh::findOne(['ghi_chu' => 'so_nuoc_toi_da'])->content;
        $soTieuThu = 0;
        $soNguoi = 1;
        $tienNuoc = 0;
        $soDau = intval($_POST['soDau']);
        $soCuoi = intval($_POST['soCuoi']);
        if ($soCuoi < $soDau){
            $soTieuThu = ($toiDa - $soDau) + $soCuoi;
        }else{
            $soTieuThu = $soCuoi - $soDau;
        }
        $bangGia = GiaNuoc::findOne($_POST['bangGiaID']);
        $mucSuDungs =  explode('-',$bangGia->luong_nuoc);
        $donGias = explode('-',$bangGia->don_gia);
        foreach ($mucSuDungs as $index => $mucSuDung){
            if ($index < count($mucSuDungs)-1){
                $soNuoc = (intval($mucSuDungs[$index+1])-intval($mucSuDung)) * $soNguoi;
                $tienNuoc += $donGias[$index] * min($soNuoc, $soTieuThu);
                if($soNuoc < $soTieuThu)
                    $soTieuThu -= $soNuoc;
                else
                    $soTieuThu = 0;
            }else
                $tienNuoc += $donGias[$index] * $soTieuThu;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phaiTra = (int)((float)$tienNuoc * (100 + $bangGia->thue)/100);
        return [
            'success' => true,
            'tienNuoc' => $phaiTra
        ];
    }
}
