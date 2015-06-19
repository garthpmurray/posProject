<?php
$cs = Yii::app()->getClientScript();
$cs->scriptMap['jquery.js'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js';

$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bootstrap-switch.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/image-picker.js');


Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/core.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/widget.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/mouse.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/sortable.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jqueryui/slider.js');

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/fancybox/jquery.fancybox.pack.js');



/* Yii::app()->clientScript->registerCSSFile('//fonts.googleapis.com/css?family=Philosopher',"screen"); */
Yii::app()->clientScript->registerCSSFile('//fonts.googleapis.com/css?family=Carme',"screen");
/*
Yii::app()->clientScript->registerCSSFile('//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700',"screen");
Yii::app()->clientScript->registerCSSFile('//fonts.googleapis.com/css?family=Quicksand:400,300',"screen");
Yii::app()->clientScript->registerCSSFile('//fonts.googleapis.com/css?family=Open+Sans:400,800,700,600',"screen");
*/

Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/normalize.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/bootstrap/bootstrap.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/bootstrap-switch.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/cross-browser.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/typography.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/image-picker.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/jqueryui/theme.css',"screen");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/jqueryui/slider.css',"screen");
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