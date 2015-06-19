<?php
    
$module_navs = array(
    'items' => array()
);

foreach(Yii::app()->modules as $key => $value){
    if(!in_array($key, Yii::app()->params['systemModules']) && !in_array($key, Yii::app()->params['ignoredModules']) && isset($value['navType'])){
        $module_navs['items'][] = require_once(Yii::getPathOfAlias($value['navType']).'.php');
    }
}
$this->widget('ExtendedSideMenu', $module_navs);


if(Yii::app()->user->IsSuperuser){
    $sysModule_navs = array(
        'items' => array(
            array(
                'label' => 'Modules',
                'url' => '#',
                'submenuOptions' => array('class' => 'sub-menu'),
                'labelIcon' => 'fa fa-fw fa-gears',
            )
        )
    );
    
    foreach(Yii::app()->modules as $key => $value){
        if( !in_array($key, Yii::app()->params['ignoredModules']) && isset($value['navType']) && in_array($key, Yii::app()->params['systemModules'])){
            $sysModule_navs['items'][0]['items'][] = require_once(Yii::getPathOfAlias($value['navType']).'.php');
        }
    }
    
    $this->widget('ExtendedSideMenu', $sysModule_navs);
}