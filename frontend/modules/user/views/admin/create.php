<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Create'),
);

$this->menu=array(
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
/*     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')), */
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);

$this->title = UserModule::t('Create User');

?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>
        </div>
    </div>
</div>
