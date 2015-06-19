<?php
$flashMessages = Yii::app()->user->getFlashes();
foreach($flashMessages as $key => $message){ 
	switch($key){
		case 'success':
			$alertType = 'alert-success';
			break;
		case 'error':
		case 'failure':
			$alertType = 'alert-danger';
			break;
		case 'caution':
			$alertType = 'alert-warning';
			break;
		case 'info':
			$alertType = 'alert-info';
			break;
		default:
			$alertType = 'alert-info';
			break;
	}
?>
<div class="alert <?php echo $alertType; ?> fade in">
    <button class="close" type="button" data-dismiss="alert">x</button>
    <div class="errorSummary">
	    <strong><?php echo strtoupper($key); ?></strong>: <?php echo $message; ?>
    </div>
</div>	
<?php } ?>