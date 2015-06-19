<?php
    $cs = Yii::app()->getClientScript();
    $aliasDir = Yii::getPathOfAlias('application.www.themes.rapido');
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/autosize/jquery.autosize.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/select2/select2.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery-maskmoney/jquery.maskMoney.js'), CClientScript::POS_END);

    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-daterangepicker/daterangepicker.js'), CClientScript::POS_END);

    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-datetimepicker/js/moment-with-locales.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'), CClientScript::POS_END);


    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jQuery-Tags-Input/jquery.tagsinput.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js'), CClientScript::POS_END);


    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-colorpicker/js/commits.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js'), CClientScript::POS_END);
/*
*/
    
/*
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/ckeditor/ckeditor.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/ckeditor/adapters/jquery.js'), CClientScript::POS_END);
*/
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/js/form-elements.js'), CClientScript::POS_END);
    
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/select2/select2.css');
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/datepicker/css/datepicker.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css');
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css');
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css');
    
    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css');
