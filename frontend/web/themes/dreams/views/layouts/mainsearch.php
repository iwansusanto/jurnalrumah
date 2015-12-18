<?php

//use yii\web\View;
use yii\helpers\Html;

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
//use frontend\assets\PasangiklanAsset;
//use frontend\widgets\Alert;
//use yii\widgets\Menu;
//use yii\helpers\Url;
//use app\components\PencarianMobil;
//use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title); ?></title>
        <link rel="shortcut icon" href="<?php echo $this->theme->getUrl('images/komponen/favicon.ico'); ?>" type="image/x-icon" />
        <?php $this->head() ?>
        
        <?php \yii\web\View::registerJs('var base_url = ' . json_encode(yii\helpers\Url::base(true)) . '', yii\web\View::POS_HEAD); ?>

        <!-- Facebook Pixel Code -->
        
        <!-- End Facebook Pixel Code -->

        
        
        <!-- Google Analytics -->
        
    </head>
    <body>
        <?php
        $this->beginBody();
        ?>
        <div id="page">
            <!--header-->
            <header>
                <?php echo $this->render('header'); ?>             
            </header>
            <!--header-->

            <!--content-->
            <div class="wrap">
                <div class="container" id="content">
                    <div class="content-search left">
                        <?php echo $content ?>
                    </div>
                    <div class="content-right left">
                        <?php echo $this->render('right'); ?>   
                    </div>
                </div>
            </div>
            <!--end content-->

            <!--begin footer-->
            <footer>
                <?php echo $this->render('footer');?>
            </footer>
            <!--end footer-->
        </div>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
