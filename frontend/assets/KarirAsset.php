<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use frontend\assets\KarirAsset;

class KarirAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/rmperjuangan/css/dr-karir.css'
    ];
    public $js = [
        'themes/rmperjuangan/bxslider-4-master/dist/jquery.bxslider.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
      'frontend\assets\PosHeadAsset'
    ];

}
