<?php
/* @var $this yii\web\View */
//use yii\base\Widget;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AdminlteAsset;

$bundle = AdminlteAsset::register($this);
//echo $bundle->baseUrl;


$this->title = 'JurnalRumah.com';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Selamat Datang!</h1>
        <?php
//        echo Menu::widget([
//                'items' => [
//                    ['label' => 'Logout (' . Yii::$app->user->identity->email . ')',
//                     'url' => ['/site/logout'],
//                     'visible' => !Yii::$app->user->isGuest, 
//                     'linkOptions' => ['data-method' => 'post']],
//                ],
//            'labelTemplate' =>'{label} Label',
//            'linkTemplate' => '<a href="{url}" data-method="post"><span>{label}</span></a>',
//
//            ]);
        ?>
    </div>
</div>
