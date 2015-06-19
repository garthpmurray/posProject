<?php

Yii::import('common.components.MW360Cache');

class MediaAssetController extends GxController {

    public $layout='column2';
    public $title;
    public $subTitle;

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'MediaAsset'),
        ));
    }

    public function actionCreate() {
        $model = new MediaAsset;

        if (isset($_POST['MediaAsset'])) {
            $model->setAttributes($_POST['MediaAsset']);
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

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'MediaAsset');

        if (isset($_POST['MediaAsset'])) {
            $model->setAttributes($_POST['MediaAsset']);
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
            $model = $this->loadModel($id, 'MediaAsset');

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
        $model = new MediaAsset('search');
        $model->unsetAttributes();

        if (isset($_GET['MediaAsset']))
            $model->setAttributes($_GET['MediaAsset']);

        $this->render('index', array(
            'model' => $model,
        ));
    }
*/
    
    public function actionIndex() {
        $model = new MediaAsset('search');
        
        $criteria = new CDbCriteria;
        if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
            $criteria->addSearchCondition('LOWER(name)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('LOWER(media_url)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('CAST(width AS VARCHAR)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
            $criteria->addSearchCondition('CAST(height AS VARCHAR)', strtolower($_REQUEST['sSearch']), true, 'OR', 'LIKE');
        }
        
        $sort = new EDTSort('MediaAsset', array(
//            'id',
            'media_category_id',
            'name',
            'media_url',
//            'description',
            'width',
            'height',
        /*
            'file_hash',
            'created',
            'updated',
            'deleted',
        */
        ));
        $sort->defaultOrder = 'name';
    
        $sort->attributes = array(
//            'id',
            'media_category_id',
            'name',
            'media_url',
//            'description',
            'width',
            'height',
        /*
            'file_hash',
            'created',
            'updated',
            'deleted',
        */
        );
    
        $pagination = new EDTPagination();
        
        $dataProvider = new CActiveDataProvider('MediaAsset', array(
            'criteria'      => $criteria,
            'pagination'    => $pagination,
            'sort'          => $sort,
        ));


        $widget=$this->createWidget('application.extensions.edatatables.EDataTables', array(
            'id'            => 'MediaAsset',
            'htmlOptions'   => array(
                'class' => '',
            ),
            'dataProvider'  => $dataProvider,
            'ajaxUrl'       => $this->createUrl('/mediaasset/index'),
            'datatableTemplate' => "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>",
            'columns'       => array(
//                'id',
                array(
                    'name'=>'media_category_id',
                    'value'=>'GxHtml::valueEx($data->mediaCategory)',
                    'filter'=>GxHtml::listDataEx(MediaCategoryCore::model()->findAllAttributes(null, true)),
                ),
                'name',
                'media_url',
//                'description',
                'width',
                'height',
            /*
                'file_hash',
                array(
                    'name'=>'created',
                    'value'=>'is_int($data->created) ? date("Y-m-d H:i:s", $data->created) : "Not Set"',
                ),
                array(
                    'name'=>'updated',
                    'value'=>'is_int($data->updated) ? date("Y-m-d H:i:s", $data->updated) : "Not Set"',
                ),
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
                    'url'=>Yii::app()->createUrl('mediaasset/create'),
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
    
    /**
     * Logic to get the media's dimensions,save the file to file system, url, etc.
     * 
     * @author David Eddy <me@davidjeddy.com>
     * @version  0.
     * @since  0.1.5
     * @todo  break this into its own CNTL
     * @param  MediaAsset $model
     * @return boolean
     */
    private function mediaManipulation(MediaAsset $model, $action = 'created')
    {
        Yii::log(__METHOD__.' started.', 'info', 'frontend.controllers.MediaAssetController');

        if (!$model->media_category_uuid) { return false; };

        // get image media_category_uuid name
        $catName = MediaCategory::model()->findByPk($model->media_category_id);
        // create a upload class instance for the given category
        $fileData = CUploadedFile::getInstance($model, 'media_url');

        // confirm dir exists, else make it
        if (!file_exists('../../cdn/'.$catName->name)) {
            mkdir('../../cdn/'.$catName->name, 0755, true);
        }

        // if the media file is changed, remove the old one
        if ($action == 'updated' && is_object($fileData)) { unlink('../../'.$model->media_url); };

        if ($fileData != null) {
            // set the additional properties of the media asset model
            $imageInfo     = getimagesize($fileData->getTempName());

            // save file to system location
            $model->media_url = Yii::app()->params['cdn']['file_path'].$catName->name.'/'
                .strtolower(preg_replace("/[^A-Za-z0-9._]/", '-', $fileData->getName() ));
            
            $fileData->saveAs('../../'.$model->media_url);

            // if the media is an image resize as needed and set the H*W properties
            if (strstr($fileData->getType(), 'image')) {
                
                // resize images over 1080*1920
                // todo refactor into a unified component - DJE : 23015-03-09
                $simpleImage = Yii::app()->simpleImage->load('../../'.$model->media_url);
                // TODO Removed size checking per Greg as uploaded images could be HD vertically. - DJE : 2015-03-31
                /*if ($simpleImage->getHeight() > 1080) {

                    $simpleImage->resizeToHeight(1080);
                } elseif ($simpleImage->getWidth() > 1920) {

                    $simpleImage->resizeToWidth(1920);
                }*/
                $simpleImage->save('../../'.$model->media_url, substr($model->media_url, -4), 95, 0644);

                $model->height = $simpleImage->getHeight();
                $model->width  = $simpleImage->getWidth();
            }

            // generate md5 hash from the file created onto the filesystem
            $model->file_hash = CommonFunctions::uuid_make(md5($model->media_url));

        }
        return true;
    }
    
}