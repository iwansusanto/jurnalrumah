<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\assets;

use yii\web\AssetBundle;

class HomeAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/dreams';
    public $css = [
        'css/home.css'
    ];
    public $js = [
        // 'http://jwpsrv.com/library/XPl24EjEEeSFcSIACy4B0g.js',
        'bxslider-4-master/dist/jquery.bxslider.js',
        // 'js/jquery.li-scroller.1.0.js',
        'js/home.js',
    ];
    public $depends = [
         'yii\web\YiiAsset',
         'frontend\assets\AppAsset',
    ];
}
