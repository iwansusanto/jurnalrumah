<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\ArtikelAsset;
use backend\models\Artikel;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArtikelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

ArtikelAsset::register($this);

$this->title = 'Artikels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Artikel', ['create'], ['class' => 'btn btn-success']) ?>
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
                    return "#" . $model->id;
                },
            ],
            'judul',
//            'summary',
            'summary:ntext',
//            'author',
            // 'author_name',
            // 'categori_id',
            // 'categori_name',
            // 'sumber',
             'schedule_date',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Artikel::getStatus($model->status);
                },
            ],
            // 'viewed',
            // 'image1:ntext',
            // 'image2:ntext',
            // 'image3:ntext',
            // 'image4:ntext',
            // 'image5:ntext',
            // 'image6:ntext',
            // 'image7:ntext',
            // 'image8:ntext',
            // 'image9:ntext',
            // 'video:ntext',
            // 'user_create',
            // 'user_update',
            // 'date_create',
            // 'date_update',
            // 'user_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
