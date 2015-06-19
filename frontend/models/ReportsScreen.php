<?php
    
class ReportsScreen
{
    
    public $_data;
    public $_sortedData;
    public $_screenData;
    public $_screenTypes;
    
    public function getReportData(){
        $decks = $this->decks($this->_data);
        $data = array();
        foreach($decks as $key => $value){
            $subnets = $this->subnet($value);
            $screenTypes = array();
            foreach($subnets as $k=>$v){
                $screenTypes[$k] = $this->screenType($v);
            }
            
            $data[$key] = $screenTypes;
        }
        $this->_sortedData = $data;
        return $this;
    }
    
    public function getScreenTypes(){
        $this->_screenTypes = array('' => 'none')+GxHtml::listDataEx(ScreenType::model()->findAllAttributes(null, true));
        return $this;
    }
    
    public function getScreenData(){
        $this->_data = Screen::model()->findAll();
        return $this;
    }
    
    public function decks($data){
        $decks = array();
        
        foreach($data as $d){
            
            if(!isset($d->screenDetail->deck)){
                $deck = null;
            }else{
                $deck = $d->screenDetail->deck;
            }
            
            $decks[$deck][] = $d;
        }
        
        
        return $decks;
    }
    
    public function subNet($data){
        $subnets = array();
        
        foreach($data as $d){
            $subnet = explode('.', $d->ip_address);
            
            if(isset($subnet[2])){
                $subnets[$subnet[2]][] = $d;
            }else{
                $subnets['none'][] = $d;
            }
        }
        return $subnets;
    }
    
    public function screenType($data){
        $screenTypes = array();
        
        foreach($data as $d){
            if(isset($d->type_id)){
                $screenTypes[$this->_screenTypes[$d->type_id]][] = $d;
            }else{
                $screenTypes[null][] = $d;
            }
        }
        return $screenTypes;
    }
    
    public function getScreenStatus(){
        $data = Yii::app()->db->createCommand('SELECT "count"(*) as statuscount, status FROM provision_screen GROUP BY status')->queryAll();
        $return = array();
        
        foreach($data as $d){
            $return[] = array(
                'label' => $d['status'] ? 'Up' : 'Down',
                'value' => $d['statuscount'],
            );
        }
        
        return $return;
    }
    
    public function getScreenUpStatus(){
        $data = Yii::app()->db->createCommand('SELECT "count"(*) as debugflagcount, "debugFlag" FROM provision_screen GROUP BY "debugFlag"')->queryAll();
        $return = array();
        
        foreach($data as $d){
            $return[] = array(
                'label' => $d['debugFlag'] ? 'Up' : 'Down',
                'value' => $d['debugflagcount'],
            );
        }
        
        return $return;
    }
    
    public function getScreenVersion(){
        $version = Yii::app()->db->createCommand('SELECT
            "count"(*) as versioncount,
            system_version, type_id
        FROM
            provision_screen
        GROUP BY system_version, type_id')->queryAll();
        $return = array();
        foreach($version as $v){
            $return[$this->_screenTypes[$v['type_id']]][] = array(
                'label' => 'v'.(is_null($v['system_version']) ? '0' : $v['system_version']),
                'value' => $v['versioncount']
            );
        }
        
        return $return;
    }
    
    public function getScreenStatusType($type = 1){
        $data = Yii::app()->db->createCommand('SELECT
            "count"(*) as debugcount,
            "debugFlag", type_id
        FROM
            provision_screen
        GROUP BY "debugFlag", type_id')->queryAll();
        $return = array();
        
        switch($type){
            case 1:
                foreach($data as $v){
                    $return[$this->_screenTypes[$v['type_id']]][] = array(
                        'label' => $v['debugFlag'] ? 'Up' : 'Down',
                        'value' => $v['debugcount']
                    );
                }
                break;
            case 2:
                foreach($data as $v){
                    $status = $v['debugFlag'] ? 'Up' : 'Down';
                    $return[$status]['key'] = $status;
                    $return[$status]['values'][] = array(
                        'label' => $this->_screenTypes[$v['type_id']],
                        'value' => $v['debugcount']
                    );
                }
                $return = array_values($return);
                break;
        }
        
        return $return;
    }
    
    
    public function generateTreeArray($subData = null){
        $subData = is_null($subData) ? $this->_sortedData : $subData;
        $data = array();
        foreach($subData as $key1 => $value1){
            $data[$key1] = array(
                'text' => "Deck {$key1}",
                'children'  => array(),
            );
            $blocks = true;
            foreach($value1 as $key2 => $value2){
                $data[$key1]['children'][$key2] = array(
                    'text' => "Subnet {$key2}",
                    'children'  => array(),
                );
                $types = true;
                foreach($value2 as $key3 => $value3){
                    $data[$key1]['children'][$key2]['children'][$key3] = array(
                        'text' => "Screen Type {$key3}",
                        'children'  => array(),
                    );
                    $screens = true;
                    foreach($value3 as $v){
                        
                        $array = array(
                            'text' => $v->clean_name.' - '.$v->mac_address,
                            'a_attr' => array(
                                'data-screenId' => $v->id,
                                'class' => 'screenCheck',
                            ),
                        );
                        
                        if($v->debugFlag){
                            $array['icon'] = "fa fa-desktop text-green";
                        }else{
                            $screens = false;
                            $array['icon'] = "fa fa-desktop text-red";
                        }
                        
                        $data[$key1]['children'][$key2]['children'][$key3]['children'][] = $array;
                    }
                    
                    if($screens){
                        $data[$key1]['children'][$key2]['children'][$key3]['icon'] = "fa fa-cube text-green";
                    }else{
                        $types = false;
                        $data[$key1]['children'][$key2]['children'][$key3]['icon'] = "fa fa-cube text-red";
                    }
                    
                }
                
                if($key2 !== 'none' && $types){
                    $data[$key1]['children'][$key2]['icon'] = "fa fa-code-fork  text-green";
                }else{
                    $blocks = false;
                    $data[$key1]['children'][$key2]['icon'] = "fa fa-code-fork  text-red";
                }
                
                $data[$key1]['children'][$key2]['children'] = array_values($data[$key1]['children'][$key2]['children']);
            }
            $data[$key1]['children'] = array_values($data[$key1]['children']);

            if($blocks){
                $data[$key1]['icon'] = "fa fa-bars text-green";
            }else{
                $data[$key1]['icon'] = "fa fa-bars text-red";
            }
        }
        return $data;
    }
    
}