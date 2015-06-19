<?php
	function subSelectDisplay($data, $count = 0){
		$count++;
		$text = "";
		foreach($data as $key=>$value){
			if(is_array($value)){
				$text .= "<optgroup class=\"optGroup{$count}\" label=\"{$key}\">\r\n";
				$text .= subSelectDisplay($value, $count);
				$text .= "</optgroup>\r\n";
			}else{
				$breakapart = explode('.', $value);
				$display = end($breakapart);
				$text .= "<option value=\"{$value}\">{$value}</option>\r\n";
			}
		}
		return $text;
	}
?>

<div class="col-md-6 col-xs-12">
	<div class="panel panel-white">
<?php $form=$this->beginWidget('CActiveForm'); ?>
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Rights::t('core', 'Assign item'); ?></h4>
			<div class="panel-tools">
				<?php echo GxHtml::submitButton(Rights::t('core', 'Assign'), array('class' => 'btn margin-fix btn-primary', 'style' => 'min-height: 40px;'));?>
			</div>
		</div>
		<div class="panel-body">
			<table class="form-horizontal table">
				<tbody>
					<tr>
						<td>
							<select multiple="multiple" style="width: 100%; min-height: 250px;" id="AssignmentForm_itemname" name="AssignmentForm[][itemname]">
						<?php	foreach($itemnameSelectOptions as $key => $value){ ?>
									<optgroup label="<?php echo $key; ?>">
										<?php
										foreach($value as $permissionKey => $permissionValue){
											if($key == 'Operations'){
												$breakapart = explode('.', $permissionKey);
												$operationsGroup[$breakapart[0]] [$breakapart[1]] [] = $permissionValue;
											}else{ ?>
												<option value="<?php echo $permissionKey; ?>"><?php echo $permissionValue; ?></option>
										<?php }
										}
										
										if($key == 'Operations'){
											echo subSelectDisplay($operationsGroup);
										}
										
										?>
									</optgroup>
							<?php } ?>
							</select>
								<?php // echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
								<?php echo $form->error($model, 'itemname'); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
<?php $this->endWidget(); ?>
	</div>
</div>