<?php
    require_once('scripts.php');
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="language" content="en" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=1">
        <meta name="author" content="Garth Murray">
        
        <link rel="apple-touch-icon-precomposed" href="<?= Yii::app()->theme->baseUrl ?>/img/touch-icon-iphone.png">
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?= Yii::app()->theme->baseUrl ?>/img/touch-icon-ipad.png">
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= Yii::app()->theme->baseUrl ?>/img/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= Yii::app()->theme->baseUrl ?>/img/touch-icon-ipad-retina.png">
        
        <link rel="icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon-16.png" sizes="16x16">
        <link rel="icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon-32.png" sizes="32x32">
        <link rel="icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon-48.png" sizes="48x48">
        <link rel="icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon-64.png" sizes="64x64">
        <link rel="icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon-128.png" sizes="128x128">
        <title><?php echo $this->pageTitle; ?></title>
    </head>

    <body class="container">
        <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._header'); ?>
        <?php if (isset($this->breadcrumbs) && !empty($this->breadcrumbs)){ ?>
            <div class="breadcrumb" style="position:relative;">
                <ul>
                    <?php $this->widget('ExtendedBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                        'encodeLabel' => false,
                    )); ?><!-- breadcrumbs -->
                </ul>
            </div>
        <?php } ?>
        
        <div class="row affix-top" data-spy="affix" data-offset-top="0">
            Test
        </div>
        
        <div class="row affix-top" data-spy="affix" data-offset-top="70">
            <div id="main_status_bar">
                <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._statusbar'); ?>
            </div>
        </div>
        <div class="row">
            <?php echo $content; ?>
            <div class="push"></div>
        </div><!-- wrap -->
        <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._footer'); ?>
        <?php if(Yii::app()->user->isGuest){
            //  echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._modalLogin');
            } ?>
        <?php // echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._modal', array('modalID' => 'dl-modal')); ?>
    </body>
</html>