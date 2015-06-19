<?php 

//    $this->widget('zii.widgets.grid.CGridView', array(
  $this->widget('SarabonDataGrid', array(
        'id' => 'permissions',
        'dataProvider'=>$dataProvider,
/*
        'widgetType'    => 'nonboxy-widget',
        'title' => 'Assign Permissions',
*/
        'htmlOptions' => array('class'=> 'table form-horizontal span11'),
        'emptyText'=>Rights::t('core', 'No authorization items found.'),
        'columns'=>$columns,
    ));
?>
