<?php 

use yii\helpers\Html;
//use frontend\assets\MemberAsset;
use app\models\Client;
use frontend\models\DealerDetail;
use frontend\models\DealerHeader;
//
//MemberAsset::register($this);
if(isset($id_client_dealer)):
    $id_client_dealer;
    $cliend_dealer = Client::findIdentity($id_client_dealer);
endif;


?>
<?php 
$nama_lf = '';
$nama_dealer = '';
$id_client = $id_client;

$model = Client::findIdentity($id_client);
if(!empty($model)){
    $nama_lf = $model['fullname'];
}
$sales_dealer = DealerDetail::find()
                ->select('id, id_dealer, id_client')
                ->where('id_client = '.$id_client)
                ->orderBy('create_time DESC')
                ->one();
if(!empty($sales_dealer)){
    $dealer = DealerHeader::getOne($sales_dealer['id_dealer']);
    $nama_dealer = $dealer['nama'];
}

?>

<p>Bapak/Ibu Pimpinan Authorized Dealer Yth,</p>

<p>
    Bersama ini kami mohon verifikasi <i>Sales Force</i> bernama <strong><?= !empty($nama_lf) ? $nama_lf : '-'; ?></strong> 
    yang mengaku bekerja di Authorized Dealer yang Bapak/Ibu pimpin, yaitu <strong><?= $nama_dealer; ?></strong>. 
</p>

<p>
    Agar <i>Sales Force</i> tersebut dapat menjaring calon <i>Customer</i> MOBIL BARU di <i>website</i> kami, 
    mohon Bapak/Ibu memverifikasi dengan <strong>Login</strong> ke akun Autorized Dealer Anda di RajaMobil.Com, dengan:
</p>

<?php if(isset($id_client_dealer)): ?>
<p>
    User name (email) :  <?= !empty($cliend_dealer) ? $cliend_dealer['email'] : ''; ?><br> 
    Password          :  <i>dealerrajamobil</i>
</p>
<?php endif; ?>

<p>
    di <?= Html::a('klik tautan ini ', \Yii::$app->urlManager->createAbsoluteUrl(['/sales']), [
            'style' =>  'color: #3f75bb; text-decoration: underline;',
            'target'    =>  '_blank']) ?>
</p>

<hr>

<p>
    Kami <?= Html::a('www.rajamobil.com', \Yii::$app->urlManager->createAbsoluteUrl(['site/index'])); ?> 
    adalah media 'Semua Soal Mobil dan Jual Beli Mobil' <i>online</i> yang dipersembahkan untuk masyarakat Indonesia.
</p>

<p>
    Kami memiliki satu fitur menarik bagi para calon pembeli <strong>Mobil Baru</strong> yang dapat melihat berbagai model 
    dan spesifikasi mobil baru yang ditawarkan di <strong>Authorized Dealer</strong> di seluruh Indonesia. 
    Lalu mereka dapat memilih layanan yang diinginkan, seperti:
</p>

<ol>
    <li>Penawaran Mobil Baru dari Authorized Dealer terdekat</li>
    <li><i>Test Drive</i></li>
    <li>Dikirimkan Brosur mobil baru yang diminati</li>
    <li>Penawaran Paket (Kepemilikan Mobil)</li>
</ol>

<p>
    Kami menawarkan kepada para <i>Sales Force</i> dari berbagai Authorized Dealer terpercaya di seluruh Indonesia 
    untuk merespon minat para calon pembeli mobil baru tersebut. 
    Setiap prospek atau calon <i>Customer</i> sudah kami verifikasi nomor kontaknya 
    sehingga terjamin keabsahannya dan dapat dihubungi langsung setiap saat.
</p>

<p>
    <i>*Kami tidak memungut biaya apapun dari para User</i> atau <i>calon Customer Mobil Baru tersebut</i>.
</p>

<p>
    Terima kasih dan Salam hangat,
</p>

<p>
    <strong>PT. Raja Mobil Media</strong><br>
    Gd. Extention Plaza Toyota Lt. 5, Jl. Raya Boulevard Gading Serpong Kav. M5/10, Tangerang<br>
    Ph. +62 21 2900 9609
</p>

<?php /*<?= Html::a(HTml::img($this->theme->getUrl('images/logo/logo-rajamobil-2015.png'), ['alt' => 'logo rajamobil 2015', 'width' => 212, 'height' => 44]), ['site/index']); */?>