<h1>Wsdl2php Generator</h1>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'wsdlUrl'); ?>
        <div class="hint">
            Example: http://soap.amazon.com/schemas2/AmazonWebServices.wsdl
        </div>
        <?php echo $form->textField($model,'wsdlUrl',array('size'=>100)); ?>
        <div class="tooltip">
            The url of the wsdl document
        </div>
        <?php echo $form->error($model,'wsdlUrl'); ?>
    </div>
    <br/>
    <div class="row">
        <?php echo $form->labelEx($model,'serviceClassName'); ?>
        <div class="hint">
            Example: Amazon
        </div>
        <?php echo $form->textField($model,'serviceClassName',array('size'=>65)); ?>
        <div class="tooltip">
            The name of the generated class file
        </div>
        <?php echo $form->error($model,'serviceClassName'); ?>
    </div>
    <br/>
    <div class="row">
        <?php echo $form->labelEx($model,'classDirectory'); ?>
        <div class="hint">
            Add the alias path where the class is generated. Default is 'application.components'
        </div>
        <?php echo $form->textField($model,'classDirectory',array('size'=>65)); ?>
		<div class="tooltip">
            Ensure this directory is writeable
        </div>
        <?php echo $form->error($model,'classDirectory'); ?>
    </div>
    <br/>
    <h3>Advanced</h3>
    <div class="row">
        <?php echo $form->labelEx($model,'clientClassExtends'); ?>
        <div class="hint">
            Enter a classname if the main client class should extend a existing Yii class
        </div>
        <?php echo $form->textField($model,'clientClassExtends',array('size'=>65)); ?>
        <div class="tooltip">
            Examples: CComponent, BaseClient ...
        </div>
        <?php echo $form->error($model,'clientClassExtends'); ?>
    </div>
    <br/>
    <div class="row">
        <?php echo $form->labelEx($model,'paramClassExtends'); ?>
        <div class="hint">
            Enter a classname if all param classes should extend a existing Yii class
        </div>
        <?php echo $form->textField($model,'paramClassExtends',array('size'=>65)); ?>
        <div class="tooltip">
            Examples: CComponent, BaseParam ...
        </div>
        <?php echo $form->error($model,'paramClassExtends'); ?>
    </div>
    <br/>
<?php $this->endWidget(); ?>