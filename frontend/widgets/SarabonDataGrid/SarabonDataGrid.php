<?php
Yii::import('application.widgets.SarabonDataGrid.SarabonCButtonColumn');
Yii::import('application.widgets.SarabonDataGrid.SarabonCDataColumn');

Yii::import('zii.widgets.grid.CGridView');

/**
 * SarabonDataGrid class.
 *
 * @extends CGridView
 *
 * @param	string	$title			(default: null)								title of the table
 * @param	array	$pullIcons		(default: null)								operations that can apply to the table
 * @param	int		$entriesPP		(default: 10)								number of entries to display
 * @param	string	$widgetType		(default: widget-block or nonboxy-widget)	defines html surrounding hte datatable
 * @param	string	$widgetIcon		(default: icon-file)						Icon in the header
 * @param	int		$sScrollY		(default: 575)								Height of the datatable content box Set to 0 to remove any heigh limits.
 																				WARNING large datasets will really stretch the page when all is set for paginate.
 * @param	boolean	$dt_export		(default: false)							Show the export functions.
 * @param	boolean	$dt_hide		(default: false)							Show the hide column dropdown.
 *
 * @return javascript and html for the datatable
 *
 * Example:

$this->widget('SarabonDataGrid', array(
    'dataProvider'	=> $model->search(),
    'widgetType'	=> 'nonboxy-widget',
    'id'			=> 'manage_affiliates',
    'title'			=> Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)),
    'entriesPP'		=> 25,
//    'dt_export'		=> true,
//    'dt_hide'		=> true,
    'columns'=>array(
//		'id',
		'name',
//		'username',
//		'password',
//		'apikey',
		'web_id',
		'conv_pixel:integer',
		array(
			'class' => 'application.extensions.widgets.SarabonDataGrid.SarabonCDataColumn',
			'name' => 'apicalls',
			'type' => 'integer',
			'sColumns'=>'{ "sType": "formatted-num" },',
		),
		'portal_url',
//		'orderBy',
		'mobileworks',
	    array(
	    	'class'=>'SarabonCButtonColumn',
	    	'template' => '{view} {update}',	// column with "view", "update"  "delete"
	    	'sColumns' => '{ "bSortable": false },',
	    ),
    ),
));

 */


class SarabonDataGrid extends CGridView
{

	public $title = '';
	public $pullIcons = array();
	public $entriesPP = 25;
	public $widgetType = 'widget-block';
	public $widgetIcon = 'icon-file';
	public $sScrollY = 575;
	public $sScrollX = '2516px';
	public $initSearch = '';

	/* datatables options */
	public $dt_export	= false;
	public $dt_hide		= false;
	public $wideTable	= false;
	public $sAjaxSource = false;
	public $aaSorting = 0;

	public function init()
	{
		$this->enablePagination = false;
		$this->enableSorting = false;
		$this->cssFile = false;
		$this->ajaxUpdate = false;
		$this->itemsCssClass = 'data-tbl-tools table';
		$this->rowCssClass = null;
		$this->template = "{items}";
		$this->htmlOptions['class'] = 'widget-box';
		$this->showTableOnEmpty = false;
		if($this->wideTable == true){
			$this->htmlOptions['class'] .= ' wideTable';
		}

		$this->id = str_replace('-', '_', $this->id);

/*
		if($this->ajaxDataTables === true){
			die(var_dump($this->dataProvider));
		}
*/

		parent::init();
	}

	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns()
	{
		if($this->columns===array())
		{
			if($this->dataProvider instanceof CActiveDataProvider)
				$this->columns=$this->dataProvider->model->attributeNames();
			else if($this->dataProvider instanceof IDataProvider)
			{
				// use the keys of the first row of data as the default columns
				$data=$this->dataProvider->getData();
				if(isset($data[0]) && is_array($data[0]))
					$this->columns=array_keys($data[0]);
			}
		}
		$id=$this->getId();
		foreach($this->columns as $i=>$column)
		{
			if(is_string($column))
				$column=$this->createDataColumn($column);
			else
			{
				if(!isset($column['class']))
					$column['class']='CDataColumn';
				$column=Yii::createComponent($column, $this);
			}
			if(!$column->visible)
			{
				unset($this->columns[$i]);
				continue;
			}
			if($column->id===null)
				$column->id=$id.'_c'.$i;
			$this->columns[$i]=$column;
		}

		foreach($this->columns as $column)
			$column->init();
	}

	/**
	 * Creates a {@link CDataColumn} based on a shortcut column specification string.
	 * @param string $text the column specification string
	 * @return CDataColumn the column instance
	 */
	protected function createDataColumn($text)
	{
		if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$text,$matches))
			throw new CException(Yii::t('zii','The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
		$column=new CDataColumn($this);
		$column->name=$matches[1];
		
		if(isset($matches[3]) && $matches[3]!==''){
			$column->type=$matches[3];
		}
		if(isset($matches[5])){
			$column->header=$matches[5];
		}

		return $column;
	}

	public function run()
	{
		/*
		if ($this->altHtmlContent === null)
			$this->altHtmlContent = Yii::t('yii', 'This content requires the <a href="http://www.adobe.com/go/getflash/">Adobe Flash Player</a>.');
		*/

		echo $this->registerScripts();

		/*
				<li><a href="#"><i class="icon-plus"></i> Add New</a></li>
				<li><a href="#"><i class="icon-ok"></i> Bulk Approved</a></li>
				<li><a href="#"><i class="icon-minus-sign"></i> Bulk Remove</a></li>
		*/

		?>
			<div class="panel panel-white">
        		<div class="panel-heading">
        			<h4 class="panel-title"><i class="<?php echo $this->widgetIcon; ?>" style="margin-right: 10px;"></i><?php echo $this->title; ?></h4>
				<?php if(count($this->pullIcons) > 0) { ?>
    				<div class="panel-tools">
        				<?php foreach($this->pullIcons as $pullIcon) {
                    		foreach (Yii::app()->params['standardOperations'] as $standardOps) {
                    			$check = stristr($pullIcon['label'], $standardOps['name']);
                    			if ($check !== FALSE) {
                    				$labelIcon = $standardOps['icon'];
                    			}
                    		}
        				 ?>
            				<a class="btn btn-xs btn-link" href="<?php echo $pullIcon['url']; ?>">
            					<i class="fa <?php echo $labelIcon; ?>"></i>
            				</a>
    					<?php } /* ?>
    					<ul class="dropdown-menu">
    						<?php foreach($this->pullIcons as $pullIcon) { ?>
    						<li><a href="<?php echo $pullIcon['url']; ?>"><i class="<?php echo $pullIcon['class']; ?>"></i> <?php echo $pullIcon['label']; ?></a></li>
    						<?php } ?>
    					</ul> */ ?>
    				</div>
				<?php } ?>
        		</div>
    			<?php echo CHtml::openTag('div',array('class' => 'panel-body'))."\n";
    				parent::run();
    			echo CHtml::closeTag('div');
			echo CHtml::closeTag('div');



/*
		echo CHtml::openTag('div',array('class' => $this->widgetType))."\n";
		?>
		<div class="widget-head">
			<h5><i class="<?php echo $this->widgetIcon; ?>"></i><?php echo $this->title; ?></h5>
			<?php if(count($this->pullIcons) > 0) { ?>
				<div class="widget-control pull-right"> <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><i class="icon-cog"></i><b class="caret"></b></a>
				  <ul class="dropdown-menu">
					  <?php foreach($this->pullIcons as $pullIcon) { ?>
					<li><a href="<?php echo $pullIcon['url']; ?>"><i class="<?php echo $pullIcon['class']; ?>"></i> <?php echo $pullIcon['label']; ?></a></li>
						<?php } ?>
				  </ul>
				</div>
			<?php } ?>
		  </div>
			<?php
		echo CHtml::openTag('div',array('class' => 'widget-content'))."\n";

		parent::run();

		echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');
*/


		// $this->renderGrid();
	}


	/*
	protected function renderGrid()
	{
		$this->render('sarabonDataGrid',
			array(
				'data' => $this->dataProvider->getData(),
				'title' => $this->title,
				'columns' => $this->columns,
			)
		);
	}
	*/

	/**
	 * Registers the needed CSS and JavaScript.
	 */
	public function registerScripts()
	{
		$cs = Yii::app()->getClientScript();

        $sarabonCorePackage = array(
            'basePath'=> 'application.widgets.SarabonDataGrid', 
            'js'      => array(
                'js/data-table.jquery.js',
                'js/TableTools.min.js',
                'js/ColVis.min.js',
                'js/data-table-sort.jquery.js',
            ),
            'depends' => array('jquery')
        );
        $sarabonPackage = array(
            'basePath'=> 'application.www.themes.rapido.assets.plugins.DataTables.media',
            'css'     => array(
                'css/DT_bootstrap.css',
            ),
            'js'      => array(
                'js/DT_bootstrap.js',
            ),
            'depends' => array(
                'sarabonCorePackage','jquery'
            )
        );
        
        $sarabonCorePackage = Yii::app()->clientScript
                              ->addPackage('sarabonCorePackage', $sarabonCorePackage)
                              ->registerPackage('sarabonCorePackage')
                              ->getPackageBaseUrl('sarabonCorePackage');
        $sarabonPackage = Yii::app()->clientScript
                              ->addPackage('sarabonPackage', $sarabonPackage)
                              ->registerPackage('sarabonPackage')
                              ->getPackageBaseUrl('sarabonPackage');
		ob_start();

		echo $this->datatablesjs();

		return ob_get_clean();
	//	$cs->registerScript("create_datatable_js_{$this->id}", $script, CClientScript::POS_HEAD);
	}

	function registerClientScript()
	{
		// specifically does nothing, in order to override CGridView's method.
	}


	function datatablesjs(){
		$columnKeys = array_keys($this->columns);
		$aoColumns = "";
		foreach($this->columns as $i=>$c){
			$item = '';
			if(isset($c->sColumns)){
				$item = $c->sColumns;
				$aoCenter	= $i;
			}

			if(isset($c->type)){
				switch($c->type){
					case 'text':
					case 'raw':
					case 'boolean':
					case 'html':
						break;
					case 'percent':
						$item = '{ "sType": "percent" },';
						break;
					case 'currency':
						$item = '{ "sType": "currency" },';
						break;
					case 'date':
					case 'str_date':
						$item = '{ "sType": "date" },';
						break;
					case 'dropdown':
						$item = '{ "bSortable": false, "bSearchable": false, "sClass": "center", },';
						break;
					default:
						$item = '{ "sType": "formatted-num" },';
						break;
				}
			}

			$aoColumns .= !empty($item) ? $item : 'null,';
		}

		$sDom = '<"tbl-tools-searchbox"<"dataTables_toolbar">fl<"clearfix">i p<"clearfix">r>,';
		if($this->dt_export == true || $this->dt_hide == true){
			$sDom .= '<"tbl_tools"';
			$sDom .= $this->dt_hide == true ? 'C' : '';
			$sDom .= $this->dt_export == true ? 'T' : '';
			$sDom .= ' <"clearfix">>,';
		}
		$sDom .= '<"table_content"t>,<"widget-bottom"i p<"clearfix">>';
		
		
//		$sDom = "<'tbl-tools-searchbox'<'dataTables_toolbar'>fl<'clearfix'>i p<'clearfix'>r>,<'table_content't>,<'widget-bottom'i p<'clearfix'>>";

?>
<script type="text/javascript">
		$(document).ready(function(){
/*======================
	DATA TABLE Sorting
========================*/
			
/*			$(function () {*/
				var <?php echo $this->id; ?> = $('#<?php echo $this->id; ?> table').dataTable({
			
			/* standard */		"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
			/* standard */		"sPaginationType": "bootstrap",
			/* standard */		"iDisplayLength": <?php echo $this->entriesPP; ?>,
			/* standard */	//	"bStateSave": true,				// save state of form via cookies
				<?php if($this->sScrollY !== 0){ ?>
			/* standard */	//	"sScrollY": '<?php echo $this->sScrollY; ?>px',
				<?php } ?>
				<?php if($this->wideTable == true){ ?>
								"sScrollX": "<?php echo $this->sScrollX; ?>",
				<?php } ?>
								"bScrollCollapse": true,

			//		"oLanguage": {
			//			"sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
			//		},
			<?php 
			if(isset($this->initSearch) && !empty($this->initSearch)){ ?>
					"oSearch": {"sSearch": "<?php echo $this->initSearch; ?>"},
			<?php } ?>
					"aaSorting": [[ <?php echo $this->aaSorting; ?>, "asc" ]],
			
			<?php  echo isset($aoColumns) ? "		\"aoColumns\": [ {$aoColumns} ]," : ''; ?>
			
					"sDom": '<?php echo $sDom; ?>',
			<?= (isset($this->sAjaxSource) && $this->sAjaxSource) ? "		\"sAjaxSource\": '{$sAjaxSource}'," : ''; ?>
					"oTableTools": {
						"sRowSelect": "multi",
						"aButtons": [
							"select_all",
							"select_none",
			<?php if($this->dt_export == true){ ?>
							{
							    "sExtends":    "copy",
							    "bSelectedOnly": "true",
			                    "mColumns": "visible",
							},
							{
							    "sExtends":    "csv",
							    "bSelectedOnly": "true",
			                    "mColumns": "visible",
							},
							{
							    "sExtends":    "xls",
							    "bSelectedOnly": "true",
			                    "mColumns": "visible",
							},
							{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape",
							    "bSelectedOnly": "true",
			                    "mColumns": "visible",
							},
							{
								"sExtends": "print",
			                    "mColumns": "visible",
							},
			<?php } ?>
						],
			<?php if($this->dt_export == true){ ?>
						"sSwfPath": "/themes/sarabon/swf/copy_csv_xls_pdf.swf"
			<?php } ?>
					},
				});
				$(".lenghtMenu select").addClass('tbl_length');
			
				<?php if($this->wideTable !== true){ ?>
					$(window).bind('resize', function () {
						<?php echo $this->id; ?>.fnDraw('false');
					});
				<?php } ?>
			

				$('#<?php echo $this->id; ?> table').on('click', 'a.delete', function() {
					if(!confirm('Are you sure you want to delete this item?')) return false;
					var th=this;
			
					$.ajax({
						type: 'POST',
						url: $(this).attr('href'),
					});
			
					var row = $(this).closest('tr');
					var nRow = row[0];
					$('#<?php echo $this->id; ?> table').dataTable().fnDeleteRow(nRow);
			
					return false;
				});
			
/*			});*/
		});
</script>
<?php

	}
}

?>