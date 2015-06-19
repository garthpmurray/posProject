<?php
$cs = Yii::app()->getClientScript();
$cs->scriptMap['jquery.js'] = '/common/lib/assets/js/jquery.2.0.3.min.js';

$cs->registerCoreScript('jquery');

$corePackageHead = array(
    'basePath' => 'application.www.themes.rapido',
    'js'       => array(),
    'depends'  => array('jquery'),
    'position' => CClientScript::POS_HEAD,
);
$corePackage = array(
    'basePath' => 'application.www.themes.rapido',
    'css'   => array(
        'css/jqueryui/theme.css',
        'css/jqueryui/slider.css',
// start: MAIN CSS -->
        'assets/plugins/bootstrap/css/bootstrap.min.css',
        'assets/plugins/font-awesome/css/font-awesome.min.css',
        'assets/plugins/iCheck/skins/all.css',
        'assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css',
        'assets/plugins/animate.css/animate.min.css',
// end: MAIN CSS -->
// start: CORE CSS -->
        'assets/css/styles.css',
        'assets/css/styles-responsive.css',
        'assets/css/plugins.css',
        'assets/css/themes/theme-default.css',
//        'assets/css/print.css',
// end: CORE CSS -->
        'js/fancybox/jquery.fancybox.css',
    ),
    'js'      => array(
        'js/jquery.validate.js',
        'js/fancybox/jquery.fancybox.pack.js',
//  start: MAIN JAVASCRIPTS -->
        'assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js',
        'assets/plugins/bootstrap/js/bootstrap.min.js',
        'assets/plugins/blockUI/jquery.blockUI.js',
        'assets/plugins/iCheck/jquery.icheck.min.js',
        'assets/plugins/moment/min/moment.min.js',
        'assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js',
        'assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js',
        'assets/plugins/bootbox/bootbox.min.js',
        'assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js',
        'assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js',
        'assets/plugins/jquery.appear/jquery.appear.js',
        'assets/plugins/jquery-cookie/jquery.cookie.js',
        'assets/plugins/velocity/jquery.velocity.min.js',
//  end: MAIN JAVASCRIPTS -->
//  start: CORE JAVASCRIPTS  -->
        'assets/js/main.js',
//  end: CORE JAVASCRIPTS  -->
        'js/jqueryui/core.js',
        'js/jqueryui/widget.js',
        'js/jqueryui/mouse.js',
        'js/jqueryui/sortable.js',
        'js/jqueryui/slider.js',
        'js/tinymce/tinymce.min.js',
        'js/tinymce/jquery.tinymce.min.js',
    ),
    'depends' => array('jquery'),
    'position' => CClientScript::POS_END,
);

$cs->addPackage('corePackageHead', $corePackageHead)->registerPackage('corePackageHead');
$cs->addPackage('corePackage', $corePackage)->registerPackage('corePackage');

Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/css/print.css',"print");
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/css/main.css');
$cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('common.lib.assets').'/js/jquery.unveil.js'), CClientScript::POS_HEAD);

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