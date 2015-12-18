<?php
define('START', microtime(TRUE));  

switch ($_SERVER['HTTP_HOST']):
    case 'www.rajamobil.com':
        defined('YII_DEBUG') or define('YII_DEBUG', FALSE);
        break;
    default :
        defined('YII_DEBUG') or define('YII_DEBUG', TRUE);
        break;
endswitch;

defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();
