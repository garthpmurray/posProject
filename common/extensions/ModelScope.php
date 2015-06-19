<?php
    
/**
 * ModelScope class.
 *
 *
 * Adds default scope to use the userLimitedData system
 */

class ModelScope {
    
    static public function defaultScope($model){
        $criteria=new CDbCriteria();
        $alias = $model->getTableAlias(true, false);
        if(method_exists($model, 'checkStatus')){
            $check = $model->checkStatus($alias);
            if($check instanceOf CDbCriteria){
                $criteria = $check;
            }else{
                $criteria->addCondition($check);
            }
        }
        
        $ignoreSuperUser = isset($model->ignoreSuperUser) ? $model->ignoreSuperUser : false;
        
/*
        if(0 && $ignoreSuperUser || get_class(Yii::app()) !== 'CConsoleApplication' || Yii::app()->user->isSuperUser || (isset(Yii::app()->user->skipDefaultScope) && Yii::app()->user->skipDefaultScope)){
            $criteria = array();
        }else{
*/
            
            if(self::checkIfModelLimited($model)){
                $user_id = Yii::app()->user->id;
                $userLimitedData = array_values(GxHtml::listDataEx(UserLimitedData::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 'table_name' => $model->tableName())), 'data_id', 'data_id'));
                
                $criteria->addInCondition($alias.'.id',$userLimitedData);
            }
//         }
        return $criteria;
    }
    
    static public function beforeSave($model){
        $userLimitedData = new UserLimitedData;
        
        $data = array(
            'user_id'       => Yii::app()->user->id,
            'data_id'       => $model->id,
            'table_name'    => $model->tableName(),
            'model_name'    => self::getModelName($model),
        );
        $userLimitedData->setAttributes($data);
        $transaction = $userLimitedData->dbConnection->beginTransaction();
        try {
            if ($userLimitedData->save()) {
                $transaction->commit();
                return true;
            } else {
                throw new Exception(CHtml::errorSummary($userLimitedData));
            }
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }
    
    static protected function checkIfModelLimited($model){
        $check = UserLimitedModel::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'table_name' => $model->tableName()));
        
        if(!is_null($check) && !empty($check) && $check->limited){
            return true;
        }
        return false;
    }
    
    static protected function getModelName($model){
        $return = '';
        if(isset(Yii::app()->controller) && isset(Yii::app()->controller->module)){
            $return = Yii::app()->controller->module->id.'.models.';
        }
        
        return $return.get_class($model);
    }
    
}
