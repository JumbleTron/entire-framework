<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/checkbox.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/file.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/radio.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/select.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/textarea.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/textbox.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/switcher.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/wp_pages.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/font.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/wyswig.php');
class renderHTML {
    
    public $elemnet;
    private $type;


    public function __construct($element) {
        $this->elemnet = $element;
        if(isset($element['type'])) {
            $this->type = $element['type'];
        } else {
            $this->type = 'text';
        }
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function render($slug) {
        $obj = $this->createObject($slug);
        if(is_object($obj) && $this->type != 'wyswig') {
            return $obj->render();
        } else {
            return $obj;
        }
    }
    
    private function createObject($slug) {
        $obj = NULL;
        switch($this->type) {
            case 'text' :
                $obj = new Textbox($this->elemnet,$slug);
                break;
            case 'color' :
                $obj = new Textbox($this->elemnet,$slug);
                $obj->setClass('ef-color_picker');
                break;
            case 'textarea' :
                $obj = new Textarea($this->elemnet,$slug);
                break;
            case 'select' :
                $obj = new Select($this->elemnet,$slug);
                break;
            case 'radio' :
                $obj = new Radio($this->elemnet,$slug);
                break;
            case 'checkbox' :
                $obj = new Checkbox($this->elemnet,$slug);
                break;
            case 'file' :
                $obj = new File($this->elemnet,$slug);
                break;
            case 'switcher' :
                $obj = new Switcher($this->elemnet,$slug);
                break;
            case 'wp_pages' :
                $obj = new WPPages($this->elemnet,$slug);
                break;
            case 'font' :
                $obj = new Font($this->elemnet,$slug);
                break;
            case 'wyswig' :
                $obj = new Wyswig($this->elemnet,$slug);
                break;
        }
        return $obj;
    }
}
