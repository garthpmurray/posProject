<?php

Yii::import('common.models._base.BaseConfigCore');

class ConfigCore extends BaseConfigCore
{
    protected $_oldAttributes = array();
    
    public function setOldAttributes($value){
        $this->_oldAttributes = $value;
    }
    
    public function getOldAttributes(){
        return $this->_oldAttributes;
    }
    
    public function init(){
        $this->attachEventHandler("onAfterFind", function ($event){
            $event->sender->OldAttributes = $event->sender->Attributes;
        });
    }
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}