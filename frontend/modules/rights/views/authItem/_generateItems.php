<?php if( $items['controllers']!==array() ): ?>

    <?php foreach( $items['controllers'] as $key=>$item ): ?>

        <?php if( isset($item['actions'])===true && $item['actions']!==array() ): ?>

            <?php $controllerKey = isset($moduleName)===true ? ucfirst($moduleName).'.'.$item['name'] : $item['name']; ?>
            <?php $controllerExists = isset($existingItems[ $controllerKey.'.*' ]); ?>

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

            <?php $i=0; foreach( $item['actions'] as $action ): ?>

                <?php $actionKey = $controllerKey.'.'.ucfirst($action['name']); ?>
                <?php $actionExists = isset($existingItems[ $actionKey ]); ?>

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

            <?php endforeach; ?>

        <?php endif; ?>

    <?php endforeach; ?>

<?php else: ?>

    <tr><th  class="no-items-row" colspan="3"><?php echo Rights::t('core', 'No actions found.'); ?></th></tr>

<?php endif; ?>

<?php if( $items['modules']!==array() ): ?>

    <?php if( $displayModuleHeadingRow===true ): ?>

        <tr><th class="module-heading-row" colspan="3"><?php echo Rights::t('core', 'Modules'); ?></th></tr>

    <?php endif; ?>

    <?php foreach( $items['modules'] as $moduleName=>$moduleItems ): ?>

                    </tbody>
                </table>
            </div>          
        </div>
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4><?php echo ucfirst($moduleName).'Module'; ?></h4>
            </div>
            <div class="panel-body">
                    <table class="rights form-horizontal table" style="table-layout:auto;">
                        <tbody>
        <?php $this->renderPartial('_generateItems', array(
            'model'=>$model,
            'form'=>$form,
            'items'=>$moduleItems,
            'existingItems'=>$existingItems,
            'moduleName'=>$moduleName,
            'displayModuleHeadingRow'=>true,
            'basePathLength'=>$basePathLength,
        )); ?>

    <?php endforeach; ?>

<?php endif; ?>