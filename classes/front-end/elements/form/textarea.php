<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Textarea extends Element {
        
    public function __construct($element) {
        parent::__construct($element);
    }

    public function render() {
        $render = '<textarea name="'.$this->_name.'" id="'.$this->_id.'" ';
        $render .= 'class="'.$this->_class.'">'.$this->_value.'</textarea>';
        return $this->_render($render);
    }
}
