<?php

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

?>

<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"> <?= $model->model_name ?></span></h4>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:125px;">Id</th>
                    <td><?= $model->id ?></td>
                </tr>
                <tr>
                    <th><?= $model->generateAttributeLabel('user') ?></th>
                    <td><?= GxHtml::valueEx($model->user) ?></td>
                </tr>
                <tr>
                    <th><?= $model->generateAttributeLabel('table_name') ?></th>
                    <td><?= $model->table_name ?></td>
                </tr>
                <tr>
                    <th><?= $model->generateAttributeLabel('model_name') ?></th>
                    <td><?= $model->model_name ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
