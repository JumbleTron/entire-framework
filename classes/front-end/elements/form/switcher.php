<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Switcher extends Element {
    
    private $options;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            $this->options = $element['options'];
        }
    }
    
    public function render() {
        $render = '<div class="onoffswitch">';
        $render .= "<input type=\"checkbox\" ".$this->entire_framework_checked(false,$this->_value);
        $render .= 'class="onoffswitch-checkbox" id="myonoffswitch" name="'.$this->_name.'" >';
        $render .= '<label class="onoffswitch-label" for="myonoffswitch">';
        $render .= '<span class="onoffswitch-inner"></span>';
        $render .= '<span class="onoffswitch-switch"></span>';
        $render .= '</label>';
        $render .= "</div>";
        return $this->_render($render);
    }
    
    public function addOption($option) {
        $this->options[] = $option;
    }
    
    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }
    
    private function entire_framework_checked($current,$value) {
        if(is_array($value)) {
            if(in_array($current,$value)) {
                return "checked='checked'";
            }
        }
        else {
           return checked($current,$this->_value,false); 
        }
    }

}

