<?php

/**
 * ECDbHttpSession
 * 
 * @package Yii
 * @author Twisted1919
 * @copyright 2011
 * @version 1.3
 * @access public
 */
class ECDbHttpSession extends CDbHttpSession
{

    public $_compareIpBlocks=2;
    public $_compareIpAddress=false;
    public $_compareUserAgent=false;
    
    /**
     * MyCDbHttpSession::createSessionTable()
     * 
     * @param mixed $db
     * @param mixed $tableName
     * @return
     */
    protected function createSessionTable($db, $tableName)
    {
        $ipAddress = "int(10) unsigned NOT NULL DEFAULT '0'";
        switch($db->getDriverName())
        {
            case 'mysql':
                $blob='LONGBLOB';
                break;
            case 'pgsql':
                $blob='text';
                $ipAddress = 'int4 NOT NULL DEFAULT 0';
                break;
            case 'sqlsrv':
            case 'mssql':
            case 'dblib':
                $blob='VARBINARY(MAX)';
                break;
            default:
                $blob='BLOB';
                break;
        }
        $db->createCommand()->createTable($tableName,array(
            'id'                 => 'CHAR(32) PRIMARY KEY',
            'ip_address'         => $ipAddress,
            'user_agent'         => 'char(32) NOT NULL',
            'expire'             => 'integer',
            'data'               => $blob,
            'human_ip_address'   => 'varchar(64) NOT NULL',
        ));
        
    }

    /**
     * Updates the current session id with a newly generated one.
     * Please refer to {@link http://php.net/session_regenerate_id} for more details.
     * @param boolean $deleteOldSession Whether to delete the old associated session file or not.
     * @since 1.1.8
     */
    public function regenerateID($deleteOldSession=false)
    {
        $oldID=session_id();

        // if no session is started, there is nothing to regenerate
        if(empty($oldID))
            return;

        CHttpSession::regenerateID(false);
        $newID=session_id();
        $db=$this->getDbConnection();

        $row=$db->createCommand()
            ->select()
            ->from($this->sessionTableName)
            ->where('id=:id',array(':id'=>$oldID))
            ->queryRow();
        if($row!==false)
        {
            if($deleteOldSession)
                $db->createCommand()->update($this->sessionTableName,array(
                    'id'=>$newID
                ),'id=:oldID',array(':oldID'=>$oldID));
            else
            {
                $row['id']=$newID;
                $db->createCommand()->insert($this->sessionTableName, $row);
            }
        }
        else
        {
            // shouldn't reach here normally
            $update = array(
                'id'=>$newID,
                'expire'=>time()+$this->getTimeout(),
                'data'=>'',
                'user_agent' => md5(Yii::app()->request->getUserAgent()),
                'human_ip_address'  => Yii::app()->request->getUserHostAddress(),
            );
            
            if($this->getCompareIpAddress()){
                if($this->getCompareIpBlocks() > 0)
                    $update['ip_address'] = sprintf("%u", ip2long($this->getClientIpBlocks()));
                else
                    $update['ip_address'] = sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()));
            }else{
                $update['ip_address'] = sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()));
            }
            
            $db->createCommand()->insert($this->sessionTableName, $update);
        }
    }

    /**
     * MyCDbHttpSession::readSession()
     * 
     * @param mixed $id
     * @return mixed $data on success, empty string on failure
     */
    public function readSession($id)
    {
    
        $data = $this->getDbConnection()->createCommand()
        ->select('data')
        ->from($this->sessionTableName)
        ->where('id = :id', array(':id' => $id))
        ->limit(1);
        
        if($this->getCompareIpAddress()){
            if($this->getCompareIpBlocks() > 0){
                $data->andWhere('ip_address = :ip', array(':ip' => sprintf("%u", ip2long($this->getClientIpBlocks()))));
            }else{
                $data->andWhere('ip_address = :ip', array(':ip' => sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()))));
            }
        }
        if($this->getCompareUserAgent()){
            $data->andWhere('user_agent = :ua', array(':ua' => md5(Yii::app()->request->getUserAgent())));
        }
        
        $data->andWhere('expire > :expire', array(':expire' => time()));
        
        $data = $data->queryScalar();
        return (false === $data) ? '' : $data;
        
    }
    
    /**
     * MyCDbHttpSession::writeSession()
     * 
     * @param mixed $id
     * @param mixed $data
     * @return boolean
     */
    public function writeSession($id, $data)
    {
        try
        {
            $check = Yii::app()->db->createCommand()
            ->select('id')
            ->from($this->sessionTableName)
            ->where('id = :id', array(':id' => $id))
            ->limit(1);

            $expire=time() + $this->getTimeout();
            
            if($this->getCompareIpAddress()){
                if($this->getCompareIpBlocks() > 0){
                    $check->andWhere('ip_address = :ip', array(':ip' => sprintf("%u", ip2long($this->getClientIpBlocks()))));
                }else{
                    $check->andWhere('ip_address = :ip', array(':ip' => sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()))));
                }
            }
            if($this->getCompareUserAgent()){
                $check->andWhere('user_agent = :ua', array(':ua' => md5(Yii::app()->request->getUserAgent())));
            }

            if(false===$check->queryAll()){
                
                Yii::app()->db->createCommand()->delete($this->sessionTableName, 'id = :id', array(':id' => $id))->execute();
                
                $insert = array(
                    'id' => $id,
                );
                if($this->getCompareIpAddress())
                {
                    if($this->getCompareIpBlocks() > 0)
                        $insert['ip_address'] = sprintf("%u", ip2long($this->getClientIpBlocks()));
                    else
                        $insert['ip_address'] = sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()));
                }else{
                    $insert['ip_address'] = sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()));
                }
/*
                if($this->getCompareUserAgent()){
                    $insert['user_agent'] = md5(Yii::app()->request->getUserAgent());
                }
*/
                $insert['user_agent'] = md5(Yii::app()->request->getUserAgent());
                $insert['human_ip_address'] = Yii::app()->request->getUserHostAddress();
                $insert['expire'] = $expire;
                $insert['data'] = $data;

                Yii::app()->db->createCommand()->insert($this->sessionTableName, $insert)->execute();
            }else{
                $update = array(
                    'expire'    => $expire,
                    'data'      => $data,
                );
                
                if($this->getCompareIpAddress()){
                    if($this->getCompareIpBlocks() > 0)
                        $update['ip_address'] = sprintf("%u", ip2long($this->getClientIpBlocks()));
                    else
                        $update['ip_address'] = sprintf("%u", ip2long(Yii::app()->request->getUserHostAddress()));
                }
                if($this->getCompareUserAgent()){
                    $update['user_agent'] = md5(Yii::app()->request->getUserAgent());
                }
                
                Yii::app()->db->createCommand()->update($this->sessionTableName, $update, 'id=:id', array(':id'=>$id))->execute();
            }
        }
        catch(Exception $e)
        {
            if(YII_DEBUG)
                echo $e->getMessage();
            return false;
        }
        return true;
    }
    
    /**
     * MyCDbHttpSession::getClientIpBlocks()
     * 
     * @return on success newly created ip based on block, on failure, localhost ip
     * 
     * Note, we could use a regular expression like:
     * /^([0-9]{1,3}+\.)([0-9]{1,3}+\.)([0-9]{1,3}+\.)([0-9]{1,3}+)$/
     * But, i think it's better this way because we have more control over the IP blocks.
     */
    public function getClientIpBlocks()
    {
        $remoteIp=Yii::app()->request->getUserHostAddress();
        if(strpos($remoteIp,'.')!==false)
        {
            $blocks=explode('.',$remoteIp);
            $partialIp=array();
            $continue=false;
            $i=0;
            if(count($blocks)==4)
            {
                $continue=true;
                foreach($blocks AS $block)
                {
                    ++$i;
                    if(false===is_numeric($block)||$block<0||$block>255)
                    {
                        $continue=false;
                        break;
                    }
                    if($i<=$this->getCompareIpBlocks())
                        $partialIp[]=$block;
                    else
                        $partialIp[]=0;
                }
            }
            if($continue)
                return implode('.',$partialIp);
        }
        return '127.0.0.1';     
    }
    
    /**
     * MyCDbHttpSession::setCompareIpBlocks()
     * 
     * @param int $int
     */
    public function setCompareIpBlocks($int)
    {
        $int=(int)$int;
        if($int < 0)
            $this->_compareIpBlocks=0;
        elseif($int > 4)
            $this->_compareIpBlocks=4;
        else
            $this->_compareIpBlocks=$int;
    }
    
    /**
     * MyCDbHttpSession::getCompareIpBlocks()
     */
    public function getCompareIpBlocks()
    {
        return $this->_compareIpBlocks;
    }
    
    /**
     * MyCDbHttpSession::setCompareIpAddress()
     * 
     * @param bool $bool
     */
    public function setCompareIpAddress($bool)
    {
        $this->_compareIpAddress=(bool)$bool;
    }
    
    /**
     * MyCDbHttpSession::getCompareIpAddress()
     */
    public function getCompareIpAddress()
    {
        return $this->_compareIpAddress;
    }
    
    /**
     * MyCDbHttpSession::setCompareUserAgent()
     * 
     * @param bool $bool
     */
    public function setCompareUserAgent($bool)
    {
        $this->_compareUserAgent=(bool)$bool;
    }
    
    /**
     * MyCDbHttpSession::getCompareUserAgent()
     */
    public function getCompareUserAgent()
    {
        return $this->_compareUserAgent;
    }
    
}

?>