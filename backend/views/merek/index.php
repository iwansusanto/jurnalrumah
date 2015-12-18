<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MerekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mereks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merek-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Merek', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nama',
            'deskripsi:ntext',
            'status',
            'image',
            // 'date_created',
            // 'date_update',
            // 'user_created',
            // 'user_update',
            // 'user_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
