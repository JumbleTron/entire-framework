<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class Wyswig extends Element {

    private $options;
    
    public function __construct($element,$slug) {
        parent::__construct($element,$slug);
        if(isset($element['options'])) {
            $this->options = $element['options'];
        }
    }
        
    public function getOptions() {
        return $this->options;
    }
}
