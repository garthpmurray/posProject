<?php

class SiteController extends Controller
{
    public $layout='column1';
    public $scripts = array(
        'css' => array(),
        'js' => array(),
    );

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    public function actionIndex()
    {
        $reportsScreen = new ReportsScreen;
        $subNetData = $reportsScreen->getScreenData()->getScreenTypes()->getReportData()->generateTreeArray();
/*
        $debug      = $reportsScreen->getScreenUpStatus();
        $status     = $reportsScreen->getScreenStatus();
        $type       = $reportsScreen->getScreenStatusType(2);
        
        $version    = $reportsScreen->getScreenVersion();
*/
        
        $viewData = array(
            'debug'    => $reportsScreen->getScreenUpStatus(),
            'status'    => $reportsScreen->getScreenStatus(),
            'version'   => $reportsScreen->getScreenVersion(),
            'type'      => $reportsScreen->getScreenStatusType(2),
            'data'      => json_encode(array_values($subNetData)),
            'issueScreens' => Screen::model()->findAllBySql('SELECT * FROM provision_screen WHERE type_id IS NULL'),
        );
        
        
/*
        $UDPSender = Yii::app()->UDPSender;
        
        $UDPSender->serverIp = '172.16.0.156';
        $UDPSender->port = 59897;
        
        $message = array(
            'mute'      => true,
            'pause'     => false,
            'message'   => array(
                'content'       => 'This is a message that could be displayed',
                'displayTime'   => 5,
            ),
        );
        $message = json_encode($message);
        
        $test = $UDPSender->createSocket()->setMessage($message)->sendMessage();
        $UDPSender->closeSocket();
        
        die(var_dump($test));
*/
        
//        $this->scripts['css'][] = '/css/nv.d3.css';
        $this->scripts['js'][] = '/js/d3.v3.js';
        $this->scripts['js'][] = '/assets/plugins/nvd3/nv.d3.js';

        $this->scripts['css'][] = '/assets/plugins/nvd3/build/nv.d3.min.css';
/*
        $this->scripts['js'][] = '/js/d3.v3.min.js';
        $this->scripts['js'][] = '/assets/plugins/nvd3/build/nv.d3.min.js';
*/

        $this->scripts['js'][] = '/assets/js/charts.js';
        
        $this->scripts['css'][] = '/assets/plugins/jstree/dist/themes/default/style.css';
        $this->scripts['js'][] = '/assets/plugins/jstree/dist/jstree.min.js';
        $this->scripts['js'][] = '/assets/js/ui-treeview.js';

        $this->render('index', $viewData);
    }

    public function actionMultiBar(){
        $reportsScreen = new ReportsScreen;
        $reportsScreen->getScreenData()->getScreenTypes();

        $viewData = array(
            'type'      => $reportsScreen->getScreenStatusType(2),
        );
        
        $this->scripts['css'][] = '/assets/plugins/nvd3/build/nv.d3.min.css';

        $this->scripts['js'][] = '/js/d3.v3.js';
        $this->scripts['js'][] = '/assets/plugins/nvd3/nv.d3.js';

        $this->render('_multiBarGraph', $viewData);
    }

    public function actionTest()
    {
        $viewData = array(
            
        );
        
        $this->render('test', $viewData);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error){
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}
