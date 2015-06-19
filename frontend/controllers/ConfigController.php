<?php

class ConfigController extends GxController {

	public $layout='column2';
	public $title;
	public $subTitle;

	public function actionView($id) {
    	
        $aliasDir = Yii::getPathOfAlias('common.lib.assets.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/md5_reboot.js'), CClientScript::POS_END);
        
    	$screens = CHtml::listData(Screen::model()->findAllByAttributes(array('assigned_config' => $id)), 'id', 'mac_address');
    	$screens = json_encode(array_values($screens));
    	
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Config'),
			'screens' => $screens,
		));
	}

	public function actionCreate() {
		$model = new Config;

		if (isset($_POST['Config'])) {
			$model->setAttributes($_POST['Config']);
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
		$model = $this->loadModel($id, 'Config');

		if (isset($_POST['Config'])) {
			$model->setAttributes($_POST['Config']);
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
			$model = $this->loadModel($id, 'Config');

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

/*
	public function actionIndex() {
		$model = new Config('search');
		$model->unsetAttributes();

		if (isset($_GET['Config']))
			$model->setAttributes($_GET['Config']);

		$this->render('index', array(
			'model' => $model,
		));
	}
*/
	
    public function actionIndex() {
        $model = new Config('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
//            $criteria->addSearchCondition('LOWER(description)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('Config', array(
'id',
// 'content',
'name',
'assigned_system_software',
'assigned_data_software',
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
        'id',
// 'content',
'name',
'assignedSystemSoftware.assigned_system_software',
'assignedDataSoftware.assigned_data_software',
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('Config', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'Config',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/config/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
		'id',
// 		'content',
		'name',
		array(
				'name'=>'assigned_system_software',
				'value'=>'GxHtml::valueEx($data->assignedSystemSoftware)',
				'filter'=>GxHtml::listDataEx(Software::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'assigned_data_software',
				'value'=>'GxHtml::valueEx($data->assignedDataSoftware)',
				'filter'=>GxHtml::listDataEx(Software::model()->findAllAttributes(null, true)),
				),
                array(
                    'class'=>'SarabonCButtonColumn',
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
            'pullIcons'     => array(
                array( 
                    'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'=>Yii::app()->createUrl('config/create'),
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