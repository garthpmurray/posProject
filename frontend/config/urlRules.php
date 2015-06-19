<?php
$systemVariables = require(dirname(__FILE__).'/../../common/config/systemVariables.php');

$common_rules = array(
    array(
        'class' => 'application.components.SystemUrlRule',
    ),
    ''                                          => 'site/index',
    '<controller:\w+>/<action:\w+>'             => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>/<id:\d+>'    => '<controller>/<action>',
    '<controller:\w+>'                          => '<controller>',
);

//die(var_dump(CMap::mergeArray($systemVariables['urlRules'], $common_rules)));

return CMap::mergeArray($systemVariables['urlRules'], $common_rules);
?>