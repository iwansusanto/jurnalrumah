<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>


<div class="header-right-cat">
    <span class="header-right-thin">Berita </span><span class="header-right-bold">POPULER</span>
</div>
<ul class="list-berita-popular">
    <?php
    if(!empty($artikelPopular)){
        foreach ($artikelPopular as $i=>$data){ ?>
        <li>
            <a class="link-detail" href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['/berita/detail',
                                            'kategori'  =>  \Yii::$app->jurnalrumah->slug($data['categori_name']),
                                            'y' => date('Y', strtotime($data['date_create'])),
                                            'm' => date('m', strtotime($data['date_create'])),
                                            'd' => date('d', strtotime($data['date_create'])),
                                            'slug' => \Yii::$app->jurnalrumah->slug($data['judul']),
                                            'id' => $data['id']]) ?>" alt="<?= $data['judul'] ?>">
                <div class="judul-berita-popular-r left">
                    <?= $data['judul']; ?>
                    <div class="berita-popular-waktu-tayang">
                        <?= Html::tag('i', '', [
                            'class' =>  'fa fa-clock-o'
                        ]) ?>
                        <?= \Yii::$app->jurnalrumah->cekwaktutayangdetail(strtotime($data['date_create'])) ?>
                    </div>
                </div>

                <div class="img-berita-popular-r right">
                    <?= Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($data['image1'],"","artikel"), [
                        'width' =>  90,
                        'height'    =>  65
                    ]) ?>
                </div>
                
            </a>
            <div class="cleaner"></div>
        </li>    
    <?php    }
    }else{
        echo Html::tag('li', 'Tidak Ada Berita', [
                
            ]);
    }
    ?>
</ul>
