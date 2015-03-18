<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/menu.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/assets.php');
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
    private $avaliblePage;
   
    public function __construct($title,$name,$icon,$capability) {
        $this->_title = $title;
        $this->_name = $name;
        $this->_slug = $this->generatSlug();
        $this->_capability = $capability;
        $this->icon = $icon;
        $this->settingsName = $this->_slug."_settings";
        add_action('admin_init', array($this,'entire_framework_register_settings'));
    }
    
    public function entire_framework_add_main_page_callback() {
        if($this->main_page === NULL) {
            $this->main_page = add_menu_page($this->_title,$this->_name,$this->_capability,$this->_slug,array($this,'entire_framework_render_pages_callback'),  $this->_icon);
        }
        if(!empty($this->pages)) {
            foreach($this->pages as $key => $page) {
                $this->avaliblePage[] = $key;
                $p = add_submenu_page($this->_slug,$page['title'],$page['name'],$this->_capability,$this->_slug."_$key",array($this,'entire_framework_render_pages_callback'));
                if(isset($page['sub-pages'])) {
                    foreach($page['sub-pages'] as $k => $subPage) {
                        add_submenu_page($this->_slug."_$key",$subPage['title'],$subPage['name'],$this->_capability,$this->_slug."_$key_$k",array($this,'entire_framework_render_pages_callback'));
                    }
                }
                add_action('load-'.$p,array($this,'entire_framework_current_page'));
            }
        }
        global $submenu;
        unset($submenu[$this->_slug][0]);
        $assets = new Assets($this->avaliblePage);
    }
    
    public function entire_framework_register_settings() {
        register_setting($this->settingsName,$this->settingsName,array($this,'entire_framework_sanitize_callback'));
        foreach($this->pages as $key => $page) {
            if(isset($page['sub-pages'])) {
                foreach($page['sub-pages'] as $k => $subPage) {
                    add_settings_section($this->settingsName.'_'.$key.'_'.$k.'_section',$subPage['title'],array($this,'entire_framework_section_desc'),$this->_slug."_$key");
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
        if(isset($this->pages[$this->current]['sub-pages'])) {
            echo $this->renderTabs();
        } else {
            do_settings_sections($this->_slug."_".$this->current);   
        }
    }
    
    public function entire_framework_section_desc() {
        echo $this->pages[$this->current]['name'];
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

    private function renderTabs() {
        $render = "<div class='options-main-wrapper'>";
        $menu = new Menu('ul');
        foreach($this->pages[$this->current]['sub-pages'] as $key => $subPage) {
            $menu->addLink('#'.$this->generatSlug($subPage['name']),$subPage['title'],$subPage['icon']);
        }
        $render .= $menu->render();
        foreach($this->pages[$this->current]['sub-pages'] as $key => $subPage) {
            $render .= "<div id='".$this->generatSlug($subPage['name'])."'>";
            $render .= do_settings_sections($this->_slug."_".$this->current."_$key");
            $render .= "</div>";
        }
        $render .= "</div>";
        return $render;
    }
    
    private function generatSlug($slug = NULL) {
        if($slug === NULL) {
            return substr(strtolower(str_replace(" ",'_',$this->_name)),0,15);
        } else {
            return substr(strtolower(str_replace(" ",'_',$slug)),0,15);
        }
    }
}

