<?php

$flashMessages = Yii::app()->user->getFlashes();

foreach($flashMessages as $key => $message){
    $system = explode('.', $key);
    $name = '';
    
    foreach($system as $s){
        switch($s){
            case 'success':
                $name = $s;
                $alertType = 'alert-success';
                break;
            case 'error':
            case 'failure':
                $name = $s;
                $alertType = 'alert-danger';
                break;
            case 'caution':
                $name = $s;
                $alertType = 'alert-warning';
                break;
            case 'info':
                $name = $s;
                $alertType = 'alert-info';
                break;
            default:
                $alertType = 'alert-info';
                break;
        }
    }
?>
<div class="alert <?php echo $alertType; ?> fade in">
    <button class="close" type="button" data-dismiss="alert">x</button>
    <div class="errorSummary">
        <strong><?php echo strtoupper($name); ?></strong>: <?php echo $message; ?>
    </div>
</div>  
<?php } ?>