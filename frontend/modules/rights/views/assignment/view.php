<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignments'),
);

$this->title = Rights::t('core', 'Assignments');
$this->subTitle = Rights::t('core', 'Here you can view which permissions has been assigned to each user.');

?>

		<?php $this->widget('SarabonDataGrid', array(
			'dataProvider'=>$dataProvider,
			//'template'=>"{items}\n{pager}",
			'emptyText'=>Rights::t('core', 'No users found.'),
			'htmlOptions' => array('class'=>'formStyle noiseGeneration theadActive', 'style' => 'display: block;'),
			'widgetType'	=> 'nonboxy-widget',
			'title' => 'Manage User Assignments',
			'columns'=>array(
				array(
					'name'=>'name',
					'header'=>Rights::t('core', 'Name'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'name-column'),
					'value'=>'$data->getAssignmentNameLink()',
				),
				array(
					'name'=>'assignments',
					'header'=>Rights::t('core', 'Roles'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'role-column'),
					'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
				),
				array(
					'name'=>'assignments',
					'header'=>Rights::t('core', 'Tasks'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'task-column'),
					'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
				),
				array(
					'name'=>'assignments',
					'header'=>Rights::t('core', 'Operations'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'operation-column'),
					'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
				),
			)
		)); ?>