<div class="well">
        
    <?php     $form = $this->beginWidget('GxActiveForm', array(
    	'id' => 'config-form',
    	'enableAjaxValidation' => false,
    ));
    ?>    
    
    	<p class="note">
    		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    	</p>
    
    	<?php echo $form->errorSummary($model); ?>
    
        <div class="row form-group">
    		<?php echo $form->labelEx($model,'name',array('class' => 'col-xs-12 col-md-2')); ?>
            <div class="col-xs-12 col-md-10">
    		<?php echo $form->textField($model, 'name', array('style' => 'width:100%')); ?>
    		<?php echo $form->error($model,'name'); ?>
            </div>
        </div><!-- row -->
        <div class="row form-group">
    		<?php echo $form->labelEx($model,'content',array('class' => 'col-xs-12 col-md-2')); ?>
            <div class="col-xs-12 col-md-10">
    		<?php echo $form->textArea($model, 'content', array('style' => 'width:100%')); ?>
    		<?php echo $form->error($model,'content'); ?>
            </div>
        </div><!-- row -->
        <div class="row form-group">
    		<?php echo $form->labelEx($model,'assigned_system_software',array('class' => 'col-xs-12 col-md-2')); ?>
            <div class="col-xs-12 col-md-10">
    		<?php echo $form->dropDownList($model, 'assigned_system_software', array('' => '-- Choose One --')+GxHtml::listDataEx(Software::model()->systemType()->findAllAttributes(null, true)), array('style' => 'width:100%')); ?>
    		<?php echo $form->error($model,'assigned_system_software'); ?>
            </div>
        </div><!-- row -->
        <div class="row form-group">
    		<?php echo $form->labelEx($model,'assigned_data_software',array('class' => 'col-xs-12 col-md-2')); ?>
            <div class="col-xs-12 col-md-10">
    		<?php echo $form->dropDownList($model, 'assigned_data_software', array('' => '-- Choose One --')+GxHtml::listDataEx(Software::model()->dataType()->findAllAttributes(null, true)), array('style' => 'width:100%')); ?>
    		<?php echo $form->error($model,'assigned_data_software'); ?>
            </div>
        </div><!-- row -->
        
    <div class="row">
    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'), array('class' => 'btn btn-success col-xs-12'));
    ?>
    </div>
    <?php $this->endWidget(); ?>
</div>