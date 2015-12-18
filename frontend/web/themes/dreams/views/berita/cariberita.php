<?php

use frontend\assets\CariberitaAsset;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\Html;

CariberitaAsset::register($this);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo '<pre>';print_r($count);die;
//if(!empty($results)): ?>

<div>    
    <div class="list-berita-lainnya">
        <div class="cariberita-label">
            Menemukan <?php echo '<strong>'.$count['total'].'</strong>' ?> berita dengan kata kunci <?php echo '<strong>'.$cariberita.'</strong>';   ?>
        </div>
        
        <?php
        Pjax::begin([
            'id' => 'cariberitalist',
        ])
        ?>
        
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_cariberita',
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
        
<?php // foreach ($results as $i=>$data): ?>

    <?php // $data['judul'].'<br/>'; ?>

<?php // endforeach; ?>
    </div>    
<?php // else: ?>
    <?php // 'Data Tidak Di Temukan'; ?>
<?php // endif; ?>
    
</div>