<?php

$commonParams = require(dirname(__FILE__).'/../../common/config/params.php');
$params = array(

);
return CMap::mergeArray($commonParams, $params);