<?php

/**
 * LogDb class.
 * 
 * Extends CDbLogRoute to include more information regarding the logs
 * 
 * @extends CDbLogRoute
 */
class LogDbConsole extends CDbLogRoute
{
	protected function createLogTable($db,$tableName)
	{
		$db->createCommand()->createTable($tableName, array(
			'id'=>'pk',
			'error_set'=>'varchar(256) NOT NULL',
			'level'=>'varchar(128)',
			'category'=>'varchar(128)',
			'logtime'=>'integer',
			'message'=>'text',
			'logRealTime'=>'timestamp(6) NOT NULL',
			'ip_user'=>'varchar(64) NOT NULL',
			'request_url'=>'varchar(256) NOT NULL',
		));
		$db->createCommand()->createTable('sys_log_404', array(
			'id'=>'pk',
			'error_set'=>'varchar(256) NOT NULL',
			'level'=>'varchar(128)',
			'category'=>'varchar(128)',
			'logtime'=>'integer',
			'message'=>'text',
			'logRealTime'=>'timestamp(6) NOT NULL',
			'ip_user'=>'varchar(64) NOT NULL',
			'request_url'=>'varchar(256) NOT NULL',
		));
	}

	protected function processLogs($logs)
	{
		$command = $this->getDbConnection()->createCommand();
		$logTime = date('Y-m-d H:i:s'); //Get Current Date
		$errorSet = md5(microtime() + mt_rand('1000','9999'));

		$error404 = false;
		$sphinxError = false;
		foreach($logs as $log){
			if(strpos($log[2], 'CHttpException.404')){
				$error404 = true;
			}
			if(strpos($log[2], 'DGSphinxSearchException')){
				$sphinxError = true;
			}
		}

		foreach($logs as $log)
		{
			
			$insertArray = array(
				'level'			=> $log[1],
				'category'		=> $log[2],
				'logtime'		=> time(),
				'logRealTime'	=> $logTime,
				'error_set'		=> $errorSet,
				'ip_user'		=> Yii::app()->request->userHostAddress, //Get Ip 
				'request_url'	=> 'console', // Get Url
				'message'		=> $log[0]
			);
			
			if($error404){
				$tablename = 'sys_log_404';
				$insertArray['http_referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			}elseif($sphinxError){
				$tablename = 'sys_log_sphinx';
			}else{
				$tablename = $this->logTableName;
			}
			$command->insert($tablename, $insertArray);
		}
	}

}

?>