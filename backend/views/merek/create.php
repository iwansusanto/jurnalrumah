<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Merek */

$this->title = 'Create Merek';
$this->params['breadcrumbs'][] = ['label' => 'Mereks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merek-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
