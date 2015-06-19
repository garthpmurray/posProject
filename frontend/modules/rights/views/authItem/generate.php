<?php $this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Generate items'),
);

$this->title = Rights::t('core', 'Generate items');
/*
$this->subTitle = Rights::t('core', 'For :username', array(
        ':username'=>$model->getName()
    ));
*/

?>

<script type="text/javascript">

$('body').on('click', '.panel-check-all', function(e) {
    e.preventDefault();
    var el = $(this);
    var bodyPanel = jQuery(this).parent().closest(".panel").children(".panel-body");
    if($(this).hasClass("checked")) {
        el.addClass("unChecked").removeClass("checked").children("span").text("Uncheck All").end().children("i").removeClass("fa-check-square").addClass("fa-square-o");
        bodyPanel.find(':checkbox').prop('checked', false);
    } else {
        el.addClass("checked").removeClass("unChecked").children("span").text("Uncheck All").end().children("i").removeClass("fa-square-o").addClass("fa-check-square");
        bodyPanel.find(':checkbox').prop('checked', true);
    }
});

$('body').on('click', '.panel-collapse-all', function(e) {
    e.preventDefault();
    var el = $(this);
    var bodyPanel = jQuery(this).parent().closest(".panel").children(".panel-body");
    if($(this).hasClass("collapses")) {
        el.addClass("expand").removeClass("collapses").children("span").text("Expand All").end().children("i").addClass("fa-rotate-180");
        bodyPanel.find('.panel-collapse.collapses').trigger('click');
    } else {
        el.addClass("collapses").removeClass("expand").children("span").text("Collapse All").end().children("i").removeClass("fa-rotate-180");
        bodyPanel.find('.panel-collapse.expand').trigger('click');
    }
});

$('document').ready(function(){
    $('.panel-collapse-all').trigger('click');
});
</script>

<?php if (isset($generatedStatements) && !is_null($generatedStatements) && $generatedStatements !== array()) { ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4><?php echo Rights::t('core', 'Generated Statements'); ?></h4>
            </div>
            <div class="panel-body">
                <table class="rights form-horizontal table" style="table-layout:auto;">
                    <tr>
                        <td>
                            <?php foreach ($generatedStatements as $statement) { ?>
                            <?php echo $statement . "<br />\n"; ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array('class' => 'form-horizontal well')
    ));
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading border-light">
                <h4><?php echo Rights::t('core', 'Generate items'); ?></h4>
                <ul class="panel-heading-tabs border-light">
                    <li style="height:70px;padding:10px 15px;">
                        <?php echo GxHtml::submitButton(Rights::t('core', 'Generate'), array('class' => 'btn margin-fix btn-primary', 'style' => 'min-height: 40px;', 'onclick' => 'return confirm("Are you sure you want to generate the AuthItem permissions now?");'));?>
                    </li>
                    <li style="height:70px;padding:10px 15px;">
                        <?php echo GxHtml::submitButton(Rights::t('core', 'View Statements Only'), array('class' => 'btn margin-fix btn-primary', 'style' => 'min-height: 40px;', 'name' => 'viewOnlyStatements'));?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4><?php echo Rights::t('core', 'Application'); ?></h4>
                <div class="panel-tools">
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"><i class="fa fa-cog"></i></a>
                        <ul style="display: none;" role="menu" class="dropdown-menu dropdown-light pull-right">
                            <li><a href="#" class="panel-collapse-all collapses"><i class="fa fa-angle-up"></i> <span>Collapse All</span></a></li>
                            <li><a href="#" class="panel-check-all"><i class="fa fa-square-o"></i> <span>Check All</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
<?php
    $this->renderPartial('_generateItemsNew', array(
        'model' => $model,
        'form' => $form,
        'items' => $items,
        'existingItems' => $existingItems,
        'displayModuleHeadingRow' => true,
        'basePathLength' => strlen(Yii::app()->basePath),
    ));
?>
            </div>
        </div>
    </div>
</div>

<? /*
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4><?php echo Rights::t('core', 'Application'); ?></h4>
            </div>
            <div class="panel-body">
                <table class="rights form-horizontal table" style="table-layout:auto;">
                    <tbody>
                    <?php $this->renderPartial('_generateItems', array(
                        'model' => $model,
                        'form' => $form,
                        'items' => $items,
                        'existingItems' => $existingItems,
                        'displayModuleHeadingRow' => false,
                        'basePathLength' => strlen(Yii::app()->basePath),
                    )); ?>
    
                    </tbody>
                </table>
            </div>          
        </div>
                
<? /*                    <table class="rights form-horizontal table" style="table-layout:auto;">
                        <tbody>

                        <tr class="application-heading-row">
                            <th colspan="3"><?php echo Rights::t('core', 'Application'); ?></th>
                        </tr>

                        <?php $this->renderPartial('_generateItems', array(
                            'model' => $model,
                            'form' => $form,
                            'items' => $items,
                            'existingItems' => $existingItems,
                            'displayModuleHeadingRow' => true,
                            'basePathLength' => strlen(Yii::app()->basePath),
                        )); ?>

                        </tbody>

                    </table>
-->

                    <?php /*<div class="row clearfix" style="margin-bottom:10px;">
                    <?php echo CHtml::link(Rights::t('core', 'Select all'), '#', array(
                        'onclick'=>"jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
//                      'id' => 'cancelButton',
                        'class'=>'selectAllLink twoSubmitButtons left')); ?>

                    <?php echo CHtml::link(Rights::t('core', 'Select none'), '#', array(
                        'onclick'=>"jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
//                      'id' => 'cancelButton',
                        'class'=>'selectNoneLink twoSubmitButtons right')); ?>
                </div>*/ ?>


    </div>
</div>
<?php $this->endWidget(); ?>
