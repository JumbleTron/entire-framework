<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class File extends Element {
    
    private $mutli = false;


    public function __construct($element,$slug) {
        if(isset($element['multi'])) {
            $this->setMutli($element['multi']);
        }
        parent::__construct($element,$slug);
    }
    
    public function render() {
        $render = '<input type="hidden" name="'.$this->_name.'"/>';
        $render .= "<p class='ef-image-wrapper'>".$this->renderImage($this->_value)."</p>";
        $render .= '<a title="Add file" class="button ef-insert-media" href="#" data-multi="'.$this->getMulti().'">Add file</a>';
        return $this->_render($render);
    }
    
    private function renderImage($url) {
        $url = $this->slugToURL($url);
        if ($url != '') {
            return '<img src="'.$url.'" />';
        }
    }
    
    private function slugToURL($url) {
        $args = array(
            'post_type' => 'attachment',
            'name' => sanitize_title($slug),
            'posts_per_page' => 1,
            'post_status' => 'inherit',
        );
        $_header = get_posts($args);
        $header = $_header ? array_pop($_header) : null;
        return $header ? wp_get_attachment_thumb_url($header->ID) : '';
    }
    
    public function getMulti() {
        $multi = 'false';
        if($this->mutli) {
            $multi = 'true';
        }
        return $multi;
    }

    public function setMutli($multi) {
        $this->mutli = $multi === 'true'? true: false;
    }
}

