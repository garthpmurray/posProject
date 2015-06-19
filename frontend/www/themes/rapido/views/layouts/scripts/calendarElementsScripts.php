<?php
    $cs = Yii::app()->getClientScript();
    $aliasDir = Yii::getPathOfAlias('application.www.themes.rapido');
    
    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js'), CClientScript::POS_END);
//    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'), CClientScript::POS_END);
//    $cs->registerScriptFile(Yii::app()->assetManager->publish($aliasDir.'/assets/js/pages-calendar.js'), CClientScript::POS_END);
    
    
     Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl.'/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css');
