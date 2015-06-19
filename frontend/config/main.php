<?php
$systemVariables = require(dirname(__FILE__).'/../../common/config/systemVariables.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}

$homePath      = dirname(__FILE__) . '/..';
$protectedPath = _joinpath($homePath, '../frontend');
$webrootPath   = _joinpath($homePath, 'www');
$runtimePath   = _joinpath($homePath, 'runtime');

$root = dirname(__FILE__).'/../../';

$ignoreModules = CMap::mergeArray($systemVariables['systemModules'], $systemVariables['ignoredModules']);
foreach($systemVariables['modules'] as $key => $module){
    if(in_array($key, $ignoreModules)) continue;
    Yii::setPathOfAlias($key, $root.'common/modules/'.$key);
}

Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . 'common');
Yii::setPathOfAlias('user', $root . 'frontend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'user');

return array(
    'theme'    => 'rapido',
//    'homeUrl'   => '/',
    'basePath'    => $protectedPath,
    'runtimePath' => $runtimePath,
    'name'        => $systemVariables['name'],
    'preload' => array(
        'log',
        'session',
/*
        'MobileDetect',
        'application.extensions.YiiMailer.YiiMailer',
*/
    ),
    'behaviors' => array(
        'onBeginRequest' => array(
            'class' => 'application.behaviors.RequireLogin'
        ),
    ),
    // autoloading model and component classes
    'import' =>array(
        'common.models.*',
        'common.filters.*',
        'common.components.*',
        'application.models.*',
        'application.filters.*',
        'application.components.*',
        'zii.widgets.*',
        'common.extensions.giix-components.*', // giix components
        'common.extensions.file.CFile',
        'common.extensions.CAdvancedArFindBehavior',
        'common.extensions.ModelScope',
        'application.extensions.ExtendedBreadcrumbs',
        'application.extensions.ExtendedSideMenu',
        'application.extensions.edatatables.*',

        'application.widgets.SarabonDataGrid.SarabonDataGrid',
        'application.widgets.SarabonDataGrid.SarabonCButtonColumn',

        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',


        'common.components.Color',

/*
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.widgets.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.components.DGSphinxSearch.DGSphinxSearch',
        'application.extensions.states.*',
        'application.extensions.PayPalExtension.*',
        'application.extensions.YiiMailer.YiiMailer',
        'application.extensions.curl.Curl',
        'application.extensions.CAdvancedArFindBehavior',
        'application.extensions.CHtmlExtension',
        'application.components.Customizer',
        'application.components.Widgets.Carousel.Carousel',
        'application.components.Widgets.AddressBook.AddressBook',
*/
    ),
    'modules' => $systemVariables['modules'],
    'defaultController' => 'Site',
    // application components
    'components' =>array(
        'db' => require(dirname(__FILE__) . '/../../common/config/db.php'),
        'JsonTable' => array(
            'class' => 'common.components.JsonTable',
        ),
        'cache' => array(
            'class'=>'common.extensions.ECDbCache',
//            'class'=>'system.caching.CDbCache',
            'cacheTableName' => 'sys_cache',
            'connectionID' => 'db',
        ),
/*
        'errorHandler' =>array(
            'errorAction' => 'site/error',
        ),
*/
        'simpleImage' => array(
            'class' => 'common.extensions.SimpleImage.CSimpleImage',
        ),
        'user'=>array(
            'class'             => 'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin'    => true,
            'loginUrl'          => array('/user/login'),
            'returnUrl'         => array('/user/profile'),
        ),
        'authManager'=>array(
            'class'             => 'RDbAuthManager',
            'connectionID'      => 'db',
            'defaultRoles'      => array('Authenticated', 'Guest'),
            'itemTable'         => 'rights_authitem',
            'itemChildTable'    => 'rights_authitemchild',
            'assignmentTable'   => 'rights_authassignment',
            'rightsTable'       => 'rights_rights',
        ),
        'session' => array(
            'class'             => 'application.extensions.ECDbHttpSession',
            'connectionID'      => 'db',
            'timeout'           => (3*60*60),
            'sessionTableName'  => 'sys_session',
            'cookieParams'      => array(
            ),
        ),
        'themeManager' => array(
            'class'     => 'common.extensions.ECThemeManager',
            'baseUrl'   => '/frontend/www/themes/',
        ),
        'assetManager' => array(
            'baseUrl'=>'/frontend/www/assets/',
        ),
        'request'=>array(
            'class'=>'application.extensions.EHttpRequest',
            'baseUrl'=>'',
        ),
        'urlManager' =>array(
            'showScriptName'  => false,     // enable mod_rewrite in .htaccess if this is set to false
            'appendParams'    => false,     // in general more error resistant
            'urlFormat'       => 'path',
            'rules'           => require(dirname(__FILE__) . '/urlRules.php'),
        ),
        'clientScript' => array(
            'class' => 'application.extensions.ECClientScript',
        ),
        'widgetFactory'=>array(
            'widgets'=>array(
                'EDataTables'=>array(
                    'htmlOptions' => array(
                        'class' => '',
                    ),
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed items',
                    'pagerCssClass' => 'paging_bootstrap pagination',
                    'buttons' => array(
                        'refresh' => array(
                            'tagName' => 'a',
                            'label' => '<i class="glyphicon glyphicon-refresh"></i>',
                            'htmlClass' => 'btn',
                            'htmlOptions' => array('rel' => 'tooltip', 'title' => Yii::t('EDataTables.edt',"Refresh")),
                            'init' => 'js:function(){}',
                            'callback' => 'js:function(e){e.data.that.eDataTables("refresh"); return false;}',
                        ),
                    ),
                    'datatableTemplate' => "<'tbl-tools-searchbox'f<'dataTables_toolbar'>l<'clear'>i p<'clear'>r>,<'table_content't>,<'widget-bottom'i p<'clear'>>",
/*                  'datatableTemplate' => '<"tbl-tools-searchbox"fl<"clear">i p<"clear">>,<"table_content"t>,<"widget-bottom"i p<"clear">>', */
/*                  'datatableTemplate' => "<><'row'<'span3'l><'dataTables_toolbar'><'pull-right'f>r>t<'row'<'span3'i><'pull-right'p>>", */
                    'registerJUI' => false,
                    'options' => array(
                        'bJQueryUI' => false,
                        'sPaginationType' => 'bootstrap',
//                        'scrollX' => true,
                        //'fnDrawCallbackCustom' => "js:function(){\$('a[rel=tooltip]').tooltip(); \$('a[rel=popover]').popover();}",
                    ),
                    'cssFiles' => array('bootstrap.dataTables.css'),
                    'jsFiles' => array(
                        'jquery.SortExtensions.js',
                        'bootstrap.dataTables.js',
                        'jquery.fnSetFilteringDelay.js',
                        'jdatatable.js' => CClientScript::POS_END,
                    ),
                ),
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                // Yii debug toolbar
                array(
                    'class'                => 'application.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'panels'               => array('YiiDebugToolbarPanelVarDumper'),
                    'ipFilters'            => $systemVariables['system']['devIps'],
                    'enabled'              => YII_DEBUG,
                ),
                array(
                    'class'                => 'CWebLogRoute',
                    'categories'           => 'application, exception.*',
                    'levels'               => 'error, warning, trace, profile, info',
                    'showInFireBug'        => false,
                ),
/*
                array(
                    'class'                => 'CEmailLogRoute',
                    'levels'               => 'error, warning',
                    'emails'               => array('garth@studioakt.com', 'cory@studioakt.com', 'garthpmurray@gmail.com'),
                    'subject'              => 'Error on District Lines',
                    'filter'               => 'CLogFilter',
                ),
*/
                array(
                    'class'                => 'CFileLogRoute',
                    'logFile'              => 'application.log',
                    'levels'               => 'error, warning',
                ),
                array(
                    'class'                => 'common.extensions.ECDbLogRoute',
//                  'class'                => 'CDbLogRoute',
                    'logTableName'         => 'sys_log',
                    'connectionID'         => 'db',
                    'autoCreateLogTable'   => true,
                    'levels'               => 'error, warning, system, websocket, screenEvents',
                    'filter'               => 'CLogFilter',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' =>require(dirname(__FILE__).'/params.php'),
);
