<?php
class Element {
    
    protected $_name;
    protected $_id;
    protected $_value;
    protected $_class;
    protected $_label;


    public function __construct($element) {
        if(isset($element['name'])) {
            $this->_name = $element['name'];
        }
        if(isset($element['id'])) {
            $this->_id = $element['id'];
            if(!isset($element['name'])) {
                $this->_name = $element['id'];
            }
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
    }
    
    protected function _render($child) {
        $render = "<div class='form-row'>";
        $render .= "<label for='".$this->_id."'>".$this->_label."</label>";
        $render .= $child;
        $render .= "</div>";
        return $render;
    }

    protected function _generateID($name) {
        return substr(md5(strtolower(str_replace(' ','_',$name)).date('c')),-10,10);
    }

    protected function _emptyValue() {
        if(empty($this->_value)) {
            return '<option value="" selected="selected">chose value</option>';
        } else {
            return '<option value="">chose value</option>';
        }
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

