<?php
    
Yii::import('common.models.LogCore');

class LogView extends LogCore
{
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
}