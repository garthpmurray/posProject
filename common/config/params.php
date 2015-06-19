<?php
$systemVariables = require('systemVariables.php');
// this contains the application parameters that can be maintained via GUI
$params = array(
    // this is displayed in the header section
    'title'=>'',
    'standardOperations' => array(
        array(
            'name' => 'Manage',
            'icon' => 'fa fa-list-ul',
        ),
        array(
            'name' => 'List',
            'icon' => 'fa fa-bars',
        ),
        array(
            'name' => 'Create',
            'icon' => 'fa fa-plus',
        ),
        array(
            'name' => 'Update',
            'icon' => 'fa fa-pencil',
        ),
        array(
            'name' => 'Edit',
            'icon' => 'fa fa-pencil',
        ),
        array(
            'name' => 'Delete',
            'icon' => 'fa fa-bomb',
        ),
        array(
            'name' => 'View',
            'icon' => 'fa fa-eye',
        ),
        array(
            'name' => 'Logout',
            'icon' => 'fa fa-power-off',
        ),
    ),
);

foreach($systemVariables['modules'] as $module){
    if(isset($module['params']) && file_exists($module['params'])){
        $moduleParams = require_once $module['params'];
        $params = CMap::mergeArray($moduleParams, $params);
    }
}

return CMap::mergeArray($systemVariables, $params);