<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
    UserModule::t("Profile")=>array('profile'),
    UserModule::t("Edit"),
);
$this->menu=array(
    ((UserModule::isAdmin())
        ?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
        :array()),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

$this->title = UserModule::t('Edit profile');

?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
<?php endif; ?>
<div class="well">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'profile-form',
    'enableAjaxValidation'=>true,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary(array($model,$profile), '<div class="errorHandler alert alert-danger"> You have some form errors. Please check below.', '</div>'); ?>

<?php 
        $profileFields=Profile::getFields();
        if ($profileFields) {
            foreach($profileFields as $field) {
            ?>
        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
                <?php echo $form->labelEx($profile,$field->varname); ?>
            </div>
<?php
            if ($widgetEdit = $field->widgetEdit($profile)) {
                echo $widgetEdit;
            } elseif ($field->range) {
                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
                echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class'=>'col-xs-12 col-sm-10'));
            } else {
                echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'col-xs-12 col-sm-10'));
            }
?>
        </div>
            <?php
            }
        }
?>
        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
                <?php echo $form->labelEx($model,'username'); ?>
            </div>
            <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class'=>'col-xs-12 col-sm-10')); ?>
        </div>

        <div class="row form-group">
            <div class="col-xs-12 col-sm-2">
                <?php echo $form->labelEx($model,'email'); ?>
            </div>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'col-xs-12 col-sm-10')); ?>
        </div>

    <div class="row">
        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn btn-success col-xs-12')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
        </div>
    </div>
</div>
