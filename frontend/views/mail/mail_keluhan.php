<?php 

use yii\helpers\Html;
?>

<p>Hi <strong><?php echo 'Admin'; ?></strong>, </p>
<p>
    Dengan ini saya kirimkan Keluhan dan Saran <br>
    
    ID              : <?= $model->id_client; ?><br>
    Nama User       : <?= $model->name; ?><br>
    Email           : <?= $model->email; ?><br>
    Telpon          : <?= $model->phone; ?><br>
    Tipe Keluhan    : <br>
    <ol>
        <?php 
        foreach (explode(',', $model->tipe_keluhan) as $key => $value) {
            echo "<li>'app\models\Kontak::getKeluhanLabel($value)'</li>";
        }
        ?>
    </ol>
    <?php
        if($value==8) {
            echo '<p>'.$model->message.'</p>';
        }
    ?>
    <br><br>
    Demikianlah data yang dikirimkan,<br>
    Atas perhatian dan kerjasamanya saya ucapkan terima kasih.<br>
</p>
<p>
    Salam,<br>
    <br>
    <br>
    <?= Html::a('RajaMobil.com', 'http://www.rajamobil.com', [])?>
</p>