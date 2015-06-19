<?php
    require_once('scripts.php');
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?php echo $this->pageTitle; ?></title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- end: META -->
        
        <link rel="shortcut icon" href="<?= Yii::app()->params['system']['favicon'] ?>" />
    </head>
    <!-- end: HEAD -->
    <body>
        <?php // echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._slidingBar'); ?>
		<div class="main-wrapper">
            <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._header'); ?>
            <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._sidebarLeft'); ?>
            <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._sidebarRight'); ?>
            <!-- start: MAIN CONTAINER -->
            <div class="main-container inner">
                <!-- start: PAGE -->
                <div class="main-content">
                    <div class="container">
                        <!-- start: PAGE HEADER -->
                        <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._toolbarHeader'); ?>
                        <!-- end: PAGE HEADER -->
                        <!-- start: BREADCRUMB -->
                        <div class="row">
                            <div class="col-md-12">
                                <ol class="breadcrumb">
                                    <?php $this->widget('ExtendedBreadcrumbs', array(
                                        'links' => $this->breadcrumbs,
                                        'encodeLabel' => false,
                                    )); ?><!-- breadcrumbs -->
                                </ol>
                            </div>
                            <div class="col-md-12">
                                <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._statusbar'); ?>
                            </div>
                        </div>
                        <!-- end: BREADCRUMB -->
                    <?php echo $content; ?>
                    </div>
                    <div class="subviews">
                        <div id="subViewContainer" class="subviews-container"></div>
                    </div>
                </div>
                <!-- end: PAGE -->
            </div>
            <!-- end: MAIN CONTAINER -->
            <?php echo $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._footer'); ?>
		</div>
    </body>
</html>
