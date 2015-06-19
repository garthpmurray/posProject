<?php $form=$this->beginWidget('CActiveForm'); ?>
        <div class="panel panel-white">
            <div class="panel-heading border-light">
                <h4>
        <?php if( $model->scenario==='update' ){ ?>
                   <?php echo Rights::getAuthItemTypeName($model->type); ?> 
        <?php }else{
            echo Rights::t('core', 'Create :type', array(
                ':type'=>Rights::getAuthItemTypeName($_GET['type']),
            ));
        } ?>
                </h4>
                <ul class="panel-heading-tabs border-light">
                    <li style="height:70px;padding:10px 15px;">
                    <?php echo GxHtml::submitButton(Rights::t('core', 'Save'), array('class' => 'btn margin-fix btn-primary', 'style' => 'min-height: 40px; display: block; float: left; border-radius: 0px 0px 0px 0px;'));?>
                    </li>
                    <?php /* echo CHtml::link(Rights::t('core', '<div id="cancelButton" class="btn margin-fix btn-warning">Cancel</div>'), Yii::app()->user->rightsReturnUrl); */ ?>
                </ul>
            </div>
            <div class="panel-body">

        <table class="no-border table">
            <tbody>
                <tr class="controls">
                    <th><?php echo $form->labelEx($model, 'name'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'name', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'name'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'Do not change the name unless you know what you are doing.'); ?></p>
                    </td>
                </tr>
                <tr class="controls">
                    <th><?php echo $form->labelEx($model, 'description'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'description', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'description'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'A descriptive name for this item.'); ?></p>
                    </td>
                </tr>
    <?php if( Rights::module()->enableBizRule===true ): ?>
                <tr class="controls">
                    <th><?php echo $form->labelEx($model, 'bizRule'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'bizRule', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'bizRule'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'Code that will be executed when performing access checking.'); ?></p>
                    </td>
                </tr>
    <?php endif; ?>

    <?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>
                <tr class="controls">
                    <th><?php echo $form->labelEx($model, 'data'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'data', array('maxlength'=>255, 'class'=>'text-field')); ?>
                        <?php echo $form->error($model, 'data'); ?>
                        <p class="hint"><?php echo Rights::t('core', 'Additional data available when executing the business rule.'); ?></p>
                    </td>
                </tr>
    <?php endif; ?>
                </tbody>
            </table>
<?php /*            <div class="clearfix">
        <?php echo CHtml::submitButton(Rights::t('core', 'Save'), array('class'=>'twoSubmitButtons left')); ?>
        <?php echo CHtml::link(Rights::t('core', '<div id="cancelButton" class="twoSubmitButtons right">Cancel</div>'), Yii::app()->user->rightsReturnUrl); ?>
            </div>*/ ?>

            </div>
        </div>
<?php $this->endWidget(); ?>
