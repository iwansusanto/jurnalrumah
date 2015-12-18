<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>

<a class="link-detail" href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['/berita/detail',
                                        'kategori'  =>  \Yii::$app->jurnalrumah->slug($model['categori_name']),
                                        'y' => date('Y', strtotime($model['date_create'])),
                                        'm' => date('m', strtotime($model['date_create'])),
                                        'd' => date('d', strtotime($model['date_create'])),
                                        'slug' => \Yii::$app->jurnalrumah->slug($model['judul']),
                                        'id' => $model['id']]) ?>" alt="<?= $model['judul'] ?>" data-pjax="0">
    <div class="wrapper-berita-lainnya-l left">
        <div class="kategori-berita-lainnya">
            <?= $model['categori_name'] ?>
        </div>
        <div class="judul-berita-lainnya">
            <?= $model['judul'] ?>
        </div>
        <div class="content-berita-lainnya">
            <?= $model['summary'] ?>
        </div>
        <div class="berita-lainnya-waktu-tayang">
            <?= Html::tag('i', '', [
                            'class' =>  'fa fa-clock-o'
                        ]) ?>
            <?= \Yii::$app->jurnalrumah->cekwaktutayangdetail(strtotime($model['date_create'])) ?>
        </div>
    </div>
    <div class="wrapper-berita-lainnya-r right">
        <?= Html::img(\Yii::$app->jurnalrumah->lihatimagedetail($model['image1'],"","artikel"), [
            'width' =>  120,
            'height'    =>  90,
            'alt'   =>  $model['judul']
        ]) ?>
    </div>
</a>

<div class="cleaner"></div>
