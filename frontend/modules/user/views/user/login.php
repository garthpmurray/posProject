<!-- start: LOGIN BOX -->
<div class="box-login">
    <h3>Sign in to your account</h3>
    <p>Please enter your name and password to log in.</p>
    <?= $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._statusbar'); ?>
    <?php if(Yii::app()->user->hasFlash('loginMessage') || Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
        </div>
    <?php endif; ?>
    <?php echo CHtml::beginForm('/user/login', 'post', array(
        'class' => 'form-login',
    )); ?>
        <?php echo CHtml::errorSummary($model, '<div class="errorHandler alert alert-danger"> You have some form errors. Please check below.', '</div>'); ?>
        <fieldset>
            <div class="form-group">
                <span class="input-icon">
                    <?php echo CHtml::activeTextField($model,'username', array('placeholder' => 'Username', 'class' => 'form-control')) ?>
                    <i class="fa fa-user"></i> </span>
            </div>
            <div class="form-group form-actions">
                <span class="input-icon">
                    <?php echo CHtml::activePasswordField($model,'password', array('placeholder' => 'Password', 'class' => 'form-control password')); ?>
                    <i class="fa fa-lock"></i>
                    <a class="forgot" href="#">
                        I forgot my password
                    </a> </span>
            </div>
            <div class="form-actions">
                <label for="remember" class="checkbox-inline">
                    <?php echo CHtml::activeCheckBox($model,'rememberMe', array('class' => 'grey remember')); ?>
                    Keep me signed in
                </label>
                <button type="submit" class="btn btn-green pull-right">
                    Login <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>

<?php
    /*
        <div class="row">
            <?php echo CHtml::activeLabelEx($model,'username'); ?>
            <?php echo CHtml::activeTextField($model,'username') ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::activeLabelEx($model,'password'); ?>
            <?php echo CHtml::activePasswordField($model,'password') ?>
        </div>
        
        <div class="row">
            <p class="hint">
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>
        
        <div class="row rememberMe">
            <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
            <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
        </div>
    
        <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Login")); ?>
        </div>
    */
?>

        </fieldset>
    <?php echo CHtml::endForm(); ?>
    <!-- start: COPYRIGHT -->
    <div class="copyright">
        <?= date('Y') ?> &copy; Signage by Sourcetoad.
    </div>
    <!-- end: COPYRIGHT -->
</div>
<!-- end: LOGIN BOX -->
<!-- start: FORGOT BOX -->
<div class="box-forgot">
    <h3><?php echo UserModule::t("Restore"); ?></h3>
    <p>Enter your e-mail address below to reset your password.</p>
    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
    <?php else:
        echo CHtml::beginForm('/user/recovery', 'post', array(
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
