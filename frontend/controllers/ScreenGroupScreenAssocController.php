<?php

class ScreenGroupScreenAssocController extends GxController {

    public $layout='column1';
    public $title;
    public $subTitle;
    
    public function actionIndex(){
        $model = new ScreenGroupScreenAssoc;
        $dataProvider = new CActiveDataProvider('Screen');
        $screenGroup = ScreenGroup::model()->fetchColumnNames();
        
        $screenGroupColumnWidth = $screenGroup!==array() ? 75/count($screenGroup) : 0;
        
        $columns = array(
            array(
                'name'      => 'screen',
                'header'    => 'Screen',
                'type'      => 'raw',
                'htmlOptions' => array(
                    'class' => 'permission-column',
                    'style' => 'width:25%',
                ),
            ),
        );
        
        // Add a column for each role
        foreach($screenGroup as $key => $value){
            $columns[] = array(
                'name'      => strtolower($value),
                'header'    => $value,
                'id'        => $key,
                'type'      => 'raw',
                'htmlOptions' => array(
                    'class' => 'role-column',
                    'style' => 'width:'.$screenGroupColumnWidth.'%',
                ),
            );
        }
        
        $rawData = $model->getAssignData($dataProvider, $columns);
        
        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'screen',
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        
        $params = array(
            'model'         => $model,
            'dataProvider'  => $dataProvider,
            'columns'       => $columns,
        );
        
        if(Yii::app()->getRequest()->getIsAjaxRequest()){
            $this->renderPartial('_index', $params);
        }else{
            $this->render('index', $params);
        }
    }
    
    public function actionRemove($screen, $group){
        $model = new ScreenGroupScreenAssoc;
        
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $model->findByAttributes(array('screen_id'=>$screen,'screen_group_id'=>$group));
            
            $transaction = $model->dbConnection->beginTransaction();
            if ($model->delete()) {
                $screen = Screen::model()->findByPk($screen);
                if(!$screen->custom_config){
                    $screen->setConfig();
                }
                $transaction->commit();
            }
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }
    
    public function actionAssign($screen, $group){
        $model = new ScreenGroupScreenAssoc;
        
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model->setAttributes(array(
                'screen_id'         => $screen,
                'screen_group_id'   => $group
            ));
            $transaction = $model->dbConnection->beginTransaction();
            
            if ($model->save()) {
                $screen = Screen::model()->findByPk($screen);
                if(!$screen->custom_config){
                    $screenGroup = ScreenGroup::model()->findByPk($group);
                    if(!empty($screenGroup->assigned_config)){
                        $screen->setConfig($screenGroup->assigned_config);
                        if(isset($screenGroup->assignedConfig->assignedSoftware)){
                            $screen->setUpdate($screenGroup->assignedConfig->assignedSoftware->file_type);
                        }
                    }
                }
                
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        }
    }
}