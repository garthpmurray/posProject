<?php echo "<?php\n"; ?>

$nav_items = array(
    'label' => '<?php echo ucfirst($this->moduleID); ?> Module',
    'url' => '#',
    'submenuOptions' => array('class' => 'sub-menu'),
    'labelIcon' => 'fa fa-fw ',
    'subModule' => '<?php echo $this->moduleID; ?>',
    'items' => array(
        array(
            'label' => 'Dashboard',
            'url' => array('/<?php echo $this->moduleID; ?>'),
            'submenuOptions' => array('class' => 'sub-menu'),
            'labelIcon' => 'fa fa-fw',
        ),
    ),
);

return $nav_items;
