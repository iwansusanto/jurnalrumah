<?php

use yii\helpers\Html;
use backend\assets\ArtikelAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\Artikel */

ArtikelAsset::register($this);
$this->title = 'Update Artikel: ' . ' ' . $model->judul;
$this->params['breadcrumbs'][] = ['label' => 'Artikels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artikel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
