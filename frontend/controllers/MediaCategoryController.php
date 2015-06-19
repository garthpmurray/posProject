<?php

class MediaCategoryController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'MediaCategory'),
        ));
    }

    public function actionCreate() {
        $model = new MediaCategory;

        if (isset($_POST['MediaCategory'])) {
            $model->setAttributes($_POST['MediaCategory']);
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

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'MediaCategory');

        if (isset($_POST['MediaCategory'])) {
            $model->setAttributes($_POST['MediaCategory']);
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

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'MediaCategory');

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

/*
    public function actionIndex() {
        $model = new MediaCategory('search');
        $model->unsetAttributes();

        if (isset($_GET['MediaCategory']))
            $model->setAttributes($_GET['MediaCategory']);

        $this->render('index', array(
            'model' => $model,
        ));
    }
*/
    
    public function actionIndex() {
        $model = new MediaCategory('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(name)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(description)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('MediaCategory', array(
///            'id',
            'name',
            'description',
            'created',
            'updated',
//            'deleted',
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
//            'id',
            'name',
            'description',
            'created',
            'updated',
//            'deleted',
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('MediaCategory', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'MediaCategory',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/mediacategory/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
//                'id',
                'name',
                'description',
                array(
                    'name'=>'created',
                    'value'=>'is_int($data->created) ? date("Y-m-d H:i:s", $data->created) : "Not Set"',
                ),
                array(
                    'name'=>'updated',
                    'value'=>'is_int($data->updated) ? date("Y-m-d H:i:s", $data->updated) : "Not Set"',
                ),
/*
                array(
                    'name'=>'deleted',
                    'value'=>'is_int($data->updated) ? date("Y-m-d H:i:s", $data->deleted) : "Not Set"',
                ),
*/
                array(
                    'class'=>'SarabonCButtonColumn',
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
            'pullIcons'     => array(
                array( 
                    'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'=>Yii::app()->createUrl('mediacategory/create'),
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