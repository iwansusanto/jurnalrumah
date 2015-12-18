<?php 

use yii\helpers\Html;

?>

<p>Hi <strong><?php echo $model->email; ?></strong>, </p>
<p>
    Kami menerima permintaan untuk mengirimkan link verifikasi yang baru ke alamat email ini.<br />
    Silahkan klik 
    <?= Html::a('tautan berikut ', Yii::$app->urlManager->createAbsoluteUrl(['/auth/verification','id' => \Yii::$app->rajamobil->encryptIt($model->vernumber)]));
    ?>
    untuk melakukan verifikasi terhadap akun anda.<br />
</p>
<!--<p>-->
    <?php 
        //echo Html::a(Yii::$app->urlManager->createAbsoluteUrl(['/auth/verification','id'=>$model->vernumber]), Yii::$app->urlManager->createAbsoluteUrl(['/auth/verification','id'=>$model->vernumber])); 
    ?>
<!--</p>-->
