<?php

/*
if(Yii::app()->user->checkAccess('User.Admin.Admin')) {
    // or superuser, but by definition if they are superuser they also have all privs, so it's cool.
    $users = User::model()->findAll(array('select' => 'id, username'));
}
*/

$nav_items = array(
//  'encodeLabel' => false,
//    'items' => array(
//        array(
            'label' => 'Rights Module',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'labelIcon' => 'fa fa-fw fa-database ',
            'subModule' => 'rights',
            'items' => array(
                    array(
                        'label' => 'Assignments',
                        'url' => '#',
                        'submenuOptions' => array('class' => 'sub-menu'),
                        'labelIcon' => 'fa fa-fw fa-pencil',
                        'items' => array(
                            array(
                                'label' => 'Manage Assignments',
                                'url' => array('/rights/assignment/view'),
                                'subnav' => true,
                            ),
                        )
                    ),
                    array(
                        'label' => 'Permissions',
                        'url' => '#',
                        'submenuOptions' => array('class' => 'sub-menu'),
                        'labelIcon' => 'fa fa-fw fa-key',
                        'items' => array(
                            array(
                                'label' => 'Manage Permissions',
                                'url' => array('/rights/authItem/permissions'),
                                'subnav' => true,
                            ),
                            array(
                                'label' => 'Generate Controller Actions',
                                'url' => array('/rights/authItem/generate'),
                                'subnav' => true,
                            ),
                        )
                    ),
                    array(
                        'label' => 'Roles',
                        'url' => '#',
                        'submenuOptions' => array('class' => 'sub-menu'),
                        'labelIcon' => 'fa fa-fw fa-archive',
                        'items' => array(
                            array(
                                'label' => 'Manage Roles',
                                'url' => array('/rights/authItem/roles'),
                                'subnav' => true,
                            ),
                            array(
                                'label' => 'Create a New Role',
                                'url' => array('/rights/authItem/create', 'type'=> 2),
                                'subnav' => true,
                            ),
                        )
                    ),
                    array(
                        'label' => 'Tasks',
                        'url' => '#',
                        'submenuOptions' => array('class' => 'sub-menu'),
                        'labelIcon' => 'fa fa-fw fa-truck',
                        'items' => array(
                            array(
                                'label' => 'Manage Tasks',
                                'url' => array('/rights/authItem/tasks'),
                                'subnav' => true,
                            ),
                            array(
                                'label' => 'Create a New Task',
                                'url' => array('/rights/authItem/create', 'type'=> 1),
                                'subnav' => true,
                            ),
                        )
                    ),
                    array(
                        'label' => 'Operations',
                        'url' => '#',
                        'submenuOptions' => array('class' => 'sub-menu'),
                        'labelIcon' => 'fa fa-fw fa-wrench',
                        'items' => array(
                            array(
                                'label' => 'Manage Operations',
                                'url' => array('/rights/authItem/operations'),
                                'subnav' => true,
                            ),
                            array(
                                'label' => 'Create a New Operation',
                                'url' => array('/rights/authItem/create', 'type' => 0),
                                'subnav' => true,
                            ),
                        )
                    ),
                ),
//        ),
//    )
);

return $nav_items;

$this->widget('ExtendedSideMenu',$nav_items);

?>