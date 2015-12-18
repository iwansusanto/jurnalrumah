<?php

//use backend\assets\AdminlteAsset;
use yii\helpers\Html;
use backend\assets\ErrorAsset;

/* @var $this \yii\web\View */
/* @var $content string */


ErrorAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower') . '/admin-lte/dist';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?php echo \Yii::$app->request->baseUrl ?>/img/icon/favicon.ico">
    
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
  <body class="skin-blue">
    <?php $this->beginBody() ?>
      <div class="wrapper">
          <?= $this->render(
                'header.php',
                ['directoryAsset' => $directoryAsset]
            ) ?>
          
          <div class="wrapper row-offcanvas row-offcanvas-left">
              <?= 
            $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>
          </div>
          
          
      </div>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>