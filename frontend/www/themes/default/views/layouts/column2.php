<?php $this->beginContent('//layouts/main'); ?>
<section id="sidebar" class="col-md-3 col-xs-12 pull-right">
    <?php 
        $this->widget('zii.widgets.CMenu', array(
            'items'=> $this->menu,
            'htmlOptions' => array(
                'class' => 'well',
            ),
        ));
    ?>
    <?= isset($this->clips['sidebar']) ? $this->clips['sidebar'] : '' ?>
</section><!-- sidebar -->
<section class="col-md-9 col-xs-12">
    <section id="content">
        <?php echo $content; ?>
    </section><!-- content -->
</section>
<?php $this->endContent(); ?>