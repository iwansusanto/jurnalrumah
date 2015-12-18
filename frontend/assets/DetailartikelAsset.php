<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use frontend\assets\AppAsset;

class DetailartikelAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/dreams';
//    public $sourcePath = '@frontend';
    
    public $css = [
        'css/detailberita.css',
    ];
    public $js = [
        'js/detailberita.js',
//        'http://w.sharethis.com/button/buttons.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}