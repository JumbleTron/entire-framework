<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/checkbox.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/radio.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/select.php');

class WPPages {
    
    private $elementType;
    private $pageType;
    private $returned;
    private $label;
    private $elementOptions;
    private $element;


    public function __construct($element,$slug) {
        $this->elementType = 'Select';
        $this->label = 'post_title';
        $this->returned = 'post_name';
        $this->pageType = 'page';
        if(isset($element['elementy_type'])) {
            $this->setElementType($element['elementy_type']);
        }
        if(isset($element['display'])) {
            $this->setDisplay($element['display']);
        }
        if(isset($element['element_value'])) {
            $this->setReturnedValue($element['element_value']);
        }
        if(isset($element['page_type'])) {
            $this->pageType = $element['page_type'];
        }
        $this->elementOptions = $this->setElementOptions($element);
        $this->element = new $this->elementType($this->elementOptions,$slug);
    }
    
    public function render() {
        return $this->element->render();
    }
    
    public function setElementType($type) {
        $avalible = array('radio','checkbox','select');
        if(in_array(trim($type),$avalible)) {
            $this->elementType = ucfirst(strtolower(trim($type)));
        }
    }
    public function setDisplay($label) {
        $avalible = $this->avalibleRenturn();
        if(in_array(trim($label),$avalible)) {
            $this->label = $this->typeToPagesKey(strtolower(trim($label)));
        }
    }
    public function setReturnedValue($value) {
        $avalible = $this->avalibleRenturn();
        if(in_array(trim($value),$avalible)) {
            $this->returned = $this->typeToPagesKey(strtolower(trim($value)));
        }
    }
    public function setPageType($type) {
        $this->pageType = $type;
    }
    
    private function avalibleRenturn() {
        return array('slug','id','name');
    }
    private function typeToPagesKey($type) {
        if($type == 'slug') {
            return 'post_name';
        }
        if($type == 'id') {
            return 'ID';
        }
        if($type == 'name') {
            return 'post_title';
        }
    }
    
    private function setPages() {
        $renturn = array();
        if(is_array($this->pageType)) {
            foreach($this->pageType as $type) {
                $renturn[ucfirst($type)] = $this->getPostAndPages($type);
            }
        } else {
           $renturn = $this->getPostAndPages($this->pageType); 
        }
        return $renturn;
    }

    private function getPostAndPages($type) {
        $renturn = array();
        $key = $this->returned;
        $value = $this->label;
        if(strtolower($type) == 'page') {
            $pages =  get_pages(); 
        } else {
           $pages =  get_posts(array('posts_per_page' => '-1','post_type' => $type));
        }
        foreach($pages as $page) {
            $renturn[$page->$key] = $page->$value;
        }
        return $renturn;
    }
    
    private function setElementOptions($el) {
        $element = array(
            'id' => $el['id'], 
            'label' => $el['label'],
        );
        if(isset($el['desc'])) {
            $element['desc'] = $el['desc'];
        }
        if(isset($el['value'])) {
            $element['value'] = $el['value'];
        }
        $element['options'] = $this->setPages();
        return $element;
    }
}

