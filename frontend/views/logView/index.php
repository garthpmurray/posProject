<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('log-view-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->title = 'Manage';
$this->subTitle = GxHtml::encode($model->label(2));
?>
<div class="col-md-12">
    <?php $widget->run(); ?>
</div>