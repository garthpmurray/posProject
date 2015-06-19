<script type="text/javascript">
$(document).ready(function() {
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
	
		d3.json('/frontend/www/themes/rapido2/assets/plugins/nvd3/json/multiBarHorizontalData.txt', function(data) {
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

				d3.select('#demo-chart-5 svg').datum(data).call(chart);

				nv.utils.windowResize(chart.update);

				return chart;
			});
		});
	
});
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


<div class="col-xs-12">
    <div class="panel panel-white">
        <div class="panel-body">
            <div id="demo-chart-5" style="width:100%; height:190px;">
            	<svg></svg>
            </div>
        </div>
    </div>
</div>
