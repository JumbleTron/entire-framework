<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Textbox extends Element {
    
    private $type;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['element_type'])) {
            $this->setType($element['element_type']);
        } else {
            $this->type = 'text';
        }
    }

    public function render() {
        $render = '<input type="'.$this->type.'" name="'.$this->_name.'" id="'.$this->_id.'" ';
        $render .= 'value="'.$this->_value.'" class="'.$this->_class.'"/>';
        return $this->_render($render);
    }
    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $avalible = array('text','password','color','date','datetime','datetime-local','email','month',
        'number','range','search','tel','time','url','week');
        if(in_array($type,$avalible)) {
            $this->type = $type;
        } else {
            $this->type = 'text';
        }
    }


}
