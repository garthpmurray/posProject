<?php
$this->breadcrumbs = array(
    'Rights'=>Rights::getBaseUrl(),
    Rights::t('core', 'Permissions'),
);

$this->title = Rights::t('core', 'Assign Permissions');
$this->subTitle = Rights::t('core', 'Here you can view and manage the permissions assigned to each role.');
?>

<div id="permissionsDataBlock">
<?php  /*?>
<div class="box" style="display:block;" id="permissions">
    <div class="boxHeader">
        <h2><?php echo Rights::t('core', 'Permissions'); ?></h2>
        <h3><?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
        <?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
            '{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
            '{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
            '{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
        )); ?></h3>
    </div>
    <div class="boxContent">*/ ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
            <blockquote>
                <p><?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
                        '{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
                        '{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
                        '{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
                    )); ?></p>
            </blockquote>
            
            <p class="alert alert-info fade in">(*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4>Assign Permissions</h4>
            </div>
            <div class="panel-body">
    <?php 
        $this->renderPartial('_permissions', array(
            'dataProvider'=>$dataProvider,
            'columns'=>$columns,
        ));
    ?>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
/*      $('a.assign-link').click(function(){
            var element = $(this);
            var save = $.post('<?php echo Yii::app()->controller->createUrl('authItem/assign/'); ?>', { 'name': element.attr("name"), 'child': element.attr("child"), 'ajax': 1})
            .success(function() {
                location.reload();
//              $('#permissionsDataBlock').load('<?php echo Yii::app()->controller->createUrl('authItem/permissions'); ?>', { ajax:1 });
//              element.text("Revoke");
//              element.attr("class", "revoke-link");
            });
        });

        $('a.revoke-link').click(function(){
            var element = $(this);
            var save = $.post('<?php echo Yii::app()->controller->createUrl('authItem/revoke/'); ?>', { 'name': element.attr("name"), 'child': element.attr("child"), 'ajax': 1})
            .success(function() {
                location.reload();
//              $('#permissionsDataBlock').load('<?php echo Yii::app()->controller->createUrl('authItem/permissions'); ?>', { ajax:1 });
//              element.text("Assign");
//              element.attr("class", "assign-link");
            });
        });*/
    
        /**
        * Attach the tooltip to the inherited items.
        */
        jQuery('.inherited-item').rightsTooltip({
            title:'<?php echo Rights::t('core', 'Source'); ?>: '
        });

        /**
        * Hover functionality for rights' tables.
        */
        $('#rights tbody tr').hover(function() {
            $(this).addClass('hover'); // On mouse over
        }, function() {
            $(this).removeClass('hover'); // On mouse out
        });

    </script>
<!--    </div>
</div> -->
</div>