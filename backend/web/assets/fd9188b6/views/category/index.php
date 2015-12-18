<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\CategoryAsset;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CategoryAsset::register($this);
$this->title = 'Kategori';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    return "#".$model->id;
                },
            ],
            'nama',
            'deskripsi:ntext',
            [
                'attribute' => 'parent_category',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->parent_category != 0 ? Category::getCateory($model->parent_category)->nama : '-';
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Category::getStatus($model->status);
                },
            ],
            // 'date_create',
            // 'date_update',
            // 'user_create',
            // 'user_update',
            // 'user_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
