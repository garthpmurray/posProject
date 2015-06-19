<?php
class RequireLogin extends CBehavior
{
    public function attach($owner){
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
    }
    
    public function handleBeginRequest($event){
        $rights = Yii::app()->getModule('rights');
        if((!is_null($rights) && !$rights->install) || (is_null($rights))){
            $allowedUrls = array('/user/recovery');
            $allowedUrls = array_merge(Yii::app()->user->loginUrl, $allowedUrls);
            
            if (Yii::app()->user->isGuest && !in_array(Yii::app()->request->getUrl(),$allowedUrls) && !$this->allowedPaths()){
                Yii::app()->user->loginRequired();
            }
        }
    }
    
    protected function allowedPaths(){
        $url = ltrim(Yii::app()->request->getUrl(), '/');
        $urlExplode = explode('/', $url);
        
        $allowedPaths = array(
            'system',
            'api',
            'apiRebuild',
        );
        $return = in_array($urlExplode[0],$allowedPaths);
        return $return;
    }
}
?>
