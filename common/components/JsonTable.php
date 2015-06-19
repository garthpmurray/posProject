<?php
/**
 * JsonTable class.
 * Create Takes a json feed and converts it to a usable input form.
 * User: Garth
 * 
 * @extends CComponent
 */
class JsonTable extends CComponent
{
    
    
    
    /**
     * _format
     * 
     * 1 = div
     * 0 = table
     * 
     * @var int
     * @access protected
     */
    protected $_format = 0;
    protected $_tools = array(
        'collapse' => array(
            'href' => '#',
            'icon'=> 'fa fa-angle-up',
            'options' => array(
                'class' => 'panel-collapse collapses',
            ),
        ),
        'fullscreen' => array(
            'href' => '#',
            'icon'=> 'fa fa-expand',
            'options' => array(
                'class' => 'panel-expand',
            ),
        ),
    );
    
    public function init(){
        
    }
    
    public function setFormat($format = 0){
        $this->_format = $format;
        return $this;
    }
    
    public function formatJson($json){
        if($this->_format){
            $result = $this->divFormat($json, $lvl = '');
        }else{
            $result = $this->tableFormat($json, $lvl = '');
        }
        
        return $result;
    }
    
    protected function tableFormat($data, $lvl = ''){
        $return = '<table class="table table-bordered">';
        
        foreach($data as $k=>$v){
            $return .= '<tr>';
            if(is_array($v) || is_object($v)){
                $return .= "<td>{$k}</td><td>".$this->tableFormat($v, "{$lvl}[$k]").'</td>';
            }elseif($k == 'image' || $k == 'thumbnail' || $k == 'location_image'){
                $name = "json{$lvl}[{$k}]";
                $id = str_replace(']', '', str_replace('[', '_', $name));
                
                $return .= '<td>'.CHtml::label($k, $name).' '.CHtml::link('Asset List', '#inline', array('class'=>'inlineFancy assetChoiceLink', 'data-link-id'=>$id, 'style'=>'float:right')).'</td>';
                $return .= '<td>'.CHtml::hiddenField($name, $v).CHtml::image($v, '', array('id' => "{$id}_disabled", 'class'=> 'img-responsive')).'</td>';
//                $return .= '<td>'.CHtml::hiddenField($name, $v).CHtml::textField($name.'_disabled', $v, array('disabled'=> true, 'style'=>'width:100%')).'</td>';
            }elseif(strlen($v) >= 150){
                $return .= '<td>'.CHtml::label($k, "json{$lvl}[{$k}]").'</td>';
                $return .= '<td>'.CHtml::textArea("json{$lvl}[{$k}]", $v, array('style'=>'width:100%;')).'</td>';
            }else{
                $return .= '<td>'.CHtml::label($k, "json{$lvl}[{$k}]").'</td>';
                $return .= '<td>'.CHtml::textField("json{$lvl}[{$k}]", $v).'</td>';
            }
            $return .= '</tr>';
        }
        return $return.'</table>';
    }
    
    protected function divFormat($data, $lvl = '', $depth = -1, $test = false){
        $depth++;
        $return = '';
        $skip = array();
        foreach($data as $k => $v){
            if(is_array($v) || is_object($v)){
                $skip[$k] = $v;
            }else{
                $return .= $this->inputField($k, $v, $lvl);
            }
        }
        
        if(!empty($skip)){
            foreach($skip as $k => $v){
                $v = is_object($v) ? (array)$v : $v;
                if(is_numeric(implode('',array_keys($v)))){
                    $return .= $this->twoBytwo($k, $v, $lvl, $depth);
                }else{
                    $return .= $this->panelSet($k, $v, $lvl, $depth);
                }
            }
        }
        
        
//        $return .= '</div>';
        return $return;
    }
    
    protected function panelSet($k, $v, $lvl, $depth, $test = false){
        ob_start();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <div class="panel panel-white">
                <?= $this->returnHeader(CHtml::label($k, "{$lvl}[{$k}]", array('style' => 'font-weight:700;text-transform: capitalize;'))) ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $this->divFormat($v, "{$lvl}[{$k}]", $depth); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        return ob_get_clean();
    }
    
    protected function twoBytwo($k, $v, $lvl, $depth, $test = false){
        ob_start();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <div class="panel panel-white">
                <?= $this->returnHeader(CHtml::label($k, "{$lvl}[{$k}]", array('style' => 'font-weight:700;text-transform: capitalize;'))) ?>
                <div class="panel-body">
                    <div class="row">
                    <?php
                        $column = $this->colSet($v, $depth);
                        foreach($v as $setK => $setV){
                    ?>
                        <div class="<?= $column ?>">
                            <div class="panel panel-white">
                                <?= $this->returnHeader($setK) ?>
                                <div class="panel-body">
                                    <?php echo $this->divFormat($setV, "{$lvl}[$k][{$setK}]", $depth); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        return ob_get_clean();
    }
    
    protected function inputField($k, $v, $lvl){
        ob_start();
?>
<div class="row form-group">
    <div class="col-xs-12">
        <?php 
            if($k == 'image' || $k == 'thumbnail' || $k == 'location_image'){
                $name = "json{$lvl}[{$k}]";
                $id = str_replace(']', '', str_replace('[', '_', $name));
                echo CHtml::label($k, $name);
                echo CHtml::link('Asset List', '#inline', array('class'=>'inlineFancy assetChoiceLink', 'data-link-id'=>$id, 'style'=>'float:right'));
            }else{
                echo CHtml::label($k, "json{$lvl}[{$k}]");
            }
        ?>
    </div>
    <div class="col-xs-12">
        <?php
            if($k == 'image' || $k == 'thumbnail' || $k == 'location_image'){
                $name = "json{$lvl}[{$k}]";
                $id = str_replace(']', '', str_replace('[', '_', $name));
                
                echo CHtml::hiddenField($name, $v).CHtml::image($v, '', array('id' => "{$id}_disabled", 'class'=> 'img-responsive'));
            }elseif(strlen($v) >= 150){
                echo CHtml::textArea("json{$lvl}[{$k}]", $v, array('style'=>'width:100%;', 'class' => 'form-control'));
            }else{
                echo CHtml::textField("json{$lvl}[{$k}]", $v, array('class' => 'form-control'));
            }
        ?>
    </div>
</div>
<?php
        return ob_get_clean();
    }
    
    protected function returnHeader($header, $tools = null){
        $return = CHtml::openTag('div', array('class' => 'panel-heading'));
            $return .= CHtml::openTag('h4', array('class' => 'panel-title'));
                $return .= $header;
            $return .= CHtml::closeTag('h4');
            //$return .= $this->generateTools($tools);
        $return .= CHtml::closeTag('div');
        return $return;
    }
    
    protected function generateTools($tools){
        if(!is_null($tools) && is_array($tools)){
            $tools = CMap::mergeArray($this->_tools, $tools);
        }else{
            $tools = $this->_tools;
        }
        $return = CHtml::openTag('div', array('class' => 'panel-tools'));
            $return .= CHtml::openTag('div', array('class' => 'dropdown'));
                $return .= CHtml::link('<i class="fa fa-cog"></i>', '', array('class'=>'btn btn-xs dropdown-toggle btn-transparent-grey', 'data-toggle'=>'dropdown'));
                $return .= CHtml::openTag('ul', array('class' => 'dropdown-menu dropdown-light pull-right', 'role'=>'menu', 'style'=>'display: none;'));
                    foreach($tools as $key => $value){
                        $return .= $this->generateTool($key, $value);
                    }
                $return .= CHtml::closeTag('ul');
            $return .= CHtml::closeTag('div');
        $return .= CHtml::closeTag('div');
        return $return;
    }
    
    protected function generateTool($name, $value){
        $return = CHtml::openTag('li');
        $return .= CHtml::link("<i class='{$value['icon']}'></i> <span>".ucfirst($name)."</span>", $value['href'], $value['options']);
        $return .= CHtml::closeTag('li');
        return $return;
    }
    
    protected function colSet($set, $depth){
/*
        Yii::log(CVarDumper::dumpAsString($depth, 10, true), 'varDumper', '$depth');
        
        $format = '(%1$2d = %1$04b) = (%2$2d = %2$04b)'. ' %3$s (%4$2d = %4$04b)' . "\n";
        printf($format, (count($set) & 12), count($set), '&', 12);
        
        //Yii::log(CVarDumper::dumpAsString((count($set) & 12).' '.count($set), 10, true), 'varDumper', 'test');
        $count = floor(12/floor(sqrt(count($set))));
        $column = $count < 4 ? 4 : $count;
        if($depth >= 1 && $column <= 5){
            $column = 'col-xs-12';
        }else{
            $column = "col-xs-12 col-md-{$column}";
        }
*/
        if($depth >= 1){
            $column = 'col-xs-12';
        }else{
            $column = "col-xs-12 col-md-6";
        }
        
        return $column;
    }
    

/*
    <? if($test){
        var_dump($setK);
        var_dump($setV);
        var_dump("{$lvl}[$k][{$setK}]");
        die();
    } ?>
*/
    
}

array(
    'items' => array(
        'depth' => 5,
        'men'
    )
    
)


/*
?>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
  </div>

<div class="row">
    <div class="col-xs-12">
        <?= CHtml::label($k, "json{$lvl}[{$k}]") ?>
    </div>
    <div class="col-xs-12">
        <?= CHtml::textField("json{$lvl}[{$k}]", $v) ?>
    </div>
</div>


------------------------------------------------------------------------------------------
<div class="row">
    <div class="col-xs-12">
        <?= CHtml::label($k, "json{$lvl}[{$k}]") ?>
    </div>
    <div class="col-xs-2">
        
    </div>
    <div class="col-xs-2">
        
    </div>
    <div class="col-xs-2">
        
    </div>
    <div class="col-xs-2">
        
    </div>
    <div class="col-xs-2">
        
    </div>
    <div class="col-xs-2">
        
    </div>
</div>
------------------------------------------------------------------------------------------

<div class="row">
    <div class="col-xs-12">
        <?= CHtml::label($k, "json{$lvl}[{$k}]") ?>
    </div>
    <div class="col-xs-3">
        
    </div>
    <div class="col-xs-3">
        
    </div>
    <div class="col-xs-3">
        
    </div>
    <div class="col-xs-3">
        
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?= CHtml::label($k, "json{$lvl}[{$k}]") ?>
    </div>
    <div class="col-xs-4">
        
    </div>
    <div class="col-xs-4">
        
    </div>
    <div class="col-xs-4">
        
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?= CHtml::label($k, "json{$lvl}[{$k}]") ?>
    </div>
    <div class="col-xs-6">
        
    </div>
    <div class="col-xs-6">
        
    </div>
</div>

*/ ?>