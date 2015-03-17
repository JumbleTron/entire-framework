<?php
class EntireFrameworkCallback {

    protected $_title;
    protected $_name;
    protected $_slug;
    protected $_capability;
    protected $_icon;
    private $main_page;
    private $pages;
    private $current;
    private $settingsName;
   
    public function __construct($title,$name,$icon,$capability) {
        $this->_title = $title;
        $this->_name = $name;
        $this->_slug = $this->generatSlug();
        $this->_capability = $capability;
        $this->icon = $icon;
        $this->settingsName = $this->_slug."_settings";
    }
    
    public function entire_framework_add_main_page_callback() {
        add_action('admin_init', array($this,'entire_framework_register_settings'));
        if($this->main_page === NULL) {
            $this->main_page = add_menu_page($this->_title,$this->_name,$this->_capability,$this->_slug,array($this,'entire_framework_render_pages_callback'),  $this->_icon);
        }
        if(!empty($this->pages)) {
            foreach($this->pages as $key => $page) {
                if(isset($page['sub-page'])) {
                    $p = add_submenu_page($this->_slug,$page['title'],$page['name'],$this->_capability,$this->_slug."_$key",array($this,'entire_framework_render_pages_callback'));
                }
                else {
                    $p = add_submenu_page($this->_slug,$page['title'],$page['name'],$this->_capability,$this->_slug."_$key",array($this,'entire_framework_render_pages_callback'));
                }
                add_action('load-'.$p,array($this,'entire_framework_current_page'));
            }
        }
        global $submenu;
        unset($submenu[$this->_slug][0]);
    }
    
    public function entire_framework_register_settings() {
        register_setting($this->settingsName,$this->settingsName,array($this,'entire_framework_sanitize_callback'));
        foreach($this->pages as $key => $page) {
            if(isset($page['sub-page'])) {
                foreach($page['sub-page'] as $k => $subPage) {
                    if(isset($subPage['fields'])) {
                        foreach($subPage['fields'] as $fKey => $field) {
                            add_settings_field($fKey.'_field',$field['title'],array($this,'entire_framework_form_field'),$this->_slug."_$key",$this->settingsName.'_'.$key.'_section',$field);
                        }
                    }
                }
            }
            else {
                add_settings_section($this->settingsName.'_'.$key.'_section',$page['title'],array($this,'entire_framework_section_desc'),$this->_slug."_$key");
                if(isset($page['fields'])) {
                    foreach($page['fields'] as $fKey => $field) {
                        add_settings_field($fKey.'_field',$field['title'],array($this,'entire_framework_form_field'),$this->_slug."_$key",$this->settingsName.'_'.$key.'_section',$field);
                    }
                }
            }
        }
    }
    
    public function entire_framework_render_pages_callback() {
        settings_fields($this->settingsName);
        do_settings_sections($this->settingsName."_$this->current");
    }
    
    public function entire_framework_section_desc() {
        echo "SEKCJA";
    }

    public function entire_framework_form_field($args) {
        print_r($args);
    }
    
    public function entire_framework_current_page() {
        $screen = get_current_screen();
        $id = explode($this->_slug.'_',$screen->base);
        $this->current = $id[1];
    }
    
    public function addPages($pages) {
        $this->pages = $pages;
    }
    
    private function generatSlug($slug = NULL) {
        if($slug === NULL) {
            return substr(strtolower(str_replace(" ",'_',$this->_name)),0,15);
        } else {
            return substr(strtolower(str_replace(" ",'_',$slug)),0,15);
        }
    }
}

