<?php

/**
 * EHttpRequest class.
 * 
 * Extension to utilize loadbalancer specific server variables
 * 
 * @extends CHttpRequest
 */
class EHttpRequest extends CHttpRequest
{
	private $_pathInfo;
	/**
	 * Returns the user IP address.
	 * 
	 * extended to use the HTTP_X_FORWARDED_FOR server variable set by the load balancer
	 * 
	 * @return string user IP address
	 */
	public function getUserHostAddress()
	{
		$ip_user = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR']: $_SERVER['REMOTE_ADDR'];
		
		return !empty($ip_user)?$ip_user:'127.0.0.1';
	}

    public function getPathInfo()
    {
        if($this->_pathInfo===null)
        {
            $pathInfo=$this->getRequestUri();
        
            if(($pos=strpos($pathInfo,'?'))!==false)
               $pathInfo=substr($pathInfo,0,$pos);
    
            $pathInfo=$this->decodePathInfo($pathInfo);
    
            $scriptUrl=$this->getScriptUrl();
            $baseUrl=$this->getBaseUrl();
            
            if(strpos($pathInfo,$scriptUrl)===0)
                $pathInfo=substr($pathInfo,strlen($scriptUrl));
            elseif($baseUrl==='' || strpos($pathInfo,$baseUrl)===0)
                $pathInfo=substr($pathInfo,strlen($baseUrl));
            elseif(strpos($_SERVER['PHP_SELF'],$scriptUrl)===0)
                $pathInfo=substr($_SERVER['PHP_SELF'],strlen($scriptUrl));
            else
                throw new CException(Yii::t('yii','CHttpRequest is unable to determine the path info of the request.'));
    
            $this->_pathInfo=trim($pathInfo,'/');
        }
        
        return $this->_pathInfo;
    } 

}
