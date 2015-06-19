<?php
$systemVariables = require(dirname(__FILE__).'/../../common/config/systemVariables.php');

error_reporting(E_ERROR);
ini_set('log_errors', 1);
//ini_set('error_log', '../runtime/php.log');

ini_set('display_errors', 1);
set_time_limit(180);

ini_set('memory_limit', '512M');

function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}

$homePath      = dirname(__FILE__) . '/..';
$protectedPath = _joinpath($homePath, '../console');
$webrootPath   = _joinpath($homePath, 'www');
$runtimePath   = _joinpath($homePath, 'runtime');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$root = dirname(__FILE__).'/../../';
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('frontend', $root . 'frontend');
Yii::setPathOfAlias('common', $root . 'common');
Yii::setPathOfAlias('user', $root . 'frontend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'user');

return array(
    'basePath'    => $protectedPath,
    'runtimePath' => $runtimePath,
    'name' => $systemVariables['name'].' Console Application',
    'preload' => array(
        'log'
    ),
    'import' => array(
        'application.models.*',
        'application.filters.*',
        'application.components.*',
        'common.models.*',
        'common.filters.*',
        'common.components.*',
        'common.extensions.giix-components.*', // giix components
        'common.extensions.file.CFile',
        'common.extensions.CAdvancedArFindBehavior',

        'frontend.extensions.user.UserModule',
        'frontend.extensions.user.models.*',
        'frontend.extensions.user.components.*',
        'frontend.extensions.rights.*',
        'frontend.extensions.rights.components.*',

    ),
    'modules' => array(
        'user'=>array(
            'hash'                  => 'md5',
            'sendActivationMail'    => true,
            'loginNotActiv'         => false,
            'activeAfterRegister'   => false,
            'autoLogin'             => true,
            'registrationUrl'       => array('/user/registration'),
            'recoveryUrl'           => array('/user/recovery'),
            'loginUrl'              => array('/user/login'),
            'returnUrl'             => array('/user/profile'),
            'returnLogoutUrl'       => array('/user/login'),

            'tableUsers'            => 'sys_users',
            'tableProfiles'         => 'sys_profiles',
            'tableProfileFields'    => 'sys_profiles_fields',
        ),
    ),
    'commandMap' => array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
        ),
    ),
    'components' => array(
        'db' => require(dirname(__FILE__) . '/../../common/config/db.php'),
        'file' =>array(
            'class' => 'common.extensions.file.CFile',
        ),
        'curl' => array(
            'class' => 'common.extensions.curl.Curl',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'                => 'common.extensions.ECDbLogRoute',
/*                  'class' => 'CDbLogRoute', */
                    'logTableName'=>'sys_log',
                    'connectionID' => 'db',
                    'autoCreateLogTable'=>true,
                    'levels' => 'error, warning',
                    'filter'=>'CLogFilter',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
    ),
    'params' =>require(dirname(__FILE__).'/params.php'),
);