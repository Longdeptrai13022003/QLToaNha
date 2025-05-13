<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietHoaDon;
use backend\models\DanhMuc;
use backend\models\HoaDon;
use backend\models\PhongKhach;
use backend\models\QuanLyHoaDon;
use backend\models\search\QuanLyGiaoDichSearch;
use common\models\myAPI;
use common\models\User;
use Yii;
use backend\models\GiaoDich;
use backend\models\search\GiaoDichSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * GiaoDichController implements the CRUD actions for GiaoDich model.
 */
class GiaoDichController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = true;
    public $contentAPI = null;
    public function behaviors()
    {
        $arr_action = [
            'index','create','view','update','duyet-giao-dich','delete','gui-tin-nhan'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('GiaoDich', $action_name, $this->contentAPI->uid);
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
                        return myAPI::isAccess2('GiaoDich', $action_name);
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
     * Lists all GiaoDich models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new QuanLyGiaoDichSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single GiaoDich model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $hopDong = PhongKhach::findOne($model->phong_khach_id);
        $khach = User::findOne($hopDong->khach_hang_id);
        $user = User::findOne($model->user_id);
        $phong = DanhMuc::findOne($hopDong->phong_id);
        $toaNha = DanhMuc::findOne($phong->parent_id);
        $thang = '';
        if ($model->hoa_don_id!=null){
            $hoaDon = HoaDon::findOne($model->hoa_don_id);
            if(!is_null($hoaDon)){
                $thang = $hoaDon->thang.'/'.$hoaDon->nam;
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=>'Chi tiết giao dịch',
            'content'=>$this->renderAjax('view', [
                'model' => $model,
                'hopDong' => $hopDong,
                'khach' => $khach,
                'user' => $user,
                'phong' => $phong,
                'toaNha' => $toaNha,
                'thang' => $thang
            ]),
            'footer'=> $model->trang_thai_giao_dich != GiaoDich::KHOI_TAO? '' : Html::button('<i class="fa fa-check-circle"></i> Duyệt',['class'=>'btn btn-success btn-duyet-trang-thai','data-pjax' => 0,'data-value'=>$id,'loai'=>1]).
                Html::button('<i class="fa fa-ban"></i> Hủy',['class'=>'btn btn-danger btn-duyet-trang-thai','data-pjax' => 0,'data-value'=>$id,'loai'=>0])
        ];
    }

    /**
     * Creates a new GiaoDich model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GiaoDich();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new GiaoDich",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new GiaoDich",
                    'content'=>'<span class="text-success">Create GiaoDich success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new GiaoDich",
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
     * Updates an existing GiaoDich model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $hopDong = PhongKhach::findOne($model->phong_khach_id);
        $khach = User::findOne($hopDong->khach_hang_id);
        $phong = DanhMuc::findOne($hopDong->phong_id);
        $toaNha = DanhMuc::findOne($phong->parent_id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> 'Duyệt giao dịch',
            'content'=>$this->renderAjax('update', [
                'model' => $model,
                'hopDong' => $hopDong,
                'khach' => $khach,
                'phong' => $phong,
                'toaNha' => $toaNha
            ]),
            'footer'=> Html::button('<i class="fa fa-check-circle"></i> Duyệt',['class'=>'btn btn-success btn-duyet-trang-thai','data-pjax' => 0,'data-value'=>$id,'loai'=>1]).
                Html::button('<i class="fa fa-ban"></i> Hủy',['class'=>'btn btn-danger btn-duyet-trang-thai','data-pjax' => 0,'data-value'=>$id,'loai'=>0])
        ];
    }

    /**
     * Delete an existing GiaoDich model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $model = GiaoDich::findOne($_POST['ID']);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!is_null($model)){
            if($model->trang_thai_giao_dich == GiaoDich::THANH_CONG){
                if (!is_null($model->hoa_don_id)){
                    $hoaDon = HoaDon::findOne($model->hoa_don_id);
                    $newTien = $hoaDon->da_thanh_toan - $model->tong_tien;
                    $hoaDon->updateAttributes([
                        'da_thanh_toan' => $newTien
                    ]);
                    if ($hoaDon->tong_tien>$newTien){
                        $hoaDon->updateAttributes([
                            'trang_thai' => HoaDon::CHUA_THANH_TOAN
                        ]);
                        $hoaDon->afterUpdate();
                    }
                }

                $hopDong = PhongKhach::findOne($model->phong_khach_id);
                $daThanhToan = $hopDong->da_thanh_toan-$model->tong_tien;
                $hopDong->updateAttributes([
                    'da_thanh_toan' => $daThanhToan
                ]);
            }

            $model->updateAttributes([
                'active' => 0
            ]);
            return [
                'success' => true,
                'content' => 'Hủy giao dịch thành công!'
            ];
        }
        return [
            'success' => false,
            'content' => 'Không tìm thấy giao dịch!'
        ];
    }

     /**
     * Delete multiple existing GiaoDich model.
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
     * Finds the GiaoDich model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiaoDich the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiaoDich::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //duyet-giao-dich
    public function actionDuyetGiaoDich()
    {
        $model = GiaoDich::findOne($_POST['ID']);
        $trangThai = intval($_POST['trangThai']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($model)){
            if($trangThai == 0){
                $model->updateAttributes([
                    'trang_thai_giao_dich'=>GiaoDich::KHONG_THANH_CONG
                ]);
                $model->afterUpdate();
            }else{
                $model->updateAttributes([
                    'trang_thai_giao_dich'=>GiaoDich::THANH_CONG,
                    'so_tien_giao_dich' => $model->tong_tien
                ]);
                $model->afterUpdate();
            }
            return [
                'success' => true,
                'content' => 'Cập nhập trạng thái giao dịch thành công!'
            ];
        }
        return [
            'success' => false,
            'content' => 'Không tìm thấy giao dịch!'
        ];
    }
//get-access-token
    public function GetAccessToken()
    {
        $reToken = CauHinh::findOne(['ghi_chu'=>'refresh_token']);
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token']);
        $url = 'https://oauth.zaloapp.com/v4/oa/access_token';
        $secretKey = 'szpDdhiKLTr3fYZSWW56';
        $appId = '3433189854621494610';

        $postData = [
            'refresh_token' => $reToken->content,
            'app_id' => $appId,
            'grant_type' => 'refresh_token'
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'secret_key: ' . $secretKey
        ]);

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        $data = json_decode($response, true);
        if (isset($data['access_token']) && isset($data['refresh_token'])) {
            $acToken->updateAttributes([
                'content' => $data['access_token']
            ]);

            $reToken->updateAttributes([
                'content' => $data['refresh_token']
            ]);
            return true;
        } else {
            return false;
        }
    }
    //gui-tin-nhan
    public function actionGuiTinNhan(){
        $giaoDichID = $_POST['ID'];

        $this->getAccessToken();

        $url = 'https://business.openapi.zalo.me/message/template';
        $acToken = CauHinh::findOne(['ghi_chu'=>'access_token'])->content;
        $templateID = CauHinh::findOne(['ghi_chu'=>'template_id']);
        $tracking = CauHinh::findOne(['ghi_chu'=>'tracking_id']);
        $trackingID = intval($tracking->content);

        $giaoDich = GiaoDich::findOne($giaoDichID);

        $hoaDon = QuanLyHoaDon::findOne(['id'=>$giaoDich->hoa_don_id]);

        $phone = $hoaDon->dien_thoai;
        if (substr($phone, 0, 1) === '0') {
            $phone = '84' . substr($phone, 1);
        }
        $HDs = HoaDon::findAll(['phong_khach_id'=>$hoaDon->phong_khach_id]);
        $tienNo = 0;
        foreach ($HDs as $HD){
            if ($HD->thang == $hoaDon->thang && $HD->nam == $hoaDon->nam)
                break;
            $tienNo += ($HD->tong_tien - $HD->da_thanh_toan);
        }
        $tienDien = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>2])->one();
        $tienNuoc = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>3])->one();
        $tienInternet = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>5])->one();
        $tienRac = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>4])->one();
        $tienGiat = ChiTietHoaDon::find()
            ->andFilterWhere(['hoa_don_id'=>$hoaDon->id])
            ->andFilterWhere(['dich_vu_id'=>6])->one();

        $templateData = [
            'thang' => $hoaDon->thang,
            'tien_phong' => number_format($hoaDon->tien_phong,0,',','.'),
            'tien_dien' => number_format($tienDien->thanh_tien,0,',','.'),
            'tien_nuoc' => number_format($tienNuoc->thanh_tien,0,',','.'),
            'tien_internet' => number_format($tienInternet->thanh_tien,0,',','.'),
            'tien_rac' => number_format($tienRac->thanh_tien,0,',','.'),
            'tien_giat' => number_format($tienGiat->thanh_tien,0,',','.'),
            'tien_no' => number_format($tienNo,0,',','.'),
            'tong_tien' => number_format($tienNo + $hoaDon->tong_tien,0,',','.'),
            'noi_dung_chuyen_khoan' => 'GD '.$giaoDichID.' HD '.$hoaDon->id,
            'so_tien' => $giaoDich->tong_tien,
            'ho_ten' => $hoaDon->hoten,
            'dien_thoai' => $hoaDon->dien_thoai,
            'phong' => $hoaDon->ten_phong
        ];
        $postData = [
            'phone' => $phone,
            'template_id' => $templateID->content,
            'template_data' => $templateData,
            'tracking_id' => 'TID'.sprintf('%07d',$trackingID)
        ];

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'access_token: ' . $acToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        // Xử lý kết quả
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = json_decode($response, true);
        if (isset($data['message'])) {
            $tracking->updateAttributes([
                'content' => $trackingID+1
            ]);
            if ($data['message'] == 'Success')
                return [
                    'success' => true,
                    'content' => 'Gửi tin nhắn thành công tới khách '.$hoaDon->hoten.', hóa đơn '.$hoaDon->ma_hoa_don,
                ];
            else
                return [
                    'success' => false,
                    'content' => $data['message']
                ];
        } else {
            return [
                'success' => false,
                'content' => 'Dữ liệu giao dịch không chính xác'
            ];
        }
    }
}
