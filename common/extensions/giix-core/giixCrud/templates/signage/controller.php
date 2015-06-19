<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass; ?> {

	public $layout='column2';
	public $title;
	public $subTitle;

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, '<?php echo $this->modelClass; ?>'),
		));
	}

	public function actionCreate() {
		$model = new <?php echo $this->modelClass; ?>;
<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidation($model, '<?php echo $this->class2id($this->modelClass)?>-form');
<?php endif; ?>

		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
			$transaction = $model->dbConnection->beginTransaction();
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			$relatedData = <?php echo $this->generateGetPostRelatedData($this->modelClass, 4); ?>;
<?php endif; ?>

			try {
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
				if ($model->saveWithRelated($relatedData)) {
<?php else: ?>
				if ($model->save()) {
<?php endif; ?>
					$transaction->commit();
					if (Yii::app()->getRequest()->getIsAjaxRequest()) {
						Yii::app()->end();
					} else {
						$this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
					}
				} else {
					$transaction->rollBack();
					Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.	See other error messages for details.');
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
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');
<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidation($model, '<?php echo $this->class2id($this->modelClass)?>-form');
<?php endif; ?>

		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
			$transaction = $model->dbConnection->beginTransaction();
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			$relatedData = <?php echo $this->generateGetPostRelatedData($this->modelClass, 4); ?>;
<?php endif; ?>

			try {
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
				if ($model->saveWithRelated($relatedData)) {
<?php else: ?>
				if ($model->save()) {
<?php endif; ?>
					$transaction->commit();
					if (Yii::app()->getRequest()->getIsAjaxRequest()) {
						Yii::app()->end();
					} else {
						$this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
					}
				} else {
					$transaction->rollBack();
					Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.	See other error messages for details.');
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
			$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');

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
		$model = new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();

		if (isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->setAttributes($_GET['<?php echo $this->modelClass; ?>']);

		$this->render('index', array(
			'model' => $model,
		));
	}
*/
	
	public function actionIndex() {
		$model = new <?php echo $this->modelClass; ?>('search');
		$criteria = new CDbCriteria;
		if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
//			  $criteria->addSearchCondition('LOWER(description)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
		}
		
		$sort = new EDTSort('<?php echo $this->modelClass; ?>', array(
		<?php
			$count = 0;
			foreach($this->tableSchema->columns as $column){
				if (++$count == 7)
					echo "\t\t/*\n";
				echo "'{$column->name}',\r\n";
			}
			if ($count >= 7)
				echo "\t\t*/\n";
		?>
		));
		$sort->defaultOrder = 'id';
	
		$sort->attributes = array(
		<?php
			$count = 0;
			foreach($this->tableSchema->columns as $column){
				if (++$count == 7)
					echo "\t\t/*\n";
				if($column->isForeignKey){
					$relation = $this->findRelation($this->modelClass, $column);
					$relationName = $relation[0];
					echo "'{$relationName}.{$column->name}',\r\n";
				}else{
					echo "'{$column->name}',\r\n";
				}
			}
			if ($count >= 7)
				echo "\t\t*/\n";
		?>
		);
	
		$pagination = new EDTPagination();
		
		$dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>', array(
			'criteria'		=> $criteria,
			'pagination'	=> $pagination,
			'sort'			=> $sort,
		));


		$widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
			'id'			=> '<?php echo $this->modelClass; ?>',
			'htmlOptions'	=> array(
				'class' => '',
			),
			'dataProvider'	=> $dataProvider,
			'ajaxUrl'		=> $this->createUrl('/<?php echo strtolower($this->modelClass); ?>/index'),
			'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
			'columns'		=> array(
<?php
	$count = 0;
	foreach ($this->tableSchema->columns as $column) {
		if (++$count == 7)
			echo "\t\t/*\n";
		echo "\t\t" . $this->generateGridViewColumn($this->modelClass, $column).",\n";
	}
	if ($count >= 7)
		echo "\t\t*/\n";
?>
				array(
					'class'=>'SarabonCButtonColumn',
				),
			),
			'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
			'widgetType'	=> 'nonboxy-widget',
			'pullIcons'		=> array(
				array( 
					'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
					'url'=>Yii::app()->createUrl('<?php echo strtolower($this->modelClass); ?>/create'),
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