<?php
/**
 * Created by PhpStorm.
 * User: hungddvimaru
 * Date: 11/11/16
 * Time: 1:19 AM
 */

namespace common\models;

use backend\models\CauHinh;
use backend\models\GiaoDich;
use backend\models\LogGetListSanPham;
use backend\models\QuanLyPhanQuyen;
use backend\models\ThietBiNhanThongBao;
use backend\models\UserVaiTro;
use backend\models\VaiTro;
use backend\models\Vaitrouser;
use kartik\mpdf\Pdf;
use yii\bootstrap\ActiveForm;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\Url;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\VarDumper;
use yii\jui\DatePicker;
use yii\swiftmailer\Mailer;
use function React\Promise\all;

class myAPI
{
    const PREFIX_NAME_SYSTEM = 'QLTN';
    const SUB_NAME = 'TN';
    const LINK_SYSTEM = 'https://toanha.andin.asia';
    const TEN_PHAN_MEM = 'QUẢN LÝ TOÀ NHÀ LIVING APARTMENT';

    public static function createCode($str){
        $str = trim($str);
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        $str = str_replace($coDau,$khongDau,$str);
        $str = trim(preg_replace("/\\s+/", " ", $str));
        $str = preg_replace("/[^a-zA-Z0-9 \-\.]/", "", $str);
        $str = strtolower($str);
        return str_replace(" ", '-', $str);;
    }

    public static function createEngName($str){
        $str = trim($str);
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        $str = str_replace($coDau,$khongDau,$str);
        $str = trim(preg_replace("/\\s+/", " ", $str));
        $str = preg_replace("/[^a-zA-Z0-9 \-\.]/", "", $str);
        $str = strtoupper($str);
        return $str;
//        return str_replace(" ", '', $str);;
    }

    public static function duyetNhom($object,$parentid = 0,$space = '--', $trees = NULL){
        if(!$trees) $trees = array();
        $nhoms = $object::find()->where(['parent_id' => $parentid])->all();
        /** @var  $nhom  Daily*/
        foreach ($nhoms as $nhom) {
            $trees[] = array('id'=>$nhom->id,'title'=>$space.$nhom->name);
            $trees = myAPI::duyetNhom($object,$nhom->id,"|..".$space,$trees);
        }

        return $trees;
    }

    public static function dsNhom($object){
        $danhmuccons =$object::find()->where('parent_id is null')->all();
        $trees = array();
        /** @var  $danhmuccon Daily */
        foreach ($danhmuccons as $danhmuccon) {
            $trees[] = array('id'=>$danhmuccon->id, 'title'=>$danhmuccon->name);
            $trees = myAPI::duyetNhom($object,$danhmuccon->id,'|--',$trees);
        }
        return $trees;
    }

    public static function dataTree($object,$parentid = NULL,$trees){
        $trees =[];
        $danhmuccons = $object::find()->where(['parent_id'=>$parentid])->all();
        foreach ($danhmuccons as $danhmuccon) {
            $nodes =[];
            $nodes = myAPI::dataTree($object,$danhmuccon->id,$nodes);
            $trees[] = ['id'=>$danhmuccon->id,'title'=>$danhmuccon->name,'nodes'=>$nodes];
        }
        return $trees;
    }

    public static function getNam($namBatDau,$namKetThuc){
        $namBatDau = (int)$namBatDau;
        $namKetThuc = (int)$namKetThuc;
        for($i=$namBatDau;$i <= $namKetThuc;$i++)
        {
            $data[$i] = $i;
        }
        return $data;
    }

    public static function getCapDo($str = 'quan | huyen | phuong | xa | thitran'){
        $data = [
            'quan' => 'Quận',
            'huyen' => 'Huyện',
            'phuong' => 'Phường',
            'xa' => 'Xã',
            'thitran' => 'Thị trấn'
        ];
        return $data[$str];
    }

    public static function getTab($cap = 'quan | huyen | xa | phuong | thitran' ){
        $data = [
            'quan' => 0,
            'huyen' => 0,
            'phuong' => 5,
            'xa' => 5,
            'thitran' => 5
        ];

        $str = '';
        for($i = 0; $i<=$data[$cap]; $i++)
            $str.='&emsp;';

        return $str;
    }

    public static function getMessage($att = "success|danger|warning|info", $content){
        return "<div class='note note-{$att}'>{$content}</div>";
    }

    public static function createMessage($att = 'success | danger | warning | info', $content){
        return [
            'messagePlan' => $content,
            'messageHtml' => self::getMessage($att, $content)
        ];
    }

    /**
     * @param $value
     * @param ActiveRecord $model
     * @param string $attributeTitle
     * @param array $attributeType
     * @return Expression
     */
    public static function getIdOtherModel($value, $model, $attributeTitle = 'name', $attributeType = ['name' => '', 'value' => '']){
        if(trim($value)=="")
            return new Expression('NULL');

        $data = $model->find()->where("code = :name", [':name' => self::createCode(trim($value))])->one();

        if(count($data) == 0){
            $model->{$attributeTitle} = trim($value);
            if($attributeType['name'] != '')
                $model->{$attributeType['name']} = trim($attributeType['value']);

            $model->save();
            return $model->id;
        }
        return $data->id;
    }

    public static function getHeadModal($noidung){
        return '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">'.$noidung.'</h4>';
    }

    public static function activeDateField($form, $model, $field, $label, $yearRange = '1950:2050'){
        return $form->field($model,$field)->widget(\yii\jui\DatePicker::className(),[
            'language' => 'vi',
            'clientOptions' => [
                'dateFormat' => 'dd/mm/yy',
                'changeMonth' => true,
                'yearRange' => $yearRange,
                'changeYear' => true,
            ],
            'options' => ['class' => 'form-control']
        ])->label($label);
    }

    /**
     * @param $form ActiveForm
     * @param $model ActiveRecord
     * @param $field
     * @param $label
     * @param string $yearRange
     * @param array $options
     * @return mixed
     */
    public static function activeDateField2($form, $model, $field, $label, $yearRange = '2015:2018', $options = ['class' => 'form-control']){
        return $form->field($model,$field)->widget(\yii\jui\DatePicker::className(),[
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => $yearRange,
                'changeYear' => true,
            ],
            'options' => $options
        ])->label($label);
    }

    public static function dateField($name, $value, $class='form-control', $yearRange = '1950:2050'){
        return DatePicker::widget([
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'name' => $name,
            'value' => $value,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => $yearRange,
                'changeYear' => true,
            ],
            'options' => ['class' => $class]
        ]);
    }
    public static function dateField2($name, $value, $yearRange = '2015:2018',$options= ['class' => 'form-control']){
        return DatePicker::widget([
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'name' => $name,
            'value' => $value,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => $yearRange,
                'changeYear' => true,
            ],
            'options' => $options
        ]);
    }

    public static function activeDateFieldNoLabel($model, $attribute, $yearRange = '2015: 2100', $options = ['class' => 'form-control']){
        return DatePicker::widget([
            'language' => 'vi',
            'model' => $model,
            'dateFormat' => 'dd/MM/yyyy',
            'attribute' => $attribute,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => $yearRange,
                'changeYear' => true,
            ],
            'options' => $options
        ]);
    }

    public static function convertDateSaveIntoDb($date){
        if($date == "")
            return null;

        $splash = '/';
        if(strpos($date, '-') !== false)
            $splash = '-';
        else if(strpos($date, '.') !== false)
            $splash = '.';

        $date = trim($date);
        if($date == "")
            return new Expression('NULL');
        $arr = explode(trim($splash), $date);
        if(count($arr) == 3)
            return implode('-', array_reverse($arr));
        else if(count($arr) == 2)
            return date("Y")."-{$arr[1]}-{$arr[0]}";
        else
            return date("Y")."-".date("m")."-".$arr[0];
    }

    public static function getBtnCloseModal(){
        return Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]);
    }

    public static function getBtnFooter( $label, $options = []){
        return Html::button($label, $options);
    }

    public static function getVaitro(){
        return [
            'quantrivien' => '<span class="text-danger"><i class="fa fa-flag"></i> Quản trị viên</span>',
            'quanly' => '<span class="text-warning"><i class="fa fa-flag"></i> Quản lý</span>',
            'nhanvien' => '<span class="text-success"><i class="fa fa-flag"></i> Nhân viên</span>',
        ];
    }

    public static function getAFieldOfAModelFromName($model, $field, $name){
        $code = self::createCode(trim($name));
        $data = $model->find()->where(['code' => $code])->one();
        if(is_null($data))
            return '';
        return $data->{$field};
    }

    public static function getFilterFromTo($searchModel, $fieldFrom, $field_to, $options = ['class' => 'form-control']){
        return Html::activeTextInput($searchModel, $fieldFrom, $options).
            Html::activeTextInput($searchModel, $field_to, $options);
    }

    public static function getBtnSearch(){
        return '<button type="button" class="btn blue btn-search"><i class="fa fa-search"></i> Tìm kiếm</button>';
    }

    public static function getDMY($YMD){
        if($YMD != "")
            return date("d/m/Y", strtotime($YMD));
        return '';
    }

    /**
     * @return string
     */
    public static function getBtnDownload(){
        return Html::button('<i class="fa fa-cloud-download"></i> Tải xuống',['class'=>'btn btn-primary btn-download-ketquatimkiem pull-right']);
    }

    public static function getBtnDeleteAjaxCRUD($text = '', $url, $clsBtn = ''){
        return Html::a('<i class="fa fa-trash"></i> '.$text, $url, ['title' => 'Xóa', 'role' => 'modal-remote', 'data-request-method' => 'post', 'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Thông báo', 'data-confirm-message' => 'Bạn có chắc chắn muốn xóa không ?', 'class' => $clsBtn]);
    }

    public static function getDsThang(){
        $arr = [];
        for ($i= 1; $i<=12; $i++)
            $arr[$i] = "Tháng {$i}";
        return $arr;
    }

    public static function createUpdateBtnInGrid($path, $title = 'Sửa dữ liệu'){
        return Html::a('<i class="fa fa-edit"></i>', $path, ['title' => $title, 'data-pjax' => 0, 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'data-original-tile' => $title]);
    }

    public static function createDeleteBtnInGrid($path, $title = 'Xóa dữ liệu'){
        return Html::a('<i class="fa fa-trash"></i>', $path,['title' => $title, 'data-pjax' => 0, 'role' => 'modal-remote', 'data-request-method' => 'post', 'data-toggle' => 'tooltip', 'data-confirm-title' => 'Thông báo', 'data-confirm-message' => 'Bạn có chắc chắn muốn xóa dữ liệu này?', 'data-original-title' => 'Xóa', 'class' => 'text-danger']);
    }

    /**
     * @param string $model
     * @param int $id
     * {$model}-{$id}
     * @param array $optionsTD
     * @return string
     */
    public static function getBtnDeletInRow($model, $id, $optionsTD = ['class' => 'text-center']){
        return Html::tag('td', Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger btn-xoa-dong-tren-bang', 'id' => "{$model}-{$id}"]), $optionsTD);
    }
    public static function getBtnDeletInRowNewRow($options = ['class'=>"text-center"]){
        return Html::tag('td', Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger btn-xoa-dong-tren-bang dong-moi-trenbang']), $options);
    }

    /**
     * @param string $id
     * tauthuynoidia-soluongthuyenvien => views/tauthuynoidia/row/_row_soluongthuyenvien
     * @param integer $colspan
     * @param integer $colspan
     * @param integer $colspan
     * @param integer $colspan
     * @return string
     */
    public static function getRowBoSung($id = "{model}-{row_file}", $colspan){
        return Html::tag('tr', Html::tag('td', Html::button('<i class="fa fa-plus"></i> Bổ sung',[
            'class' => 'btn btn-sm btn-primary btn-them-dong-moi',
            'id' => $id
        ]), ['colspan' => $colspan]));
    }

    /**
     * @param $post string
     * @param $model ActiveRecord
     */
    public static function saveAnExistTable($post, $model, $attributes = []){
        if(isset($_POST[$post])){
            foreach ($_POST[$post] as $id => $item) {
                $kqkd = $model->findOne($id);
                $kqkd->attributes = $item;
                foreach ($attributes as $attribute => $value) {
                    $kqkd->{$attribute} = $value;
                }
                if(!$kqkd->save()){
                    var_dump(Html::errorSummary($kqkd));
                    exit;
                }
            }
        }
    }

    /**
     * @param $post array
     * @param $newOBJ string
     * @param $firstField string
     * @param $model ActiveRecord
     * @param $others array
     */
    public static function saveOtherTable($newOBJ, $firstField, $objectName, $others = []){
        $model = new $objectName();
        $arr_fields = $model->attributes;
        if(isset($_POST[$newOBJ][$firstField])){
            foreach ($_POST[$newOBJ][$firstField] as $index => $item) {
                /** @var  $newModel ActiveRecord*/
                $newModel = new $objectName();
                foreach ($arr_fields as $field => $value) {
                    if(isset($_POST[$newOBJ][$field][$index]))
                        $newModel->{$field} = $_POST[$newOBJ][$field][$index];
                }
                foreach ($others as $field => $value) {
                    $newModel->{$field} = $value;
                }
                if(!$newModel->save()) {var_dump(Html::errorSummary($newModel)); exit();};
            }
        }
    }

    /**
     * @param $arrRoles
     * @return bool
     */
    public static function isAccess($arrRoles, $uid = null){
        if(is_null($uid)){
            if(Yii::$app->user->isGuest)
                return false;
            return (new User())->isAccess($arrRoles);
        }else{
            return (new User())->isAccess($arrRoles, $uid);
        }
    }

    public static function isHasRole($name){
        $vaitro = VaiTro::findOne(['name' => $name]);
        if(is_null($vaitro))
            return false;
        return !is_null(Vaitrouser::findOne(['vaitro_id' => $vaitro->id, 'user_id' => Yii::$app->user->identity->ID]));
    }

    public static function getYMDFromDMY($date, $splash = '-'){
        if($date == '')
            return '';
        $arr = explode($splash, $date);
        return implode('-', array_reverse($arr));
    }

    public static function getCodesMBLDaChon(){
        $arr = [];
        if(\Yii::$app->session->get('ma'))
            $arr = \Yii::$app->session->get('ma');
        if(count($arr) > 0)
            return 'Học viên đã chọn: '.implode(', ',$arr);
        return '';
    }

    /**
     * @param $controller
     * @param $action
     * @return bool
     * QuanLyCongViec;Huy-giao-viec
     */
    public static function isAccess2($controller, $action, $uid = null ){
        if(is_null($uid)){
            if(Yii::$app->user->isGuest)
                return false;
            else{
//                if(Yii::$app->user->identity->getId() == 1)
//                    return true;
                $action = ucfirst($action);
                $controller_action = "{$controller};{$action}";
                $user_id = Yii::$app->user->id;
                return !is_null(QuanLyPhanQuyen::findOne(['controller_action' => $controller_action, 'user_id' => $user_id]));
            }
        }else{
//            if($uid == 1)
//                return true;
            $action = ucfirst($action);
            $controller_action = "{$controller};{$action}";
            return !is_null(QuanLyPhanQuyen::findOne(['controller_action' => $controller_action, 'user_id' => $uid]));
        }

    }
    ////
    public static function convertDMY2YMD($strDate){
        $arr = explode('/', $strDate);
        return implode('-', array_reverse($arr));
    }
    public static function covertYMD2DMY($strDate){
        if($strDate == '')
            return '';
        return date("d/m/Y", strtotime($strDate));
    }
    public static function covertYMD2TDMY($strDate){
        $arr = explode(' ', $strDate);
        $arrT = $arr[1];
        $arrPD =explode('-', $arr[0]);

        $arrD = implode('-', array_reverse($arrPD));
        $time =$arrD.' '.$arrT;
        return $time;
    }

    public static function covertTDMY2YMD($strDate){

        if (strpos(':',$strDate)>0){
            $arr = explode(' ', $strDate);
            $arrT = $arr[0];
            $arrPD =explode('-', $arr[1]);
            $arrD = implode('-', array_reverse($arrPD));
            $time =$arrD.' '.$arrT;
            return $time;
        }else
            $arr = explode('-', $strDate);
        $time = implode('-', array_reverse($arr));
        return $time;

    }

    public static function get_extension($imagetype)
    {
        if(empty($imagetype)) return false;
        switch($imagetype)
        {
            case 'image/bmp': return '.bmp';
            case 'image/cis-cod': return '.cod';
            case 'image/gif': return '.gif';
            case 'image/ief': return '.ief';
            case 'image/jpeg': return '.jpg';
            case 'image/pipeg': return '.jfif';
            case 'image/tiff': return '.tif';
            case 'image/x-cmu-raster': return '.ras';
            case 'image/x-cmx': return '.cmx';
            case 'image/x-icon': return '.ico';
            case 'image/x-portable-anymap': return '.pnm';
            case 'image/x-portable-bitmap': return '.pbm';
            case 'image/x-portable-graymap': return '.pgm';
            case 'image/x-portable-pixmap': return '.ppm';
            case 'image/x-rgb': return '.rgb';
            case 'image/x-xbitmap': return '.xbm';
            case 'image/x-xpixmap': return '.xpm';
            case 'image/x-xwindowdump': return '.xwd';
            case 'image/png': return '.png';
            case 'image/x-jps': return '.jps';
            case 'image/x-freehand': return '.fh';
            default: return false;
        }
    }

    // dt2 - dt1
    public static function tinhSoNgay($dt1, $dt2){
        $t1 = strtotime($dt1);
        $t2 = strtotime($dt2);

        $dtd = new \stdClass();
        $dtd->interval = $t2 - $t1;
        $dtd->total_sec = abs($t2-$t1);
        $dtd->total_min = floor($dtd->total_sec/60);
        $dtd->total_hour = floor($dtd->total_min/60);
        $dtd->total_day = floor($dtd->total_hour/24);

        $dtd->day = $dtd->total_day;
        $dtd->hour = $dtd->total_hour -($dtd->total_day*24);
        $dtd->min = $dtd->total_min -($dtd->total_hour*60);
        $dtd->sec = $dtd->total_sec -($dtd->total_min*60);
        return $dtd->total_day;
    }

    public static function getQuy($thang){
        $arr_quy = [
            1 => 'Quý I',
            2 => 'Quý I',
            3 => 'Quý I',
            4 => 'Quý II',
            5 => 'Quý II',
            6 => 'Quý II',
            7 => 'Quý III',
            8 => 'Quý III',
            9 => 'Quý III',
            10 => 'Quý IV',
            11 => 'Quý IV',
            12 => 'Quý IV',
        ];
        return $arr_quy[$thang];
    }

    /**
     * @param $content string
     * @param $form string
     * @param $to array <p>['receiver@domain.org', 'other@domain.org' => 'A name']</p
     * @param $subject string
     */
    public static function pushNotification($content, $ids){
        \Yii::$app->webpusher->userPush($content, $ids);
    }

    /**
     * @param $name
     * Quý I, Quý II, Quý III, Quý IV
     * @param $nam
     * Năm
     * @return mixed
     *
     */
    public static function getRangeMonthsByQuy($name = "quy-i", $nam){
        $quy = [
            'quy-i' => [
                'from' => mktime(0, 0, 0, 1, 1, $nam),
                'to' => mktime(0, 0, 0, 3, 31, $nam)
            ],
            'quy-ii' => [
                'from' => mktime(0, 0, 0, 4, 1, $nam),
                'to' => mktime(0, 0, 0, 6, 30, $nam)
            ],
            'quy-iii' => [
                'from' => mktime(0, 0, 0, 7, 1, $nam),
                'to' => mktime(0, 0, 0, 9, 30, $nam)
            ],
            'quy-iv' => [
                'from' => mktime(0, 0, 0, 10, 1, $nam),
                'to' => mktime(0, 0, 0, 12, 31, $nam)
            ],
        ];
        return $quy[$name];
    }

    /**
     * @param $content string
     * @param $file_name string
     * @param $title string
     * @param $subject string
     * @param $header string
     * @param $footer string
     * @param $margin array
     * $margin[0 => top, 1 => left, 2 => bottom, 3 => right]
     * @param $temPath string
     * @param $urlTaiFile string
     * 'files_excel/'.$file_name
     */

    public static function exportPDF($content, $file_name, $title, $subject, $header, $footer, $margin, $temPath, $urlTaiFile){
        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $content,
            'filename' => $file_name,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px} 
                         body{font-family: "Times New Roman"; font-size: 14pt} table td,table th{padding: 3px}',
            'options' => [
                'title' => $title,
                'subject' => $subject
            ],
            'methods' => [
                'SetHeader' => [$header],
                'SetFooter' => [$footer],
            ],
            'destination' => Pdf::DEST_FILE,
            'marginLeft' => $margin[1],
            'marginRight' => $margin[3],
            'marginTop' => $margin[0],
            'marginBottom' => $margin[2],
            'tempPath' => $temPath
        ]);

        $pdf->render();
        echo Json::encode([
            'title' => 'Tải file kết quả',
            'content' => \yii\helpers\Html::a('<i class="fa fa-cloud-download"></i> Nhấn vào đây để tải file về!', $urlTaiFile, ['class' => 'text-primary', 'target' => '_blank'])
        ]);
    }

    public static function getNgay(){
        $arr = [];
        for($i=1; $i<=31; $i++)
            $arr[sprintf('%02d',$i)] = sprintf('%02d',$i);
        return $arr;
    }

    public static function getThang(){
        $arr = [];
        for($i=1; $i<=12; $i++)
            $arr[sprintf('%02d',$i)] = sprintf('%02d',$i);
        return $arr;
    }

    // Gửi email tới email $to, nếu $to == null thì gửi email đến QTV
    public static function sendMail($content, $subject, $to = null, $hoTenNguoiGui = null){
        $cauHinh = json_decode(CauHinh::findOne(['ghi_chu' => 'cau_hinh_smtp_full'])->content);

        $transport = (new \Swift_SmtpTransport($cauHinh->smtp, $cauHinh->port))
            ->setEncryption($cauHinh->Encryption)
            ->setUsername($cauHinh->username)
            ->setPassword($cauHinh->password);
        if(is_null($to))
            $nguoiNhan = CauHinh::findOne(['ghi_chu' => 'email_nhan_thong_bao_he_thong'])->content;
        else
            $nguoiNhan = $to;

        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message('test'))
            ->setContentType( 'text/html')
            ->setSubject($subject)
            ->setFrom([$cauHinh->username => is_null($hoTenNguoiGui) ? CauHinh::findOne(['ghi_chu' => 'ten_chuong_trinh'])->content : $hoTenNguoiGui])
            ->setTo($nguoiNhan)
            ->setBody($content);
        $mailer->send($message);
//        return $result;
    }

    public static  function checkBeforeAction($content){
        if($content->uid == '' || $content->auth == ''){
            return [
                'success' => false,
                'content' => 'Không có thông tin tài khoản'
            ];
        }else {
            $user = User::findOne($content->uid);
            if ($user->auth_key == $content->auth) {
                return [
                    'success' => true,
                    'user' => $user,
                ];
            } else {

                return [
                    'success' => false,
                    'content' => 'Tài khoản không hợp lệ'
                ];
            }
        }
    }

    public static function getLamTronLen($value){
        return $value > intval($value) ? intval($value) + 1 : $value;
    }

    public static function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
        if(count($data) > 1)
            // we could add validation here with ensuring count( $data ) > 1
            fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        else
            fwrite( $ifp, base64_decode($base64_string) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }

    public static function MinhHienTranslate($arrContent, $target = 'vi'){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gg.minhhien.com.vn/translate-v3.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => json_encode([
                'token' => md5('ANDIN'.date("YmdHi")),
                'data' => $arrContent,
                'target' => $target,
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $model = new LogGetListSanPham();
        $model->content = $response;
        $model->type = 'Translate';
        $model->keyword = json_encode($arrContent);
        $model->created = date("Y-m-d H:i:s");
        $model->save();

        curl_close($curl);
        $result = json_decode($response);
        if(isset($result->success)){
            if($result->success)
                return  $result->content;
            return [];
        }
        return [];
    }

    // Thông báo đẩy giống Zalo: Gửi tới uid
    public static   function sendMessNotiForOneUser($uid, $tieuDe, $noiDung){
        $devies = ThietBiNhanThongBao::findAll(['user_id' => $uid]);
        $tokens = [];
        foreach ($devies as $node)
            $tokens[] = $node->code;
        self::sendMessageNotifications($tokens, $tieuDe, $noiDung);
    }

    public static  function sendMessageNotifications($deviceToken, $tieuDe, $noiDung){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gg.minhhien.com.vn/send-message.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'deviceToken' => $deviceToken,
                'tieuDe' => $tieuDe,
                'noiDung' => $noiDung,
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    // Thông báo đẩy tới QTV
    public static  function guiThongBaoLoiDenQuanTriVien($tieuDe, $noiDung){
        $uids = explode(',', CauHinh::findOne(['ghi_chu' => 'danh_sach_uid_nhan_thong_bao_tu_he_thong'])->content); //explode(',', node_load(12636)->field_ghi_chu['und'][0]['value']);
        $dsThietBi = ThietBiNhanThongBao::find()
            ->andFilterWhere(['in', 'user_id', $uids])
            ->andFilterWhere(['active' => 1])
            ->all();
        $tokens = [];
        /** @var ThietBiNhanThongBao $node */
        foreach ($dsThietBi as $node)
            $tokens[] = $node->code;

        myAPI::sendMessageNotifications($tokens, $tieuDe, $noiDung);
    }

    public static function sinhQrCode($ClientID, $APIKey, $soTaiKhoan, $tenTaiKhoan, $BIN, $noiDungCK, $soTienCK){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.vietqr.io/v2/generate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "accountNo": "'.trim($soTaiKhoan).'",
                "accountName": "'.trim($tenTaiKhoan).'",
                "acqId": "'.trim($BIN).'",
                "addInfo": "'.trim($noiDungCK).'",
                "amount": "'.trim($soTienCK).'",
                "template": "compact"
            }',
            CURLOPT_HTTPHEADER => array(
                'x-client-id: '.trim($ClientID),
                'x-api-key: '.trim($APIKey),
                'Content-Type: application/json',
                'Cookie: connect.sid=s%3AKbV_z3t_2H93B-PSyb_XlxnScyUlm5FS.Psxou9%2FT5d6ZQVDigGuKJ1PMlW242Jkha2GbfZ6Ynn0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response)->data->qrDataURL;

    }

    public static function sinhMaQR($maGiaoDich, $soTien, $nidGiaoDich = null){
        $thongTinTaiKhoan = explode('<br />', nl2br(CauHinh::findOne(['ghi_chu' => 'thong_tin_chuyen_khoan'])->content));
        $thongTinAPIVietQr = explode('<br />', nl2br(CauHinh::findOne(['ghi_chu' => 'thong_tin_API_vietQR'])->content));
        $qrDataURL = self::sinhQrCode(
            trim($thongTinAPIVietQr[1]),
            trim($thongTinAPIVietQr[3]),
            trim($thongTinTaiKhoan[0]),
            trim($thongTinTaiKhoan[1]),
            trim($thongTinTaiKhoan[2]),
            $maGiaoDich,//$responseThemGD['maGiaoDichMoi'],
            intval($soTien) //intval($nodeDonHang->field_thanh_tien['und'][0]['value'])
        );
        if(!is_null($nidGiaoDich)){
            GiaoDich::updateAll(['anh_giao_dich' => $qrDataURL], ['id' => $nidGiaoDich]);
        }
        //$ClientID, $APIKey, $soTaiKhoan, $tenTaiKhoan, $BIN, $noiDungCK, $soTienCK
        //Sinh mã giao dịch
        return ([
            'success' => true,
            'content' => [
                'type' => 'Nạp tiền',
                'code' => $qrDataURL,
                'params' => [
                    'soTaiKhoan' => trim($thongTinTaiKhoan[0]),
                    'tenTaiKhoan' => trim(trim($thongTinTaiKhoan[1])),
                    'BIN' => trim($thongTinTaiKhoan[2]),
                    'noiDungCK' => $maGiaoDich,//$responseThemGD['maGiaoDichMoi'],
                    'soTienCK' => $soTien //$nodeDonHang->field_thanh_tien['und'][0]['value']
                ],
            ]
        ]);
    }

    public static function verifyEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function getListNganHang(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.vietqr.io/v2/banks',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    /**
     * @param $soLuong
     * @param $wholesales
     * @param $giaMacDinh
     * @return mixed
     */
    public static function getGiaNDTBySoLuongV2($soLuong, $wholesales, $giaMacDinh){
        $donGia = $giaMacDinh;
        if(is_array($wholesales)){
            if(count($wholesales) > 2){
                for($i = count($wholesales) - 1; $i>=0 ; $i--){
                    if($soLuong >= $wholesales[$i]->begin){
                        $donGia = $wholesales[$i]->price;
                        break;
                    }
                }
            }
        }
        // Nếu không tìm thấy mức nào phù hợp thì price = 0
        return $donGia;
    }
    public static function checkUsername_invalid($value){
        if (preg_match("/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{5,20}$/", $value))
            return true;
        else
            return false;
    }
    public static function checkOnlyRule($nameVaiTro, $uid){
        $model = UserVaiTro::find()
            ->andWhere('vai_tro <> :n and id = :i and status = 10', [
                ':n' => $nameVaiTro,
                ':i' => $uid
            ])
            ->one();
        return is_null($model);
    }
}
