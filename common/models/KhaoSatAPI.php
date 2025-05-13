<?php
/**
 * Created by PhpStorm.
 * User: hungluong
 * Date: 4/20/18
 * Time: 07:21
 */

namespace common\models;


class KhaoSatAPI
{
    public static function getThongKeTheoNhomDonVi($nhom = "Sở, ban ngành | Quận, huyện", $tungay, $denngay, $thongkecauhoi_nhom_1, $thongkecauhoi_nhom_2){
        $ketqua = \Yii::$app->db->createCommand("SELECT ks_get_thongke_theoquanhuyen(:tungay, :denngay, :socau_nhom1_mau1, 
            :socau_nhom2_mau1, :socau_nhom1_mau2, :socau_nhom2_mau2, :nhomdonvi) AS ketqua;",[
            ':tungay' => $tungay,
            ':denngay' => $denngay,
            ':socau_nhom1_mau1' => $thongkecauhoi_nhom_1[1],
            ':socau_nhom2_mau1' => $thongkecauhoi_nhom_1[2] + $thongkecauhoi_nhom_1[1],
            ':socau_nhom1_mau2' => $thongkecauhoi_nhom_2[1],
            ':socau_nhom2_mau2' => $thongkecauhoi_nhom_2[2] + $thongkecauhoi_nhom_2[1],
            ':nhomdonvi' => $nhom
        ])->queryAll();
        return $ketqua;
    }
}