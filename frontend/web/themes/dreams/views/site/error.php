<?php
use frontend\assets\ErrorAsset;

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
ErrorAsset::register($this);

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Untuk bantuan silahkan hubungi team support JurnalRumah[dot]com di support@jurnalrumah.com.
    </p>

</div>
