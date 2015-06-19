<!-- start: FORGOT BOX -->
<div class="box-login">
    <h3><?php echo UserModule::t("Restore"); ?></h3>
    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
    <?php else: ?>
    <p>Enter your e-mail address below to reset your password.</p>
    <?php echo CHtml::beginForm('/user/recovery', 'post', array(
                'class' => 'form-forgot',
            )); ?>
        
            <?php echo CHtml::errorSummary($form, '<div class="errorHandler alert alert-danger"> You have some form errors. Please check below.', '</div>'); ?>
            <fieldset>
                <div class="form-group">
                    <span class="input-icon">
            		<?php echo CHtml::activeTextField($form,'login_or_email', array('class' => 'form-control', 'placeholder' => 'Email')) ?>
                        <i class="fa fa-envelope"></i> </span>
                </div>
                <div class="form-actions">
                    <a class="btn btn-light-grey go-back">
                        <i class="fa fa-chevron-circle-left"></i> Log-In
                    </a>
                    <button type="submit" class="btn btn-green pull-right">
                        Submit <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </fieldset>
        <?php echo CHtml::endForm();
    endif; ?>
    <!-- start: COPYRIGHT -->
    <div class="copyright">
        <?= date('Y') ?> &copy; Signage by Sourcetoad.
    </div>
    <!-- end: COPYRIGHT -->
</div>
<!-- end: FORGOT BOX -->
