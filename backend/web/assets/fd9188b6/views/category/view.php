<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\CategoryAsset;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

CategoryAsset::register($this);
$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'deskripsi:ntext',
//            'parent_category',
            [
                'label' =>  'Parent Category',
                'value' =>  $model->parent_category != 0 ? Category::getCateory($model->parent_category)->nama : 'Not Set'
            ],
            [
                'label' =>  'Status',
                'value' =>  Category::getStatus($model->status)
            ],
            'date_create',
            'date_update',
//            'user_create',
//            'user_update',
//            'user_by',
        ],
    ]) ?>

</div>
