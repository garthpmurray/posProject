<?php

Yii::import('common.models.UserLimitedModelCore');

class UserLimitedModel extends UserLimitedModelCore
{
    
    public function beforeValidate(){
        $modelExplode = explode('.', $this->model_name);
        if(count($modelExplode) > 1){
            Yii::import($this->model_name);
        }
        $modelName = end($modelExplode);
        $model = new $modelName;
        $this->table_name = $model->tableName();
        
        return parent::beforeValidate();
    }

}