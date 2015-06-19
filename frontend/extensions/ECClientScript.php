<?php

/**
 * ECClientScript
 * 
 * @package Yii
 */
class ECClientScript extends CClientScript
{
    
    public function renderCoreScripts(){
        if($this->coreScripts===null)
            return;
        $cssFiles=array();
        $jsFiles=array();
        $position=$this->defaultScriptFilePosition;
        
        foreach($this->coreScripts as $name=>$package){
            if(isset($package['position']))
                $position=$package['position'];
            
            $baseUrl=$this->getPackageBaseUrl($name);
            
            if(!empty($package['js'])){
                foreach($package['js'] as $js)
                    $jsFiles[$position][$baseUrl.'/'.$js]=$baseUrl.'/'.$js;
            }
            if(!empty($package['css'])){
                foreach($package['css'] as $css)
                    $cssFiles[$baseUrl.'/'.$css]='';
            }
        }
        // merge in place
        if($cssFiles!==array()){
            foreach($this->cssFiles as $cssFile=>$media)
                $cssFiles[$cssFile]=$media;
            $this->cssFiles=$cssFiles;
        }
        if($jsFiles!==array()){
            if(isset($this->scriptFiles)){
                foreach($this->scriptFiles as $key => $value){
                    foreach($value as $url => $path){
                        $jsFiles[$key][$url]=$path;
                    }
                }
            }
            $this->scriptFiles=$jsFiles;
        }
    }
    
}