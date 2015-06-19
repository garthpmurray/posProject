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

<?php $form=$this->beginWidget('CActiveForm'); ?>
<div class="panel panel-white">
    <div class="panel-heading border-light">
        <h4>Add Children</h4>
        <ul class="panel-heading-tabs border-light">
            <li style="height:70px;padding:10px 15px;">
                <?php echo GxHtml::submitButton(Rights::t('core', 'Add'), array('class' => 'btn margin-fix btn-primary', 'style' => 'min-height: 40px;'));?>
            </li>
        </ul>
    </div>
    <div class="panel-body">
        <table class="table no-border">
            <tbody>
                <tr>
                    <td style="width:100px"><?php echo Rights::t('core', 'Add Child'); ?></td>
                    <td>
                        <select style="width: 100%;" id="AuthChildForm_itemname" name="AuthChildForm[itemname]">
                        <?php   foreach($itemnameSelectOptions as $key => $value){ ?>
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
</div>
<?php $this->endWidget(); ?>
