<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label' => Yii::t('app', 'View') . ' ' . $model->label(), 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);

$this->title = Yii::t('app', 'Update');
$this->subTitle = GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));

?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>
        </div>
    </div>
</div>