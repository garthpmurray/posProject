<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n
\$this->breadcrumbs = array(
	\$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);\n";
?>

$this->title = Yii::t('app', 'Create');
$this->subTitle = GxHtml::encode($model->label());

$this->menu = array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
);
?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
<?php echo "<?php\n"; ?>
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
<?php echo '?>'; ?>
        </div>
    </div>
</div>