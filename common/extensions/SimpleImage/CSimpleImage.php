<?php
// Created by Khanh Nam
class CSimpleImage extends CApplicationComponent {

    public $error;

    public $_fileData;
    public $_fileInfo;
    
    public $_root;
    public $_cdnPath;
    public $_fileName;
    public $_CDNCatFile;

    public function init() {
        parent::init();
        $dir = dirname(__FILE__);
        $alias = md5($dir);
        Yii::setPathOfAlias($alias,$dir);
        Yii::import($alias.'.simple_image');
        $this->setRoot(Yii::getPathOfAlias('root'));
        $this->setCDNPath(Yii::app()->params['cdn']['file_path']);
    }
    
    public function setRoot($root){
        return $this->_root = $root;
    }
    
    public function setCDNPath($path){
        return $this->_cdnPath = $path;
    }
    
    public function setFileName($name, $id){
        $nameExplode = explode('.', $name);
        $nameExplode[0] = $nameExplode[0].'-'.$id;
        $name = implode('.', $nameExplode);
        return $this->_fileName = strtolower(preg_replace("/[^A-Za-z0-9._]/", '-', $name ));
    }
    
    public function getFileData($model){
        $this->_fileData = CUploadedFile::getInstance($model, 'media_url');
        if(!is_null($this->_fileData) && $this->_fileData->hasError){
            $this->error = $this->codeToMessage($this->_fileData->getError());
            return false;
        }
        return true;
    }
    
    public function uploadImage($model, $oldUrl = null){
        
        $this->setFileName($this->_fileData->getName(), $model->id);
        $this->createCDNFolder($model->mediaCategory->name);
        if($this->_fileData->saveAs($this->_root.'/'.$this->_CDNCatFile.'/'.$this->_fileName)){
            $this->_fileInfo = $this->load($this->_root.'/'.$this->_CDNCatFile.'/'.$this->_fileName);
            if(!$this->checkFileHash($oldUrl, $this->_CDNCatFile.'/'.$this->_fileName)){
                $this->removeOldFile($oldUrl);
            }
        }else{
            if($this->_fileData->hasError){
                $this->error = $this->codeToMessage($this->_fileData->getError());
            }else{
                $this->error = 'There was an issue uploading your file. Please check folder permissions and try again.';
            }
            return false;
        }
        return true;
    }
    
    public function checkFileHash($oldPath, $newPath){
        $oldPath = CommonFunctions::uuid_make(md5($oldPath));
        $newPath = CommonFunctions::uuid_make(md5($newPath));
        if($oldPath == $newPath){
            return true;
        }
        return false;
    }
    
    public function removeOldFile($filePath){
        $path = $this->_root.'/'.$filePath;
        if(is_file($path)){
            unlink($path);
        }
        return true;
    }
    
    public function createCDNFolder($name){
        $this->_CDNCatFile = $this->_cdnPath.$name;
        $path = $this->_root.'/'.$this->_CDNCatFile;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return true;
    }
    
    public function load($filename){
        return new simple_image($filename);
    }
    
    private function codeToMessage($code){
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}
