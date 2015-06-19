<?php

/* if(Yii::app()->user->checkAccess('User.Admin.Admin')) {
    // or superuser, but by definition if they are superuser they also have all privs, so it's cool.
    $users = User::model()->findAll(array('select' => 'id, username', 'order' => 'username'));
} */

$nav_items = array(
//  'encodeLabel' => false,
//    'items' => array(
//        array(
            'label' => 'User Module',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'labelIcon' => 'fa fa-fw fa-user',
            'subModule' => 'user',
            'items' => array(
                array(
                    'url' => array('/user/admin'),
                    'label' => Yii::app()->getModule('user')->t("Manage Users"),
                    'visible' => Yii::app()->user->checkAccess('User.Admin.Admin'),
                    'labelIcon' => 'fa fa-fw fa-users',
                ),
                array(
                    'url' => array('/user/admin/create'),
                    'label' => Yii::app()->getModule('user')->t("Create User"),
                    'visible' => Yii::app()->user->checkAccess('User.Admin.Create'),
                    'labelIcon' => 'fa fa-fw fa-plus',
                ),
                
            ),
//        ),
//    ),
);

return $nav_items;

$this->widget('ExtendedSideMenu', $nav_items);

?>