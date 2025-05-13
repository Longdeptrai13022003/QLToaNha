<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\DanhMuc;
use backend\models\QuanLyGiaoDich;
use backend\models\search\QuanLyGiaoDichSearch;
use backend\models\search\QuanLyKhachHangSearch;
use backend\models\search\QuanLyUserSearch;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use common\models\myAPI;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index','xoa-anh','view', 'create', 'update', 'delete', 'xoa-anh-dai-dien', 'change-status','khach-hang','them-khach-hang','update-khach-hang','popup-khach-hang'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('User', $action_name, $this->contentAPI->uid);
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
                        return myAPI::isAccess2('User', $action_name);
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
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuanLyUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //khach-hang
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionKhachHang()
    {
        $this->contentAPI = json_decode(file_get_contents('php://input'));

        if(isset($this->contentAPI->uid)){
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $searchModel = new QuanLyKhachHangSearch();
            $check = myAPI::checkBeforeAction($this->contentAPI);
            if($check['success']){

                Yii::$app->response->format = Response::FORMAT_JSON;

                $dataProvider = $searchModel->search($queryParams, $this->contentAPI);
                $dataProvider->setPagination(['page' => $this->contentAPI->data->page, 'pageSize' => 10]);
                $data = $dataProvider->getModels();

                foreach ($data as $indx => $item){
                    $data[$indx]->id = $item->user_old_id;
                }

                return [
                    'success' => true,
                    'content' =>  $data,
                    'roles' => '',//ArrayHelper::map(UserVaiTro::findAll(['user_id' => $this->contentAPI->uid]), 'vai_tro', 'vai_tro'),
                    'loadMore' => ($this->contentAPI->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount()
                ];

            }else
            {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }

        }
        else{
            $searchModel = new QuanLyKhachHangSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
            return $this->render('khach-hang/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Thông tin khách hàng",
                'content'=>$this->renderAjax('khach-hang/view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Chỉnh sửa',['update-khach-hang','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        }else{
            return $this->render('khach-hang/view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User();
        $vaitros = [];
        $vaitrouser = new Vaitrouser();
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm thành viên",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'vaitros' => $vaitros,
                        'vaitrouser' => $vaitrouser,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
//                if($model->validate())
//                    $model->setPassword($model->password_hash);

                $model->created_at = date("Y-m-d H:i:s");
                $model->password_hash = $model->password;
                $model->password = '';
                $file = UploadedFile::getInstance($model, 'anhdaidien');
                $path = '';

                if ($model->email)
                    if(!is_null($file)){
                        $model->anhdaidien = myAPI::createCode(time().$file->name);
                        $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$model->anhdaidien;
                    }
                    else{
                        $model->anhdaidien = 'no-image.jpg';
                    }
                if($model->validate()){
                    if ($model->save()){
                        if ($path != '')
                            $file->saveAs($path);
                        return [
                            'success' => true,
                            'forceReload'=>'#crud-datatable-pjax',
                            'title'=> "Thêm mới thành viên",
                            'content'=>'<span class="text-success">Thêm mới thành viên thành công</span>',
                            'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Tạo thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                        ];
                    }
                }else{
                    return [
                        'title'=> "Thêm mới thành viên",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                            'vaitros' => $vaitros,
                            'vaitrouser' => $vaitrouser
                        ]),
                        'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }
                //                else
                //                    throw new HttpException(500, Html::errorSummary($model));
            }else{
                return [
                    'title'=> "Thêm mới thành viên",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'vaitros' => $vaitros,
                        'vaitrouser' => $vaitrouser
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

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

    public function actionThemKhachHang()
    {
        $request = Yii::$app->request;
        $model = new User();

        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thêm khách hàng",
                'content'=>$this->renderAjax('khach-hang/create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

            ];
        }else if($model->load($request->post())){
            $model->username = 'user_' . time();
            $model->password_hash = uniqid('', true);
            if (mb_strlen($model->password_hash) < 6) {
                $model->password_hash = uniqid('', true) . '123';
            }
//            if($model->validate())
//                $model->setPassword($model->password_hash);

            $model->created_at = date("Y-m-d H:i:s");
            $file = UploadedFile::getInstance($model, 'anhdaidien');
            $path = '';
            if(!is_null($file)){
                $model->anhdaidien = myAPI::createCode(time().$file->name);
                $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$model->anhdaidien;
            }
            else{
                //Nếu người dùng không uplaod ảnh thì mặc đinh lấy hình anảnh no-image.jpg
                $model->anhdaidien = 'no-image.jpg';
            }

            $name1 = 'no-image.jpg';
            $name2 = 'no-image.jpg';
            $cccd1 = UploadedFile::getInstanceByName('anhcancuoc1');
            $cccd2 = UploadedFile::getInstanceByName('anhcancuoc2');
            $pathcccd1 = '';
            $pathcccd2 = '';
            $time = time();
            if(!is_null($cccd1)){
                $name1 = myAPI::createCode('1'.$time.$cccd1->name);
                $pathcccd1 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name1;
            }
            if(!is_null($cccd2)){
                $name2 = myAPI::createCode('2'.$time.$cccd2->name);
                $pathcccd2 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name2;
            }
            $model->anhcancuoc = $name1.','.$name2;

            if($model->save()){
                if ($path != '')
                    $file->saveAs($path);
                if($pathcccd1!='')
                    $cccd1->saveAs($pathcccd1);
                if($pathcccd2!='')
                    $cccd2->saveAs($pathcccd2);
                return [
                    'success'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới khách hàng",
                    'content'=>'<span class="text-success">Thêm mới khách hàng thành công</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Tạo thêm',['them-khach-hang'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'success'=>false,
                    'title'=> "Thêm khách hàng",
                    'content'=>$this->renderAjax('khach-hang/create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            return [
                'title'=> "Thêm khách hàng",
                'content'=>$this->renderAjax('khach-hang/create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

            ];
        }
    }

    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){

        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $hinhAnhCu = $model->anhdaidien;
        $vaitros = ArrayHelper::map(Vaitrouser::findAll(['user_id' => $id]), 'vai_tro_id', 'vai_tro_id');
        $vaitrouser = new Vaitrouser();
        if($request->isAjax){

            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Chỉnh sửa thông tin thành viên",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'vaitros' => $vaitros,
                        'vaitrouser' => $vaitrouser,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
            else if($model->load($request->post())){
                $oldUser = User::findOne($id);
                $model->password != '' ?  $model->password_hash = $model->password : $model->password_hash = $oldUser->password_hash;
                $model->password = '';
                if($oldUser->password_hash != $model->password_hash && $model->validate())
                    $model->setPassword($model->password_hash);
                if($model->id == 1){
                    if(Yii::$app->user->id != 1){
                        echo Json::encode(['message' => myAPI::getMessage('danger', 'Bạn không có quyền thực hiện chức năng này')]);
                        exit;
                    }
                }

                $file = UploadedFile::getInstance($model, 'anhdaidien');
                if($model->save()){
                    $path = '';

                    if (!is_null($file)){
                        $anhdaidien = myAPI::createCode(time().$file->name);
                        $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$anhdaidien;
                        $model->updateAttributes(['anhdaidien'=>$anhdaidien]);
                        if ($hinhAnhCu != '' && $hinhAnhCu != 'no-image.jpg'){
                            $oldPath = dirname(dirname(__DIR__)).'/hinh-anh/'.$hinhAnhCu;
                            if (is_file($oldPath))
                                unlink($oldPath);
                        }
                        $file->saveAs($path);
                    }
                    else{
                        $model->updateAttributes(['anhdaidien' => $hinhAnhCu]);
                    }
                    return [
                        'success' => true,
                        'forceReload'=>'#crud-datatable-pjax',
                        'title' => "Thông tin thành viên",
                        'content' => '<div class="alert alert-success"><i class="fa fa-check-circle"></i> Lưu thông tin thành viên thành công!</div>',
                        'footer' => Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];
                }else{
                    if (is_null($file))
                        $model->anhdaidien = $oldUser->anhdaidien;
                    return [
                        'title'=> "Cập nhật thông tin thành viên " . $model->hoten,
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                            'vaitros' => $vaitros,
                            'vaitrouser' => $vaitrouser
                        ]),
                        'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }

            }else{
                return [
                    'title'=> "Chỉnh sửa thông tin thành viên",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'vaitros' => $vaitros,
                        'vaitrouser' => $vaitrouser
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
        else{
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

    public function actionUpdateKhachHang($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $hinhAnhCu = $model->anhdaidien;
        $cancuoccu = $model->anhcancuoc;
        $error = [
            'loi_ho_ten' => '',
            'loi_dien_thoai' => '',
            'loi_mat_khau' => '',
            'loi_ten_dang_nhap' => '',
            'loi_anh_can_cuoc' => ''
        ];
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Chỉnh sửa thông tin khách hàng",
                    'content'=>$this->renderAjax('khach-hang/update', [
                        'model' => $model,
                        'error' => $error,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post())){
                $oldUser = User::findOne($id);

                if($oldUser->password_hash != $model->password_hash && $model->validate())
                    $model->setPassword($model->password_hash);
                if($model->id == 1){
                    if(Yii::$app->user->id != 1){
                        echo Json::encode(['message' => myAPI::getMessage('danger', 'Bạn không có quyền thực hiện chức năng này')]);
                        exit;
                    }
                }
                $file = UploadedFile::getInstance($model, 'anhdaidien');
                $cccd1 = UploadedFile::getInstanceByName('anhcancuoc1');
                $cccd2 = UploadedFile::getInstanceByName('anhcancuoc2');

                $name = explode(',',$oldUser->anhcancuoc);
                $name1 = $name[0];
                $name2 = $name[1];


                if($model->save()){
                    $path = '';
                    $pathcccd1 = '';
                    $pathcccd2 = '';

                    if (!is_null($file)){
                        $anhdaidien = myAPI::createCode(time().$file->name);
                        $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$anhdaidien;
                        $model->updateAttributes(['anhdaidien'=>$anhdaidien]);
                        if ($hinhAnhCu != '' && $hinhAnhCu != 'no-image.jpg'){
                            $oldPath = dirname(dirname(__DIR__)).'/hinh-anh/'.$hinhAnhCu;
                            if (is_file($oldPath))
                                unlink($oldPath);
                        }
                        $file->saveAs($path);
                    }
                    else{
                        $model->updateAttributes(['anhdaidien' => $hinhAnhCu]);
                    }

                    if(!is_null($cccd1)){
                        $name1 = myAPI::createCode('1'.time().$cccd1->name);
                        $pathcccd1 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name1;
                        if($name[0]!='' && $name[0] != 'no-image.jpg'){
                            $oldcccd1 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name[0];
                            if(is_file($oldcccd1))
                                unlink($oldcccd1);
                        }
                        $cccd1->saveAs($pathcccd1);
                    }
                    if(!is_null($cccd2)){
                        $name2 = myAPI::createCode('1'.time().$cccd2->name);
                        $pathcccd2 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name2;
                        if($name[1]!='' && $name[1] != 'no-image.jpg'){
                            $oldcccd2 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name[1];
                            if(is_file($oldcccd2))
                                unlink($oldcccd2);
                        }
                        $cccd2->saveAs($pathcccd2);
                    }
                    $model->updateAttributes(['anhcancuoc'=>$name1.','.$name2]);

                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title' => "Thông tin khách hàng",
                        'content' => '<div class="alert alert-success"><i class="fa fa-check-circle"></i> Lưu thông tin khách hàng thành công!</div>',
                        'footer' => Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Chỉnh sửa',['update-khach-hang','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];
                }else{
                    if(is_null($file))
                        $model->anhdaidien = $oldUser->anhdaidien;
                    return [
                        'title'=> "Chỉnh sửa thông tin khách hàng hàng",
                        'content'=>$this->renderAjax('khach-hang/update', [
                            'model' => $model,
                            'error' => $error,
                        ]),
                        'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }

            }else{
                return [
                    'title'=> "Chỉnh sửa thông tin khách hàng",
                    'content'=>$this->renderAjax('khach-hang/update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['khach-hang/view', 'id' => $model->id]);
            } else {
                return $this->render('khach-hang/update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($id != 1  || ($id == 1 && Yii::$app->user->id == 1)){
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
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
    }

    /**
     * Delete multiple existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //xoa-anh-dai-dien
    public function actionXoaAnhDaiDien(){
        $user = User::findOne($_POST['id_user']);
        if(is_null($user))
            throw new HttpException(500,'Người dùng ko tồn tại');
        else{
            $anhdaidien = $user->anhdaidien;
            if($anhdaidien != ''){
                $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$user->anhdaidien;
                if(is_file($path)){
                    //xóa ảnh trong thư mực hình ảnh
                    unlink($path);
                    //Upload lại tên file trong bảng user
                    $user->updateAttributes(['anhdaidien' => 'no-image.jpg']);
                }
            }
        };
        //Quay trở lại trang người dùng
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ([
            'success' => true,
            'content' => [
                'message' => 'Xóa ảnh đại diện thành công',
                'new_img' => CauHinh::findOne(['ghi_chu' => 'no_image'])->content
            ]
        ]);
    }

    /** xoa-anh */
    public function actionXoaAnh(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne($_POST['idUser']);
        $loaiAnh = $_POST['loaiAnh'];

        if($loaiAnh=='anhdaidien'){
            $oldPath = dirname(dirname(__DIR__)).'/hinh-anh/'.$user->anhdaidien;
            if (is_file($oldPath))
                unlink($oldPath);
            $user->updateAttributes([
                'anhdaidien'=>'no-image.jpg',
            ]);
        }
        else if($loaiAnh=='anhcancuoc0'){
            $anhs = explode(',',$user->anhcancuoc);
            $oldPath = dirname(dirname(__DIR__)).'/hinh-anh/'.$anhs[0];
            if (is_file($oldPath))
                unlink($oldPath);
            $user->updateAttributes(['anhcancuoc'=>'no-image.jpg,'.$anhs[1]]);
        }
        else{
            $anhs = explode(',',$user->anhcancuoc);
            $oldPath = dirname(dirname(__DIR__)).'/hinh-anh/'.$anhs[1];
            if (is_file($oldPath))
                unlink($oldPath);
            $user->updateAttributes(['anhcancuoc'=>$anhs[0].',no-image.jpg']);
        }
        return ['status'=>'success'];

    }
    //change-status
    public function actionChangeStatus(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $donHang = User::findOne($_POST['uid']);
        if ($donHang) {
            if ($donHang->status == 0)
                $trangThai = 10;
            else
                $trangThai = 0;
            $donHang->updateAttributes(['status' => $trangThai]);
            return ['status' => 'success'];
        } else {
            return ([
                'content' => 'Không tìm thấy thông tin',
                'title' => 'Thông báo'
            ]);
        }
    }
    //Tao-khach-hang
    public function actionTaoKhachHang()
    {
        $request = Yii::$app->request;
        $model = new User();
        $error = [
            'loi_email' => ''
        ];
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm khách hàng",
                    'content'=>$this->renderAjax('khach-hang/create', [
                        'model' => $model,
                        'error' => $error,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
//                if(!filter_var($model->email, FILTER_VALIDATE_EMAIL) && $model->email!=''){
//                    $error['loi_email'] = 'Email không đúng định dạng';
//                }
                if($model->password_hash != '')
                    $model->setPassword($model->password_hash);

                $model->created_at = date("Y-m-d H:i:s");
                $file = UploadedFile::getInstance($model, 'anhdaidien');
                $path = '';
                if(!is_null($file)){
                    $model->anhdaidien = myAPI::createCode(time().$file->name);
                    $path = dirname(dirname(__DIR__)).'/hinh-anh/'.$model->anhdaidien;
                }
                else{
                    //Nếu người dùng không uplaod ảnh thì mặc đinh lấy hình anảnh no-image.jpg
                    $model->anhdaidien = 'no-image.jpg';
                }

                $name1 = 'no-image.jpg';
                $name2 = 'no-image.jpg';
                $cccd1 = UploadedFile::getInstanceByName('anhcancuoc1');
                $cccd2 = UploadedFile::getInstanceByName('anhcancuoc2');
                $pathcccd1 = '';
                $pathcccd2 = '';
                if(!is_null($cccd1)){
                    $name1 = myAPI::createCode('1'.time().$cccd1->name);
                    $pathcccd1 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name1;
                }
                if(!is_null($cccd2)){
                    $name2 = myAPI::createCode('2'.time().$cccd2->name);
                    $pathcccd2 = dirname(dirname(__DIR__)).'/hinh-anh/'.$name2;
                }
                $model->anhcancuoc = $name1.','.$name2;

                if($model->save()){
                    if ($path != '')
                        $file->saveAs($path);
                    if($pathcccd1!='')
                        $cccd1->saveAs($pathcccd1);
                    if($pathcccd2!='')
                        $cccd2->saveAs($pathcccd2);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thêm mới khách hàng",
                        'content'=>'<span class="text-success">Thêm mới khách hàng thành công</span>',
                        'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Tạo thêm',['them-khach-hang'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];
                }else{
                    return [
                        'title'=> "Thêm khách hàng",
                        'content'=>$this->renderAjax('khach-hang/create', [
                            'model' => $model,
                            'error' => $error,
                        ]),
                        'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }
            }else{
                return [
                    'title'=> "Thêm khách hàng",
                    'content'=>$this->renderAjax('khach-hang/create', [
                        'model' => $model,
                        'error' => $error,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('khach-hang/create', [
                    'model' => $model,
                    'error' => $error,
                ]);
            }
        }
    }
//    Popup-khach-hang
    public function actionPopupKhachHang()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new User();
        $error = [
            'loi_ho_ten'=>''
        ];
        $model->hoten = $_POST['hoten'];
        if($model->hoten==''){
            $error['loi_ho_ten']='Họ tên không được đê trống';
        }
        $model->dien_thoai = $_POST['dien_thoai'];
        $model->email = $_POST['email'];
        $model->username = $_POST['username'];
        $model->password_hash = $_POST['matkhau'];
        if ($model->password_hash != '')
            $model->setPassword($model->password_hash);

        $model->created_at = date("Y-m-d H:i:s");
        $file = UploadedFile::getInstanceByName('anhdaidien');
        $path = '';
        if (!is_null($file)) {
            $model->anhdaidien = myAPI::createCode(time() . $file->name);
            $path = dirname(dirname(__DIR__)) . '/hinh-anh/' . $model->anhdaidien;
        } else {
            $model->anhdaidien = 'no-image.jpg';
        }

        $name1 = 'no-image.jpg';
        $name2 = 'no-image.jpg';
        $cccd1 = UploadedFile::getInstanceByName('anhcancuoc1');
        $cccd2 = UploadedFile::getInstanceByName('anhcancuoc2');
        $pathcccd1 = '';
        $pathcccd2 = '';
        if (!is_null($cccd1)) {
            $name1 = myAPI::createCode('1' . time() . $cccd1->name);
            $pathcccd1 = dirname(dirname(__DIR__)) . '/hinh-anh/' . $name1;
        }
        if (!is_null($cccd2)) {
            $name2 = myAPI::createCode('2' . time() . $cccd2->name);
            $pathcccd2 = dirname(dirname(__DIR__)) . '/hinh-anh/' . $name2;
        }
        $model->anhcancuoc = $name1 . ',' . $name2;
        if ($model->save()) {
            if ($path != '')
                $file->saveAs($path);
            if ($pathcccd1 != '')
                $cccd1->saveAs($pathcccd1);
            if ($pathcccd2 != '')
                $cccd2->saveAs($pathcccd2);
            return [
                'title' => "Thêm mới khách hàng",
                'success' => true,
                'content' => 'Thêm mới khách hàng thành công',
            ];
        }else{
            return [
                'success' => false,
                'model' => $model->attributes,
                'error' => $error,
                'content' => $this->renderAjax('khach-hang/_form_them_khach_hang', [
                    'model' => $model,
                    'error' => $error,
                ]),
                'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }

}
