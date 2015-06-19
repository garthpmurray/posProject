<?php
/**
 * @var $this YiiDebugToolbarPanelVarDumper
 */
?>
<div data-ydtb-panel-data="<?php echo $this->id ?>">
	<div>
		<div data-ydtb-accordion="<?php echo $this->id?>">
		<?php
		foreach( $this->getLogs() as $category => $categoryLogs ) {
			$c = 0;
		?>
			<div data-ydtb-accordion-group="collapsed">
				<div data-ydtb-accordion-heading="" data-ydtb-data-size="<?php echo count($categoryLogs)?>">
					<i data-ydtb-icon="s"></i>
					<span><?php echo $category?></span>
					<i data-ydtb-icon="q"></i>
					<i data-ydtb-icon="t"></i>
					<div class="clear clearfix"></div>
				</div>
				<div data-ydtb-accordion-body="">
					<table data-ydtb-data-table="fixed">
						<thead>
							<tr>
								<th><?=YiiDebug::t('Value')?></th>
								<th width="10%"><?=YiiDebug::t('Time')?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach( $categoryLogs as $log ) { ?>
							<tr>
								<td><?php echo $log[0]; ?></td>
								<td style="vertical-align: top;"><?php echo date('H:i:s.',$log[3]).sprintf('%06d',(int)(($log[3]-(int)$log[3])*1000000)); ?></td>
							</tr>
							<?php $c++;
								} ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>