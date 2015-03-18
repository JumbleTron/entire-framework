<?php
class Menu {
    
    private $items;
    private $tag;
    private $class;
    private $id;
    private $openTag;
    private $closeTag;
    
    public function __construct($tag = 'ul',$class = 'menu',$id = 'tabs') {
        $this->tag = $tag;
        $this->setClass($class);
        $this->id = $id;
        $this->createTags();
    }
    
    public function render() {
        $render = $this->openTag;
        if(!empty($this->items)) {
            foreach($this->items as $item) {
                $render .= '<li><a href="'.$item['link'].'">';
                if($item['icon'] != '') {
                    $render .= '<icon class="fa fa-'.$item['icon'].'"></icon>';
                }
                $render .= $item['label'].'</a></li>';
            }
        }
        $render .= $this->closeTag;
        return $render;
    }
    
    public function addLink($link,$label,$icon = '') {
        $this->items[] = array('link' => $link,'label' => $label,'icon' => $icon);
    }
    
    private function createTags() {
        $this->openTag = "<".$this->tag." class='".$this->class."' id='".$this->id."'>";
        $this->closeTag = "</".$this->tag.">";
    }
    
    public function setClass($class) {
        if(preg_match('/^.*menu(.*\/s)*/',$class)) {
            $this->class = $class;
        } else {
            $this->class = 'menu '.$class;
        }
    }
}
