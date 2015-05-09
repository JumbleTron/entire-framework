<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/elements/element.php');
class File extends Element {
    
    private $mutli = false;
    private $avalible = '';


    public function __construct($element,$slug) {
        if(isset($element['multi'])) {
            $this->setMutli($element['multi']);
        }
        if(isset($element['file_type'])) {
            $this->avalible = $element['file_type'];
        }
        parent::__construct($element,$slug);
    }
    
    public function render() {
        $render  = '<input type="hidden" name="'.$this->_name.'" value="'.$this->_value.'"/>';
        $render .= "<p class='ef-image-wrapper'>".$this->renderImage($this->_value)."</p>";
        $render .= '<a title="Add file" class="button ef-insert-media" href="#" data-multi="'.$this->getMulti().'" data-file_type="'.$this->getAvalible().'">Add file</a>';
        $render .= get_submit_button('Remove','secondary delete remove_file','remove-file',false);
        return $this->_render($render);
    }
    
    private function renderImage($url) {
        $url = $this->slugToURL($url);
        if ($url != '') {
            return '<img src="'.$url.'" />';
        }
    }
    
    private function getAvalible() {
        if($this->avalible != '') {
            return $this->avalible;
        } else {
            return '';
        }
    }
    
    private function slugToURL($slug) {
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

