<?php
use yii\helpers\Html;
//use frontend\assets\MemberAsset;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//MemberAsset::register($this);
?>

<ul style="list-style-type: none;margin: 0px;padding: 0px;overflow: hidden;">
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Nama</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $nama; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Authorized</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;">Dealer</div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Nama Dealer</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $nama_dealer; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Alamat</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $alamat; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Email Kepala Cabang</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian"><?= $email_kepala_cabang; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Email Sales Supervisior</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $email_spv_sales; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">No Telp Dealer</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $no_telp; ?></div>
        <!--<div class="clearfix"></div>-->
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <div class="label" style="width: 150px;font-weight: bold;float: left;">Keterangan</div>
        <div class="semicolon" style="width: 10px;float: left;">:</div>
        <div class="isian" style="float: left;"><?= $keterangan; ?></div>
    </li>
    <li style="border-bottom: 1px solid #b3b3b3;overflow: hidden;padding: 8px;">
        <?= Html::a('Klik Tautan Ini', \Yii::$app->urlManager->createAbsoluteUrl(['/auth/dealerverification','id' => \Yii::$app->rajamobil->encryptIt($id),'client'   =>  \Yii::$app->rajamobil->encryptIt($client)]), []) ?> untuk aktifasi dealer.<br>
        <strong>Setelah berhasil aktifasi, silahkan buatkan akun user tersebut</strong>
    </li>
</ul>