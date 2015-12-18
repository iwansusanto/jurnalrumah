<?php

use yii\helpers\Html;
use backend\assets\CategoryAsset;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

CategoryAsset::register($this);
$this->title = 'Create Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
