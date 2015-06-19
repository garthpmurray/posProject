<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
);

$this->title = 'View';
$this->subTitle = GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model));

//var_dump($model->errorGroup);
?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-body">
            <table class="table table-bordered">
                    <tbody><tr>
                        <th style="width:125px">Time</th>
                        <td><?= $model->logRealTime ?></td>
                    </tr>
                    <tr>
                        <th>Ip User</th>
                        <td><?= $model->ip_user ?></td>
                    </tr>
                    <tr>
                        <th>Request Url</th>
                        <td><?= $model->request_url ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php foreach($model->errorGroup as $eg){ ?>
<div class="col-md-12">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><label for="" style="font-weight:700;text-transform: capitalize;"><?= $eg->category ?></label></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"><i class="fa fa-cog"></i></a>
                    <ul style="display: none;" role="menu" class="dropdown-menu dropdown-light pull-right">
                        <li><a href="#" class="panel-collapse collapses"><i class="fa fa-angle-up"></i> <span>Collapse</span></a></li>
                        <li><a href="#" class="panel-expand"><i class="fa fa-expand"></i> <span>Fullscreen</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                    <tbody><tr>
                        <th style="width:125px">Id</th>
                        <td><?= $eg->id ?></td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td><?= $eg->level ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?= $eg->category ?></td>
                    </tr>
                </tbody>
            </table>            
            <div class="panel panel-dark">
            	<div class="panel-heading">
            		<div class="panel-tools">
            			<div class="dropdown">
            				<a class="btn btn-xs dropdown-toggle btn-transparent-grey" data-toggle="dropdown"><i class="fa fa-cog"></i></a>
            				<ul role="menu" class="dropdown-menu dropdown-light pull-right">
            					<li><a href="#" class="panel-collapse collapses"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a></li>
            					<li><a href="#" class="panel-expand"><i class="fa fa-expand"></i> <span>Fullscreen</span></a></li>
            				</ul>
            			</div>
            		</div>
            	</div>
            	<div class="panel-body">
<pre><?php echo $eg->message ?></pre>
            	</div>
            </div>
        </div>
    </div>
</div>
<? } ?>
