<script type="text/javascript">
$(document).ready(function() {
    $('#UserLimitedData_model_name').change(function(){
        $.post( "/limitedData/getModelData", {modelName: $(this).val()}, function( data ) {
            $( ".result" ).html( data );
        });
    })
});
</script>
<div class="well">
    <?php     $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'user-limited-data-form',
        'enableAjaxValidation' => false,
    ));
    ?>    
    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>
    <?php echo $form->errorSummary($model); ?>
    <div class="row form-group">
        <?php echo $form->labelEx($model,'user_id',array('class' => 'col-xs-12 col-md-2')); ?>
        <div class="col-xs-12 col-md-10">
            <?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'user_id'); ?>
        </div>
    </div>
<? /*
    <div class="row form-group">
        <?php echo $form->labelEx($model,'table_name',array('class' => 'col-xs-12 col-md-2')); ?>
        <div class="col-xs-12 col-md-10">
            <?php echo $form->textField($model, 'table_name'); ?>
            <?php echo $form->error($model,'table_name'); ?>
        </div>
    </div>
*/ ?>
    <div class="row form-group">
        <?php echo $form->labelEx($model,'model_name',array('class' => 'col-xs-12 col-md-2')); ?>
        <div class="col-xs-12 col-md-10">
            <?php echo $form->dropDownList($model, 'model_name', array('' => 'Select Model')+$models); ?>
            <?php // echo $form->textField($model, 'model_name'); ?>
            <?php echo $form->error($model,'model_name'); ?>
        </div>
    </div>
    <div class="row form-group">
        <?php echo $form->labelEx($model,'data_id',array('class' => 'col-xs-12 col-md-2')); ?>
        <div class="col-xs-12 col-md-10">
            <div class="result">
                <?= $select ?>
            </div>
            <?php echo $form->error($model,'data_id'); ?>
        </div>
    </div>
    <div class="row">
        <?= GxHtml::submitButton(Yii::t('app', 'Save'), array('class' => 'btn btn-success col-xs-12')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>