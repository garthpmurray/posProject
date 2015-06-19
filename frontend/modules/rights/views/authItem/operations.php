<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Operations'),
);

$this->title = Rights::t('core', 'Manage Operations');
$this->subTitle = Rights::t('core', 'An operation is a permission to perform a single operation, for example accessing a certain controller action.');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <blockquote>
                	<p><?php echo Rights::t('core', 'Operations exist below tasks in the authorization hierarchy and can therefore only inherit from other operations.'); ?></p>
                	<p>Editing this page should only be done by developers! This directly affects the underlying code checks for permissions. It could cause things to not work or work unexpectedly if you do not know what you are doing.</p>
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
    'template'=>'{items}',
    'emptyText'=>Rights::t('core', 'No operations found.'),
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
			'value'=>'$data->getDeleteOperationLink()',
		),
    )
)); ?>
    </div>
</div>