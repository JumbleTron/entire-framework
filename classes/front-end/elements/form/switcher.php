<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Switcher extends Element {
    
    private $on = 'ON';
    private $off = 'OFF';
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            if(isset($element['options'][0])) {
                $this->on = $element['options'][0];
            }
            if(isset($element['options'][1])) {
                $this->off = $element['options'][1];
            }
        }
    }
    
    public function render() {
        $render = $this->addStyle();
        $render .= '<div class="onoffswitch">';
        $render .= "<input type=\"checkbox\" ".checked("true",$this->_value,false);
        $render .= 'class="onoffswitch-checkbox" id="myonoffswitch" name="'.$this->_name.'" value="true" >';
        $render .= '<label class="onoffswitch-label" for="myonoffswitch">';
        $render .= '<span class="onoffswitch-inner"></span>';
        $render .= '<span class="onoffswitch-switch"></span>';
        $render .= '</label>';
        $render .= "</div>";
        return $this->_render($render);
    }
    
    private function addStyle() {
        $render = '<style type="text/css">';
        if(strtoupper($this->on) != 'ON') {
            $render .= '.onoffswitch-inner:before {';
            $render .= 'content: "'.$this->on.'"; }';
        }
        if(strtoupper($this->off) != 'OFF') {
            $render .= '.onoffswitch-inner:after {';
            $render .= 'content: "'.$this->off.'"; }';
        }
        $render .= '</style>';
        if(strtoupper($this->on) != 'ON' || strtoupper($this->off) != 'OFF') {
            return $render;
        }
    }
}

