<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->menu=array(
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
);
?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">

<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>