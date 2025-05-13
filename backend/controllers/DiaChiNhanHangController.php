<?php

namespace backend\controllers;

use backend\models\DiaChiNhanHang;
use backend\models\QuanLyDiaChiNhanHang;
use backend\models\QuanLyGiaoDich;
use backend\models\search\QuanLyDiaChiNhanHangSearch;
use backend\models\search\QuanLyGiaoDichSearch;
use common\models\myAPI;
use common\models\User;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class DiaChiNhanHangController extends Controller
{
    public $enableCsrfValidation = true;
    public $contentAPI = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr_action = [
            'index', 'save', 'save-dia-chi-nhan-hang-mac-dinh', 'load-dia-chi-nhan-hang', 'delete-dia-chi-nhan-hang'
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
                        return $this->contentAPI->uid == 1 || myAPI::isAccess2('DiaChiNhanHang', $action_name, $this->contentAPI->uid);
                    }
                ];
            }
        }else{
            foreach ($arr_action as $item) {
                $rules[] = [
                    'actions' => [$item],
                    'allow' => true,
                    //                'matchCallback' => myAPI::isAccess2($controller, $item)
                    'matchCallback' => function ($rule, $action) {
                        $action_name =  strtolower(str_replace('action', '', $action->id));
                        return \Yii::$app->user->id == 1 || myAPI::isAccess2('DiaChiNhanHang', $action_name);
                    }
                ];
            }
        }
        //
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

    public function actionIndex()
    {
        $content = json_decode(file_get_contents('php://input'));

        if(isset($content->uid)){
            $uid = $content->uid;
            $queryParams = [
                '_pjax' => '#crud-datatable-pjax',
//          'page' => $this->contentAPI->data->page
            ];

            $searchModel = new QuanLyDiaChiNhanHangSearch();
            $check = myAPI::checkBeforeAction($content);
            if($check['success']){
                $dataProvider = $searchModel->search($queryParams, $content);
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $dataProvider->setPagination(['page' => $content->data->page == null ? 0 : $content->data->page, 'pageSize' => 10]);
//          $dataProvider->setPagination([]);
                $data = $dataProvider->getModels();

                return [
                    'success' => true,
                    'content' =>  $data,
                    'loadMore' => ($content->data->page + 1) * $dataProvider->getPagination()->pageSize < $dataProvider->getTotalCount(),
                    'quanLy' => User::isViewAll($uid),
                ];
            }else
            {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return $check;
            }
        }
        else{
            $searchModel = new QuanLyDiaChiNhanHangSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    // save
    public function actionSave(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            if($content->data->field_dien_thoai == '')
                return (['success' => false, 'content' => 'Vui lòng nhập điện thoại người nhận']);
            else if($content->data->field_dia_chi == '')
                return (['success' => false, 'content' => 'Vui lòng nhập địa chỉ người nhận']);
            else if($content->data->field_ho_ten == '')
                return (['success' => false, 'content' => 'Vui lòng nhập họ tên người nhận']);
            else{
                if($content->data->nid == 0){
                    $model = new DiaChiNhanHang();
                    $model->user_id = $content->uid;
                }else{
                    $model = DiaChiNhanHang::findOne($content->data->nid); //node_load();
                }

                $fields = [
                    'dien_thoai_nguoi_nhan' => $content->data->field_dien_thoai,
                    'thong_tin_dia_chi' => $content->data->field_dia_chi,
                    'mac_dinh' => $content->data->field_chon_mac_dinh == true ? 1 : 0,
                    'ghi_chu' => $content->data->field_ghi_chu,
                    'ho_ten_nguoi_nhan' => $content->data->field_ho_ten,
                ];
                foreach ($fields as $field => $value)
                    $model->{$field} = $value;

                if($model->save()){
                    // Nếu $content->data->field_chon_mac_dinh thì tắt hết các địa chỉ khác vè 0
                    \Yii::$app->db->createCommand('update qlcvsd_dia_chi_nhan_hang set mac_dinh = 0 where user_id = :u and id <> :i', [
                        ':u' => $model->user_id,
                        ':i' => $model->id
                    ]);

                    return ['success' => true, 'content' => 'Lưu thông tin địa chỉ thành công', 'nid' => $model->id];
                }
                else
                    return ['success' => false, 'content' => strip_tags(Html::errorSummary($model))];
            }

        }else
            return $check;
    }

    //save-dia-chi-nhan-hang-mac-dinh
    public function actionSaveDiaChiNhanHangMacDinh(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            $model = DiaChiNhanHang::findOne($content->nid);

            // update trường mặc định = 0 cho toàn bộ địa chỉ nhận hàng của uid
            $sql = 'update qlcvsd_dia_chi_nhan_hang set mac_dinh = 0 where user_id = :u';
            \Yii::$app->db->createCommand($sql, [':u' => $model->user_id])->execute();
            $model->updateAttributes(['mac_dinh' => 1]);
            return ([
                'success' => true,
                'content' => "Cập nhật địa chỉ nhận hàng mặc định thành công"
            ]);
        }else
            return $check;
    }

    //load-dia-chi-nhan-hang
    public function actionLoadDiaChiNhanHang(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            $node = DiaChiNhanHang::findOne($content->nid);//();
            return ([
                'success' => true,
                'content' => [
                    'nid' => $node->id,
                    'field_dia_chi' => $node->thong_tin_dia_chi,
                    'field_ho_ten' => $node->ho_ten_nguoi_nhan,
                    'field_dien_thoai' => $node->dien_thoai_nguoi_nhan,
                    'field_ghi_chu' => $node->ghi_chu,
                    'mac_dinh' => $node->mac_dinh
                ]
            ]);
        }else
            return $check;
    }

    //delete-dia-chi-nhan-hang
    public function actionDeleteDiaChiNhanHang(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $content = json_decode(file_get_contents('php://input'));
        $check = myAPI::checkBeforeAction($content);
        if($check['success']){
            $model = DiaChiNhanHang::findOne($content->nid);
            $model->updateAttributes(['active' => 0]);
            return ([
                'success' => true,
                'content' => 'Xoá địa chỉ thành công'
            ]);

        }else
            return $check;
    }
}
