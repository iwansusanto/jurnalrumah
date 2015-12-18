<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\widgets\Menu;
use yii\helpers\Url;
use app\components\PencarianMobil;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

#print_r($artikelList);die;
$rajamobil_function = Yii::$app->rajamobil;
if(!empty($artikelList)){
    foreach($artikelList as $value){
        $url = 'http://www.rajamobil.com/'.$value['cat_slug']."/".date("Y/m/d/", strtotime($value['created'])).$value['slug']."-".$value['id'].".htm";
        $judul = $value['title'];
        /*$url = Yii::$app->urlManager->createUrl("mobil/detail",array(
                                            "condition" => strtolower($kondisi_kendaraan),
                                            "year"  =>  $year,
                                            "month" =>  $month,
                                            "day"   =>  $day,
                                            "slug"  =>  $slug,
                                            "id"=>$value["id"]));*/

        echo HTml::a($judul,$url,['title'=>$judul,'target'=>'_blank']).'<br>';
    }
}else{
    echo 'Artikel yang anda cari tidak ada';
}
?>