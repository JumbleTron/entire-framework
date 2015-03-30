<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/form/select.php');
class Font {
    
    const API_KEY = 'AIzaSyD0tNOWZh1ME-C9YCcTZZDnS_usBogiqEg';

    private $subnets = array();
    private $font;
    private $element;
    
    public function __construct($element,$slug) {
        if(isset($element['subnet'])) {
             $this->setSubnets($element['subnet']);
        }
        $this->element = new Select($this->setElementOptions($element),$slug);
    }

    public function render() {
        return $this->element->render();
    }

    public function setFont() {
        $fonts = $this->getFontsList();
        if(!isset($fonts->error)) {
            foreach($fonts->items as $f) {
                $diff = array_diff($this->subnets,$f->subsets);
                if(empty($diff) || empty($this->subnets)) {
                    $this->font[$f->category][$f->family] = $f->family;
                }
            }
        }
        return $this->font;
    }

    public function setSubnets($subnet) {
        if(is_array($subnet)) {
            $this->subnets = $subnet;
        } else {
            $this->subnets = array($subnet);
        }
    }
    
    private function getFontsList() {
        $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.self::API_KEY.'&sort=alpha&fields=items(category%2Cfamily%2Csubsets)';
        $curl = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json')
        );
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
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
        $element['options'] = $this->setFont();
        return $element;
    }
        
}
