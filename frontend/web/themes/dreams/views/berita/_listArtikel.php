<?php

use yii\helpers\Html;
use app\components\ParentController;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($model["scheduled_date"]) && $model["scheduled_date"] != '0000-00-00 00:00:00'){
    $date = $model["scheduled_date"];
//    echo 'nah';
}else{
    $date = $model["created"];
//    echo 'nih';
}
$time = ParentController::esitime(strtotime($date));
$datex = date('j F Y H:i', strtotime($date)) . ' WIB';
$year = date('Y', strtotime($date));
$month = date('m', strtotime($date));
$day = date('d', strtotime($date));
$id = $model['id'];
$kategori = isset($model['kategori']) && !empty($model['kategori']) ? $model['kategori'] : isset($model['cat_slug']) && !empty($model['cat_slug'])? $model['cat_slug'] : "";
$slug = isset($model['slug']) ? $model['slug'] : "";
$url = ['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id];
$_title_sub = $model['aub_judul'];
//if ($model['aub_judul'] == '')
//    $_title_sub = isset($model['kategori']) ? $model['kategori'] : isset($model['cat_name']) ? $model['cat_name'] : "";

// begin link, dan foto
echo Html::a(
        Html::tag('div', Html::img(
                        Yii::$app->rajamobil->lihatImageDetail($model['img_1'], $size = 90, $kategori = 'artikel'), [
                    'alt' => $model['title'],
                    'width' => 90,
                    'height' => 75,
                        ]
                ), ['class' => 'foto left']), $url, ['data-pjax'=>0], ['data-slide-index' => $index]
);
// end link, dan foto
?>

<!-- begin deskripsi berita -->
<div class="deskripsi left">
    <!-- begin subjudul -->
    <span class="subjudul"><?= $_title_sub ?></span>
    <!-- end subjudul -->

    <!-- begin link h2 -->
    <?php
    echo Html::a('<h2 title="' . $model['title'] . '">' . $model['title'] . '</h2>', $url, ['data-pjax'=>0]);
    ?>
    <!--<a href=""><h2 title="<?= $model['title'] ?>"><?= $model['title'] ?></h2></a>-->
    <!-- end link h2 -->

    <!-- begin deskripsi / artikel summary -->
    <span class="summary"><?= $model['summary'] ?></span>
    <!-- begin deskripsi / artikel summary -->

    <!-- begin posting time -->
    <div class="time">
        <!-- begin time -->
        <div class="label left"><?= $time ?></div>
        <!-- end time -->

        <!-- begin sharer tools -->
        <div class="sharer left">
            <div class="share-btn-wrap">
                <span class="facebook" data-href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']])  ?>" data-title="<?= $model['title'] ?>"></span>
                <span class="count_fb"></span>
                <span class="twitter" data-href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']])  ?>" data-title="<?= $model['title'] ?>"></span>
                <span class="count_twitter"></span>
            </div>
<!--            <div class="fb"><div class="fb-share-button" data-href="<?php // echo 'http://www.rajamobil.com/berita/berita-mobil/2015/06/22/ferrari-siap-suplai-mesin-untuk-red-bull-29252.htm';//Url::to($url); ?>" data-layout="button_count"></div></div>
            <div class="tw"><a href="https://twitter.com/share" class="twitter-share-button" data-text="judul" data-url="<?php // echo 'http://www.rajamobil.com/berita/berita-mobil/2015/06/22/ferrari-siap-suplai-mesin-untuk-red-bull-29252.htm';//Url::to($url); ?>" data-via="RajaMobilCom">Tweet</a></div>-->
            
        </div>
        <!-- end sharer tools -->
        <div class="cleaner"></div>
    </div>
    <!-- begin posting time -->
</div>
<!-- end deskripsi berita -->
<div class="cleaner"></div>