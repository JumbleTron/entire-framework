<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Radiobox extends Element {
    
    private $options;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            $this->options = $element['options'];
        }
    }
    
    public function render() {
        $render = '<div class="css3-radios">';
        foreach($this->options as $key => $value) {
            $id = $this->_generateID($value);
            $render .= "<label for='".$id."'>".$value."</label>";
            $render .= "<input type=\"radio\" ".checked($key,$this->_value,false);
            $render .= " id='".$id."' value='".$key."' name='".$this->_name."' class='".$this->_class."'/><span></span>";
        }
        $render .= '</div>';
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

