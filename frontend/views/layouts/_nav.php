<?php
$screen = array(
    array(
        'label' => 'Manage',
        'url' => array('/screen/index'),
        'visible' => Yii::app()->user->checkAccess('Screen.Index')
    ),
    array(
        'label' => 'Screen Details Manage',
        'url' => array('/screenDetailFields/index'),
        'visible' => Yii::app()->user->checkAccess('ScreenDetailFields.Index')
    ),
);
$screenGroup = array(
    array(
        'label' => 'Manage',
        'url' => array('/screenGroup/index'),
        'visible' => Yii::app()->user->checkAccess('ScreenGroup.Index')
    ),
);
$software = array(
    array(
        'label' => 'Manage',
        'url' => array('/software/index'),
        'visible' => Yii::app()->user->checkAccess('Software.Index')
    ),
    array(
        'label' => 'Import',
        'url' => array('/software/ImportSoftware'),
        'visible' => Yii::app()->user->checkAccess('Software.ImportSoftware')
    ),
);
$config = array(
    array(
        'label' => 'Manage',
        'url' => array('/config/index'),
        'visible' => Yii::app()->user->checkAccess('Config.Index')
    ),
    array(
        'label' => 'Create New',
        'url' => array('/config/create'),
        'visible' => Yii::app()->user->checkAccess('Config.Create')
    ),
    array(
        'label' => "Software",
        'labelIcon' => 'fa fa-fw fa-cube',
        'url' => '#',
        'submenuOptions' => array('class' => 'sub-menu'),
        'visible' => CommonFunctions::anyVisible($software),
        'items' => $software,
    ),
);
$limitedModel = array(
    array(
        'label' => 'Manage',
        'url' => array('/limitedModel/index'),
        'visible' => Yii::app()->user->checkAccess('LimitedModel.Index')
    ),
    array(
        'label' => 'Create New',
        'url' => array('/limitedModel/create'),
        'visible' => Yii::app()->user->checkAccess('LimitedModel.Create')
    ),
);
$limitedData = array(
    array(
        'label' => 'Manage',
        'url' => array('/limitedData/index'),
        'visible' => Yii::app()->user->checkAccess('LimitedData.Index')
    ),
    array(
        'label' => 'Create New',
        'url' => array('/limitedData/create'),
        'visible' => Yii::app()->user->checkAccess('LimitedData.Create')
    ),
);
$limited = array(
    array(
        'label' => "Models",
        'labelIcon' => 'fa fa-fw fa-cloud ',
        'url' => '#',
        'submenuOptions' => array('class' => 'sub-menu'),
        'visible' => CommonFunctions::anyVisible($limitedModel),
        'items' => $limitedModel,
    ),
    array(
        'label' => "Data",
        'labelIcon' => 'fa fa-fw fa-database ',
        'url' => '#',
        'submenuOptions' => array('class' => 'sub-menu'),
        'visible' => CommonFunctions::anyVisible($limitedData),
        'items' => $limitedData,
    ),
);

$mediaAsset = array(
    array(
        'label' => 'Manage',
        'url' => array('/mediaAsset/index'),
        'visible' => Yii::app()->user->checkAccess('MediaAsset.Index')
    ),
    array(
        'label' => 'Create New',
        'url' => array('/mediaAsset/create'),
        'visible' => Yii::app()->user->checkAccess('MediaAsset.Create')
    ),
);
$mediaCategory = array(
    array(
        'label' => 'Manage',
        'url' => array('/mediaCategory/index'),
        'visible' => Yii::app()->user->checkAccess('MediaCategory.Index')
    ),
    array(
        'label' => 'Create New',
        'url' => array('/mediaCategory/create'),
        'visible' => Yii::app()->user->checkAccess('MediaCategory.Create')
    ),
);
$media = array(
    array(
        'label' => "Assets",
        'labelIcon' => 'fa fa-fw fa-camera-retro',
        'url' => '#',
        'submenuOptions' => array('class' => 'sub-menu'),
        'visible' => CommonFunctions::anyVisible($mediaAsset),
        'items' => $mediaAsset,
    ),
    array(
        'label' => "Categorys",
        'labelIcon' => 'fa fa-fw fa-codepen',
        'url' => '#',
        'submenuOptions' => array('class' => 'sub-menu'),
        'visible' => CommonFunctions::anyVisible($mediaCategory),
        'items' => $mediaCategory,
    ),
);


$nav_items = array(
//  'encodeLabel' => false,
    'items' => array(
        array(
            'label' => "Home",
            'labelIcon' => 'fa fa-fw fa-home',
            'url' => '/',
            'visible' => Yii::app()->user->checkAccess('Site.Index')
        ),
/*
        array(
            'label' => "Screens",
            'labelIcon' => 'fa fa-fw fa-desktop',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($screen),
            'items' => $screen,
        ),
        array(
            'label' => "Config",
            'labelIcon' => 'fa fa-fw fa-cube',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($config),
            'items' => $config,
        ),
*/
        array(
            'label' => "User Limited",
            'labelIcon' => 'fa fa-fw fa-meh-o',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($limited),
            'items' => $limited,
        ),
/*
        array(
            'label' => "Media",
            'labelIcon' => 'fa fa-fw fa-deviantart',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($media),
            'items' => $media,
        ),
*/
        array(
            'label' => "Logs",
            'labelIcon' => 'fa fa-fw fa-cog',
            'url' => array('/logView'),
            'visible' => Yii::app()->user->checkAccess('LogView.View')
        ),
/*
        array(
            'label' => "Playlists",
            'labelIcon' => 'fa fa-fw fa-cubes',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($playlist),
            'items' => $playlist,
        ),
        array(
            'label' => "Screens",
            'labelIcon' => 'fa fa-fw fa-desktop',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($screen),
            'items' => $screen,
        ),
        array(
            'label' => "Assign Playlist to Screen",
            'labelIcon' => 'fa fa-fw fa-th-large',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($playlistScreenAssoc),
            'items' => $playlistScreenAssoc,
        ),
        array(
            'label' => "Templates",
            'labelIcon' => 'fa fa-fw fa-crop',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($template),
            'items' => $template,
        ),
        array(
            'label' => "Feed Sources",
            'labelIcon' => 'fa fa-fw fa-send-o',
            'url' => '#',
            'submenuOptions' => array('class' => 'sub-menu'),
            'visible' => CommonFunctions::anyVisible($feedSource),
            'items' => $feedSource,
        ),
*/
    ),
);

$this->widget('ExtendedSideMenu', $nav_items);
?>