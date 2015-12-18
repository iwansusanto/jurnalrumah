<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'rajamobil.com',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@frontend/views/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.gmail.com',
                'username' => 'iwansusanto87@gmail.com',
                'password' => 'password',
                'port' => '465',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/site/login'],  
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'enableStrictParsing' => true,
            'rules' => [
                [
                    'pattern' => '<kategori>/<y>/<m>/<d>/<slug>-<id:\d+>',
                    'route' => 'berita/detail',
                    'suffix' => '.htm',
                ],
                [
                    'pattern' => 'hubungikami',
                    'route' => 'site/hubungikami',
                    'suffix' => '.htm',
                ],
                [
                    'pattern' => '<tag>/<tagberita>',
                    'route' => 'berita/tag',
                    'suffix' => '.htm',
                ],
                [
                    'pattern' => '<kat>',
                    'route' => 'berita/kategori',
                    'suffix' => '.htm',
                ],
                
                
//                [
//                    'pattern' => '<cariberita>/<q:w>',
//                    'route' => 'berita/cariberita/param/<q>',
////                    'suffix' => '.htm',
//                ],
//                'cariberita/<q:w>'  =>  'berita/cariberita/<q>'
//                'cariberita/<q:\w+>' => 'berita/cariberita',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/themes/dreams/views'],
                'baseUrl' => '@web/themes/dreams',
            ],
        ],
        'jurnalrumah' => [
            'class' => 'app\components\Jurnalrumah'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YpW12N5dbN2N88_U__oYDta8EIdpXo4L',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                   'css' => [],
                ]
            ]    
        ],
        'cache_file' => [
            'class' => 'yii\caching\FileCache',
//            'serializer'    =>  false,
        ],
    ],
    'params' => $params,
    'timeZone' => 'Asia/Jakarta',
    'language' => 'id',
];
