<?php
$config = [
    'components' => [
            'db' => [
                'class' => '\yii\db\Connection',
                'dsn' => 'mysql:host=127.0.0.1;dbname=jr_jurnalrumah',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => 'jr_',
                'charset' => 'utf8',
        ]
    ],
];



if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug']=[
//        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['127.0.0.1', '192.168.56.*'],
//    ];

    $config['bootstrap'][] = 'gii';
//    // $config['modules']['gii'] = 'yii\gii\Module';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.10.*'],
    ];
}

return $config;
