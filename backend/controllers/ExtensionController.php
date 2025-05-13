<?php

namespace backend\controllers;

use backend\models\CauHinh;
use backend\models\ChiTietDonHang;
use backend\models\DonHang;
use backend\models\LogIS;
use backend\models\Product;
use backend\models\QuanLyDonHang;
use common\models\myAPI;
use common\models\User;
use yii\bootstrap\Html;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class ExtensionController extends Controller
{
    public function actionExchangerate(){
        return [
            'success' => true,
            'data' => CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content
        ];
    }

    /**
     * @param $productJSON
     * @param $uid
     * @param $ext
     * @return []
     */
    public function saveDonHang1688FromProductJsonString($productJSON, $uid){
        // Tìm sản phẩm
        $products = Product::findOne(['product_id' => trim($productJSON->productId)]);

        if(is_null($products)){
            $fieldsProduct = [
                'link_product' => $productJSON->itemUrl,
                'product_id' => $productJSON->productId,
                'shop_link' => $productJSON->shopUrl,
                'string_json' => json_encode($productJSON),
                'nguon' => 'Ext',
                'domain' => '1688',
                'user_id' => $uid,
                'name' => $productJSON->name,
                'string_json_vi' => json_encode($productJSON),
            ];

            $newProduct = new Product();
            foreach ($fieldsProduct as $field => $value)
                $newProduct->{$field} = $value;
            $newProduct->save();
            $idProduct = $newProduct->id;
        }
        else{
            $products->updateAttributes(['string_json' => json_encode($productJSON), 'string_json_vi' => json_encode($productJSON)]);
            $idProduct = $products->id;
        }

        // Kiểm tra đơn hàng theo shop đã tồn tại chưa. Nếu đã tồn tại thì tìm xem sản phẩm đã đặt chưa. Nếu đã đặt thì tăng số lượng
        $nodeDonHang = DonHang::findOne(['trang_thai' => DonHang::GIO_HANG, 'shop_id' => $productJSON->shopId, 'active' => 1, 'user_id' => $uid]);

        $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;

        // Nếu đã tồn tại đơn hàng
        if(is_null($nodeDonHang)){
            $website = '1688';
            $fieldsDonHang = array(
                'shop_name' => $productJSON->shopName,
                'shop_id' => $productJSON->shopId,
                'ship_noi_dia_cny' => 0,
                'ship_noi_dia_vnd' => 0,
                'ty_gia' => $tyGia,
                'phi_van_chuyen_hang' => 0,
                'phi_dong_go' => 0,
                'trang_thai' => DonHang::GIO_HANG,
                'tong_tien' => 0,
                'thanh_tien' => 0,
                'da_thanh_toan' => 0,
                'phi_mua_hang' => 0,
                'khoi_luong' => 0,
                'chiet_khau' => 0,
                'kieu_chiet_khau_tien_hang' => 'VNĐ',
                'ti_le_phan_tram_mua_hang' => 0,
                'ghi_chu' => '',
                'active' => 1,
                'ma_van_don' => '',
                'website' => $website,
                'shop_link' => '',
                'tong_tien_cny' => 0,
                'tong_so_luong' => 0,
                'anh_don_hang' => $productJSON->image,
                'da_chon_de_thanh_toan' => 1,
                'user_id' => $uid,
                'cong_cu_mua_hang' => 'Extension'
            );

            $nodeDonHang = new DonHang();
            foreach ($fieldsDonHang as $field => $value)
                $nodeDonHang->{$field} = $value;
            if(!$nodeDonHang->save()){
                myAPI::sendMail(Html::errorSummary($nodeDonHang), 'Lỗi Lưu đơn hàng');
                return ['success' => false, 'data' => Html::errorSummary($nodeDonHang)];
            }
        }

        // Tìm tất cả đơn hàng chi tiết của đơn hàng, sau đó ktra chi tiết đơn hàng tồn tại k
        $nodesChiTietDonhang = ChiTietDonHang::findAll(['don_hang_id' => $nodeDonHang->id]);
        $skuIDDaLuau = [];
        foreach ($nodesChiTietDonhang as $item)
            $skuIDDaLuau[$item->skuMap] = $item;

        $tongSoLuongSPDonHang = 0;
        $tongTienCNYDonHang = 0;
//      $tongChiPhiKiemDem = 0;

        $skusChosen = [];

        foreach ($productJSON->skuMaps as $indexSKU => $skuMap) {
            if($indexSKU != 'skuMapsAvailable'){
                // Lưu từng SKU với số lượng đặt hàng > 0
                if ($skuMap->soLuong > 0) {
                    $skusChosen[] = $skuMap;

                    // Trường hợp đặt thêm trùng SKU Sản phẩm
                    if (isset($skuIDDaLuau[$skuMap->skuId])) { // Nếu sản phẩm đã được chọn
//            $phiKiemDem = getChiPhiKiemDem(
//              doubleval($nodeChiTietDonHang->field_price_money),
//              doubleval($nodeChiTietDonHang->field_quantity),
//              node_load(2645)
//            );
//            $hoTroKiemDem = 1;
//            if($phiKiemDem < 0){
//              $hoTroKiemDem = 0;
//              $chiPhiKiemDem = 0;
//            }else{
//              $chiPhiKiemDem = $phiKiemDem;
//            }
                        // Tăng số lượng
                        /** @var ChiTietDonHang $nodeChiTietDonHang */
                        $nodeChiTietDonHang = $skuIDDaLuau[$skuMap->skuMap];
                        $fieldsChiTietDonHang = [];

                        $soLuongMoi = intval($nodeChiTietDonHang->so_luong) + intval($skuMap->soLuong);
                        $fieldsChiTietDonHang['so_luong'] = $soLuongMoi;
                        $tongSoLuongSPDonHang += $soLuongMoi;
                        $donGiaNDT = myAPI::getGiaNDTBySoLuongV2($soLuongMoi, $productJSON->wholesales, $skuMap->discountPrice);

                        $tienHang = $donGiaNDT * $soLuongMoi;

                        $tongTienCNYChiTietDH = $tienHang; //$tienHang['tongTien'];//($nodeChiTietDonHang->field_quantity + $sku->soLuong) * doubleval($sku->sale_price);
                        $tongTienCNYDonHang += $tienHang;

                        $fieldsChiTietDonHang['tong_tien_cny'] = ($tongTienCNYChiTietDH);
                        $fieldsChiTietDonHang['price_money'] = ($donGiaNDT);
                        $fieldsChiTietDonHang['tong_tien'] = ($tongTienCNYChiTietDH * $tyGia);

//            $entityChiTietDonHang->field_ho_tro_kiem_dem->set($hoTroKiemDem);
//            $entityChiTietDonHang->field_phi_kiem_dem->set($chiPhiKiemDem);

//            $tongChiPhiKiemDem += $chiPhiKiemDem;
                        $nodeChiTietDonHang->updateAttributes($fieldsChiTietDonHang);

                    }
                    else {
                        $arrSKUMap = explode(';', $skuMap->skuMap);
                        $imagesChiTietSP = '';
                        foreach ($arrSKUMap as $itemSKUMap) {
                            foreach ($productJSON->itemPropertys as $itemProperty) {
                                if ($itemProperty->title == $itemSKUMap) {
                                    if (!is_null($itemProperty->image) && $itemProperty->image != '') {
                                        $imagesChiTietSP = $itemProperty->image;
                                        break;
                                    }
                                }
                            }
                        }

                        $donGiaNDT = myAPI::getGiaNDTBySoLuongV2($skuMap->soLuong, $productJSON->wholesales, $skuMap->discountPrice);

                        $nodeChiTietDonHang = new ChiTietDonHang();
                        $fieldNewChiTietDonHang = [
                            'don_hang_id' => $nodeDonHang->id,
                            'images' => $imagesChiTietSP == '' ? $productJSON->image : $imagesChiTietSP,
                            'skuid' => $skuMap->skuId,
                            'product_name' => $productJSON->name,
                            'props_name' => $skuMap->skuMap,
                            'props_name_vn' => $skuMap->skuMap,
                            'price_money' => $donGiaNDT,
                            'sku2info' => json_encode($skuMap),
                            'so_luong' => $skuMap->soLuong,
                            'skuMap' => $skuMap->skuMap,
                            'tong_tien_cny' => $donGiaNDT * $skuMap->soLuong,//$sku->soLuong * doubleval($sku->sale_price),
                            'tong_tien' => $donGiaNDT * $skuMap->soLuong * $tyGia,
                            'notes' => '',
                            'product_id' => $idProduct,
                            'vids' => '',
                            'phi_kiem_dem' => null, // $chiPhiKiemDem,
                            'ho_tro_kiem_dem' => null, //$hoTroKiemDem,
                            'da_chon_de_thanh_toan' => 1,
                            'user_id' => $uid
                        ];
                        foreach ($fieldNewChiTietDonHang as $field => $value){
                            $nodeChiTietDonHang->{$field} = $value;
                        }
                        if(!$nodeChiTietDonHang->save()){
                            myAPI::sendMail(Html::errorSummary($nodeChiTietDonHang), 'Lỗi CTDH');
                        }
//                        $nodeChiTietDonHang = insertNewNode('chi_tiet_don_hang', 'Chi tiết đơn hàng 1688 - ' . $nodeDonHang->nid . ' sku ' . $skuMap->skuId, , $uid);

                        $tongSoLuongSPDonHang += $skuMap->soLuong;
                        $tongTienCNYDonHang += $donGiaNDT * $skuMap->soLuong; // * $tyGia;
                    }
                }
            }
        }

        // Tính lại tổng số lượng và tổng tiền CNY + VND > Tính tiền mua hàng hộ
        $nodesChiTietDonhang = ChiTietDonHang::findAll(['don_hang_id' => $nodeDonHang->id]);
        $tongTienCNYDonHang = 0;
//      $tongTienVND = 0;
        $tongSoLuongSPDonHang = 0;
        foreach ($nodesChiTietDonhang as $nodeChiTietDH) {
            $tongTienCNYDonHang += intval($nodeChiTietDH->tong_tien_cny);
//        $tongTienVND += intval($nodeChiTietDH->field_tong_tien);
            $tongSoLuongSPDonHang += intval($nodeChiTietDH->so_luong);

// Tính tiền mua hàng hộ
            $tongTienVND = round($tongTienCNYDonHang * $tyGia);

            $chiPhiMuaHangHo = QuanLyDonHang::getChiPhiMuaHang($tongTienVND);
            $chiPhiMuaHang = $chiPhiMuaHangHo['chiPhiMuaHang'];
            $chiPhiTheoThangGiaTri = $chiPhiMuaHangHo['chiPhiTheoThangGiaTri'];

            // Update lại tổng số lượng, tổng tiền CNY, tổng tiền VND của Đơn hàng
            $fieldsDonHang = [
                'tong_so_luong' => $tongSoLuongSPDonHang,
                'tong_tien_cny' => $tongTienCNYDonHang,
                'ti_le_phan_tram_mua_hang' => $chiPhiTheoThangGiaTri,
                'tong_tien' => $tongTienVND,
                'thanh_tien' => $tongTienVND + $chiPhiMuaHang,
                'phi_mua_hang' => $chiPhiMuaHang,
            ];
            $nodeDonHang->updateAttributes($fieldsDonHang);
        }
//        $khachHang = User::findOne($nodeDonHang->user_id); //user_load();

        // Thông báo cho admin biết khách hàng đã đặt vào giỏ hàng thành công
//        myAPI::sendMessNotiForOneUser($uid, 'THÔNG BÁO', 'Đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$nodeDonHang->id.' được đặt vào giỏ thành công');
//        myAPI::guiThongBaoLoiDenQuanTriVien('KH ĐÃ ĐẶT HÀNG', 'Khách hàng '.$khachHang->hoten.' ('.$khachHang->dien_thoai.') đặt hàng qua Extension thành công');

//        myAPI::sendMail(implode('<br />',  [
//            'Khách hàng '.$khachHang->dien_thoai.' đặt hàng thành công',
//            '<strong>Người thực hiện: </strong>'.$khachHang->hoten,
//            '<strong>Mã đơn: </strong>'.myAPI::PREFIX_NAME_SYSTEM.$nodeDonHang->id,
//            '<strong>Khách hàng: </strong>'.$khachHang->hoten,
//            '<strong>ĐT Khách hàng: </strong>'.$khachHang->dien_thoai,
//            '<strong>Ứng dụng: </strong> Extension',
//        ]),'KH ĐÃ ĐẶT HÀNG QUA EXTENSION');

        return ([
            'success' => true,
            'data' => 'Đặt hàng vào giỏ thành công',
        ]);
    }

    //add-to-cart
    public function actionAddToCart(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        if(!isset($_COOKIE['userId']))
            return (['success' => true, 'data' => '<h4><a href="'.myAPI::LINK_SYSTEM.'" target="_blank">Vui lòng đăng nhập trước khi đặt hàng</a></h4>']);
        else if(!isset($_COOKIE['token']))
            return (['success' => true, 'data' => '<h4><a href="'.myAPI::PREFIX_NAME_SYSTEM.'" target="_blank">Vui lòng đăng nhập trước khi đặt hàng</a></h4>']);
        else if(!isset($_COOKIE['username']))
            return (['success' => true, 'data' => '<h4><a href="'.myAPI::PREFIX_NAME_SYSTEM.'" target="_blank">Vui lòng đăng nhập trước khi đặt hàng</a></h4>']);
        else{
            $user = User::findOne(['username' => $_COOKIE['userId']]); //user_load($_COOKIE['userId']);
            if($user->auth_web != $_COOKIE['token'])
                return (['success' => true, 'data' => '<h4><a href="'.myAPI::PREFIX_NAME_SYSTEM.'" target="_blank">Vui lòng đăng nhập trước khi đặt hàng</a></h4>']);
            else{
                if($obj->website == 'CN1688')
                    return $this->luuDonHang1688($obj, $user);
                else{
                    return $this->luuDonTaoBaoTmall($obj, $user);
                }
            }
        }
    }

    /**
     * @param $obj object
     * @param $user User
     * @return array
     */
    function luuDonHang1688($obj, $user){
        if(count($obj->items) > 0 ){
            $urlProduct = $obj->items[0]->itemLink;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://s.naipot.com/api/item/detail?url='.$urlProduct,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'sourcetype: APP_IOS',
                    'versioncode: 3.8.8',
                    'infoMobie: [true, iPhone 8]',
                    'Authorization: eyJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjQxODIyNiwiaWF0IjoxNTg1Mjk5MTgwLCJlbWFpbCI6Im5odW5ndnUxMzE5OTdAZ21haWwuY29tIn0.cW8-MBZFDUm0iX3mROEBQl3YvdSeQ3P28TBS5BDKWFU'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);


            $log = new LogIS();
            $log->content = $response;
            $log->type = 'log extension';
            $log->obj_from_extension = json_encode($obj);
            $log->save();

            $result = json_decode($response);

            if(isset($result->success)){
                if($result->success){
                    foreach ($obj->items as $item){
                        foreach ($result->data->skuMaps as $indexSKUMAP => $skuMap){
                            if($indexSKUMAP != 'skuMapsAvailable'){
                                if($skuMap->skuMap == $item->propetiesName){
                                    $arr = (array)$result->data->skuMaps[$indexSKUMAP];

                                    $arr['soLuong'] = $item->quantity;
                                    $arr['propsName'] = $item->propetiesName;
                                    $arr['propsNameVi'] = $item->propetiesName;
                                    $result->data->skuMaps[$indexSKUMAP] = (object)$arr;
                                }else {
                                    $arr = (array)$result->data->skuMaps[$indexSKUMAP];
                                    if(!isset($arr['soLuong'])){
                                        $arr['soLuong'] = 0;
                                        $arr['propsName'] = '';
                                        $arr['propsNameVi'] = '';
                                        $result->data->skuMaps[$indexSKUMAP] = (object)$arr;
                                    }
                                }
                            }
                        }
                    }

                    $uid = $user->id;

                    $strChina = [
                        $result->data->name,
                    ];
                    foreach ($result->data->itemPropertys as $itemProperty) {
                        $strChina[] = $itemProperty->title;
                        foreach ($itemProperty->childPropertys as $item) {
                            $strChina[] = $item->title;
                        }
                    }

                    $resultsTranslate =  myAPI::MinhHienTranslate($strChina);

                    if(count($resultsTranslate) > 0){
                        $result->data->nameTranslate = $resultsTranslate[0];
                        $i = 1;
                        foreach ($result->data->itemPropertys as $index1 => $itemProperty) {
                            $result->data->itemPropertys[$index1]->nameTranslate = $resultsTranslate[$i];
                            $i++;
                            foreach ($itemProperty->childPropertys as $index2 => $item) {
                                $result->data->itemPropertys[$index1]->childPropertys[$index2]->titleTranslate = $resultsTranslate[$i];
                                $i++;
                            }
                        }
                    }

                    // Đặt hàng vào giỏ
                    return $this->saveDonHang1688FromProductJsonString($result->data, $uid);
                }
                else
                    return (
                    [
                        'success' => true,
                        'data' => $result->message
                    ]
                    ) ;
            }else
                return ([
                    'success' => true,
                    'data' => $response]) ;

        }
        else
            return (['success' => true, 'data' => 'Vui lòng chọn ít nhất 1 sản phẩm']);
    }

    /**
     * @param $obj object
     * @param $user User
     * @return []
     */
    function luuDonTaoBaoTmall($obj, $user){
        $log = new LogIS();
        $log->content = json_encode($obj);
        $log->type = 'log extension';
        $log->save();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://s.naipot.com/api/item/detail?url='.$obj->items[0]->itemLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'sourcetype: APP_IOS',
                'versioncode: 3.8.8',
                'infoMobie: [true, iPhone 8]',
                'Authorization: eyJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjQxODIyNiwiaWF0IjoxNTg1Mjk5MTgwLCJlbWFpbCI6Im5odW5ndnUxMzE5OTdAZ21haWwuY29tIn0.cW8-MBZFDUm0iX3mROEBQl3YvdSeQ3P28TBS5BDKWFU'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);

        if(isset($result->success)){
            if($result->success){
                $uid = $user->id;

                $strChina = [
                    $result->data->name,
                ];
                foreach ($result->data->itemPropertys as $itemProperty) {
                    $strChina[] = $itemProperty->title;
                    foreach ($itemProperty->childPropertys as $item) {
                        $strChina[] = $item->title;
                    }
                }

                $resultsTranslate = myAPI::MinhHienTranslate($strChina);
                if(count($resultsTranslate) > 0){
                    $result->data->nameTranslate = $resultsTranslate[0];
                    $i = 1;
                    foreach ($result->data->itemPropertys as $index1 => $itemProperty) {
                        $result->data->itemPropertys[$index1]->nameTranslate = $resultsTranslate[$i];
                        $i++;
                        foreach ($itemProperty->childPropertys as $index2 => $item) {
                            $result->data->itemPropertys[$index1]->childPropertys[$index2]->titleTranslate = $resultsTranslate[$i];
                            $i++;
                        }
                    }
                }

                foreach ($obj->items as $item){
//                    $SKUID = $obj->items[0]->skuId;
//                    $propetiesName = $obj->items[0]->propetiesName;
                    foreach ($result->data->skuMaps as $indexSKUMAP => $skuMap){
                        if($skuMap->skuId == $item->skuId){
                            $arr = (array)$result->data->skuMaps[$indexSKUMAP];
                            $arr['soLuong'] = $item->quantity;
                            $arr['propsName'] = $item->propetiesName;
                            $arr['propsNameVi'] = $item->propetiesName;
                            $result->data->skuMaps[$indexSKUMAP] = (object)$arr;
                        }else {
                            $arr['soLuong'] = 0;
                            $arr['propsName'] = '';
                            $arr['propsNameVi'] = '';
                            $result->data->skuMaps[$indexSKUMAP] = (object)$arr;
                        }
                    }
                }

                // Đặt hàng vào giỏ
                return $this->saveDonHangTaoBaoV2FromProductJsonString($obj, $result->data, $uid, true);
            }
            else
                return (
                [
                    'success' => false,
                    'data' => $result->message
                ]
                ) ;
        }else
            return (
            [
                'success' => false,
                'data' => $response
            ]
            ) ;
    }

    /**
     * @param $productJSON Object
     * @param $uid int
     * @return array
     */
    function saveDonHangTaoBaoV2FromProductJsonString($obj, $productJSON, $uid){
        // Tìm sản phẩm
        $product = Product::findOne(['product_id' => trim($productJSON->productId)]);

        $website = $productJSON->website == 'TAOBAO' ? 'taobao' : 'tmall';
        if(is_null($product)){
            $fieldsProduct = [
                'link_product' => $productJSON->itemUrl,
                'product_id' => $productJSON->productId,
                'shop_link' => $productJSON->shopUrl,
                'string_json' => json_encode($productJSON),
                'nguon' => 'Ext',
                'domain' => $website,
                'user_id' => $uid,
                'name' => $productJSON->name,
                'string_json_vi' => json_encode($productJSON),
            ];
            $newProduct = new Product();
            foreach ($fieldsProduct as $field => $value)
                $newProduct->{$field} = $value;
            $newProduct->save();
            $idProduct = $newProduct->id;
        }
        else{
            $product->updateAttributes([
                'string_json_vi' => json_encode($productJSON),
                'string_json' => json_encode($productJSON)
            ]);
            $idProduct = $product->id;
        }

        // Kiểm tra đơn hàng theo shop đã tồn tại chưa. Nếu đã tồn tại thì tìm xem sản phẩm đã đặt chưa. Nếu đã đặt thì tăng số lượng
        $nodeDonHang = DonHang::findOne(['trang_thai' => DonHang::GIO_HANG, 'shop_id' => $productJSON->shopId, 'active' => 1, 'user_id' => $uid]);
        $tyGia = CauHinh::findOne(['ghi_chu' => 'ty_gia_trung_viet'])->content;

        if(is_null($nodeDonHang)){
            $fieldsDonHang = array(
                'shop_name' => $productJSON->shopName,
                'shop_id' => $productJSON->shopId,
                'ship_noi_dia_cny' => 0,
                'ship_noi_dia_vnd' => 0,
                'ty_gia' => $tyGia,
                'phi_van_chuyen_hang' => 0,
                'phi_dong_go' => 0,
                'trang_thai' => DonHang::GIO_HANG,
                'tong_tien' => 0,
                'thanh_tien' => 0,
                'da_thanh_toan' => 0,
                'phi_mua_hang' => 0,
                'khoi_luong' => 0,
                'chiet_khau' => 0,
                'kieu_chiet_khau_tien_hang' => 'VNĐ',
                'ti_le_phan_tram_mua_hang' => 0,
                'ghi_chu' => '',
                'active' => 1,
                'ma_van_don' => '',
                'website' => $website,
                'shop_link' => '',
                'tong_tien_cny' => 0,
                'tong_so_luong' => 0,
                'anh_don_hang' => $productJSON->image,
                'da_chon_de_thanh_toan' => 1,
                'user_id' => intval($uid)
            );
            $nodeDonHang = new DonHang();
            foreach ($fieldsDonHang as $field => $value)
                $nodeDonHang->{$field} = $value;
            if(!$nodeDonHang->save()){
                myAPI::sendMail( Html::errorSummary($nodeDonHang). json_encode($fieldsDonHang), 'Lỗi Lưu đơn hàng');
                return ['success' => false, 'data' => Html::errorSummary($nodeDonHang)];
            }
        }

        foreach ($obj->items as $item){
            // Lưu chi tiết đơn hàng
            $nodeChiTietDonHang = ChiTietDonHang::findOne(['don_hang_id' => $nodeDonHang->id, 'skuid' => $item->skuId]);
            $skuMapStr = '';
            if(is_null($nodeChiTietDonHang)){
                if(is_array($productJSON->skuMaps)) {
                    if (count($productJSON->skuMaps) > 0) {
                        foreach ($productJSON->skuMaps as $indexSKU => $skuMap) {
                            if(isset($skuMap->skuId)){
                                if($skuMap->skuId == $item->skuId)
                                    $skuMapStr = json_encode($skuMap);
                            }
                        }
                    }
                }
                $nodeChiTietDonHang = new ChiTietDonHang();
                $fieldNewChiTietDonHang = [
                    'don_hang_id' => $nodeDonHang->id,
                    'images' => $item->propetiesImage,
                    'skuid' => $item->skuId,
                    'product_name' => $productJSON->name,
                    'props_name' => $item->propetiesName,
                    'props_name_vn' => $item->propetiesName,
                    'price_money' => $item->itemPriceNDT,
                    'sku2info' => $skuMapStr,
                    'so_luong' => $item->quantity,
                    'tong_tien_cny' => $item->quantity * $item->itemPriceNDT,//$sku->soLuong * doubleval($sku->sale_price),
                    'tong_tien' => $item->itemPriceNDT * $item->quantity * $tyGia,
                    'notes' => '',
                    'product_id' => $idProduct,
                    'vids' => '',
                    'phi_kiem_dem' => null, // $chiPhiKiemDem,
                    'ho_tro_kiem_dem' => null, //$hoTroKiemDem,
                    'da_chon_de_thanh_toan' => 1,
                    'user_id' => $uid,
                ];

                foreach ($fieldNewChiTietDonHang as $field => $value){
                    $nodeChiTietDonHang->{$field} = $value;
                }
                if(!$nodeChiTietDonHang->save()){
                    myAPI::sendMail(Html::errorSummary($nodeChiTietDonHang), 'Lỗi CTDH');
                }

            }
            else{
                $nodeChiTietDonHang->updateAttributes([
                    'so_luong' => $nodeChiTietDonHang->so_luong + $item->quantity,
                    'tong_tien_cny' => ($nodeChiTietDonHang->so_luong + $item->quantity) * $item->itemPriceNDT,
                    'tong_tien' => $item->itemPriceNDT * ($nodeChiTietDonHang->so_luong + $item->quantity) * $tyGia,
                ]);
            }
        }

        // Tính lại tổng số lượng và tổng tiền CNY + VND > Tính tiền mua hàng hộ
        $nodesChiTietDonhang = ChiTietDonHang::findAll(['don_hang_id' => $nodeDonHang->id]);
        $tongTienCNYDonHang = 0;
        $tongSoLuongSPDonHang = 0;

        foreach ($nodesChiTietDonhang as $nodeChiTietDH) {
            $tongTienCNYDonHang += doubleval($nodeChiTietDH->tong_tien_cny);
            $tongSoLuongSPDonHang += doubleval($nodeChiTietDH->so_luong);
        }

        // Tính tiền mua hàng hộ
        $tongTienVND = round($tongTienCNYDonHang * $tyGia);

        $chiPhiMuaHangHo = QuanLyDonHang::getChiPhiMuaHang($tongTienVND);
        $chiPhiMuaHang = $chiPhiMuaHangHo['chiPhiMuaHang'];
        $chiPhiTheoThangGiaTri = $chiPhiMuaHangHo['chiPhiTheoThangGiaTri'];

        // Update lại tổng số lượng, tổng tiền CNY, tổng tiền VND của Đơn hàng
        $nodeDonHang->updateAttributes([
            'tong_so_luong' => $tongSoLuongSPDonHang,
            'tong_tien_cny' => $tongTienCNYDonHang,
            'ti_le_phan_tram_mua_hang' => $chiPhiTheoThangGiaTri,
            'tong_tien' => $tongTienVND,
            'thanh_tien' => $tongTienVND + $chiPhiMuaHang,
            'phi_mua_hang' => $chiPhiMuaHang,
        ]);

        $khachHang = User::findOne($nodeDonHang->user_id);
        // Thông báo cho admin biết khách hàng đã đặt vào giỏ hàng thành công
        myAPI::sendMessNotiForOneUser($uid, 'THÔNG BÁO', 'Đơn hàng '.myAPI::PREFIX_NAME_SYSTEM.$nodeDonHang->id.' được đặt vào giỏ thành công');
        myAPI::guiThongBaoLoiDenQuanTriVien('KH ĐÃ ĐẶT HÀNG', 'Khách hàng '.$khachHang->hoten.' đặt hàng qua Extension thành công');
        myAPI::sendMail(implode(
            '<br />',
            [
                'Khách hàng '.$khachHang->dien_thoai.' đặt hàng thành công',
                '<strong>Người thực hiện: </strong>'.$khachHang->hoten,
                '<strong>Mã đơn: </strong>'.myAPI::PREFIX_NAME_SYSTEM.$nodeDonHang->id,
                '<strong>Khách hàng: </strong>'.$khachHang->hoten,
                '<strong>ĐT Khách hàng: </strong>'.$khachHang->dien_thoai,
                '<strong>Ứng dụng: </strong> Extension',
            ]
        ), 'KH ĐẶT HÀNG QUA EXTENSION THÀNH CÔNG');

        return ([
            'success' => true,
            'data' => 'Đặt hàng vào giỏ thành công',
        ]);
    }
}
