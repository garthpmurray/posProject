<?php

class SystemUrlRule extends CBaseUrlRule
{
    public $modules;
    protected $_includeUrlPath;
    protected $_modulePath;
    
    public function __construct(){
        $modules = Yii::app()->modules;
        $ignoreModules = CMap::mergeArray(Yii::app()->params['systemModules'], Yii::app()->params['ignoredModules']);
        foreach($ignoreModules as $i){
            unset($modules[$i]);
        }
        $this->modules = $modules;
        require('../../common/components/IncludeUrlPath.php');
        
        $this->_includeUrlPath = new IncludeUrlPath;
    }
    
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        $response = false;
        $pathInfoExplode = explode('/', $pathInfo);
        if($pathInfoExplode[0] == 'system'){
            $response = $pathInfo;
            if($this->checkModule($pathInfoExplode)){
                $response = $this->definedModule($pathInfoExplode);
            }else{
                if($this->moduleRoute($pathInfoExplode)){
                    $response = $this->_modulePath;
                }
            }
        }
        return $response;
    }
    
    protected function moduleRoute($pathInfoExplode){
        foreach($this->modules as $name=>$module){
            if(isset($pathInfoExplode[1]) && $this->checkMethod($name, $pathInfoExplode[1])){
                $this->_modulePath = $this->definedSystemModule($name, $pathInfoExplode);
                return true;
            }
        }
        return false; 
    }
    
    protected function checkMethod($name, $action){
        $alias = $name.'.controllers.'.ucfirst($name).'SystemController';
        $alias = Yii::getPathOfAlias($alias).'.php';
        return $this->_includeUrlPath->resetClass()->setModuleName($name)->setAlias($alias)->getClass()->checkIfMethodExists($action);
    }
    
    protected function definedSystemModule($name, $pathArray){
        $path = array(
            $name,
            $name.'System',
        );
        unset($pathArray[0]);
        $merge = CMap::mergeArray($path, $pathArray);
        $path = implode('/', $merge);
        return $path;
    }
    
    protected function definedModule($pathArray){
        $pathArray[0] = $pathArray[1];
        $pathArray[1] = $pathArray[1].'System';
        
        $path = implode('/', $pathArray);
        return $path;
    }
    
    protected function checkModule($pathArray){
        if(isset($pathArray[1]) && in_array($pathArray[1], array_keys($this->modules))){
            return true;
        }
        return false;
    }
    
}


?>