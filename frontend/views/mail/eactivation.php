<?php 

use yii\helpers\Html;

?>

<p>Hi <strong><?php echo $client->fullname; ?></strong>, </p>
<p>
    Terimakasih Anda telah mendaftar di <?= Html::a('RajaMobil.com', 'http://www.rajamobil.com', [])?><br />
    Silahkan klik 
    <?= Html::a('tautan berikut ', Yii::$app->urlManager->createAbsoluteUrl(['/auth/verification','id' => \Yii::$app->rajamobil->encryptIt($client->vernumber)]));
    ?> 
    untuk mengaktifkan akun Anda.<br />
    Namun jika Anda merasa tidak mendaftar di <a href="http://www.rajamobil.com">RajaMobil.com</a>, abaikan email ini.<br />
</p>
<p>
    Salam,<br>
    <br>
    <br>
    <?= Html::a('RajaMobil.com', 'http://www.rajamobil.com', [])?>
</p>