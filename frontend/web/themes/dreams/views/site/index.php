<?php

use yii\helpers\Html;
use frontend\assets\HomeAsset;
use yii\widgets\Pjax;
use yii\widgets\ListView;

HomeAsset::register($this);
?>

<div>
    <div class="headline">
        <div class="hlnav">
            <div id="prev" class="bgg navslider"></div>
            <div id="next" class="bgg navslider"></div>
        </div>
        <ul class="bxslider">
            <?php
            if(!empty($artikelTerupdate)){
                foreach ($artikelTerupdate as $i=>$data){
                  echo  Html::tag('li', 
                            Html::a(Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($data['image1'],"","artikel"), [
                                    'width' =>  650,
                                    'height'    =>  400,
                                    'alt'   =>  $data['judul'],
                                    'title' =>  $data['judul'],
                                    'data-penulis'  =>  ''
                                ]), \Yii::$app->urlManager->createAbsoluteUrl(['/berita/detail',
                                        'kategori'  =>  \Yii::$app->jurnalrumah->slug($data['categori_name']),
                                        'y' => date('Y', strtotime($data['date_create'])),
                                        'm' => date('m', strtotime($data['date_create'])),
                                        'd' => date('d', strtotime($data['date_create'])),
                                        'slug' => \Yii::$app->jurnalrumah->slug($data['judul']),
                                        'id' => $data['id']]), [
                                    'alt'   =>  $data['judul'],
                                ]), [
                        
                                ]);
                }   
            }
            ?>    
        </ul>
        <ul id="bx-pager">
            <?php
            if(!empty($artikelTerupdate)){
                foreach ($artikelTerupdate as $x=>$row){
                   echo  Html::tag('li',
                            Html::a(Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($row['image1'],"","artikel"), [
                                        'width' =>  130,
                                        'height'    =>  70,
                                        'alt'   =>  $row['judul']
                                    ]).'<br>'.Html::tag('span', \Yii::$app->jurnalrumah->potongjudul($row['judul'], 40), [

                                        ]), '#', [
                                    'data-slide-index'  =>  $x,
                                ]) , [
                        
                    ]);
                }
            }
            
            ?>
        </ul>
        <div class="cleaner"></div>
    </div>
    <div class="list-berita-lainnya">
        <?php
        Pjax::begin([
            'id' => 'beritalist',
        ])
        ?>
        
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_index',
            'layout' => '<ul id="wrapper-artikel" class="wrapper-list-berita">{items}</ul><div style="display: none">{pager}</div>',
            'options' => [
            ],
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'list-berita-item'
            ],
            'emptyText' => 'Tidak ada data yang dapat di tampilkan'
        ])
        ?>
        
        <?php Pjax::end() ?>
        <?= Html::hiddenInput('txt-data', 0, $options = ['id' => 'txt-data']) ?>
        <div id="loading-bar"><?= Html::img($this->theme->getUrl('images/loadingbar/subscribe.gif'), ['alt' => 'Loading Artikel', 'width' => 16, 'height' => 11]) ?></div>
    </div>
</div>


<div class="cleaner"></div>
