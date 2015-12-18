<?php

use yii\helpers\Html;
use app\components\ParentController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($model["scheduled_date"]) && $model["scheduled_date"] != '0000-00-00 00:00:00')
    $date = $model["scheduled_date"];
else
    $date = $model["created"];

$time = ParentController::esitime(strtotime($date));
$_title_sub = $model['aub_judul'];
//if ($model['aub_judul'] == '')
//    $_title_sub = isset($model['kategori']) ? $model['kategori'] : isset($model['cat_name']) ? $model['cat_name'] : "";

//<!-- begin link, dan foto -->
echo Html::a(Html::tag('div', Html::img(
                        Yii::$app->rajamobil->lihatImageDetail($model['img_1'], $size = 90, $kategori = 'artikel'), [
                    'alt' => $model['title'],
                    'width' => 90,
                    'height' => 75,
                        ]
                ), ['class' => 'foto left']), \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']]), ['data-pjax'=>0]);
//<!-- end link, dan foto -->
?>



<!-- begin deskripsi berita -->
<div class="deskripsi left">
    <!-- begin subjudul -->
    <span class="subjudul"><?= $_title_sub; ?></span>
    <!-- end subjudul -->     

    <!-- begin link h2 -->
    <?=
    Html::a(Html::tag('h2', $model['title'], [
                'title' => $model['title']
            ]), \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']]), ['data-pjax'=>0]);
    ?>
    <!-- end link h2 -->

    <!-- begin deskripsi / artikel summary -->
    <?=
    Html::tag('span', $model['summary'], [
        'class' => 'summary'
    ]);
    ?>
    <!-- end deskripsi / artikel summary -->

    <!-- begin posting time -->
    <div class="time">
        <!-- begin time -->
        <div class="label left"><?= $time ?></div>
        <!-- end time -->

        <!-- begin sharer tools -->
        <div class="sharer left">
            <div class="share-btn-wrap">
                <span class="facebook" data-href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']])  ?>" data-title="<?= $model['title'] ?>"></span>
                <span class="count_fb"></span>
                <span class="twitter" data-href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail',
                                                                                    'kategori' => $model['cat_slug'],
                                                                                    'y' => date('Y', strtotime($model['created'])),
                                                                                    'm' => date('m', strtotime($model['created'])),
                                                                                    'd' => date('d', strtotime($model['created'])),
                                                                                    'slug' => $model['slug'],
                                                                                    'id' => $model['id']])  ?>" data-title="<?= $model['title'] ?>"></span>
                <span class="count_twitter"></span>
            </div>
        </div>
        <!-- end sharer tools -->
        
        <?= Html::tag('div', $content = '', ['class' => 'cleaner']); ?>
    </div>
    <!-- begin posting time -->
</div>
<!-- end deskripsi berita -->

<?= Html::tag('div', $content = '', ['class' => 'cleaner']); ?>