<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\UserAsset;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $model backend\models\User */

UserAsset::register($this);
$this->title = ucwords($model->nama_depan);
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            [
                'label' =>  'Profile',
                'type'  =>  'row',
                'format' => ['image',['width'=>'150','height'=>'100','alt'  =>  $model->nama_depan]],
                'value' => !empty($model->pict) ? \Yii::$app->jurnalrumah->lihatImageDetail($model->pict, "", $kategori = "user") : NULL,
            ],
            'nama_depan',
            'nama_belakang',
            'email:email',
            'alamat',
            'telp',
            [
                'label' =>  'Jenis Kel',
                'value' =>  User::getJenisKel($model->jenis_kelamin)
            ],
            'deskripsi:ntext',
            [
                'label' =>  'Type',
                'value' =>  User::getType($model->type_user)
            ],
            [
                'label' =>  'Newsletter',
                'value' =>  $model->newsletter == 0 ?  'Ya' : 'Tidak'
            ],
            [
                'label' =>  'Status',
                'value' =>  User::getStatus($model->status)
            ],
            'last_login',
            'role',
            'date_create',
            'date_update',
        ],
    ]) ?>

</div>
