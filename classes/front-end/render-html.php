<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/checkbox.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/file.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/radiobox.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/select.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/textarea.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/textbox.php');
class renderHTML {
    
    private $elemnet;
    private $type;


    public function __construct($element) {
        $this->elemnet = $element;
        if(isset($element['type'])) {
            $this->type = $element['type'];
        } else {
            $this->type = 'text';
        }
    }
    
    public function render() {
        $obj = $this->createObject();
        if(is_object($obj)) {
            return $obj->render();
        }
    }
    
    private function createObject() {
        $obj = NULL;
        switch($this->type) {
            case 'text' :
                $obj = new Textbox($this->elemnet);
                break;
            case 'textarea' :
                $obj = new Textarea($this->elemnet);
                break;
            case 'select' :
                $obj = new Select($this->elemnet);
                break;
            case 'radio' :
                $obj = new Radiobox($this->elemnet);
                break;
            case 'checkbox' :
                $obj = new Checkbox($this->elemnet);
                break;
        }
        return $obj;
    }
}
