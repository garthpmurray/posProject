<?php
if(!isset($renderPartial)){
    $this->breadcrumbs = array(
        $model->label(2) => array('index'),
        GxHtml::valueEx($model),
    );
    
    $this->menu=array(
        array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
        array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
        array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
        array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
    );
    
    $this->title = 'View';
    $this->subTitle = GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));
}
?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'htmlOptions'   => array(
        'class' => 'table table-bordered'
    ),
    'attributes' => array(
        'id',
        'name',
        array(
            'name' => 'assignedSystemSoftware',
            'type' => 'raw',
            'value' => $model->assignedSystemSoftware !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->assignedSystemSoftware)), array('software/view', 'id' => GxActiveRecord::extractPkValue($model->assignedSystemSoftware, true))) : null,
        ),
        array(
            'name' => 'assignedDataSoftware',
            'type' => 'raw',
            'value' => $model->assignedDataSoftware !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->assignedDataSoftware)), array('software/view', 'id' => GxActiveRecord::extractPkValue($model->assignedDataSoftware, true))) : null,
        ),
        'content',
    ),
)); ?>
        </div>
    </div>
</div>

<?php if(isset($screens)){ ?>
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo GxHtml::encode($model->getRelationLabel('screens')); ?></h4>
                <div class="panel-tools">
                    <a class="btn btn-default" onclick='if(confirm("Are you sure you want to send this config a reboot command?")) { reboot_box(<?= $screens ?>) }' style="text-decoration: underline; cursor: pointer;">Reboot Screens</a>
                </div>
            </div>
            <div class="panel-body">
    <?php
        echo GxHtml::openTag('ul');
        foreach($model->screens as $relatedModel) {
            echo GxHtml::openTag('li');
            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('screen/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
            echo GxHtml::closeTag('li');
        }
        echo GxHtml::closeTag('ul');
    ?>
            </div>
        </div>
    </div>
<?php } ?>