<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
error_reporting(E_ALL);
ini_set('display_errors','On');

require('vendor/autoload.php');
require('vendor/grptx/yii2-firebase/src/yii2/Yii.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/backend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
  require(__DIR__ . '/common/config/main.php'),
  require(__DIR__ . '/common/config/main-local.php'),
  require(__DIR__ . '/backend/config/main.php'),
  require(__DIR__ . '/backend/config/main-local.php')
);
ini_set( 'max_input_vars' , 1000000 );
date_default_timezone_set("Asia/Ho_Chi_Minh");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");


$application = new yii\web\Application($config);
$application->run();
?>
