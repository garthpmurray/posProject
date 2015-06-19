<?php
    
$systemVariables = array(
    'system'    => array(
        'env'   => array(
            'dev'   => true,
            'debug' => true,
        ),
        'serverName'    => isset($_SERVER['SERVER_NAME']) ? '//'.$_SERVER['SERVER_NAME'] : '//360parent',
        'devIps' => array('127.0.0.1', '::1', '172.16.0.156'),
    ),
    'name' => 'POS',
    'modules' => array(),
    'systemModules' => array('user','rights'),
    'ignoredModules' => array('gii'),
    'urlRules' => array(),
);

$systemVariables['system']['logo'] = $systemVariables['system']['serverName'].'/common/lib/assets/images/logo.png';
$systemVariables['system']['favicon'] = $systemVariables['system']['serverName'].'/favicon.ico';

$systemVariables['modules'] = array(
    'gii' => array(
        'class'                 => 'system.gii.GiiModule',
        'password'              => 'mEr{GiamIoNopfa3_$',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters'             => $systemVariables['system']['devIps'],
        'generatorPaths'        => array(
            'common.extensions.giix-core',
            'common.extensions.wsdl2php.gii',
            'common.extensions.gtc',
        ),
        'newFileMode'           => 0666,
        'newDirMode'            => 0777,
    ),
    'user'=>array(
        'navType'               => 'application.modules.user.views.layouts._nav',
        'layout'                => '//layouts/column1',
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
    'rights' => array(
        'navType'               => 'application.modules.rights.views.layouts._nav',
        'layout'                => '//layouts/main',
        'appLayout'             => '//layouts/column1',
        'install'               => false,
    ),
);

return $systemVariables;