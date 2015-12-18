<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\ArtikelAsset;
use backend\models\Artikel;

/* @var $this yii\web\View */
/* @var $model backend\models\Artikel */

ArtikelAsset::register($this);

$this->title = $model->judul;
$this->params['breadcrumbs'][] = ['label' => 'Artikels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikel-view">

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
            'judul',
            'summary',
            'deskripsi:ntext',
//            'author',
            'author_name',
//            'categori_id',
            'categori_name',
            'sumber',
            'schedule_date',
            [
                'label' =>  'Status',
                'value' =>  Artikel::getStatus($model->status)
            ],
//            'viewed',
            [
                'label' =>  'Image File',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image1) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image1, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 2',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image2) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image2, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 3',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image3) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image3, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 4',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image4) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image4, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 5',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image5) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image5, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 6',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image6) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image6, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 7',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image7) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image7, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 8',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image8) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image8, "", $kategori = "artikel") : NULL,
            ],
            [
                'label' =>  'Image File 9',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->judul]],
                'value' => !empty($model->image9) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->image9, "", $kategori = "artikel") : NULL,
            ],
            'video:ntext',
//            'user_create',
//            'user_update',
            'date_create',
            'date_update',
            'tag'
//            'user_by',
        ],
    ]) ?>

</div>
