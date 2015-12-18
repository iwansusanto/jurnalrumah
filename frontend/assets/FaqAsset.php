<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use frontend\assets\FaqAsset;

class FaqAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/rmperjuangan/css/dr-faq.css'
    ];
    public $js = [
        'themes/rmperjuangan/js/faq/jquery.js',
        'themes/rmperjuangan/js/faq/smk-accordion.js',
        'themes/rmperjuangan/js/faq/easyResponsiveTabs.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
      'frontend\assets\PosHeadAsset'
    ];

}
