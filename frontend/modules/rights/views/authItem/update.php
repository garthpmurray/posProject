<?php
	$this->breadcrumbs = array(
    	'Rights'=>Rights::getBaseUrl(),
    	Rights::getAuthItemTypeNamePlural($model->type)=>Rights::getAuthItemRoute($model->type),
    	$model->name,
    );
$this->title = Rights::t('core', 'Update :name', array(
		':name'=>$model->name,
		':type'=>Rights::getAuthItemTypeName($model->type),
	));

?>
<div class="row">
	<div class="col-xs-12 col-md-6">
			<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
            <div class="row">
                <div class="col-xs-12">
				<?php if( $childFormModel!==null ): ?>

					<?php $this->renderPartial('_childForm', array(
						'model'=>$childFormModel,
						'itemnameSelectOptions'=>$childSelectOptions,
					)); ?>

				<?php else: ?>
					<p class="alert fade in"><?php echo Rights::t('core', 'No children available to be added to this item.'); ?></p>
				<?php endif; ?>
                </div>
			</div>
		</div>

	<div class="col-xs-12 col-md-6">
		<div class="row">
			<?php if( $model->name!==Rights::module()->superuserName ): ?>
			    <div class="col-xs-12">
					<div class="panel panel-white">
                        <div class="panel-heading">
                            <h4><?php echo Rights::t('core', 'Relations'); ?> - <?php echo Rights::t('core', 'Parents'); ?></h4>
						</div>
                        <div class="panel-body">
							<table class="table no-border" style="table-layout: auto;">
								<tbody>
								<?php
								$data = $parentDataProvider->getData();
								if(!empty($data)){
									foreach($data as $d) { ?>
									<tr>
										<td style="width:40%"><?php echo $d->getNameLink(); ?></td>
										<td style="width:60%"><?php echo $d->getTypeText(); ?></td>
									</tr>
								<?php }
								}else{ ?>
									<tr>
										<td colspan="3">This item has no parents</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
			    </div>
			    <div class="col-xs-12">
					<div class="panel panel-white">
                        <div class="panel-heading">
                            <h4><?php echo Rights::t('core', 'Relations'); ?> - <?php echo Rights::t('core', 'Children'); ?></h4>
						</div>
                        <div class="panel-body">
							<table class="table no-border" style="table-layout: auto;">
								<tbody>
								<?php
								$data = $childDataProvider->getData();
								if(!empty($data)){
									foreach($data as $d){ ?>
									<tr>
										<td style="width:40%"><?php echo $d->getNameLink(); ?></td>
										<td style="width:50%"><?php echo $d->getTypeText(); ?></td>
										<td style="width:10%"><?php echo $d->getRemoveChildLink(); ?></td>
									</tr>
								<?php }
								}else{ ?>
									<tr>
										<td colspan="3">This item has no children</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
			    </div>
			<?php else: ?>
			    <div class="col-xs-12">
					<div class="panel panel-white">
                        <div class="panel-body">
            				<p class="alert fade in">
            					<?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br />
            					<?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>
            				</p>
                        </div>
					</div>
			    </div>
			<?php endif; ?>
    		</div>
		</div>
	</div>
</div>