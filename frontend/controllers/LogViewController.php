<?php

class LogViewController extends GxController {

	public $layout='column2';
	public $title;
	public $subTitle;

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'LogView'),
		));
	}

    public function actionIndex() {
        $this->layout = 'column1';
        $model = new LogView('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(message)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(request_url)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(level)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(category)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('LogView', array(
//            'id',
            'error_set',
            'level',
            'category',
//            'logtime',
//            'message',
            'logRealTime',
//            'ip_user',
            'request_url',
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
//            'id',
            'error_set',
            'level',
            'category',
//            'logtime',
//            'message',
            'logRealTime',
//            'ip_user',
            'request_url',
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('LogView', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'LogView',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/logView/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
//                    'id',
                    'error_set',
                    'level',
                    'category',
//                    'logtime',
//                    'message',
                    'logRealTime',
//                    'ip_user',
                    'request_url',
                array(
                    'class'=>'SarabonCButtonColumn',
                    'template' => '{view}',
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
/*
            'pullIcons'     => array(
                array( 
                    'label'=>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'=>Yii::app()->createUrl('logview/create'),
                ),
            )
*/
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