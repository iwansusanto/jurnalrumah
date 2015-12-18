<?php

use frontend\assets\DetailartikelAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;

DetailartikelAsset::register($this);
?>

<div class="judul-detail-berita">
    <h1><?= $detail['judul'] ?></h1>
</div>
<div class="waktu-tayang-detail-berita">
    <h3><?= \Yii::$app->jurnalrumah->convertToTanggal($detail['date_create'], "") ?></h3>
</div>
<div class="image-detail-berita">
    <?=
    Html::img(\Yii::$app->jurnalrumah->lihatimagedetail($detail['image1'], "", "artikel"), [
        'alt' => $detail['judul'],
        'width' => 650,
        'height' => 400
    ])
    ?>
</div>
<div class="isi-detail-berita">
<?= $detail['deskripsi'] ?>
</div>
<div class="badge-berita-lainnya">
    Berita Lainnya
</div>
<div class="list-berita-lainnya">
    <?php
    Pjax::begin([
        'id' => 'beritalist',
    ])
    ?>

    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_artikelTerkait',
        'layout' => '<ul id="wrapper-artikel" class="wrapper-list-berita">{items}</ul><div style="display: none">{pager}</div>',
        'options' => [
        ],
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'list-berita-item'
        ],
        'emptyText' => 'Tidak ada data yang dapat di tampilkan'
    ])
    ?>

    <?php Pjax::end() ?>
<?= Html::hiddenInput('txt-data', 0, $options = ['id' => 'txt-data']) ?>
    <div id="loading-bar"><?= Html::img($this->theme->getUrl('images/loadingbar/subscribe.gif'), ['alt' => 'Loading Artikel', 'width' => 16, 'height' => 11]) ?></div>
</div>