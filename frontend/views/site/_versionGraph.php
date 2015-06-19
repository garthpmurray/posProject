<?php $id = str_replace(' ', '_', $name).rand(); ?>

<script type="text/javascript">
$(document).ready(function() {
    nv.addGraph(function() {
        var chart = nv.models.pieChart().x(function(d) {
            return d.label;
        }).y(function(d) {
            return d.value;
        }).showLabels(true);
    
        d3.select("#versio<?= $id ?> svg").datum(<?= json_encode($version) ?>).transition().duration(350).call(chart);
        

/*
        nv.utils.windowResize(function() {
            chart.update();
        });
*/

        return chart;
    });
});
</script>
<div class="col-xs-12">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h4 class="panel-title"><?= ucfirst($name) ?></h4>
        </div>
        <div class="panel-body">
            <div id="versio<?= $id ?>" class="height-300">
                <svg></svg>
            </div>
        </div>
    </div>
</div>