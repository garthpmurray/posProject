<?php $this->beginContent('//layouts/main'); ?>
<!-- start: PAGE CONTENT -->
<div class="row">
    <div id="sidebar" class="col-md-3 col-xs-12 pull-right">
        <div class="panel panel-white">
            <div class="panel-body">
                <?php 
                    $this->widget('zii.widgets.CMenu', array(
                        'items'=> $this->menu,
                        'htmlOptions' => array(
                            'class' => 'well',
                        ),
                    ));
                ?>
            </div>
        </div>
        <?php if(isset($this->clips['sidebar'])){ ?>
            <div class="panel panel-white">
                <div class="panel-body">
                    <?= $this->clips['sidebar'] ?>
                </div>
            </div>
        <?php } ?>
    </div><!-- sidebar -->
	<div class="col-md-9 col-xs-12">
        <div class="row">
            <?php echo $content; ?>
        </div>
	</div>
</div>
<!-- end: PAGE CONTENT-->
<?php $this->endContent(); ?>