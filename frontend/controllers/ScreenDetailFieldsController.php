<?php

class ScreenDetailFieldsController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;

    public function registerScript(){
        $cs = Yii::app()->getClientScript();
            $js = "
        var name = $('#name'),
        value = $('#value'),
        allFields = $([]).add(name).add(value),
        tips = $('.validateTips');
            
        var fieldType = {
                'INTEGER':{
                    'hide':['match','other_validator'],
                    'val':{
                        'field_size':10,
                        'default':'0',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'VARCHAR':{
                    'hide':[],
                    'val':{
                        'field_size':255,
                        'default':'',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'TEXT':{
                    'hide':['field_size','range'],
                    'val':{
                        'field_size':0,
                        'default':'',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'DATE':{
                    'hide':['field_size','field_size_min','match','range'],
                    'val':{
                        'field_size':0,
                        'default':'0000-00-00',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'FLOAT':{
                    'hide':['match','other_validator'],
                    'val':{
                        'field_size':'10.2',
                        'default':'0.00',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'DECIMAL':{
                    'hide':['match','other_validator'],
                    'val':{
                        'field_size':'10,2',
                        'default':'0',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'BOOL':{
                    'hide':['field_size','field_size_min','match'],
                    'val':{
                        'field_size':0,
                        'default':0,
                        'range':'1==".Yii::t('app', 'Yes').";0==".Yii::t('app', 'No')."',
                        'widgetparams':''
                    }
                },
                'BLOB':{
                    'hide':['field_size','field_size_min','match'],
                    'val':{
                        'field_size':0,
                        'default':'',
                        'range':'',
                        'widgetparams':''
                    }
                },
                'BINARY':{
                    'hide':['field_size','field_size_min','match'],
                    'val':{
                        'field_size':0,
                        'default':'',
                        'range':'',
                        'widgetparams':''
                    }
                }
            };
            
        function setFields(type) {
            if (fieldType[type]) {
                $('div.row').addClass('toshow').removeClass('tohide');
                if (fieldType[type].hide.length) $('div.'+fieldType[type].hide.join(', div.')).addClass('tohide').removeClass('toshow');
                if ($('div.widget select').val()) {
                    $('div.widgetparams').removeClass('tohide');
                }
                $('div.toshow').show(500);
                $('div.tohide').hide(500);
            }
        }
        
        function isArray(obj) {
            if (obj.constructor.toString().indexOf('Array') == -1)
                return false;
            else
                return true;
        }
        
        $('#field_type').change(function() {
            setFields($(this).val());
        });
        
        $('#widgetlist').change(function() {
            if ($(this).val()) {
                $('div.widgetparams').show(500);
            } else {
                $('div.widgetparams').hide(500);
            }
            
        });
        
        // init
        setFields($('#field_type').val());";
        
        $cs->registerScript(__CLASS__.'#dialog', $js);
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'ScreenDetailFields'),
        ));
    }

	/**
	 * MySQL field type
	 * @param $type string
	 * @return string
	 */
	public function fieldType($type) {
		$type = str_replace('UNIX-DATE','INTEGER',$type);
		$type = str_replace('INTEGER','INT4',$type);
		return $type;
	}

    public function actionCreate() {
        $model = new ScreenDetailFields;

        if (isset($_POST['ScreenDetailFields'])) {
            $_POST['ScreenDetailFields']['widget'] = 0;
            $_POST['ScreenDetailFields']['widgetparams'] = 0;
            
            $model->setAttributes($_POST['ScreenDetailFields']);
            $transaction = $model->dbConnection->beginTransaction();
            $scheme = get_class(Yii::app()->db->schema);
            
// ALTER TABLE "public"."provision_screen_detail" ADD COLUMN "test" int2 NOT NULL DEFAULT 0;
            
            try {
                if($model->validate()) {
                    $sql = 'ALTER TABLE '.ScreenDetail::model()->tableName().' ADD COLUMN "'.$model->varname.'" ';
                    $sql .= $this->fieldType($model->field_type);
                    if ($model->field_type!='TEXT'
                        && $model->field_type!='DATE'
                        && $model->field_type!='BOOL'
                        && $model->field_type!='BLOB'
                        && $model->field_type!='BINARY'
                        && $model->field_type!='INTEGER')
                            $sql .= '('.$model->field_size.')';
                    
                    if($model->required){
                        $sql .= ' NOT NULL ';
                    }else{
                        $sql .= ' ';
                    }
                    
                    if ($model->field_type!='TEXT'&&$model->field_type!='BLOB'||$scheme!='CMysqlSchema') {
                        if ($model->default)
                            $sql .= " DEFAULT '".$model->default."'";
                        else
                            $sql .= ((
                                        $model->field_type=='TEXT'
                                        ||$model->field_type=='VARCHAR'
                                        ||$model->field_type=='BLOB'
                                        ||$model->field_type=='BINARY'
                                    )?" DEFAULT ''":(($model->field_type=='DATE')?" DEFAULT '0000-00-00'":" DEFAULT 0"));
                    }
                    $model->dbConnection->createCommand($sql)->execute();
                    
                    if ($model->save()) {
                        $transaction->commit();
                        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                            Yii::app()->end();
                        } else {
                            $this->redirect(array('view', 'id' => $model->id));
                        }
                    } else {
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.   See other error messages for details.');
                    }
                }
            } catch(Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
            }
        }
        
        $this->registerScript();
        $this->render('create', array( 'model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'ScreenDetailFields');

        if (isset($_POST['ScreenDetailFields'])) {
            $model->setAttributes($_POST['ScreenDetailFields']);
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
                    Yii::app()->user->setFlash('failure', 'Error(s) occurred during save.   See other error messages for details.');
                }
            }
            catch(Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('failure', 'Error during save: ' . $e->getMessage());
            }
        }
        
        $this->registerScript();
        $this->render('update', array(
                'model' => $model,
                ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $scheme = get_class(Yii::app()->db->schema);
            $model = $this->loadModel($id, 'ScreenDetailFields');
            
            $transaction = $model->dbConnection->beginTransaction();
            try {
                $sql = 'ALTER TABLE "'.ScreenDetail::model()->tableName().'" DROP COLUMN "'.$model->varname.'"';
                $model->dbConnection->createCommand($sql)->execute();
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
        $model = new ScreenDetailFields('search');
        $model->unsetAttributes();

        if (isset($_GET['ScreenDetailFields']))
            $model->setAttributes($_GET['ScreenDetailFields']);

        $this->render('index', array(
            'model' => $model,
        ));
    }
*/
    
    public function actionIndex() {
        $model = new ScreenDetailFields('search');
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
//            $criteria->addSearchCondition('LOWER(description)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('ScreenDetailFields', array(
        'id',
'varname',
'title',
'field_type',
'field_size',
'field_size_min',
        /*
'required',
'match',
'range',
'error_message',
'other_validator',
'default',
'widget',
'widgetparams',
'position',
'visible',
        */
        ));
        $sort->defaultOrder = 'id';
    
        $sort->attributes = array(
        'id',
'varname',
'title',
'field_type',
'field_size',
'field_size_min',
        /*
'required',
'match',
'range',
'error_message',
'other_validator',
'default',
'widget',
'widgetparams',
'position',
'visible',
        */
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('ScreenDetailFields', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'ScreenDetailFields',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/screendetailfields/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
        'id',
        'varname',
        'title',
        'field_type',
        'field_size',
        'field_size_min',
        /*
        'required',
        'match',
        'range',
        'error_message',
        'other_validator',
        'default',
        'widget',
        'widgetparams',
        'position',
        'visible',
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
                    'url'=>Yii::app()->createUrl('screendetailfields/create'),
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