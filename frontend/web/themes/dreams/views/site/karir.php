<?php

use yii\helpers\Html;
use frontend\assets\KarirAsset;

KarirAsset::register($this);
?>
<?php
$this->params['breadcrumbs'][] = 'Karir RajaMobil.com';
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
<div class="content karir">
    <div style="margin-bottom: 10px; position:relative;">
        <h1 title="Karir RajaMobil.com" class="h1">Karir RajaMobil.com</h1>
        <br />
        <div style="position: absolute;top: 30px;right: 0px;">
            <?= HTml::img($this->theme->getUrl('images/komponen/' . 'karir_gambar_cewe.png'), ['alt' => 'karir rajamobil']) ?>
        </div>

        <div class="font-oswald-light" style="font-size:14px;color: #404041;">

            <p style="margin-bottom:15px;">Rajamobil.com adalah sebuah portal jual beli yang menyajikan kemudahan dalam proses jual mobil baru dan bekas yang dipaparkan secara eksklusif,<br /> dengan tampilan gambar yang baik serta informasi yang lengkap. Portal ini juga memiliki banyak fitur yang tentu saja berkaitan dengan<br />
                bisnis otomotif. Seperti artikel berita, rubrik test drive, kalkulator perhitungan simulasi kredit dan asuransi serta fasilitas lainnya.<br />
                Berita yang disajikan meliputi mobil terbaru, modifikasi mobil, bisnis dan industri otomotif, olahraga otomotif, komponen kendaraan,<br />
                aktifitas komunitas hingga gaya hidup otomotif.</p>

            <div style="font-size:20px;"> Ingin Bergabung dengan Rajamobil.com?</div>
            <div style="font-size:16px; margin-bottom:15px;">Saat ini kami membutuhkan tambahan orang untuk mengisi posisi :</div>

            <div style="margin-bottom:10px;">
                <p style="color:tomato; margin-bottom:5px; font-weight:bold">Senior Web Developer (Programmer)</p>
                <ul class="descloker" style="margin-left:15px;">
                    <li>Work closely with the Product Team on adding new Features to the site</li>
                    <li>Provide solutions for quick turn around on adding features to the site</li>
                    <li>Design scalable / robust application and database</li>
                    <li>Provide training and support to end users (Content Team)</li>
                    <li>Writing Unit Tests / Documentation of the Application and Features</li>
                    <li>Fixing Bugs and resolving issues on Production Environment</li>
                    <li>Design, develop, maintain and enhance web-based system including content, design and coding.</li>
                    <li>Advise on technologies, tools, techniques and standards that will improve competitiveness and efficiency.</li>
                </ul>
            </div>
            
            <div style="margin-bottom:35px">
                Requirements :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Candidate must possess at least a Diploma, Bachelors Degree, Masters Degree / Post Graduate Degree, Computer Science/Information Technology, Engineering (Computer/Telecommunication) or equivalent.</li>
                    <li>At least 2 year(s) of working experience in the related field is required for this position.</li>
                    <li>Preferably Supervisor / Coordinators specializing in IT/Computer - Software or equivalent.</li>
                    <li>2+ years experience building high-scale consumer-facing web applications on LAMP technologies, especially PHP and CI/Yii Framework.</li>
                    <li>Good Knowledge of MySQL.</li>
                    <li>Comfortable with Linux as a development and deployment environment.</li>
                    <li>Javascript, CSS &amp; HTML5 proficiency.</li>
                    <li>Understanding of XML/JSON based RESTful/SOAP APIs.</li>
                    <li>Understanding of cross-site scripting (XSS) and other client-side vulnerabilities</li>
                    <li>Good understanding of CDN and setting up Cloud based applications</li>
                    <li>Ability to learn quickly</li><li>Optimizing the web application</li>
                    <li>Highly motivated team player and always eager to learn new technologies.</li>
                    <li>Possess analytical, troubleshooting and problem solving skills.</li>
                    <li>2 Full-Time position(s) available.</li>
                </ul>
            </div>

            <div style="margin-bottom:10px;">
                <p style="color:tomato; margin-bottom:5px; font-weight:bold">Account Executive (AE)
                </p>
                Responsibilities :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Make sales calls, prepare proposal, deliver presentation, negotiation, and create and maintain excellent relationship with customer</li>
                </ul>
            </div>
            <div style="margin-bottom:35px">
                Requirements :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Candidate must possess at least Diploma, Bachelors Degree any major</li>
                    <li>Maximum 30 years of age</li>
                    <li>Has excellent team work</li>
                    <li>Smart worker, hard worker and creative thinker</li>
                    <li>Attractive and good looking</li>
                    <li>Able to fulfill sales target</li>
                    <li>Has a wide networking</li>
                    <li>Familiar with Digital Advertising and Technology</li>
                </ul>
            </div>

            <div style="margin-bottom:10px;">
                <p style="color:tomato; margin-bottom:5px; font-weight:bold">Reporter</p>
                Responsibilities :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Reportage, interview and pour it on good writing</li>
                    <li>Proficient in writing articles</li>
                    <li>Doing research and make writing as assigned</li>
                </ul>
            </div>
            <div style="margin-bottom:35px">
                Requirements :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>At least 1 year(s) of working experience in the related field is required for this position.</li>
                    <li>Preferably Staff (non-management &amp; non-supervisor)s specializing in Journalist/Editor or equivalent.</li>
                    <li>Full-Time position(s) available.</li><li>Candidate must posses at least a Bachelors Degree in any field.</li>
                    <li>Energetic, creative, like challenges and good looking.</li>
                    <li>Have great interest in journalism.</li>
                </ul>

            </div>
            <div style="margin-bottom:10px;">
                <p style="color:tomato; margin-bottom:5px; font-weight:bold">Sales Support (Listing Force)</p>
                Deskripsi Pekerjaan :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Bertugas untuk mendata, mencari data showroom/data direktori (Spare Part, Aksesoris, dll) guna beriklan di rajamobil.com serta menjalin hubungan dengan para showroom dan bengkel</li>
                </ul>
            </div>
            <div style="margin-bottom:25px">
                Kriteria :<br />
                <ul class="descloker" style="margin-left:15px;">
                    <li>Memiliki relasi dengan showroom/bengkel</li>
                    <li>Memiliki wawasan tentang otomotif</li>
                    <li>Menyukai pekerjaan lapangan</li>
                    <li>Memiliki sim C</li>
                    <li>Minimal pendidikan SMU/sederajat</li>
                    <li>Max 30 tahun</li>
                    <li>Area tugas dan domisili di Tangerang, Bekasi, Jakarta</li>
                </ul>
            </div>

            <div class="section-kontributor">
                <div style="margin-bottom:10px;">
                    <p style="color:tomato; margin-bottom:5px; font-weight:bold">Kontributor Bandung, Surabaya, Medan, Yogyakarta</p>
                    Deskripsi Pekerjaan :<br />
                    <ul class="descloker" style="margin-left:15px;">
                        <li>Reportase dan interview narasumber terkait industri dan komunitas di kota tempat bertugas</li>
                        <li>Menulis dalam bentuk straight news and features</li>
                        <li>Melengkapi tulisan dengan foto dan bila diperlukan dalam format video</li>
                    </ul>
                </div>
                <div style="margin-bottom:25px">
                    Kriteria :<br />
                    <ul class="descloker" style="margin-left:15px;">
                        <li>Berpengalaman di media online minimal 2 tahun</li>
                        <li>Memiliki SIM A</li>
                        <li>Memiliki kendaraan sendiri</li>
                        <li>Usia Maksimum 27 tahun</li>
                        <li>Memiliki minat di bidang fotografi dan video journalism</li>
                        <li>Memiliki jaringan luas di kalangan industri  mobil dan komunitas mobil</li>
                        <li>Bersedia kerja dengan target tertentu</li>
                    </ul>
                </div>
            </div>

        </div>

        <div style="margin-top:40px;" align="center">
            <div style="background:url(<?= $this->theme->getUrl('images/komponen/' . 'karir_papertext.png') ?>); width:233px; height:166px;">
                <div style="padding: 40px 10px 10px 10px; font-size:13px; color:black">
                    <strong>
                        Please send applications to:<br />
                        Rajamobil HR Department<br />
                        Jl. Raya Boulevard Gading Serpong Kav. M5/10 (Plaza Toyota Gading Seprong Ext)<br />
                        Email : recruitment@rajamobil.com<br />
                    </strong>
                </div>
            </div>
        </div>
    </div>            
</div>
<!--</div>-->
<div class="cleaner"></div>
