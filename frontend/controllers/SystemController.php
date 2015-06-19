<?php

class SystemController extends GxController {

    public function getActionParams(){
        return array_merge($_GET, $_POST);
    }

    public function filters(){
        return array();
    }
    
    protected function beforeAction($action){
        foreach (Yii::app()->log->routes as $route){
            if ($route instanceof YiiDebugToolbarRoute){
                $route->enabled = false;
            }
        }
        
        $entityBody = file_get_contents('php://input');
        Yii::log($entityBody, 'system', 'managmentSystem.web.System');

        if(isset($_POST['mac_address']) || isset($_GET['mac_address'])){
            $mac_address = isset($_POST['mac_address']) ? $_POST['mac_address'] : $_GET['mac_address'];
            $screen=Screen::model()->loadByMacAddress($mac_address);
            if(!is_null($screen)){
                $screen->saveIpAddress($screen->id, $_SERVER['REMOTE_ADDR']);
            }
        }
        return true;
    }
    
    public function actionIndex(){
        
        $this->redirect('/');
    }
    
    /**
     * actionFeed function.
     * 
     * Returns all mac addresses that have an update flag as true in an array, as well as Update interval in minutes 
     * 
     * @access public
     * @return array
     */
    public function actionFeed(){
        $return = array(
            'data'      => array(),
            'system'    => array(),
        );
        
        $data   = Screen::model()->findAllByAttributes(array('update_data' => 1));
        $system = Screen::model()->findAllByAttributes(array('update_system' => 1));
        
        foreach($data as $d){
            $return['data'][] = $d->mac_address;
        }
        foreach($system as $s){
            $return['system'][] = $s->mac_address;
        }
        
        echo json_encode($return);
    }
    
    /**
     * actionStart function.
     * 
     * Retrieve Json configuration
     * 
     * @access public
     * @param mixed $mac_address
     * @param mixed $type
     * @return void
     */
    public function actionStart($mac_address, $type = null, $version = null){
        $return = array();
        $errors = array();
        if (($screen=Screen::model()->loadByMacAddress($mac_address))===null){
            echo json_encode(array(
                'error' => true,
                'message'   => "Mac Address doesn't exist in system",
            ));
            Yii::app()->end();
        }
        if (!isset($screen->assignedConfig) || is_null($screen->assignedConfig)){
            echo json_encode(array(
                'error' => true,
                'message'   => "Mac Address doesn't have an assigned configuration",
            ));
            Yii::app()->end();
        }
        
        
        switch($type){
            case 'data':
            case 1:
                $getInfo = $this->getData($screen);
                break;
            case 'system':
            case 2:
                $getInfo = $this->getSystem($screen);
                break;
            default:
                if($screen->update_system == 1){
                    $getInfo = $this->getSystem($screen);
                }elseif($screen->update_data == 1){
                    $getInfo = $this->getData($screen);
                }else{
                    echo json_encode(array(
                        'error' => false,
                        'message'   => "nothing to update",
                    ));
                    Yii::app()->end();
                }
                break;
        }
        
        switch($screen->orientation){
            case 1:
                $orientation = 'landscape';
                break;
            case 2:
                $orientation = 'invertedlandscape';
                break;
            case 3:
                $orientation = 'portrait';
                break;
            case 4:
                $orientation = 'invertedportrait';
                break;
        }
        
        $version = (float)$version == 0 ? 1 : (float)$version;
        
        $data = array(
            'version'           => $version,
            'type'              => $getInfo['type'],
            'url'               => 'http://'.$getInfo['assetUrl'].$getInfo['data']->file_name,
            'sha256sum'         => $getInfo['data']->sha256,
            'file-size'         => (float)$getInfo['data']->file_size,
            'installed-size'    => (float)$getInfo['data']->unzipped_file_size,
            "metadata"          => array(
                "DeviceType"    => $screen->type->name,
                "RoomNumber"    => $screen->screenDetail->room_number,
                "DeviceID"      => $screen->device_id,
                "Location"      => $screen->screenDetail->location,
                "Deck"          => $screen->screenDetail->deck,
            ),
            "orientation"       => $orientation,
        );
        
        echo json_encode($data);
        
        if($getInfo['type'] == 'system'){
            ScreenEvents::model()->saveEvent($screen, ScreenEvents::UPDATE_SYSTEM_START);
        }elseif($getInfo['type'] == 'data'){
            ScreenEvents::model()->saveEvent($screen, ScreenEvents::UPDATE_DATA_START);
        }
        
        $screen->saveIpAddress($screen->id, (string) Yii::app()->request->getUserHostAddress());
        
        Yii::app()->end();
    }
    
    public function actionError($mac_address, $message = null){
        $entityBody = file_get_contents('php://input');
        Yii::log($message.$mac_address." ".$_SERVER['REMOTE_ADDR']." ".$entityBody, 'error', 'managmentSystem.web.System');
        echo json_encode(array(
            'error' => false,
        ));
        Yii::app()->end();
    }
    
    public function actionCompleted($mac_address, $type = null){
        $return = array();
        $errors = array();
        if (($screen=Screen::model()->loadByMacAddress($mac_address))===null){
            echo json_encode(array(
                'error' => true,
                'message'   => "Mac Address doesn't exist in system",
            ));
            Yii::app()->end();
        }
        $transaction = $screen->dbConnection->beginTransaction();
        
        switch($type){
            case 'data':
            case 1:
                $attributes = array(
                    'update_data'   => 0,
                );
                break;
            case 'system':
            case 2:
                $attributes = array(
                    'update_system' => 0,
                );
                break;
            default:
                $attributes = array(
                    'update_data'   => 0,
                    'update_system' => 0,
                );
                break;
        }
        
        
        $screen->setAttributes($attributes);
        
        try{
            if(!$screen->save()){
                $transaction->rollBack();
                $errors[] = $screen->getErrors();
            }else{
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            $errors[] = $e->getMessage();
        }
        
        if(!empty($errors)){
            echo json_encode(array(
                'error' => true,
                'message'   => $errors,
            ));
            
            Yii::app()->end();
        }
        
        echo json_encode(array(
            'error' => false,
        ));
        if(isset($attributes['update_system'])){
            ScreenEvents::model()->saveEvent($screen, ScreenEvents::UPDATE_SYSTEM_DONE);
        }
        if(isset($attributes['update_data'])){
            ScreenEvents::model()->saveEvent($screen, ScreenEvents::UPDATE_DATA_DONE);
        }
        
        Yii::app()->end();
    }
    
    public function actionScreenList($typeId = 1){
//        $data = Screen::model()->findAllByAttributes(array('type_id' => $typeId));
        $data = Screen::model()->findAll();
        $return = array();
        
        foreach($data as $d){
            $return[] = $d->attributes;
        }
        
        echo json_encode($return);
    }
    
    public function actionScreenConfig($mac_address){
        if (($screen=Screen::model()->loadByMacAddress($mac_address))===null)
            throw new Exception('No Screen with that mac address available.');

        $screen->saveIpAddress($screen->id, $_SERVER['REMOTE_ADDR']);
        echo json_encode($screen->assignedConfig->assignedSystemSoftware->attributes);
    }
    
    protected function getSystem($screen){
        if (!isset($screen->assignedConfig->assignedSystemSoftware) || is_null($screen->assignedConfig->assignedSystemSoftware)){
            echo json_encode(array(
                'error' => true,
                'message'   => "Mac Address doesn't have an assigned system software",
            ));
            Yii::app()->end();
        }
        
        return array(
            'data'      => $screen->assignedConfig->assignedSystemSoftware,
            'type'      => 'system',
            'assetUrl'  => $_SERVER['HTTP_HOST'].'/upload/system/',
        );
    }
    
    protected function getData($screen){
        if (!isset($screen->assignedConfig->assignedDataSoftware) || is_null($screen->assignedConfig->assignedDataSoftware)){
            echo json_encode(array(
                'error' => true,
                'message'   => "Mac Address doesn't have an assigned data software",
            ));
            Yii::app()->end();
        }
        
        return array(
            'data'      => $screen->assignedConfig->assignedDataSoftware,
            'type'      => 'data',
            'assetUrl'  => $_SERVER['HTTP_HOST'].'/upload/data/',
        );
    }
}
