<?php


/**
* ECDbCache Extension of CDbCache
*/
class ECDbCache extends CDbCache {
    
    protected function getValue($key)
    {
        $time=time();

        $db=$this->getDbConnection();
        if($db->getDriverName()=='sqlsrv' || $db->getDriverName()=='mssql' || $db->getDriverName()=='dblib')
            $select='CONVERT(VARCHAR(MAX), value)';
        else
            $select='value';
        $sql="SELECT {$select} FROM {$this->cacheTableName} WHERE id='$key' AND (expire=0 OR expire>$time)";
        
        if($db->getDriverName()=='pgsql'){
            $db->createCommand("SET bytea_output=escape")->execute();
        }
        
        if($db->queryCachingDuration>0)
        {
            $duration=$db->queryCachingDuration;
            $db->queryCachingDuration=0;
            $result=$db->createCommand($sql)->queryScalar();
            $db->queryCachingDuration=$duration;
            return $result;
        }
        else{
            $result = $db->createCommand($sql)->queryScalar();
            return $result;
        }
    }
}
