<?php

class ScreenController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;
    public $pagesProfile;
    public $scripts = array(
        'css' => array(),
        'js' => array(),
    );

    
    public function getActionParams(){
        return array_merge($_GET, $_POST);
    }

    public function actionUpdateIpAddressArray($data){
        $data = (array)json_decode($data);
        
        if(Yii::app()->db->createCommand('UPDATE provision_screen SET "debugFlag" = 0')->execute()){
            ob_start();
            var_dump($data);
            $log = ob_get_clean();
            Yii::log($log, 'websocket', 'ScreenController.web.UpdateIP');
            foreach($data as $key=>$value){
                $value = (array)$value;
                $ip = $value['ip'];
                $version = $value['version'];
                
                $this->actionUpdateIpAddress($key, $ip, $version);
            }
            echo true;
            Yii::app()->end();
        }
    }

    public function actionUpdateIpAddress($mac, $ip, $version){
        $model = Screen::model()->loadByMacAddress($mac);
        if(!is_null($model)){
            $model->ip_address = $ip;
            $model->system_version = $version;
            $model->debugFlag = 1;
            try{
                $save = $model->save();
                if($save){
                     ScreenEvents::model()->saveEvent($model, ScreenEvents::UPDATE_WEBSOCKET_PING);
                    echo $save;
                }
            } catch(Exception $e) {
                Yii::log($e->getMessage(), 'websocket', 'ScreenController.web.UpdateIP');
            }
        }else{
/*
            $model = new Screen;
            $modal->mac_address = $mac;
            $model->ip_address = $ip;
            $model->system_version = $version;
            echo $model->save();
*/
            Yii::log("{$mac} Doesn't exist in system", 'websocket', 'ScreenController.web.UpdateIP');
        }
    }

    public function actionImportCsv(){
        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['CSVImport'])){
            $model = CSVImport::model();
            $model->setAttributes($_POST['CSVImport']);
            $model->validate();
            
            if(!is_null($model->getError('csv_file'))){
                Yii::app()->user->setFlash('failure', $model->getError('csv_file'));
                $this->redirect(array('index'));
            }else{
                if($model->importData()){
                    Yii::app()->user->setFlash('success', 'CSV successfully imported');
                    $this->redirect(array('index'));
                }else{
                    Yii::app()->user->setFlash('failure', 'There was an error issue with the CSV upload.');
                    $this->redirect(array('index'));
                }
            }
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionView($id, $modal = false) {
        $this->pagesProfile = true;
        if($modal){
            $this->layout = 'modal';
        }
        
        $aliasDir = Yii::getPathOfAlias('common.lib.assets.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/md5_reboot.js'), CClientScript::POS_END);
        
        $this->scripts['js'][] = '/assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js';
        $model = $this->loadModel($id, 'Screen');
        $this->render('view/view', array(
            'model' => $model,
            'details' => $model->screenDetail,
        ));
    }

    public function actionView2($id, $modal = false) {
        $this->pagesProfile = true;
        if($modal){
            $this->layout = 'modal';
        }
        
        $aliasDir = Yii::getPathOfAlias('common.lib.assets.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/md5_reboot.js'), CClientScript::POS_END);
        
        $this->scripts['js'][] = '/assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js';
        $model = $this->loadModel($id, 'Screen');
        $this->render('view', array(
            'model' => $model,
            'details' => $model->screenDetail,
        ));
    }

    public function actionCreate() {
        $model = new Screen;
        $screenDetail = new ScreenDetail;

        if (isset($_POST['Screen'])) {
            $model->setAttributes($_POST['Screen']);
            $transaction = $model->dbConnection->beginTransaction();
            
            try {
                if ($model->save()) {
                    $transaction->commit();
                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->end();
                    } else {
                        if(isset($_POST['save']) && $_POST['save'] == 'Save & Add Another'){
                            $this->redirect(array('create'));
                        }
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

        $this->render('create', array(
            'model' => $model,
            'details' => $screenDetail,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Screen');
        $screenDetail = $model->screenDetail;

        if (isset($_POST['Screen']) && isset($_POST['ScreenDetail'])) {
            $model->setAttributes($_POST['Screen']);
            $screenDetail->setAttributes($_POST['ScreenDetail']);
            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($model->save() && $screenDetail->save()) {
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
            'details' => $screenDetail,
        ));
    }
    
    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'Screen');

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
        $model = new Screen('search');
        $model->unsetAttributes();

        if (isset($_GET['Screen']))
            $model->setAttributes($_GET['Screen']);

        $this->render('index', array(
            'model' => $model,
        ));
    }
*/
    
    public function actionIndex() {
        $this->layout='column1';
        
        $model = new Screen('search');
        
//        die(var_dump($model));
        
        $criteria = new CDbCriteria;
        $criteria->join = 'JOIN "provision_screen_detail" as sd ON t."id" = sd."id"';
        $criteria->join .= 'LEFT JOIN "provision_screenType" as type ON t.type_id = type."id" ';
        $criteria->join .= 'LEFT JOIN "provision_config" as config ON t.assigned_config = config."id"';
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(t.clean_name)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(t.comments)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(t.device_id)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(t.mac_address)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('t.ip_address', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(type."name")', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(config."name")', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(sd."room_number")', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(sd."deck")', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(sd."location")', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        $sort = new EDTSort('Screen', array(
//            'id',
            'status',
            'debugFlag',
            'clean_name',
            'mac_address',
            'ip_address',
            'configName',
            'name',
            'sd.location',
            'sd.deck',
            'sd.room_number',
            'system_version',
            'orientation',
        ));
        $sort->defaultOrder = 't.id';
    
        $sort->attributes = array(
//            'id',
            'status',
            'debugFlag',
            'clean_name',
            'mac_address',
            'ip_address',
            'configName' => 'config.name',
            'name' => 'type.name',
            'sd.location',
            'sd.deck',
            'sd.room_number',
            'system_version',
            'orientation',
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('Screen', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));
        
        
        
        
        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'Screen',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/screen/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
//                'id',
                array(
                    'name' => 'status',
                    'type'  => 'raw',
                    'value' => '$data->status ? "<i data-id=\"{$data->id}\" class=\"fa fa-3x fa-dot-circle-o text-green statusCheck\"></i>" : "<i data-id=\"{$data->id}\" class=\"fa fa-3x fa-dot-circle-o text-red statusCheck\"></i>"',
                ),
                array(
                    'name' => 'debugFlag',
                    'type'  => 'raw',
                    'value' => '$data->debugFlag ? "<i class=\"fa fa-3x fa-dot-circle-o text-green\"></i>" : "<i class=\"fa fa-3x fa-dot-circle-o text-red\"></i>"',
                    'header' => 'Websocket',
                ),
                'clean_name',
                'mac_address',
                'ip_address',
                array(
                    'name'      => 'configName',
                    'value'     => 'GxHtml::valueEx($data->assignedConfig)',
                    'header'    => 'Config',
                ),
                array(
                    'name'      => 'name',
                    'value'     => 'GxHtml::valueEx($data->type)',
                    'header'    => 'Screen Type',
                ),
                array(
                    'name'      => 'sd.location',
                    'value'     => '$data->screenDetail->location',
                    'header'    => 'Location',
                ),
                array(
                    'name'      => 'sd.deck',
                    'value'     => '$data->screenDetail->deck',
                    'header'    => 'Deck',
                ),
                array(
                    'name'      => 'sd.room_number',
                    'value'     => '$data->screenDetail->room_number',
                    'header'    => 'Room Number',
                ),
                'system_version',
                array(
                    'name' => 'orientation',
                    'value' => '$data->readableOrientation',
                ),
                array(
                    'name' => 'update_system',
                    'type'  => 'raw',
                    'value' => '$data->getProgressBar($data->update_system, "updateSystem")',
                ),
                array(
                    'name' => 'update_data',
                    'type'  => 'raw',
                    'value' => '$data->getProgressBar($data->update_data, "updateData")',
                ),
                array(
                    'class'     =>'SarabonCButtonColumn',
                    'template'  => '{view}{update}{reboot}{getIp}',
                    'buttons'=>array(
                        'reboot' => array(
                            'url' => '$data->mac_address',
                            'label'=>'Reboot Box',
                            'click' => 'js:function(event) { event.preventDefault(); if(confirm("Are you sure you want to send this box a reboot command?")) { reboot_box($(this).attr("href")) }}'
                        ),
                        'getIp' => array(
                            'url' => '$data->mac_address',
                            'label'=>'Get Box Ip',
                            'click' => 'js:function(event) { event.preventDefault(); get_box_ip($(this).attr("href"));}'
                        ),
                    ),
                ),
            ),
            'title' => Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
            'widgetType'    => 'nonboxy-widget',
            'pullIcons'     => array(
                array( 
                    'label' =>Yii::t('app', 'Create') . ' ' . $model->label(),
                    'url'   =>Yii::app()->createUrl('screen/create'),
                ),
            )
        ));
        
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            $aliasDir = Yii::getPathOfAlias('common.lib.assets.js');
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/md5_reboot.js'), CClientScript::POS_END);
            
            $this->scripts['js'][] = '/assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js';
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
    
    public function actionStatusUpdate($id){
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'Screen');
            
            if($model->status == 1){
                $model->status = 0;
            }elseif($model->status == 0 || is_null($model->status)){
                $model->status = 1;
            }

            $transaction = $model->dbConnection->beginTransaction();
            try {
                $model->save();
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
    
}