<?php

use yii\helpers\Html;
use backend\assets\UserAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

UserAsset::register($this);
$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
