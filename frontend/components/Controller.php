<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='column1';
	public $title;
	public $subTitle;
	public $_pageTitle;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
    public function filters() {
        return array( 'rights' );
    }

    public function allowedActions() {
        return 'error,login,logout';
    }
    
    /**
     * @return string the page title. Defaults to the controller name and the action name.
     */
    public function getPageTitle(){
        if($this->_pageTitle!==null)
            return $this->_pageTitle.'1';
        else
        {
            $name=ucfirst(basename($this->getId()));
            $module = isset($this->module) ? ucfirst($this->module->id).' - ' : '';
            if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction))
                return $this->_pageTitle=Yii::app()->name.' - '.$module.ucfirst($this->getAction()->getId()).' '.$name;
            else
                return $this->_pageTitle=Yii::app()->name.' - '.$module.$name;
        }
    }
}