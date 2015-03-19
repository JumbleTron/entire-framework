<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Checkbox extends Element {
    
    private $options;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            $this->options = $element['options'];
        }
    }
    
    public function render() {
        $render = '';
        foreach($this->options as $key => $value) {
            $id = $this->_generateID($value);
            $render .= "<label for='".$id."'>".$value."</label>";
            $render .= "<input type=\"checkbox\" ".$this->entire_framework_checked($key,$this->_value);
            $render .= " id='".$id."' value='".$key."' name='".$this->_name."[]' class='".$this->_class."'>";
        }
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

