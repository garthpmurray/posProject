<?php

/**
 * LogDb class.
 * 
 * Extends CDbLogRoute to include more information regarding the logs
 * 
 * @extends CDbLogRoute
 */
class ECDbLogRoute extends CDbLogRoute
{
	
	/**
	 * Creates the DB table for storing log messages.
	 * @param CDbConnection $db the database connection
	 * @param string $tableName the name of the table to be created
	 */
	protected function createLogTable($db,$tableName)
	{
        switch ($db->driverName) {
            case "mysql":
        		$db->createCommand()->createTable($tableName, array(
        			'id'=>'pk',
        			'error_set'=>'varchar(256) NOT NULL',
        			'level'=>'varchar(128)',
        			'category'=>'varchar(128)',
        			'logtime'=>'integer',
        			'message'=>'text',
        			'logRealTime'=>'timestamp NOT NULL',
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
        			'logRealTime'=>'timestamp NOT NULL',
        			'ip_user'=>'varchar(64) NOT NULL',
        			'request_url'=>'varchar(256) NOT NULL',
        			'http_referer'=>'varchar(256) NOT NULL',
        		));
                break;
            case "pgsql":
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
        			'http_referer'=>'varchar(256) NOT NULL',
        		));
            break;
        }
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
				'message'		=> $log[0]
			);
			
			if(Yii::app() instanceof CConsoleApplication){
				$insertArray['ip_user']		= 'console';
				$insertArray['request_url']	= 'consoleCommand';
			}else{
				$insertArray['ip_user']		= Yii::app()->request->userHostAddress;
				$insertArray['request_url']	= Yii::app()->request->url;
			}
			
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