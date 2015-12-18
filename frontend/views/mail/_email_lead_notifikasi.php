<p>Hai <?= $param['name']; ?>,</p>
<p>Terima kasih telah mengunjungi Rajamobil.com.</p>
<p>Penawaran untuk mobil baru dengan tipe <?= $param['car_request']; ?> telah kami terima. Anda membutuhan beberapa informasi di bawah ini:</p>
<?php
$permintaan = $param['permintaan'];
$list_permintaan = array(1 => 'Penawaran Khusus', 'Test Drive', 'Minta Brosur', 'Minta Harga');
if (is_int($permintaan)) {
    $list = $list_permintaan[$permintaan];
    echo '- ' . $list . "<br />";
} else {
    $list = explode(',', $permintaan);
    foreach ($list as $i) {
        echo '<b>- ' . $list_permintaan[$i] . "</b><br/>";
    }
}
?>
<br />
<p>
    Anda akan dihubungi oleh perwakilan Authorized Dealer terdekat dari lokasi Anda berada. Perwakilan Autorized Dealer ini akan memberikan informasi penawaran terbaik dengan proses cepat.
</p>
<p>
    Jika Anda ingin membandingkan diskon dan bonus pada dealer mobil baru lainnya, silakan klik link di bawah ini.
</p>

<p>
    <a href="www.rajamobil.com/jual/mobil/baru">mobil-baru</a>
</p>

<p>
    Jika Anda membutuhkan bantuan Customer Care kami, silakan email ke support@rajamobil.com atau telepon 021 2900 9609 (jam kerja).
</p>
<p>
    Terima kasih atas perhatian dan kerjasama Anda.
</p>

Salam,<br />
Customer Care<br />
<a href="rajamobil.com">RajaMobil.com</a><br />
