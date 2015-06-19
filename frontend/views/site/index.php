<?php

$this->breadcrumbs = array();

$this->title = Yii::t('app', 'Dashboard');

?>
<script type="text/javascript">
$(document).ready(function() {
    
    $(".inlineFancy").fancybox({
        fitToView   : true,
        autoSize    : true,
    });
    
    $("#Screens").jstree({
        "core" : {
            "themes" : {
                "responsive" : false
            },
            // so that create works
            "check_callback" : true,
            'data' : <?= $data ?>
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder text-red fa-lg"
            },
            "file" : {
                "icon" : "fa fa-file text-red fa-lg"
            }
        },
        "state" : {
            "key" : "demo2"
        },
        "search" : {
            "show_only_matches" : true
        },
        "plugins" : ["search", "types", "sort", "state"]
    });
    
    var to = false;
    $('#Screens_search').keyup(function() {
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function() {
            var v = $('#Screens_search').val();
            $('#Screens').jstree(true).search(v);
        }, 250);
    });
    
    var firstLoad = 0;
    $('#Screens').on('select_node.jstree', function (n, s, e) {
        var id = $('#'+s['selected'][0]+' .screenCheck').attr('data-screenId');
        if(id){
            if(firstLoad){
                $('#hiddenFancy').attr('href', '/screen/view/id/'+id+'/modal/true').trigger('click');
            }else{
                firstLoad = 1;
            }
        }
    });
    
    $('.treeOpen').click(function () {
        $("#Screens").jstree("open_all");
    });
    
    $('.treeCollapse').click(function () {
        $("#Screens").jstree("close_all");
        $("#Screens").jstree("select_node", "#node_0", true);
    });
    

//		d3.json('assets/plugins/nvd3/json/multiBarHorizontalData.txt', function(data) {
			nv.addGraph(function() {
				var chart = nv.models.multiBarHorizontalChart().x(function(d) {
					return d.label;
				}).y(function(d) {
					return d.value;
				}).margin({
					top : 30,
					right : 20,
					bottom : 50,
					left : 175
				}).showValues(true)//Show bar value next to each bar.
				.tooltips(true)//Show tooltips on hover.
				.transitionDuration(350).showControls(true);
				//Allow user to switch between "Grouped" and "Stacked" mode.

				chart.yAxis.tickFormat(d3.format(',.2f'));

				d3.select('#multiBar svg').datum(<?= json_encode($type) ?>).call(chart);

				nv.utils.windowResize(chart.update);

				return chart;
			});
//		});

/*
		nv.addGraph(function() {
			var chart = nv.models.multiBarHorizontalChart().x(function(d) {
				return d.label;
			}).y(function(d) {
				return d.value;
			}).margin({
				top : 30,
				right : 20,
				bottom : 50,
				left : 175
			}).showValues(true)//Show bar value next to each bar.
			.tooltips(true)//Show tooltips on hover.
			.transitionDuration(350).showControls(true);
			//Allow user to switch between "Grouped" and "Stacked" mode.

			chart.yAxis.tickFormat(d3.format(',.2f'));

			d3.select('#demo-chart-5 svg').datum(<?= json_encode($type) ?>).call(chart);

			nv.utils.windowResize(chart.update);

			return chart;
		});
*/

});

//$('.switchType').trigger('click');

</script>

<div class="col-xs-12">
    <div class="panel panel-white">
        <div class="panel-body">
<div id="multiBar" style="width:100%; height:190px;">
	<svg></svg>
</div>
        </div>
    </div>
</div>

<?php if(!empty($issueScreens)){ ?>
<div class="col-xs-12">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"> Issue Screens</span></h4>
        </div>
        <div class="panel-body">
            <p>These screens appear to not be saved in the system. Please update their data as necessary</p>
            <table class="table table-bordered">
            <?php foreach($issueScreens as $i){ ?>
                <tr>
                    <th>Mac Address</th>
                    <th>Ip Address</th>
                    <th>System Version</th>
                </tr>
                <tr>
                    <td><a href="/screen/view/id/<?= $i->id ?>"><?= $i->mac_address ?></a></td>
                    <td><?= $i->ip_address ?></td>
                    <td><?= $i->system_version ?></td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
</div>
<?php } ?>
<div class="col-xs-12 col-md-6">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"> System Screens</span></h4>
            <div class="panel-tools">										
                <a href="#" class="treeOpen"><i class="fa fa-angle-up"></i> <span>Open</span> </a>
                <a href="#" class="treeCollapse"> <i class="fa fa-angle-down"></i> <span>Collapse</span> </a>
                <a id="hiddenFancy" class="inlineFancy" data-fancybox-type="iframe" href="#" style="display:none;">Iframe</a>
			</div>
		</div>
        <div class="panel-body">
            <input type="text" class="form-control margin-bottom-10" value="" id="Screens_search" placeholder="Search">
            <div id="Screens" class="tree-demo"></div>
        </div>
    </div>
</div>
<?php /*
<div class="col-xs-12 col-sm-6 col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"> Screen Status</span></h4>
            <div class="panel-tools">										
                <a href="#" class="switchType" data-target='typeLevel'><i class="fa fa-angle-up"></i> <span>Switch</span> </a>
            </div>
        </div>
        <div class="panel-body" id="topLevel">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h4 class="panel-title">Websocket Callback</h4>
                        </div>
                        <div class="panel-body">
                            <div id="webSocket" class="height-300">
                                <svg></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h4 class="panel-title">User Flagged Status</h4>
                        </div>
                        <div class="panel-body">
                            <div id="status" class="height-300">
                                <svg></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body" id="typeLevel">
            <div class="row">
                <?php
                foreach($type as $k=>$v){
                    $this->renderPartial('_versionGraph', array(
                        'name'      => $k,
                        'version'   => $v,
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</div>
*/ ?>
<div class="col-xs-12 col-sm-6 col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"> System Versions</span></h4>
            <div class="panel-tools">										
                <a href="#" class="switchType"><i class="fa fa-angle-up"></i> <span>View Type</span> </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php
                foreach($version as $k=>$v){
                    $this->renderPartial('_versionGraph', array(
                        'name'      => $k,
                        'version'   => $v,
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</div>
