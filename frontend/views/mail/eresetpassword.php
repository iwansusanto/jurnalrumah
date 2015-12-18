<?php 

use yii\helpers\Html;
//use frontend\assets\MemberAsset;
//
//MemberAsset::register($this);
?>
<?php //$model = app\models\Client::findByUsername('iwan.susanto@rajamobil.com') ?>
<p>Hi <?= $model->fullname; ?>,</p>
<p>
    Proses <strong>reset passwrod</strong> untuk  akun Anda (<?= Html::a($model->email, 'javascript:void(0)', [
            'style' =>  'text-decoration: underline; color: #3f75bb;'
    ])?>) telah berhasil dilakukan.
</p>
<p>
    Jika Anda tidak melakukan permintaan ini atau terdapat user yang tidak diinginkan mengakses akun Anda, 
    segera lakukan 
    <?=
    Html::a('Reset Password', \Yii::$app->urlManager->createAbsoluteUrl(['auth/resetpassword','verification'  => \Yii::$app->rajamobil->encryptIt($model->email)]), [
            'style' =>  'color: #585858; font-style: italic; text-decoration: underline;'
    ])    
    ?>.
</p>
<p>
    Jika Anda membutuhkan bantuan customer Care kami, silahkan email ke 
    <?=
    Html::a('support@rajamobil.com', 'mailto:support@rajamobil.com', [
            'style' =>  'color: #585858; text-decoration: underline;'
    ])    
    ?>
    atau telp.
    <?=
    Html::a('021 2900 9606', 'tel:02129009606', [
            'style' =>  'color: #585858; text-decoration: underline;'
    ])    
    ?>
    (jam kerja).
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
