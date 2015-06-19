<?php

class LimitedDataController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;

    public function getActionParams(){
        return array_merge($_GET, $_POST);
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'UserLimitedData'),
        ));
    }

    public function actionCreate() {
        $model = new UserLimitedData;
        $select = '';

        if (isset($_POST['UserLimitedData'])) {
            $transaction = $model->dbConnection->beginTransaction();
            if(is_array($_POST['UserLimitedData']['data_id'])){
                $data = array(
                    'user_id'       => $_POST['UserLimitedData']['user_id'],
                    'model_name'    => $_POST['UserLimitedData']['model_name'],
                );
                $model->user_id = $_POST['UserLimitedData']['user_id'];
                $model->model_name = $_POST['UserLimitedData']['model_name'];
                $select = $this->actionGetModelData($_POST['UserLimitedData']['model_name'], $_POST['UserLimitedData']['data_id'], true);
                
                try{
                    foreach($_POST['UserLimitedData']['data_id'] as $d){
                        $data['data_id'] = $d;
                        if(!$this->saveRecord($data)){
                            throw new Exception('Issue with one or more records.');
                        }
                    }
                    $transaction->commit();
                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->end();
                    } else {
                        $this->redirect(array('index'));
                    }
                } catch(Exception $e) {
                    $transaction->rollBack();
                    Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                }
            }else{
                $model->setAttributes($_POST['UserLimitedData']);
                $transaction = $model->dbConnection->beginTransaction();
    
                try {
                    if ($model->save()) {
                        $transaction->commit();
                        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                            Yii::app()->end();
                        } else {
                            $this->redirect(array('view', 'id' => $model->id));
                        }
                    } else {
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.  See other error messages for details.');
                    }
                }
                catch(Exception $e) {
                    $transaction->rollBack();
                    Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                }
            }
        }

        $this->render('create', array(
            'model'     => $model,
            'models'    => CommonFunctions::getModels(),
            'select'    => $select,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'UserLimitedData');
        $select = array_values(GxHtml::listDataEx($model->findAllByAttributes(array('user_id' => $model->user_id, 'model_name' => $model->model_name)), 'data_id', 'data_id'));
        $select = $this->actionGetModelData($model->model_name, $select, true);

        if (isset($_POST['UserLimitedData'])) {
            $transaction = $model->dbConnection->beginTransaction();
            $model->dbConnection->createCommand('DELETE FROM '.$model->tableName()." WHERE user_id = {$model->user_id} AND model_name = '{$model->model_name}'")->execute();
            if(is_array($_POST['UserLimitedData']['data_id'])){
                $data = array(
                    'user_id'       => $_POST['UserLimitedData']['user_id'],
                    'model_name'    => $_POST['UserLimitedData']['model_name'],
                );
                $model->user_id = $_POST['UserLimitedData']['user_id'];
                $model->model_name = $_POST['UserLimitedData']['model_name'];
                $select = $this->actionGetModelData($_POST['UserLimitedData']['model_name'], $_POST['UserLimitedData']['data_id'], true);
                
                try{
                    foreach($_POST['UserLimitedData']['data_id'] as $d){
                        $data['data_id'] = $d;
                        if(!$this->saveRecord($data)){
                            throw new Exception('Issue with one or more records.');
                        }
                    }
                    $transaction->commit();
                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->end();
                    } else {
                        $this->redirect(array('index'));
                    }
                } catch(Exception $e) {
                    $transaction->rollBack();
                    Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                }
            }else{
                $model->setAttributes($_POST['UserLimitedData']);
                $transaction = $model->dbConnection->beginTransaction();
    
                try {
                    if ($model->save()) {
                        $transaction->commit();
                        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                            Yii::app()->end();
                        } else {
                            $this->redirect(array('view', 'id' => $model->id));
                        }
                    } else {
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.  See other error messages for details.');
                    }
                }
                catch(Exception $e) {
                    $transaction->rollBack();
                    if(!isset($_GET['ajax'])){
                        Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                        $this->redirect(array('view', 'id'=> $id));
                    } else {
                        $returnJson = array(
                            'status' => false,
                            'message' => $e->getMessage(),
                        );
                        echo json_encode($returnJson);
                    }
                }
            }
        }

        $this->render('update', array(
            'model'     => $model,
            'models'    => CommonFunctions::getModels(),
            'select'    => $select,
        ));
    }
    
    protected function saveRecord($data, $model = null){
        $model = is_null($model) ? new UserLimitedData : $model;
        
        $model->setAttributes($data);
        $transaction = $model->dbConnection->beginTransaction();
        
        try {
            if ($model->save()) {
                $transaction->commit();
                return true;
            } else {
                throw new Exception(CHtml::errorSummary($model));
            }
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'UserLimitedData');

            $transaction = $model->dbConnection->beginTransaction();
            try {
                $model->delete();
                $transaction->commit();
                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                    $returnJson = array(
                        'status' => true,
                    );
                    echo json_encode($returnJson);
                }
            }
            catch(Exception $e) {
                $transaction->rollBack();
                if(!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                } else {
                    throw $e;
                }
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('index'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionGetModelData($modelName, $selected = '', $return = false){
        $model = new UserLimitedData;
        $modelExplode = explode('.', $modelName);
        if(count($modelExplode) > 1){
            Yii::import($modelName);
        }
        $modelName = end($modelExplode);
        
        $select = CHtml::dropDownList('UserLimitedData[data_id][]', $selected,
            GxHtml::listDataEx($modelName::model()->resetScope()->findAllAttributes(null, true)),
            array(
                'multiple' => true,
                'class' => 'col-xs-12',
                'style' => 'height:150px',
            )
        );
        
        if(!$return){
            echo $select;
        }else{
            return $select;
        }
    }
    
    public function actionIndex() {
        $model = new UserLimitedData('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(model_name)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(data_id)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('UserLimitedData', array(
            'id',
            'user_id',
            'table_name',
            'model_name',
            'data_id',
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
            'id',
            'user_id',
            'table_name',
            'model_name',
            'data_id',
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('UserLimitedData', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'UserLimitedData',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/limiteddata/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
                'id',
                array(
                    'name'=>'user_id',
                    'value'=>'GxHtml::valueEx($data->user)',
                ),
                'table_name',
                'model_name',
                'data_id',
                array(
                    'class'=>'SarabonCButtonColumn',
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
            'pullIcons'     => array(
                array( 
                    'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'=>Yii::app()->createUrl('userlimiteddata/create'),
                ),
            )
        ));
        
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            $this->render('index', array(
                'model' => $model,
                'widget' => $widget,
            ));
            return;
        } else {
            echo json_encode($widget->getFormattedData(intval($_REQUEST['sEcho'])));
            Yii::app()->end();
        }
    }
}