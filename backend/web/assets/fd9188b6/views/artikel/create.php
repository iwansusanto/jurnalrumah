<?php

use yii\helpers\Html;
use backend\assets\ArtikelAsset;


/* @var $this yii\web\View */
/* @var $model backend\models\Artikel */

ArtikelAsset::register($this);

$this->title = 'Create Artikel';
$this->params['breadcrumbs'][] = ['label' => 'Artikels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
