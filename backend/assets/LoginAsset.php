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
class LoginAsset extends AssetBundle
{
    public $sourcePath = '@bower/';
    //public $sourcePath = '@web/adminlte';
    public $css = [
                   'admin-lte/dist/css/AdminLTE.css',
//                   'admin-lte/dist/css/skins/_all-skins.min.css',
                   'admin-lte/plugins/iCheck/square/blue.css'
                  ];
    public $js = ['admin-lte/dist/js/app.min.js',
                  'admin-lte/plugins/iCheck/icheck.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
