<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Select extends Element {
    
    private $options;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            $this->options = $element['options'];
        }
    }
    
    public function render() {
        $render = "<select id='".$this->_id."' name='".$this->_name."'".$this->getClass().">";
	$render .= $this->_emptyValue();
        foreach($this->options as $key => $value) {
            $render .= '<option value="'.$key.'" '.selected($key,$this->_value,false).'>'.$value.'</option>';
        }
        $render .= "</select>";
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
    

}

