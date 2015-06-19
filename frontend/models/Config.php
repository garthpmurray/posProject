<?php
    
Yii::import('common.models.ConfigCore');

class Config extends ConfigCore
{
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
    public function defaultScope(){
        return ModelScope::defaultScope($this);
    }
    
    public function afterSave(){
        
        foreach($this->screens as $s){
            if($this->assigned_system_software !== $this->_oldAttributes['assigned_system_software']){
                $s->setUpdate('system');
            }
            if($this->assigned_data_software !== $this->_oldAttributes['assigned_data_software']){
                $s->setUpdate('data');
            }
        }
        
        return parent::afterSave();
    }
    
}