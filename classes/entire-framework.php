<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/entire-framework-callback.php');
class EntireFramework {

    private $callbackClass;
    
    public function __construct($title,$name,$icon = '',$capability = 'edit_theme_options') {
        $this->callbackClass = new EntireFrameworkCallback($title,$name,$icon,$capability);
        add_action('admin_head',array($this->callbackClass,'entire_framework_admin_message'));
        add_action('admin_menu',array($this->callbackClass,'entire_framework_add_main_page_callback'));
    }
    
    public function addPages($pages) {
        $this->callbackClass->addPages($pages);
    }
        
}

