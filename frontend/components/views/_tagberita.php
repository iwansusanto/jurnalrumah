<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>


<div class="tag-wrapper">
    <div class="header-right-cat">
        <span class="header-right-thin">Tag </span><span class="header-right-bold">POPULER</span>
    </div>
    <ul class="list-tag-popular">
        <?php
    //    print_r($artikelTag);
        if(!empty($artikelTag)){
            foreach ($artikelTag as $i=>$data){ ?>
            <li>
                <a href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['/berita/tag',
                                            'tag'  =>  'tag',
                                            'tagberita'  =>  \Yii::$app->jurnalrumah->slug($data['name'])]) ?>"
                                            alt="<?= $data['name'] ?>">
                    <?= ucwords($data['name']); ?>
                </a>
                <div class="cleaner"></div>
            </li>  
        <?php    }
        }else{
            echo Html::tag('li', 'Tidak Ada Tag', [

                ]);
        }
        ?>
    </ul>

</div>
