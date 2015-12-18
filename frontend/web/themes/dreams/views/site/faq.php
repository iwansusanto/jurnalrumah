<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use frontend\assets\FaqAsset;

FaqAsset::register($this);
?>
<?php
$this->params['breadcrumbs'][] = 'FAQ RajaMobil.com';
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
<script type="text/javascript">
    $(document).ready(function () {

        $(".accordion").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: false, //boolean
            slideSpeed: 300 //integer, miliseconds
        });
    });
</script>
<div class="content">
    <h1>FAQ (Frequently Asked Questions)</h1>
    Berikut ini adalah jawaban dari pertanyaan-pertanyaan yang sering diutarakan:

    <div class="sap_tabs">	
        <div id="horizontalTab">
            <ul class="resp-tabs-list">
                <li><span>Semua</span></li>
                <li><span>Pendaftaran</span></li>
                <li><span>Pembayaran</span></li>
                <div class="clear"></div>
            </ul>				  	 
            <div class="resp-tabs-container">
                <div class="tab-1">
                    <p><!--All-->
                    <div class="accordion"> 
                        <div class="accordion_in">
                            <div class="acc_head">
                                <span>Bagaimana cara Pasang Iklan Gratis (Mobil Bekas dan CBU) dengan cepat?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>
                                    <li>
                                        Anda dapat masuk ke menu "Pasang Iklan Gratis" pada bagian atas HomePage.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_1.png') ?>" onmousedown="return false;" title="Pasang Iklan Gratis" alt="Pasang Iklan Gratis"/>

                                    </li>	
                                    <li>
                                        Lalu isi info iklan mobil Anda pada form pendaftaran.<br>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_2.png') ?>" onmousedown="return false;" title="Form Pendaftaran" alt="Form Pendaftaran" /><br/>
                                        Jika Anda merupakan Sales Force - Authorized Dealer, mohon isi data dealer Anda dengan lengkap.

                                    </li>
                                    <li>
                                        Setelah klik "create", Anda akan menerima email untuk aktifasi akun Anda.
                                    </li>

                                    <li class="last">
                                        Setelah aktifasi akun, Anda sudah dapat mengakses dashboard RajaMobil.com melalui link “Login” pada bagian atas HomePage.
                                    </li>
                                </ol>
                            </div>
                        </div> 
                        <div class="accordion_in">
                            <div class="acc_head">
                                <span>Bagaimana cara mendaftar?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>
                                    <li>
                                        Anda dapat masuk ke link "Daftar" pada bagian atas HomePage.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_3.png') ?>" onmousedown="return false;" title="Daftar" alt="Daftar" />

                                    </li>	
                                    <li>
                                        Lalu isi info Anda pada form pendaftaran.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_4.png') ?>" onmousedown="return false;" title="Form Pendaftaran" alt="Form Pendaftaran" /><br/>
                                        Jika Anda merupakan Sales Force – Authorized Dealer, mohon isi data dealer Anda dengan lengkap.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_5.png') ?>" onmousedown="return false;" title="Isi Data" alt="Isi Data" />

                                    </li>
                                    <li>
                                        Setelah klik “create”, Anda akan menerima email untuk aktifasi akun Anda.
                                    </li>

                                    <li class="last">
                                        Setelah aktifasi akun, Anda sudah dapat mengakses dashboard RajaMobil.com melalui link “Login” pada bagian atas HomePage.<br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_3.png') ?>" title="Login" alt="Login" />
                                    </li>
                                    </ol>
                            </div>
                        </div>
                        <div class="accordion_in"><!--Section 2-->
                            <div class="acc_head">
                                <span>Bagaimana cara login atau masuk dashboard?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>

                                    <li>
                                        Anda dapat masuk ke link "Login" pada bagian atas HomePage.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_6.png') ?>" onmousedown="return false;" title="Login" alt="Login" />

                                    </li>	
                                    <li>
                                        Lalu isi akun Anda pada form login.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_7.png') ?>" onmousedown="return false;" title="Isi Data" alt="Isi Data" />

                                    </li>
                                    <li class="last">
                                        Setelah klik "Masuk", halaman dashboard RajaMobil.com akan terbuka.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_8.png') ?>" onmousedown="return false;" title="Masuk" alt="Masuk" />

                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 2-->
                        <div class="accordion_in"><!--Section 3-->
                            <div class="acc_head">
                                <span>Bagaimana cara membuka / melihat menu "Prospek Mobil Baru"?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>
                                    <p>Untuk membuka menu "Prospek Mobil Baru" hanya untuk akun Sales Force Authorized Dealer, Authorized Dealer, atau ATPM.</p>
                                    <li>
                                        Setelah login dashboard, Anda masuk ke menu "Prospek Mobil Baru".<br>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_9.png') ?>" onmousedown="return false;" title="Prospek Mobil Baru" alt="Prospek Mobil Baru" />
                                        </br>Hanya user yang telah di-approve oleh Kepala Cabang / Supervisor yang dapat melihat isi menu ini.
                                    </li>
                                    <li>
                                        Jika pelanggan belum mendaftarkan Authorized Dealer, silahkan isi info Authorized Dealer Anda pada form pendaftaran Authorized Dealer.</span>
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_10.png') ?>" onmousedown="return false;" title="form pendaftaran Authorized Dealer" alt="form pendaftaran Authorized Dealer" /><br/>
                                        Setelah isi form, kami akan mengirimkan akses ke Kepala Cabang /Sales Supervisor via email, sehingga Kepala Cabang / Sales Supervisor dapat konfirmasi bahwa user merupakan karyawan /sales force dealer tersebut.
                                        <br/>Mohon dipastikan Kepala Cabang / Sales Supervisor melakukan konfirmasi tersebut, agar user dapat membuka / melihat daftar prospek di menu “Prospek Mobil Baru”.

                                    </li>

                                    <li class="last">
                                        Jika user telah dikonfirmasi oleh Kepala Cabang / Sales Supervisor, maka user dapat membuka / melihat daftar prospek di menu "Prospek Mobil Baru".<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_11.png') ?>" onmousedown="return false;" title="Prospek Mobil Baru" alt="Prospek Mobil Baru" />
                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 3-->
                        <div class="accordion_in"><!--Section 4-->
                            <div class="acc_head">
                                <span>Bagaimana cara menerima atau menolak Sales Force di akun Authorized Dealer?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>
                                    <li>
                                        Setelah user mendaftarkan diri dan dealer terkait, maka Authorized Dealer dapat menerima atau menolak user tersebut.<br>
                                        Jika user mendaftarkan dealer baru, dimana akun Authorized Dealer belum ada, maka Kepala Cabang / Supervisor akan menerima email dengan informasi akses login akun Authorized Dealer.

                                    </li>	
                                    <li>
                                        Kepala Cabang / Supervisor dapat masuk ke link "Login" pada bagian atas HomePage.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_3.png') ?>" onmousedown="return false;" title="Form Login" alt="Form Login" />

                                    </li>
                                    <li>
                                        <a>
                                            <span>Lalu isi akun Kepala Cabang / Supervisor yang ada di email pada form login.<br/>
                                                <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_12.png') ?>" onmousedown="return false;" title="Isi Data" alt="Isi Data" />
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        Setelah login dashboard, Kepala Cabang / Supervisor masuk ke menu "Daftar Sales".<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_13.png') ?>" onmousedown="return false;" title="Daftar Sales" alt="Daftar Sales" />

                                    </li>
                                    <li class="last">
                                        Pada daftar sales, silahkan klik “Daftarkan” jika user tersebut merupakan karyawan / sales force dealer terkait. Atau klik "Tolak" jika user tersebut bukan karyawan / sales force dealer terkait.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_14.png') ?>" onmousedown="return false;" title="Daftar / Tolak Sales" alt="Daftar / Tolak Sales" />

                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 4-->
                        <div class="accordion_in"><!--Section 5-->
                            <div class="acc_head">
                                <span>Bagaimana cara mengambil prospek mobil baru?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>

                                    <li>
                                        Setelah login dashboard, Anda masuk ke menu "Prospek Mobil Baru".
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_15.png') ?>" onmousedown="return false;" title="Prospek Mobil" alt="Prospek Mobil" /><br/>
                                        Hanya user yang telah di-approve oleh Kepala Cabang / Supervisor yang dapat melihat isi menu ini.

                                    </li>	
                                    <li class="last">
                                        Pada halaman ini, klik "Ambil Prospek" pada prospek yang menurut Anda menarik.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_17.png') ?>" onmousedown="return false;" title="Ambil Prospek" alt="Ambil Prospek" />
                                        <br/>
                                        <ul>
                                            <li>a. Jika jumlah coin Anda mencukupi untuk mengambil prospek, akan terdapat pop-up seperti dibawah ini. Silahkan klik "Setuju".<br/>Gambar<br/>
                                                Anda dapat melihat prospek Anda pada menu "Prospek Saya".<br/>
                                                <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_18.png') ?>" onmousedown="return false;" title="Prospek Saya" alt="Prospek Saya" />
                                            </li>
                                            <li>b. Jika jumlah coin Anda tidak mencukupi untuk mengambil prospek, maka Anda akan diminta untuk deposit coin terlebih dahulu.</li>
                                        </ul>

                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 5-->
                        <div class="accordion_in"><!--Section 6-->
                            <div class="acc_head">
                                <span>Bagaimana cara deposit coin?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>

                                    <li>
                                        Anda dapat deposit coin pada tombol “Deposit Coin” bagian atas.
                                        <br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_19.png') ?>" onmousedown="return false;" title="Deposit Coin" alt="Deposit Coin" />
                                        <br/>Atau klik “Ambil Prospek” jika coin teidak mencukupi.

                                    </li>	
                                    <li>
                                        Silahkan pilih jumlah coin yang Anda butuhkan.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_20.png') ?>" onmousedown="return false;" title="Jumlah Coin" alt="Jumlah Coin" />

                                    </li>
                                    <li>
                                        Setelah klik "Bayar Sekarang", maka akan terdapat informasi nomor transaksi serta cara pembayaran.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_21.png') ?>" onmousedown="return false;" title="Bayar Sekarang" alt="Bayar Sekarang" />

                                    </li>
                                    <li>
                                        Lakukan konfirmasi pada menu “Histori Transaksi”.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_22.png') ?>" onmousedown="return false;" title="Histori Transaksi" alt="Histori Transaksi" />

                                    </li>
                                    <li class="last">
                                        Admin RajaMobil.com akan validasi pembayaran, dan akan memberikan jumlah coin yang dibutuhkan. Coin Anda akan bertambah sesuai jumlah deposit.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_23.png') ?>" onmousedown="return false;" title="Validasi" alt="Validasi" />

                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 6-->
                    </div>
                    </p><!--End All-->		              
                </div>	
                <div class="tab-2">
                    <p><!--Pendaftaran-->
                    <div class="accordion"> 

                        <div class="accordion_in">
                            <div class="acc_head">
                                <span>Bagaimana cara mendaftar?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>
                                    <li>
                                        Anda dapat masuk ke link "Daftar" pada bagian atas HomePage.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_3.png') ?>" onmousedown="return false;" title="Daftar" alt="Daftar" />

                                    </li>	
                                    <li>
                                        Lalu isi info Anda pada form pendaftaran.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_4.png') ?>" onmousedown="return false;" title="Isi Form Pendaftaran" alt="si Form Pendaftaran" /><br/>
                                        Jika Anda merupakan Sales Force – Authorized Dealer, mohon isi data dealer Anda dengan lengkap.<br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_5.png') ?>" onmousedown="return false;" title="Isi Data dengan Lengkap" alt="Isi Data dengan Lengkap" />

                                    </li>
                                    <li>
                                        Setelah klik “create”, Anda akan menerima email untuk aktifasi akun Anda.
                                    </li>

                                    <li class="last">
                                        Setelah aktifasi akun, Anda sudah dapat mengakses dashboard RajaMobil.com melalui link “Login” pada bagian atas HomePage.<br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_3.png') ?>" title="Pasang Iklan Gratis" alt="Pasang Iklan Gratis" />
                                    </li>
                                    </uo>
                            </div>
                        </div>

                    </div>
                    </p><!--End Pendaftaran-->              
                </div>				        					 
                <div class="tab-3">
                    <p><!--PEmbayaran-->
                    <div class="accordion">
                        <div class="accordion_in"><!--Section 6-->
                            <div class="acc_head">
                                <span>Bagaimana cara deposit coin?</span>
                                <div class="clear"></div>
                            </div>
                            <div class="acc_content">
                                <ol>

                                    <li>
                                        Anda dapat deposit coin pada tombol “Deposit Coin” bagian atas.
                                        <br/>
                                        <img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_19.png') ?>" onmousedown="return false;" title="Deposit Coin" alt="Deposit Coin" />
                                        <br/>Atau klik “Ambil Prospek” jika coin teidak mencukupi.

                                    </li>	
                                    <li>
                                        Silahkan pilih jumlah coin yang Anda butuhkan.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_20.png') ?>" onmousedown="return false;" title="Pilih Jumlah Coin" alt="Pilih Jumlah Coin" />

                                    </li>
                                    <li>
                                        Setelah klik "Bayar Sekarang", maka akan terdapat informasi nomor transaksi serta cara pembayaran.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_21.png') ?>" onmousedown="return false;" title="Bayar Sekarang" alt="Bayar Sekarang" />

                                    </li>
                                    <li>
                                        Lakukan konfirmasi pada menu “Histori Transaksi”.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_22.png') ?>" onmousedown="return false;" title="Konfirmasi" alt="Konfirmasi" />

                                    </li>
                                    <li class="last">
                                        Admin RajaMobil.com akan validasi pembayaran, dan akan memberikan jumlah coin yang dibutuhkan. Coin Anda akan bertambah sesuai jumlah deposit.
                                        <br/><img src="<?= $this->theme->getUrl('images/faq/' . 'gbr_23.png') ?>" onmousedown="return false;" title="Validasi" alt="Validasi" />

                                    </li>
                                </ol>
                            </div>
                        </div><!--End Section 6-->
                    </div>
                    </p><!--End Pembayaran-->          
                </div>	           	      
            </div>
            <div class="clear"></div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion           
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });
        </script>	
    </div>
</div>