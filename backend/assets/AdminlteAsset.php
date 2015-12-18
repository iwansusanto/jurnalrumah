<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminlteAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte';
    
    public $css = [
                   'dist/css/AdminLTE.css',
                   'dist/css/skins/_all-skins.min.css',
                   'plugins/iCheck/square/blue.css'
                  ];
    public $js = ['dist/js/app.min.js'];
    
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
