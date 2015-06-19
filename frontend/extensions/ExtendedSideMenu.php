<?php
Yii::import('zii.widgets.CMenu');

class ExtendedSideMenu extends CMenu
{

    public $test = false;

    public function init(){
        $this->activeCssClass = 'active';
        $this->activateParents = true;
        
        if(!isset($this->htmlOptions['class'])){
            $this->htmlOptions['class'] = '';
        }
        
        $this->htmlOptions['class'] .= ' main-navigation-menu';
        $this->recursiveSetLeaves($this->items);
        parent::init();
    }

    private function recursiveSetLeaves(&$items)
    {
        foreach ($items as &$item) {
            if (isset($item['items']) && count($item['items']) > 0) {
                if(isset($item['subModule']) && isset(Yii::app()->controller->module)){
                    if($item['subModule'] == Yii::app()->controller->module->id){
                        $item['active'] = true;
                    }
                }
                $this->recursiveSetLeaves($item['items']);
            } else {
                if(!isset($item['itemOptions']['class'])){
                    if(!is_array($item)){
                        ob_start();
                        var_export($item);
                        $variable = ob_get_clean();
                        throw new Exception("Item isn't an array. ".$variable);
                    }
                    $item['itemOptions']['class'] = '';
                }
                // this is a leaf
                $test = array(
                    'item0' => $item['url'][0],
                    'requestUri' => Yii::app()->request->requestUri,
                    'check' => ($item['url'][0] == Yii::app()->request->requestUri),
                );
                
                if($item['url'][0] == Yii::app()->request->requestUri){
//                   || $this->determineUrl($item['url'][0]);
                    $item['active'] = true;
                }
                
                $item['itemOptions']['class'] .= ' leaf';
            }
        }
        unset ($item);
    }
    
    private function determineUrl($url){
        $route = $this->getController()->getRoute();
        $requestUriExplode = explode('?', Yii::app()->request->requestUri);
        $requestUriExplode = explode('/', trim($requestUriExplode[0],'/'));
        $urlExplode = explode('/', trim($url,'/'));
        if($requestUriExplode == $urlExplode){
            return true;
        }
        
        $return = false;
        foreach($requestUriExplode as $key => $value){
//            if($urlExplode[]){
                
//            }
        }
        var_dump($requestUriExplode);
        var_dump($urlExplode);
        var_dump(!strcasecmp(trim($url,'/'),$route));
        var_dump(Yii::app()->controller->action->id);
//        var_dump(Yii::app()->controller->module->id);
        die();
        
        Yii::log(CVarDumper::dumpAsString(Yii::app()->controller, 10, true), 'varDumper', 'controllerId');
        Yii::log(CVarDumper::dumpAsString($urlExplode, 10, true), 'varDumper', $url);
        Yii::log(CVarDumper::dumpAsString($requestUriExplode, 10, true), 'varDumper', $url);
        return $return;
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
     * @return string
     * @since 1.1.6
     */
    protected function renderMenuItem($item){
        if(isset($item['url'])){
            $subNavStyle = '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>';

            $label = (isset($item['subnav']) && $item['subnav'] == true) ? "{$subNavStyle}" : "";
            $label .= isset($item['labelIcon']) ? "<span class=\"{$item['labelIcon']} fa-fw\"></span>   " : "";
            $label .= $this->linkLabelWrapper === null ? $item['label'] : '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';

            if(isset($item['items']) && !empty($item['items'])){
                $label .= '<i class="icon-arrow"></i>';
            }
            
            return CHtml::link($label, $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : array());
        }else{
            return CHtml::tag('span', isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
        }
    }

}
