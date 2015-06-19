<?php

class ECThemeManager extends CThemeManager{
    
	private $_basePath  = null;
	private $_baseUrl   = null;
    
    private $_themes;
    
/*
    public function init(){
        $this->_themes = $this->getThemeNames();
        echo '<pre>';
        debug_print_backtrace();
        echo '</pre>';
        die(var_dump($this));
        return parent::init();
    }
*/
    
    
    
    public function ressetBasePath(){
        return $this->_basePath = null;
    }
    
    /**
    * @return array list of available theme names
    */
    public function getThemeNames()
    {
        $themes = null;
        if($themes===null)
        {
            $themes=array();
            $basePath=$this->getBasePath();
            $folder=@opendir($basePath);
            while(($file=@readdir($folder))!==false)
            {
                if($file!=='.' && $file!=='..' && $file!=='.svn' && $file!=='.gitignore' && is_dir($basePath.DIRECTORY_SEPARATOR.$file))
                    $themes[]=$file;
            }
            closedir($folder);
            sort($themes);
        }
        return $themes;
    }
    
}
