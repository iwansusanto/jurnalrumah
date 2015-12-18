<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\assets;

use yii\web\AssetBundle;
use frontend\assets\LoginAsset;

class ErrorAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/rmperjuangan/css/dr-error.css'
    ];
    public $js = [
        'themes/rmperjuangan/js/dr-error.js'
    ];
    
    public $depends = [
         'frontend\assets\AppAsset'
    ];
}
