<?php

Yii::import('common.models.UserLimitedDataCore');

class UserLimitedData extends UserLimitedDataCore
{
    
    public function beforeValidate(){
        $modelExplode = explode('.', $this->model_name);
        if(count($modelExplode) > 1){
            Yii::import($this->model_name);
        }
        $modelName = end($modelExplode);
        $this->table_name = $modelName::model()->tableName();
        
        return parent::beforeValidate();
    }

}