<?php
$this->breadcrumbs=array(
    UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
    $this->layout='//layouts/column2';
    $this->menu=array(
        array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
//      array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    );
}

$this->title = UserModule::t("List User");
$this->widget('SarabonDataGrid', array(
    'id' => 'order-grid',
    'dataProvider' => $dataProvider,
    'widgetType'	=> 'nonboxy-widget',
    'title' => Yii::t('app', 'Manage'),
    'columns' => array(
        array(
            'name' => 'username',
            'type'=>'raw',
            'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
        ),
        'create_at',
        'lastvisit_at',
    ),
)); ?>