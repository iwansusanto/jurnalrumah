<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use app\components\WCariBerita;
use app\components\Jurnalrumah;
use yii\widgets;
?>



<div class="header">
    <div class="container-header">
        <div class="logo left">
            <a href="http://www.jurnalrumah.com/" title="JurnalRumah"><img src="<?php echo $this->theme->getUrl('images/komponen/jurnalrumah.svg'); ?>" alt="JurnalRumah" height="40"></a>
        </div>
        <ul class="right">
            <li class="header-time" title="2015-08-30T00:30:41+07:00"><?= Jurnalrumah::convertToTanggal(date('Y-m-d'), $type = 5) ?></li>
            <li>
                <?= WCariBerita::widget(); ?>
            </li>
        </ul>
    </div>
    
</div>

<div class="container">
    <div class="iklan-header-top left">
        <?php
//        Html::img($this->theme->getUrl('images/komponen/banner_top.jpg'), [
//            'alt'   =>  'Banner iklan header atas'
//        ]);
        ?>
    </div>
    <div class="menuheader">
        <?=
                Menu::widget([
                    'options' => [
                                    'id'=>'menuUtama',
                                    'class'=>'menu',
				],
                    'items' => [
                        ['label' => 'Home', 'url' => ['site/index']],
                        ['label' => 'Berita Perumahan', 'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/berita/kategori','kat'    =>  'berita-perumahan']),'active'   =>  (isset($_GET['kat']) && $_GET['kat'] == 'berita-perumahan' ? true: false)],
                        ['label' => 'Tips', 'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/berita/kategori','kat'    =>  'tips']),'active'   =>  (isset($_GET['kat']) && $_GET['kat'] == 'tips' ? true: false)],
//                        ['label' => 'Hubungi Kami', 'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/site/hubungikami'])],
                    ],
                ]);
        ?>
        <!--<ul id="menuUtama" class="menu">-->
            <!--<li><?php // Html::a('Home', \Yii::$app->urlManager->createAbsoluteUrl(['/']), []) ?></li>-->
<!--            <li>
                <?php // Html::a('Berita', '#', []) ?>
                <div class="drop" style="width: 420px;">
                    <div class='left'>
                        <ul>
                            <li><a href="#">Berita Perumahan</a></li>
                            <li><a href="#">Tips</a></li>
                        </ul>
                    </div>
                    <div style='clear: both;'></div>
                </div>
            </li>-->
<!--            <li><?php // Html::a('Berita Perumahan', '#', []) ?></li>
            <li><?php // Html::a('Tips', '#', []) ?></li>
            <li><?php // Html::a('Hubungi Kami', '#', []) ?></li>-->
            <!--<li><?php // Html::a('Tentang Kami', '#', []) ?></li>-->
            <!--<li><?php //Html::a('Cari Rumah', '#', []) ?></li>-->
        <!--</ul>-->
    </div>

</div>

<div class="cleaner">
    
</div>