<?php
$cs = Yii::app()->getClientScript();
    $aliasDir = Yii::getPathOfAlias('application.www.themes.rapido');
    $cs->scriptMap['jquery.js'] = '/common/lib/assets/js/jquery.2.0.3.min.js';

    $cs->registerCoreScript('jquery');


    $cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.lib.assets').'/js/jquery.unveil.js'), CClientScript::POS_HEAD);
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jquery.validate.js'), CClientScript::POS_HEAD);
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/fancybox/jquery.fancybox.pack.js'));
    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/tinymce/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/tinymce/jquery.tinymce.min.js');



//  start: MAIN JAVASCRIPTS -->
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/blockUI/jquery.blockUI.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/iCheck/jquery.icheck.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/moment/min/moment.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/bootbox/bootbox.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/jquery.appear/jquery.appear.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/jquery-cookie/jquery.cookie.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/plugins/velocity/jquery.velocity.min.js'), CClientScript::POS_END);
//  end: MAIN JAVASCRIPTS -->

//  start: CORE JAVASCRIPTS  -->
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/assets/js/main.js'), CClientScript::POS_END);
//  end: CORE JAVASCRIPTS  -->

    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jqueryui/core.js'));
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jqueryui/widget.js'));
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jqueryui/mouse.js'));
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jqueryui/sortable.js'));
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir . '/js/jqueryui/slider.js'));
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/jqueryui/theme.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/jqueryui/slider.css',"screen");


// start: MAIN CSS -->
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/bootstrap/css/bootstrap.min.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/font-awesome/css/font-awesome.min.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/iCheck/skins/all.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/animate.css/animate.min.css',"screen");
// end: MAIN CSS -->

// start: CORE CSS -->
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/styles.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/styles-responsive.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/plugins.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/themes/theme-default.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/print.css',"print");
// end: CORE CSS -->

    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/js/fancybox/jquery.fancybox.css',"screen");
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/main.css',"screen");

if(isset($this->formElements) && $this->formElements){
    require_once 'scripts/formElementsScripts.php';
}
if(isset($this->pagesProfile) && $this->pagesProfile){
    require_once 'scripts/pagesProfileScripts.php';
}
if(isset($this->calendarElements) && $this->calendarElements){
    require_once 'scripts/calendarElementsScripts.php';
}

if(isset($this->scripts) && !empty($this->scripts)){
	foreach($this->scripts['css'] as $css){
		Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . $css,"screen");
	}
	foreach($this->scripts['js'] as $js){
		Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . $js);
	}
}




?>