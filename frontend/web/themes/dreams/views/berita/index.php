<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\WShowroom;
use app\components\WIklanTerkini;
#use app\components\WPromoMobil;
use app\components\WShowcase1;
use app\components\WShowcase2;
use app\components\WShowcase3;
use app\components\WShowcase4;
use frontend\assets\BeritaAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

BeritaAsset::register($this);
// Pola 
// Beranda › Berita › Video › Video Sendiri
$homeberita = Html::tag('span', 'Berita', ['itemprop' => 'title']);
if (!empty($subslug) && !empty($slug)) {
    $kat = ucwords(strtolower(str_replace('-', ' ', $slug)));
    $subkat = ucwords(strtolower(str_replace('-', ' ', $subslug)));
    $this->params['breadcrumbs'][] = [
        'label' => $homeberita,
        'url' => Url::to(['berita/index']),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = [
        'label' => Html::tag('span', $kat, ['itemprop' => 'title']),
        'url' =>Url::to(['berita/kategori', 'slug'=>$slug]),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = $subkat;
}
// Pola 
// Beranda › Berita › Video
elseif (!empty($slug)) {
    $kat = ucwords(strtolower(str_replace('-', ' ', $slug)));
    $this->params['breadcrumbs'][] = [
        'label' => $homeberita,
        'url' => Url::to(['berita/index']),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = $kat;
}
// Pola 
// Beranda › Berita › Nama Tag
elseif (!empty($tag)) {
    $tag = urldecode(ucwords($tag));
    $this->params['breadcrumbs'][] = [
        'label' => $homeberita,
        'url' => Url::to(['berita/index']),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = 'Tag : ' . $tag;
}
// Pola 
// Beranda › Berita › Key Pencarian
elseif (!empty($cariberita)) {
    $cariberita = urldecode(ucwords($cariberita));
    $this->params['breadcrumbs'][] = [
        'label' => $homeberita,
        'url' => Url::to(['berita/index']),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = $cariberita;
}
// Pola 
// Beranda › Berita › Semua Berita
else {
    $this->params['breadcrumbs'][] = [
        'label' => $homeberita,
        'url' => Url::to('berita/index'),
        'itemprop' => 'url',
    ];
    $this->params['breadcrumbs'][] = 'Semua Berita';
}
?>

<div id="content" class="container">
    <div class="subx default">
        <?php
        if (isset($slug) && $slug != "video" || !isset($slug)) {
            ?>
            <ul class="submenu-berita">
                <li <?= (empty($slug) ? 'class="active"' : ''); ?>><?php echo HTml::a('', Url::to(['berita/index']), ['title' => 'Home berita']); ?></li>
                <li <?= (isset($slug) && $slug == "berita-mobil" ? 'class="active"' : ''); ?>><?php echo HTml::a('Berita Mobil', ['berita/berita-mobil.htm'], ['title' => 'Berita Mobil']); ?></li>
                <li <?= (isset($slug) && $slug == "test-drive" ? 'class="active"' : ''); ?>><?php echo HTml::a('Test Drive', ['berita/test-drive.htm'], ['title' => 'Test Drive']); ?></li>
                <li <?= (isset($slug) && $slug == "komunitas" ? 'class="active"' : ''); ?>><?php echo HTml::a('Komunitas', ['berita/komunitas.htm'], ['title' => 'Komunitas']); ?></li>
                <li <?= (isset($slug) && $slug == "modifikasi" ? 'class="active"' : ''); ?>><?php echo HTml::a('Modifikasi', ['berita/modifikasi.htm'], ['title' => 'Modifikasi']); ?></li>
                <li <?= (isset($slug) && $slug == "bengkel-servis" ? 'class="active"' : ''); ?>><?php echo HTml::a('Bengkel Servis', ['berita/bengkel-servis.htm'], ['title' => 'Bengkel Servis']); ?></li>
                <li <?= (isset($slug) && $slug == "video" ? 'class="active"' : ''); ?>>
                    <?php
                    echo HTml::a(
                            Html::tag('div', 'Video', ['class' => 'label left']) .
                            Html::tag('div', '', ['class' => 'label-icon bgb left']) .
                            Html::tag('div', '', ['class' => 'cleaner'])
                            , ['berita/video.htm'], ['title' => 'Home berita']);
                    ?>
                </li>
            </ul>
            <?php
        } else {
            ?>
            <ul class="submenu-berita video">
                <li <?= (empty($slug) ? 'class="active"' : ''); ?>><?php echo HTml::a('', Url::to(['berita/index']), ['title' => 'Home berita']); ?></li>
                <li <?= (isset($slug) && $slug == "video" && $subslug == "" ? 'class="active"' : ''); ?>><?php echo HTml::a('', ['berita/video.htm'], ['title' => 'Video']); ?></li>
                <li <?= (isset($subslug) && $subslug == "video-sendiri" ? 'class="active"' : ''); ?>><?php echo HTml::a('Video Terkini', ['berita/video/video-sendiri.htm'], ['title' => 'Video Terkini']); ?></li>
                <li <?= (isset($subslug) && $subslug == "youtube" ? 'class="active"' : ''); ?>><?php echo HTml::a('Youtube', ['berita/video/youtube.htm'], ['title' => 'Youtube']); ?></li>
                <li <?= (isset($subslug) && $subslug == "voa" ? 'class="active"' : ''); ?>><?php echo HTml::a('VOA', ['berita/video/voa.htm'], ['title' => 'VOA']); ?></li>
            <?php } ?>
        </ul>
        <div class="cleaner"></div>
    </div>

    <!--
    begin
    konten kiri
    -->
    <div class="konten-kiri left">
        <?= WShowcase4::widget(); ?>
    </div>
    <!--
    end
    konten kiri
    -->

    <!--
    begin
    konten tengah
    -->
    <div class="konten-tengah left">
        <!--
        Begin
        breadcrumb
        -->
        <?=
        \yii\widgets\Breadcrumbs::widget([
            'homeLink' => [
                'label' => Html::tag('span', 'Home', ['itemprop' => 'title']),
                'url' => \Yii::$app->homeUrl,
                'itemprop' => 'url',
            ],
            'itemTemplate' => "<li itemscope itemtype='http://data-vocabulary.org/Breadcrumb'>{link}</li><li>›</li>", // template for all links Rang
            'activeItemTemplate' => "<li>{link}</li>", // template for all links
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'encodeLabels' => false,
        ])
        ?>

        <!--
        Begin
        breadcrumb
        -->

        <!--
        Begin
        Headline
        -->
        <div class="headline">
            <?php
            if (isset($tag) && $tag != '')
                $_title = 'Tag : ' . $tag;
            elseif (isset($cariberita) && $cariberita != '')
                $_title = 'Cari : ' . $cariberita;
            else
                $_title = $kategori_name;
            ?>
            <h1 title="<?= $_title ?>"><?= $_title ?></h1>
            <ul class="headline-slider">
                <?php
                if (!empty($sliderheadline["docs"])):
                    foreach ($sliderheadline["docs"] as $id => $val):
                        if ($val["scheduled_date"] != '0000-00-00 00:00:00')
                            $date = $val["scheduled_date"];
                        else
                            $date = $val["created"];
                        $year = date('Y', strtotime($date));
                        $month = date('m', strtotime($date));
                        $day = date('d', strtotime($date));
                        $id = $val['id'];
                        $kategori = isset($val['kategori']) ? $val['kategori'] : (isset($val['cat_name']) ? $val['cat_slug'] : "");
                        
                        $slug = isset($val['slug']) ? $val['slug'] : "";
                        $url = ['berita/detail', 'kategori' => 'video', 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id];
                        echo '<li>';
                        
                        // menampilkan video button
                        // jika kategori id 22 atau video
                        $videobtn = '';
                        if (isset($val['category_id']) && $val['category_id'] == 22)
                            $videobtn = '<span class="bgg iconplay"></span>';

                        echo Html::a(
                                $videobtn .
                                Html::img(
                                        Yii::$app->rajamobil->lihatImageDetail($val['img_1'], $size = 680, $kategori = 'artikel'), [
                                    'alt' => $val['title'],
                                    'width' => 680,
                                    'height' => 405,
                                    'title' => $val['title'],
                                        // 'data-penulis' => ucwords($val['userid_creator']) . ' | ' . Yii::$app->formatter->asDatetime(strtotime($val['created']), 'php:j F Y, H:i'),
                                        ]
                                ), $url
                        );
                        echo '</li>';
                    endforeach;
                endif;
                ?>
            </ul>
            <ul id="headline-pager">
                <?php
                $i = 0;
                if (!empty($sliderheadline["docs"])):
                    foreach ($sliderheadline["docs"] as $id => $val):
                        if ($val["scheduled_date"] != '0000-00-00 00:00:00')
                            $date = $val["scheduled_date"];
                        else
                            $date = $val["created"];
                        $year = date('Y', strtotime($date));
                        $month = date('m', strtotime($date));
                        $day = date('d', strtotime($date));
                        $id = $val['id'];
                        $kategori = isset($val['kategori']) ? $val['kategori'] : isset($val['cat_name']) ? $val['cat_slug'] : "";
                        $slug = isset($val['slug']) ? $val['slug'] : "";
                        $url = ['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id];
                        echo '<li data-detailUrl="'.yii\helpers\Url::toRoute($url).'">';

                        // menampilkan video button
                        // jika kategori id 22 atau video
                        $videobtn = '';
                        if (isset($val['category_id']) && $val['category_id'] == 22)
                            $videobtn = '<span class="bgg iconplay"></span>';

                        echo Html::a(
                                $videobtn .
                                Html::img(
                                        Yii::$app->rajamobil->lihatImageDetail($val['img_1'], $size = 134, $kategori = 'artikel'), [
                                    'alt' => $val['title'],
                                    'width' => 134,
                                    'height' => 80,
                                        ]
                                ) . '<span>' . $val['title'] . '</span>', [''], ['data-slide-index' => $i]
                        );
                        echo '</li>';
                        $i++;
                    endforeach;
                endif;
                ?>
            </ul>
            <div class="cleaner"></div>
        </div>
        <!--
        End
        Headline
        -->

        <!--
        Begin
        Berita lainnya
        -->
        <div id="fb-root"></div>
        <div class="slot-iklan slot-noborder">
            <div class="slot-470-60">
            </div>
        </div>

        <?php
        Pjax::begin([
            'id' => 'listberita',
        ])
        ?>
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "<ul id='wrapper-artikel' class='berita'>{items}</ul><div style='display: none'>{pager}</div>",
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'artikel-list'
            ],
            'itemView' => '_listArtikel',
            'emptyText' => 'Tidak artikel lagi'
        ])
        ?>
        <?php Pjax::end() ?>
        <?= Html::hiddenInput('txt-data', 0, $options = ['id' => 'txt-data']) ?>
        <!--
        End
        Berita lainnya
        -->

        <!--
        Begin
        slot iklan 470-60
        -->
        <!--        <div class="slot-iklan">
                    <div class="slot-470-60">
                    </div>
                </div>-->
        <!--
        End
        slot iklan 470-60
        -->  
        <div id="loading-bar"><?= Html::img($this->theme->getUrl('images/loadingbar/subscribe.gif'), ['alt' => 'Loading Artikel', 'width' => 16, 'height' => 11]) ?></div>
    </div>
    <!--
    end
    konten tengah
    -->

    <!--
                begin section
                konten kanan
    -->
    <div class="konten-kanan left">

        <!--
    begin section
    tersedia / jumlah mobil
        -->
        <?php # WTotIklan::widget();  ?>
        <!--
        end section
        tersedia / jumlah mobil
        -->


        <!--
            begin section
            showroom premium
        -->
        <?= WShowroom::widget(); ?>
        <!--
        end section
        showroom premium
        -->


        <!--
        begin section
        iklan 300 250
        -->
        <?= WShowcase1::widget(); ?>
        <!--
        end section
        iklan 300 250
        -->


        <!--
        begin section
        iklan terkini
        -->
        <?= WIklanTerkini::widget(); ?>
        <!--
        end section
        iklan terkini
        -->


        <!--
        begin section
        video
        -->
        <?= WShowcase2::widget(); ?>
        <!--
        end section
        video
        -->


        <!--
        begin section
        promo mobil
        -->
        <?php # WPromoMobil::widget(); ?>
        <!--
        end section
        promo mobil
        -->


        <!--
        begin section
        iklan 300 250
        -->
        <?= WShowcase3::widget(); ?>
        <!--
        end section
        iklan 300 250
        -->


    </div>
    <!--
    end section
    konten kanan
    -->
    <div class='go-top hide'><span>TOP</span></div>
    <div class="cleaner"></div>
</div>
