<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignments')=>array('assignment/view'),
	$model->getName(),
);

$this->title = Rights::t('core', 'Assignments');
$this->subTitle = Rights::t('core', 'For :username', array(
		':username'=>$model->getName()
	));

?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-heading">
				<h4 class="panel-title">Fixed Width <span class="text-bold">Icons</span></h4>
				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a data-toggle="modal" href="#panel-config" class="btn btn-xs btn-link panel-config">
						<i class="fa fa-wrench"></i>
					</a>
					<a href="#" class="btn btn-xs btn-link panel-refresh">
						<i class="fa fa-refresh"></i>
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-resize-full"></i>
					</a>
					<a href="#" class="btn btn-xs btn-link panel-close">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
			
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="panel panel-white">
			<table class="rights form-horizontal table well" style="table-layout:auto;">
				<thead>
					<th>Name</th>
					<th>Type</th>
					<th></th>
				</thead>
				<tbody>
<?php
$data = $dataProvider->getData();
	foreach($data as $d){ ?>
					<tr>
						<td><?php echo $d->getNameText(); ?></td>
						<td><?php echo $d->getTypeText(); ?></td>
						<td><?php echo $d->getRevokeAssignmentLink(); ?></td>
					</tr>
<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php if( $formModel!==null ): ?>
			<?php $this->renderPartial('_form', array(
				'model'=>$formModel,
				'itemnameSelectOptions'=>$assignSelectOptions,
			)); ?>
	<?php else:?>
	<div class="col-md-6 col-xs-12">
		<div class="panel panel-white">
			<table class="form-horizontal table well">
				<tbody>
					<tr>
						<td>
							<p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif; ?>
</div>


<section class="row-fluid">
	<section class="span6">
		<div class="nonboxy-widget">
		    <div class="widget-content">
		        <div class="widget-box">
		        </div>
		    </div>
		</div>
	</section>


			<?php if( $formModel!==null ): ?>
					<?php /*
$this->renderPartial('_form', array(
						'model'=>$formModel,
						'itemnameSelectOptions'=>$assignSelectOptions,
					)); 
*/?>
			<?php else:?>
	<section class="span6">
		<div class="nonboxy-widget">
		    <div class="widget-content">
		        <div class="widget-box">
					<table class="form-horizontal table well">
						<tbody>
							<tr>
								<td>
									<p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>
								</td>
							</tr>
						</tbody>
					</table>
		        </div>
		    </div>
		</div>
	</section>
			<?php endif; ?>
	
</section>
