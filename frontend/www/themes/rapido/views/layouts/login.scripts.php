<?php
$cs = Yii::app()->getClientScript();
$cs->scriptMap['jquery.js'] = '/common/lib/assets/js/jquery.2.0.3.min.js';

$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/fancybox/jquery.fancybox.pack.js');

//  start: MAIN JAVASCRIPTS -->
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);

    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/iCheck/jquery.icheck.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/jquery.transit/jquery.transit.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/plugins/jquery-validation/dist/jquery.validate.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/login.js', CClientScript::POS_END);
//  end: MAIN JAVASCRIPTS -->

//  start: CORE JAVASCRIPTS  -->
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/main.js', CClientScript::POS_END);
//  end: CORE JAVASCRIPTS  -->


Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/core.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/widget.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/mouse.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/sortable.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/slider.js');

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

if(isset($this->scripts) && !empty($this->scripts)){
	foreach($this->scripts['css'] as $css){
		Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . $css,"screen");
	}
	foreach($this->scripts['js'] as $js){
		Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . $js);
	}
}


?>
