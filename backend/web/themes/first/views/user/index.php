<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\UserAsset;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

UserAsset::register($this);
$this->title = 'User Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty'=>true,
        'layout'=>"{pager}\n{summary}\n{items}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'nama_depan',
//            'nama_belakang',
            'email:email',
//            'alamat',
            // 'telp',
            // 'jenis_kelamin',
            // 'password:ntext',
            // 'deskripsi:ntext',
            [
                'attribute' => 'type_user',
                'format' => 'raw',
                'value' => function ($model) {   
                        return User::getType($model->type_user);
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {   
                        return User::getStatus($model->status);
                },
            ],
            // 'newsletter',
            // 'activation_code',
            [
                'attribute' => 'last_login',
                'format' => 'raw',
                'value' => function ($model) {   
                        return \Yii::$app->jurnalrumah->convertToTanggal($model->last_login, '');
                },
            ],
//             'last_login',
            // 'salt',
            // 'role',
            // 'date_create',
            // 'date_update',
            // 'user_create',
            // 'user_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
