<?php

class SoftwareController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Software'),
        ));
    }

    public function actionImportSoftware(){
        $dataDirectory = dirname(__FILE__).'/../..'.Yii::app()->params['directories']['data'];
        $systemDirectory = dirname(__FILE__).'/../..'.Yii::app()->params['directories']['system'];
        
        $data = array_diff(scandir($dataDirectory), array('..', '.', 'index.php'));;
        $system = array_diff(scandir($systemDirectory), array('..', '.', 'index.php'));;
        
        $dataFiles = array();
        
        $offset = date('Z');
        $updated_time = date('Y-m-d H:i:s', (time()-$offset));
        
        foreach($data as $d){
            $filename = $dataDirectory.$d;
            $dataFiles[] = array(
                'file_size'     => filesize($filename),
                'sha256'        => CommonFunctions::sha256Hash($filename),
                'created_date'  => date('Y-m-d H:i:s',filemtime($filename)),
                'version'       => 1,
                'location'      => $filename,
                'file_name'     => $d,
                'file_type'     => 'data',
            );
        }
        
        foreach($system as $s){
            $filename = $systemDirectory.$s;
            $dataFiles[] = array(
                'file_size'     => filesize($filename),
                'sha256'        => CommonFunctions::sha256Hash($filename),
                'created_date'  => date('Y-m-d H:i:s',filemtime($filename)),
                'version'       => 1,
                'location'      => $filename,
                'file_name'     => $s,
                'file_type'     => 'system',
            );
        }
        
        foreach($dataFiles as $d){
            $model = new Software;
            $model->setAttributes($d);
            $transaction = $model->dbConnection->beginTransaction();
            
            try {
                if ($model->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    $errors = CHtml::errorSummary($model);
                    Yii::app()->user->setFlash('failure', $errors);
                    $this->redirect('index');
                }
            }
            catch(Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
                $this->redirect('index');
            }
        }
        Yii::app()->user->setFlash('success', 'Software successfully imported/updated.');
        $this->redirect('index');
    }

/*
    public function actionCreate() {
        $model = new Software;

        if (isset($_POST['Software'])) {
            $model->setAttributes($_POST['Software']);
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

        $this->render('create', array( 'model' => $model));
    }
*/
    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Software');

        if (isset($_POST['Software'])) {
            $model->setAttributes($_POST['Software']);
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

        $this->render('update', array(
                'model' => $model,
                ));
    }
/*
    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'Software');

            $transaction = $model->dbConnection->beginTransaction();
            try {
                $model->delete();
                $transaction->commit();
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
*/
    
    public function actionIndex() {
        $model = new Software('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(file_name)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(location)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(version)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('Software', array(
            'file_name',
            'location',
            'created_date',
            'updated_date',
            'version',
            'file_size',
        /*
            'sha256',
        */
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
            'file_name',
            'location',
            'created_date',
            'updated_date',
            'version',
            'file_size',
            'unzipped_file_size',
        /*
            'sha256',
        */
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('Software', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'Software',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/software/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
        'file_name',
        'location',
        'created_date',
        'updated_date',
        'version',
        'file_size',
        'unzipped_file_size',
        /*
        'sha256',
        */
                array(
                    'class'     =>'SarabonCButtonColumn',
                    'template'  => '{view}{update}',
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
            'pullIcons'     => array(
                array( 
                    'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'=>Yii::app()->createUrl('software/create'),
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