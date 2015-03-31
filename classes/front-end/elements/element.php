<?php
class Element {
    
    protected $_name;
    protected $_id;
    protected $_value;
    protected $_class;
    protected $_label;
    protected $_desc;


    public function __construct($element,$slug) {
        if(isset($element['id'])) {
            $this->_id = $element['id'];
            $this->_name = $slug.'['.$element['id'].']';
        }
        if(isset($element['label'])) {
            $this->_label = $element['label'];
        }
        if(isset($element['value'])) {
            $this->_value = $element['value'];
        }
        if(isset($element['class'])) {
            $this->_class = $element['class'];
        }
        if(isset($element['desc'])) {
            $this->_desc = $element['desc'];
        }
        $this->_page = $page;
        $this->_slug = $slug;
    }
    
    protected function _render($child) {
        $render = "<div class='form-row'>";
        $render .= "<label for='".$this->_id."'>".$this->_label."</label>";
        $render .= $child;
        if($this->_desc !== NULL) {
            $render .= "<p class='howto entire-framework'>".$this->_desc."</p>";
        }
        $render .= "</div>";
        return $render;
    }

    protected function _generateID($string) {
        $id = md5($string.rand(0,999999999).time());
        return substr($id,-8);
    }

    protected function _emptyValue() {
        if(empty($this->_value)) {
            return '<option value="" selected="selected">chose value</option>';
        } else {
            return '<option value="">chose value</option>';
        }
    }
    
    public function getDesc() {
        return $this->_desc;
    }

    public function getName() {
        return $this->_name;
    }

    public function getId() {
        return $this->_id;
    }

    public function getValue() {
        return $this->_value;
    }

    public function getClass() {
        return $this->_class;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setValue($value) {
        $this->_value = $value;
    }

    public function setClass($class) {
        $this->_class = $class;
    }
    public function getLabel() {
        return $this->_label;
    }

    public function setLabel($label) {
        $this->_label = $label;
    }
}

