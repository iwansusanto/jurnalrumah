<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Merek */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mereks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merek-view">

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
            'status',
            'image',
            'date_created',
            'date_update',
            'user_created',
            'user_update',
            'user_by',
        ],
    ]) ?>

</div>
