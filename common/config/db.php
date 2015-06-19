<?php
/*
$systemVariables = require(dirname(__FILE__).'/../../common/config/systemVariables.php');

if($systemVariables['system']['env']['dev'] && file_exists(dirname(__FILE__).'/db-local.php')){
    $testDatabase = require('db-local.php');
	return $testDatabase;
}
*/

$production = array(
    'pdoClass' => 'NestedPDO',
    'tablePrefix'=>'',
	'connectionString' => 'mysql:host=localhost;dbname=pos',
	'username' => 'root',
	'password' => 'hell',
    'charset' => 'utf8',
    'enableProfiling'=>YII_DEBUG_PROFILING,
    'enableParamLogging'=>YII_DEBUG_PARAM_LOGGING,
);

/*
$production = array(
	'pdoClass' => 'NestedPDO',
    'connectionString' => 'sqlite:database/database.db',
	'charset' => 'utf8',
	'emulatePrepare' => true,
	'enableProfiling'=>YII_DEBUG_PROFILING,
	'enableParamLogging'=>YII_DEBUG_PARAM_LOGGING,
);
*/

return $production;

?>