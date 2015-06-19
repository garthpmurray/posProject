<?php
class ExtendedBreadcrumbs extends CWidget
{
    public $tagName='div';
    public $htmlOptions=array('class'=>'breadcrumbs');
    public $encodeLabel=true;
    public $homeLink;
    public $links=array();
    public $separator='';
//    public $separator='<li><span class="divider">&raquo;</span></li>';
    public $show = true;
    public $result;
    public function run()
    {
        if(empty($this->links))
                return;

        //echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        $links=array();
        
        if($this->homeLink===null){
                $links[]='<li>'.CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl).'</li>';
        }elseif($this->homeLink!==false){
                $links[]='<li><a href="'.Yii::app()->createUrl($this->homeLink).'">Home</a></li>';
        }
        
        if(isset(Yii::app()->controller) && isset(Yii::app()->controller->module)){
            if(!array_key_exists(ucfirst(Yii::app()->controller->module->id), $this->links)){
                $links[]='<li>'.CHtml::link(ucfirst(Yii::app()->controller->module->id), array('/'.Yii::app()->controller->module->id)).'</li>';
            }
        }
        
        foreach($this->links as $label=>$url)
        {
        //	die(var_dump($this->encodeLabel));
                if(is_string($label) || is_array($url))
                        $links[]='<li>'.CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url).'</li>';
                else
                        $links[]='<li class="active">'.ucfirst(($this->encodeLabel ? CHtml::encode($url) : $url)).'</li>';
        }
        if($this->show){
            echo implode($this->separator,$links);
        }else{
        	$this->result = implode($this->separator,$links);
        }
        //echo CHtml::closeTag($this->tagName);
    }
}