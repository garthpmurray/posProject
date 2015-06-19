<?php

Yii::import('common.models._base.BaseLogCore');

class LogCore extends BaseLogCore
{
    
    public $ErrorGroup;
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function getErrorGroup() {
		$return = $this->findAllByAttributes(array('error_set' => $this->error_set), array('order'=>'id'));
		
		return $return;
	}
}