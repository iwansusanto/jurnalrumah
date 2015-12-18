<?php

use yii\helpers\Html;
use backend\assets\CategoryAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\Category */

CategoryAsset::register($this);
$this->title = 'Update Kategori: ' . ' ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parent_category'  =>  $parent_category,
        'sub_categorys'    =>  $sub_categorys
    ]) ?>

</div>
