<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change password"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

$this->title = UserModule::t("Change password");

?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
            <div class="well">
            <?php $form=$this->beginWidget('CActiveForm', array(
            	'id'=>'changepassword-form',
            	'enableAjaxValidation'=>true,
            	'clientOptions'=>array(
            		'validateOnSubmit'=>true,
            	),
            )); ?>
            
            	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
            	<?php echo $form->errorSummary($model, '<div class="errorHandler alert alert-danger"> You have some form errors. Please check below.', '</div>'); ?>
            	
        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
            	<?php echo $form->labelEx($model,'oldPassword'); ?>
            </div>
        	<?php echo $form->passwordField($model,'oldPassword', array('class'=>'col-xs-12 col-sm-10')); ?>
    	</div>
            	
        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
            	<?php echo $form->labelEx($model,'password'); ?>
            </div>
        	<?php echo $form->passwordField($model,'password', array('class'=>'col-xs-12 col-sm-10')); ?>
        	<p class="col-xs-12 hint">
        	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
        	</p>
    	</div>
            	
        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
            	<?php echo $form->labelEx($model,'verifyPassword'); ?>
            </div>
        	<?php echo $form->passwordField($model,'verifyPassword', array('class'=>'col-xs-12 col-sm-10')); ?>
        </div>
            	
                <div class="row form-group">
            	    <?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn btn-success col-xs-12')); ?>
            	</div>
            <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
