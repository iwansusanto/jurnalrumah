<?php

use yii\helpers\Html;
use frontend\assets\TentangKamiAsset;

TentangKamiAsset::register($this);
?>
<?php
$this->params['breadcrumbs'][] = 'Tentang Kami';
?>
<!--<div class="bgp">-->
    <div id="breadcrumb">
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
    </div>
    <div class="content tentangkami">
        <h1 title="Tentang RajaMobil.com" class="h1">Tentang RajaMobil.com</h1>
        <div class="keterangan">
            <div>
                <p>
                    <strong>Rajamobil.com</strong> adalah portal mobil. Portal ini memudahkan pengunjung dalam proses jual-beli mobil baru dan bekas yang tersaji eksklusif dengan gambar menarik dan informasi lengkap. 
                </p>
                <p>
                   <strong>Rajamobil.com</strong> juga memiliki banyak fitur menarik yang tentu saja berkaitan dengan bisnis mobil, seperti perhitungan simulasi kredit dan asuransi, serta fitur lainnya. Tentu saja semua yang tersaji di Rajamobil.com sangat berguna bagi pecinta mobil, konsumen, pebisnis dan industri otomotif di Indonesia maupun dunia. 
                </p>
                <p>
                    <strong>Rajamobil.com</strong> juga menyajikan berita meliputi mobil terbaru, modifikasi mobil, bisnis dan industri otomotif, olahraga otomotif, komponen kendaraan, serta aktivitas komunitas mobil. Semua tersaji tidak hanya dalam format teks dan foto, melainkan juga video. 
                </p>
                <p>
                    <strong>Rajamobil.com</strong> merupakan media <span style="font-style: italic">online</span> milik perusahaan PT Raja Mobil Media yang berdiri di Jakarta. Selain sajian online, PT Raja Mobil Media juga kerap menyelenggarakan kegiatan <span style="font-style: italic">offline</span> seperti pameran otomotif, serta berbagai aktivitas terkait industri mobil.
                </p>
            </div>
<!--            <ul class="fitur"> 
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/kendaraan/carimobil" title="Cari Mobil">
                        <div class="icon cariboil tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Portal pencarian mobil dan info-info terlengkap tentang mobil. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/berita-mobil.htm" title="Berita Mobil">
                        <div class="icon berita tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Menyajikan berita seputar dunia otomotif yang selalu up to date, informatif dan menarik. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/promo-mobil-baru.htm" title="Promo Mobil">
                        <div class="icon promo tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Dapatkan informasi promo mobil baru dari dealer-dealer mobil resmi. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="http://forum.rajamobil.com" title="Forum RajaMobil" target="_blank">
                        <div class="icon cariaksesoris tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Menyediakan tempat diskusi semua tentang mobil beserta para komunitas.</div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/harga-mobil-baru.htm" title="Daftar Harga">
                        <div class="icon daftarharga tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Menyediakan daftar harga mobil yang telah di update sesuai harga mobil terkini. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/spesifikasi-dan-komparasi.htm" title="Spesifikais dan Komparasi">
                        <div class="icon spesifikasi tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Memberikan info-info mobil berupa spesifikasi dan menyediakan komparasi. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/dealer.htm" title="Showroom Mobil">
                        <div class="icon showroom tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Menyediakan daftar showroom mobil yang tepat dan terpercaya. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->baseUrl; ?>/direktori.htm" title="Direktori Outlet">
                        <div class="icon direktori tkicon left"></div>
                        <div class="label left">
                            <div class="label-l2">Memberikan informasi tentang outlet-outlet otomotif. </div>
                        </div>
                        <div class="cleaner"></div>
                    </a>
                </li>
            </ul>-->
            <div class="cleaner"></div>
        </div>
    </div>
<!--</div>-->
<div class="cleaner"></div>
