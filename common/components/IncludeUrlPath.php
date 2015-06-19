<?php


/**
* IncludeUrlPath
*/
class IncludeUrlPath {
    
    public $alias;
    public $moduleName;
    
    public $_isFile = false;
    
    public function resetClass(){
        $this->alias    = null;
        $this->_isFile  = false;
        return $this;
    }
    
    public function setAlias($alias){
        $this->alias = $alias;
        return $this;
    }
    
    public function setModuleName($moduleName){
        $this->moduleName = $moduleName;
        return $this;
    }
    
    public function getClass(){
        if(is_file($this->alias)){
            require_once $this->alias;
            $this->_isFile = true;
        }
        return $this;
    }
    
    public function checkIfMethodExists($action){
        if($this->_isFile){
            $systemController = get_class_methods($this->moduleName.'SystemController');
            $action = "action".ucfirst($action);
            if(in_array($action, $systemController)){
                return true;
            }
        }
        return false;
    }
}
