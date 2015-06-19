<?php
$systemVariables = require(dirname(__FILE__).'/../../common/config/systemVariables.php');
$debug = $systemVariables['system']['env']['debug'];
// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// change the following paths if necessary
ini_set('display_errors', 1);
define('__DIR__', dirname(__FILE__));

defined('YII_DEBUG_PARAM_LOGGING') or define('YII_DEBUG_PARAM_LOGGING',$debug); //enable param logging
defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING',$debug);         //enable profiling
defined('YII_DEBUG') or define('YII_DEBUG', $debug);                            // remove the following lines when in production mode
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);                     // specify how many levels of call stack should be shown in each log message
defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME',false);    //execution time

ini_set('xdebug.var_display_max_depth', '10');

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/../config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
$loader = require(__DIR__ . '/../../vendor/autoload.php');
Yii::$classMap = $loader->getClassMap();

Yii::createWebApplication($config)->run();
Yii::log(CVarDumper::dumpAsString($loader->getClassMap(), 10, true), 'varDumper', 'classmap');

if(YII_DEBUG_DISPLAY_TIME)
echo Yii::getLogger()->getExecutionTime();
