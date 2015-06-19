<?php
    $cs = Yii::app()->getClientScript();
    $aliasDir = Yii::getPathOfAlias('application.www.themes.rapido');
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery.pulsate/jquery.pulsate.min.js'), CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/js/pages-user-profile.js'), CClientScript::POS_END);

    Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl . '/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css',"screen");

