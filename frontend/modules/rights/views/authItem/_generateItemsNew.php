<?php

if(!empty($items['controllers'])){
    foreach($items['controllers'] as $key => $item){
        $unused = 0;
        if(isset($item['actions']) && !empty($item['actions'])){
            $controllerKey = isset($moduleName) ? ucfirst($moduleName).'.'.$item['name'] : $item['name'];
            $controllerExists = isset($existingItems[ $controllerKey.'.*' ]);
            $unused = $controllerExists ? $unused : $unused+1;
?>
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><label for="" style="font-weight:700;text-transform: capitalize;"><?= $item['name'] ?></label></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"><i class="fa fa-cog"></i></a>
                    <ul style="display: none;" role="menu" class="dropdown-menu dropdown-light pull-right">
                        <li><a href="#" class="panel-collapse collapses"><i class="fa fa-angle-up"></i> <span>Collapse</span></a></li>
                        <li><a href="#" class="panel-expand"><i class="fa fa-expand"></i> <span>Fullscreen</span></a></li>
                        <li><a href="#" class="panel-check-all"><i class="fa fa-square-o"></i> <span>Check All</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="rights form-horizontal table" style="table-layout:auto;">
                <tr class="controller-row <?php echo $controllerExists===true ? 'exists' : ''; ?>">
                    <td class="name-column"><?php echo ucfirst($item['name']).'.*'; ?></td>
                    <td class="path-column"><?php echo substr($item['path'], $basePathLength+1); ?></td>
                    <td class="checkbox-column" valign="middle" style="width: 100px;">
                        <?php if($controllerExists === false){ ?>
                            <span>
                                <?php echo CHtml::activeCheckBox($model, 'items['.$controllerKey.'.*]'); ?>
                                <label for="">Generate</label>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
            <?php
                $i = 0;
                foreach($item['actions'] as $action){
                    $actionKey = $controllerKey.'.'.ucfirst($action['name']);
                    $actionExists = isset($existingItems[ $actionKey ]);
                    $unused = $actionExists ? $unused : $unused+1;
                    ?>
                <tr class="action-row<?php echo $actionExists===true ? ' exists' : ''; ?><?php echo ($i++ % 2)===0 ? ' odd' : ' even'; ?>">
                    <td class="name-column"><?php echo $action['name']; ?></td>
                    <td class="path-column"><?php echo substr($item['path'], $basePathLength+1).(isset($action['line'])===true?':'.$action['line']:''); ?></td>
                    <td class="checkbox-column" valign="middle" style="width: 100px;">
                        <?php if($actionExists === false){ ?>
                            <span>
                                <?php echo CHtml::activeCheckBox($model, 'items['.$actionKey.']'); ?>
                                <label for="">Generate</label>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
                    <?php
                }
            ?>
            </table>
        </div>
        <div class="panel-footer">
        	<span class="total">Total Actions: <strong><?= count($item['actions'])+1 ?></strong></span><br/>
        	<span class="total">Unused Actions: <strong><?= $unused ?></strong></span>
        </div>
    </div>

<?php
        }
    }
}else{ ?>
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><label for="" style="font-weight:700;text-transform: capitalize;">Core</label></h4>
        </div>
        <div class="panel-body">
            <p><?php echo Rights::t('core', 'No actions found.'); ?></p>
        </div>
    </div>
<?php }

if(!empty($items['modules'])){
    if( $displayModuleHeadingRow===true ){
?>
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><label for="" style="font-weight:700;text-transform: capitalize;"><?= Rights::t('core', 'Modules') ?></label></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"><i class="fa fa-cog"></i></a>
                    <ul style="display: none;" role="menu" class="dropdown-menu dropdown-light pull-right">
                        <li><a href="#" class="panel-collapse collapses"><i class="fa fa-angle-up"></i> <span>Collapse</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
<?php }
    $parentModuleName = isset($moduleName) ? $moduleName.'.' : '';
    foreach( $items['modules'] as $moduleName=>$moduleItems ){
?>
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><label for="" style="font-weight:700;text-transform: capitalize;"><?= ucfirst($moduleName).'Module' ?></label></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"><i class="fa fa-cog"></i></a>
                    <ul style="display: none;" role="menu" class="dropdown-menu dropdown-light pull-right">
                        <li><a href="#" class="panel-collapse collapses"><i class="fa fa-angle-up"></i> <span>Collapse</span></a></li>
                        <li><a href="#" class="panel-expand"><i class="fa fa-expand"></i> <span>Fullscreen</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
<?php
        $this->renderPartial('_generateItemsNew', array(
            'model'=>$model,
            'form'=>$form,
            'items'=>$moduleItems,
            'existingItems'=>$existingItems,
            'moduleName'=>$parentModuleName.ucfirst($moduleName),
            'displayModuleHeadingRow'=>false,
            'basePathLength'=>$basePathLength,
        ));
?>
        </div>
    </div>
<?php
    }
    if( $displayModuleHeadingRow===true ){
?>
        </div>
    </div>
<?php
    }
}
?>