<?php 

use yii\helpers\Html;
//use frontend\assets\MemberAsset;
//
//MemberAsset::register($this);
?>
<?php //$model = app\models\Client::findByUsername('iwan.susanto@rajamobil.com') ?>
<p>Hi <?= $model->fullname; ?>,</p>
<p>
    Kami menerima permintaan untuk <strong>reset password</strong> akses dashborad 
    <?= Html::a('RajaMobil.com', 'http://www.rajamobil.com', [
            'style' =>  'text-decoration: underline; color: #3f75bb;'
    ])?> dari akun Anda (<?= Html::a($model->email, 'javascript:void(0)', [
            'style' =>  'text-decoration: underline; color: #3f75bb;'
    ])?>)
</p>
<p>
    Untuk menyelesaikan proses ini, silakan klik link dibawah ini.
</p>
<p>
    <?=
    Html::a('Reset Password', \Yii::$app->urlManager->createAbsoluteUrl(['auth/resetpassword','verification'  => \Yii::$app->rajamobil->encryptIt($model->email)]), [
            'style' =>  'color: #585858; font-style: italic; text-decoration: underline;'
    ])    
    ?>
</p>
<p>
    Link ini akan habis masa berlakunya setelah empat jam sejak email ini terkirim.
</p>
<p>
    Jika Anda tidak melakukan permintaan untuk me-reset password, 
    sepertinya terdapat user lain yang tidak sengaja memberikan email Anda. Anda bisa
    mengabaikan pesan ini.
</p>
<p>
    Terima kasih atas perhatian dan kerjasama Anda.
</p>

<p>
    Salam, <br>
    Customer Care <br>
    <?= Html::a('RajaMobil.com', 'http://www.rajamobil.com', [
            'style' =>  'text-decoration: underline; color: #3f75bb;'
    ])?>
</p>
