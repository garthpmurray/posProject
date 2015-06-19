<?php


/**
* CSVImport
*/
class CSVImport extends CFormModel{

    public $csv_file;
    protected $_csvHeader;
    
    private static $_models=array();            // class name => model
    
    public static function model($className=__CLASS__)
    {
        if(isset(self::$_models[$className]))
            return self::$_models[$className];
        else
        {
            $model=self::$_models[$className]=new $className(null);
            $model->attachBehaviors($model->behaviors());
            return $model;
        }
    }

    public function rules() {
        return array(
            array('csv_file', 'required'),
            array(
                'csv_file',
                'file',
                'types' => 'csv',
                'maxSize' => 5242880,
                'allowEmpty' => true,
                'wrongType' => 'Only csv allowed.',
                'tooLarge' => 'File too large! 5MB is the limit'
            ),
            array('csv_file', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'csv_file' => Yii::t('app', 'CSV File'),
        );
    }
    
    public function importData(){
        $csvFileUpload = CUploadedFile::getInstance($this, 'csv_file');
        $csvFile = new CsvImporter($csvFileUpload->tempName, true, ',');
        $csvData = $csvFile->get();
        $transaction = Yii::app()->db->beginTransaction();
        $save = true;
        try{
            $screenModel = new Screen;
            $screenDetailModel = new ScreenDetail;
            $this->_csvHeader = $csvFile->getHeader();
            $screenColumns = $screenModel->screenCSVImportRelations;
            $screenDetailColumns = $screenDetailModel->screenCSVImportRelations();
            foreach($csvData as $cd){
                $formattedData = $this->importRecord($cd, $screenColumns, $screenDetailColumns);
                if(!$this->SaveRecords($formattedData)){
                    $save = false;
                }
            }
        } catch(Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
         }
        if($save){
            $transaction->commit();
            return true;
        }
        return false;
    }
    
    public function importRecord($data, $screen, $screenDetail){
        $return = array(
            'screen' => array(),
            'detail' => array(),
        );
        $issues = array();
        
        array_walk($screen, array($this, 'fixKeys'));
        array_walk($screenDetail, array($this, 'fixKeys'));
        
        foreach($data as $key => $value){
            $screenKey = array_search($this->fixHeaderKeys($key), $screen);
            $detailKey = array_search($this->fixHeaderKeys($key), $screenDetail);
            if($screenKey !== false){
                $return['screen'][$screenKey] = $value;
            }elseif($detailKey !== false){
                $return['detail'][$detailKey] = $value;
            }else{
                $issues[$key] = $value;
            }
        }
        if(!empty($issues)){
            ob_start();
            print_r($issues);
            $issues = ob_get_clean();
            
            throw new Exception('Errors with Records '. $issues);
        }
        
        return $return;
    }
    
    protected function SaveRecords($formattedData){
        $screenModel = new Screen;
        $screenDetailModel = new ScreenDetail;
        $screenModel->setAttributes($formattedData['screen']);
        try {
            if ($screenModel->checkForDuplicate()->save()) {
                $formattedData['detail']['id'] = $screenModel->id;
                $screenDetailModel->setAttributes($formattedData['detail'], false);
                if ($screenDetailModel->checkForDuplicate()->save()) {
                    return true;
                }
            }
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
            return false;
        }
        return false;
    }
    
    protected function fixKeys(&$item, $key){
        if(is_array($item)){
            $item = $item['column'];
        }
        
        $value = strtolower(str_replace(array(' ', '_', '-'), '', $item));
        $item = $value;
    }
    protected function fixHeaderKeys($value){
        $value = preg_replace('/\(.*?\)|\s*/', '', $value);
        $newValue = strtolower(str_replace(array(' ', '_', '-'), '', trim($value)));
        return $newValue;
    }
    
}




?>