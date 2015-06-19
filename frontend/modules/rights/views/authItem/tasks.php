<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Tasks'),
);

$this->title = Rights::t('core', 'Manage Tasks');
$this->subTitle = Rights::t('core', 'A task is a permission to perform multiple operations, for example accessing a group of controller action.');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <blockquote>
                	<p><?php echo Rights::t('core', 'Tasks exist below roles in the authorization hierarchy and can therefore only inherit from other tasks and/or operations.'); ?></p>
                </blockquote>
                <p class="alert alert-info fade in"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></p>
	        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
<?php $this->widget('SarabonDataGrid', array(
    'dataProvider'=>$dataProvider,
    //'template'=>'{items}',
    'emptyText'=>Rights::t('core', 'No tasks found.'),
	'htmlOptions'=>array('class'=>'formStyle noiseGeneration theadActive', 'style' => 'display: block;'),
    'widgetType'	=> 'nonboxy-widget',
    'title' => '',
    'columns'=>array(
		array(
			'name'=>'name',
			'header'=>Rights::t('core', 'Name'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'name-column'),
			'value'=>'$data->getGridNameLink()',
		),
		array(
			'name'=>'description',
			'header'=>Rights::t('core', 'Description'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'description-column'),
		),
		array(
			'name'=>'bizRule',
			'header'=>Rights::t('core', 'Business rule'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'bizrule-column'),
			'visible'=>Rights::module()->enableBizRule===true,
		),
		array(
			'name'=>'data',
			'header'=>Rights::t('core', 'Data'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'data-column'),
			'visible'=>Rights::module()->enableBizRuleData===true,
		),
		array(
			'header'=>'&nbsp;',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'actions-column'),
			'value'=>'$data->getDeleteTaskLink()',
		),
    )
)); ?>
    </div>
</div>