<?php
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
);
$this->title = Rights::t('core', 'Create :type', array(
		':type'=>Rights::getAuthItemTypeName($_GET['type']),
	));

?>
<div class="row">
    <div class="col-md-12">
		<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
	</div>
</div>