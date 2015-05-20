<?php
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/menu.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/assets.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/front-end/render-html.php');
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
    private $options;

    public function __construct($title,$name,$icon,$capability) {
        $this->_title = $title;
        $this->_name = $name;
        $this->_slug = $this->generatSlug();
        $this->_capability = $capability;
        $this->_icon = $icon;
        $this->settingsName = $this->_slug."_settings";
        add_action('admin_init', array($this,'entire_framework_register_settings'));
        add_action('admin_notices',array($this,'entire_framework_admin_notice'));
    }
    
    public function entire_framework_admin_message() {
        if(get_current_screen()->base == 'themes') {
            $link = admin_url('admin.php?page='.$this->_slug);
            $output = "<div id='setting-error-tgmpa' class='updated settings-error'>";
            $output .= "<p>This theme comes with an <a href='".$link."'>options panel</a> to configure settings.</p>";
            $output .= "</div>";
            echo $output;
        }
    }
    
    public function entire_framework_admin_notice() {
        settings_errors('entire-framework-options-save-notice');
    }
    
    public function entire_framework_add_main_page_callback() {
        if($this->main_page === NULL) {
            $this->main_page = add_menu_page($this->_title,$this->_name,$this->_capability,$this->_slug,array($this,'entire_framework_render_pages_callback'),$this->_icon);
        }
        if(!empty($this->pages)) {
            foreach($this->pages as $key => $page) {
                $this->avaliblePage[] = $key;
                $p = add_submenu_page($this->_slug,$page['title'],$page['name'],$this->_capability,$this->_slug."_$key",array($this,'entire_framework_render_pages_callback'));
                add_action('admin_print_styles-'.$p,array(new Assets(),'theme_enqueue_styles'));
                add_action('admin_print_scripts-'.$p,array(new Assets(),'theme_enqueue_script'));
                add_action('load-'.$p,array($this,'entire_framework_current_page'));
            }
        }
        global $submenu;
        unset($submenu[$this->_slug][0]);
        new Assets($this->avaliblePage);
    }
    
    public function entire_framework_register_settings() {
        foreach($this->pages as $key => $page) {
            register_setting($this->settingsName.'_group_'.$key,$this->settingsName.'_'.$key,array($this,'entire_framework_sanitize'));
            if(isset($page['sub-pages'])) {
                foreach($page['sub-pages'] as $k => $subPage) {
                    add_settings_section($this->settingsName.'_'.$key.'_'.$k.'_section',$subPage['title'],array($this,'entire_framework_section_desc'),$this->_slug."_$key");
                    if(isset($subPage['fields'])) {
                        foreach($subPage['fields'] as $fKey => $field) {
                            add_settings_field($fKey.'_field',$field['id'],array($this,'entire_framework_form_field'),$this->_slug."_$key",$this->settingsName.'_'.$key.'_'.$k.'_section',$field);
                        }
                    }
                }
            }
            else {
                add_settings_section($this->settingsName.'_'.$key.'_section',$page['title'],array($this,'entire_framework_section_desc'),$this->_slug."_$key");
                if(isset($page['fields'])) {
                    foreach($page['fields'] as $fKey => $field) {
                        add_settings_field($fKey.'_field',$field['id'],array($this,'entire_framework_form_field'),$this->_slug."_$key",$this->settingsName.'_'.$key.'_section',$field);
                    }
                }
            }
        }  
    }
    
    public function entire_framework_render_pages_callback() {
        echo '<form method="post" action="options.php">';
        settings_fields($this->settingsName.'_group_'.$this->current);   
        if(isset($this->pages[$this->current]['sub-pages'])) {
            echo $this->renderTabs();
        } else {
            echo $this->entire_framework_do_settings_sections($this->_slug."_".$this->current);   
            echo get_submit_button();
        }
        echo '</form>';
    }
    
    public function entire_framework_section_desc($args) {
        $id = str_replace(array($this->settingsName.'_'.$this->current.'_','_section'),'',$args['id']);
        if(isset($this->pages[$this->current]['sub-pages'][$id]['desc'])) {
            $desc = $this->pages[$this->current]['sub-pages'][$id]['desc'];
            $output = "<div class='entire-framework-section-desc'>";
            $output .= "<p>".$desc."</p>";
            $output .= "</div>";
            return $output;
        }
    }

    public function entire_framework_form_field($args) {
        //global $ef_data;
        //$ef_data['test'] = 'test';
        $html = new renderHTML($args);
        $render = $html->render($this->settingsName.'_'.$this->current);
        if($html->getType() == 'wyswig') {
            echo "<div class='form-row'>";
            echo "<label for='".$html->elementObj->getId()."'>".$html->elementObj->getLabel()."</label>";
            wp_editor($html->elementObj->getValue(),$html->elementObj->removeBrackets($html->elementObj->getId()),$html->elementObj->getOptions());
            if($html->elementObj->getDesc() !== NULL) {
                echo "<p class='howto entire-framework'>".$html->elementObj->getDesc()."</p>";
            }
            echo "</div>";
        } else {
           echo $render; 
        }
        if(method_exists($html->elementObj, 'getId')) {
            $this->value[$html->elementObj->getId()] = $html->elementObj->getValue();
        } else {
            $this->value[$html->elementObj->element->getId()] = $html->elementObj->element->getValue();
        }
    }
    
    public function entire_framework_current_page() {
        $screen = get_current_screen();
        $id = explode($this->_slug.'_',$screen->base);
        $this->current = $id[1];
    }
    
    public function entire_framework_sanitize($input) {
        $current = end(explode('_',$_REQUEST['option_page']));
        $new_input = array();
        if(isset($_REQUEST['ef-restore-default'])) {
            if(isset($this->pages[$current]['sub-pages'])) {
                foreach($this->pages[$current]['sub-pages'] as $key => $page) {
                    foreach($page['fields'] as $fkey => $value) {
                        $value = isset($value['value']) ? $value['value'] : '';
                        $new_input[$fkey] = $value;
                    }
                }
            }
            else {
                foreach($this->pages[$current]['fields'] as $key => $value) {
                    $value = isset($value['value']) ? $value['value'] : '';
                    $new_input[$key] = $value;
                }
            }
            add_settings_error('entire-framework-options-save-notice', esc_attr('ef-info'), __('Settings restored.'),'updated');
        }
        else {
            foreach($input as $key => $value) {
                $new_input[$key] = $value;
            }
            add_settings_error('entire-framework-options-save-notice', esc_attr('ef-info'), __('Settings saved.'),'updated');
        }
        return $new_input;
    }
    
    public function addPages($pages) {
        global $ef_data;
        $this->pages = $pages;
        $ef_data = $this->getValues();
    }

    private function renderTabs() {
        echo "<div class='options-main-wrapper ui-tabs-vertical ui-helper-clearfix'>";
        echo "<div class='ef-theme-options-buttons'>";
        echo get_submit_button('Save Changes','primary large','submit',false);
        echo get_submit_button('Restore default','large secondary','ef-restore-default',false);
        echo "</div>";
        $menu = new Menu('ul');
        foreach($this->pages[$this->current]['sub-pages'] as $key => $subPage) {
            $menu->addLink('#'.$this->generatSlug($subPage['name']),$subPage['title'],$subPage['icon']);
        }
        echo '<div class="ef-left"><div class="entire-framewrok-theme-info">';
        echo $this->renderThemeInfo();
        echo '</div>';
        echo $menu->render().'</div>';
        echo $this->entire_framework_do_settings_sections($this->_slug."_".$this->current);
        echo '<div class="clearfix"></div>';
        echo "<div class='ef-theme-options-buttons-bottom'>";
        echo get_submit_button('Save Changes','primary large','submit',false);
        echo get_submit_button('Restore default','large secondary','ef-restore-default',false);
        echo "</div>";
        echo "</div>";
    }
    
    private function entire_framework_do_settings_sections($page) {
        global $wp_settings_sections, $wp_settings_fields;
        $this->options =  get_option($this->settingsName.'_'.$this->current);
        $render = '';
        if (!isset($wp_settings_sections) || !isset($wp_settings_sections[$page]))
            return $render;
        foreach((array)$wp_settings_sections[$page] as $key => $section ) {
            echo "<div id='".$this->generatSlug($section['title'])."'>";
            echo "<h3>".$section['title']."</h3>";
            echo call_user_func($section['callback'], $section);
            if ( !isset($wp_settings_fields) ||
                 !isset($wp_settings_fields[$page]) ||
                 !isset($wp_settings_fields[$page][$section['id']]) )
                    continue;
            foreach ((array)$wp_settings_fields[$page][$section['id']] as $field) {
                $field['args']['value'] = $this->setValue($field['args']);
                echo call_user_func($field['callback'],$field['args']);
            }
            echo "</div>";
        }
    }

    private function renderThemeInfo() {
        //$info = '<img src="'.ENTIRE_FRAMEWORK_URL.'assets/img/logo.png" />';
        $info = '';
        if(function_exists('wp_get_theme')) {
            if(is_child_theme()) {
                $temp_obj = wp_get_theme();
                $theme_obj = wp_get_theme( $temp_obj->get('Template') );
            } else {
                $theme_obj = wp_get_theme();
            }
            $info .= '<p>'.$theme_obj->get('Name').' v. '.$theme_obj->get('Version').'</p>';
            $info .= '<p> by: <a href="'.$theme_obj->get('AuthorURI').'" target="_blank">'.$theme_obj->get('Author').'</a></p>';
        } else {
            $theme_data = get_theme_data(get_template_directory().'/style.css');
            $info .= '<p>'.$theme_data['Name'].' v. '.$theme_data['Version'].'</p>';
            $info .= '<p> by: <a href="'.$theme_data['AuthorURI'].'" target="_blank">'.$theme_data['Author'].'</a></p>';

        }
        echo $info;
    }

    private function getValues() {
        $values = array();
        foreach($this->pages as $key => $page) {
             $savedOptions = get_option($this->settingsName.'_'.$key);
             if(isset($page['sub-pages'])) {
                foreach($page['sub-pages'] as $k => $subPage) {
                    if(isset($subPage['fields'])) {
                        foreach($subPage['fields'] as $fKey => $field) {
                            if(isset($savedOptions[$field['id']])) {
                                $values[$field['id']] = $savedOptions[$field['id']];
                            } else {
                                if(isset($field['value'])) {
                                    $values[$field['id']] = $field['value'];
                                } else {
                                     $values[$field['id']] = '';
                                }
                            }
                        }
                    }
                }
            }
            else {
                if(isset($page['fields'])) {
                    foreach($page['fields'] as $fKey => $field) {
                        if(isset($savedOptions[$field['id']])) {
                            $values[$field['id']] = $savedOptions[$field['id']];
                        } else {
                            if(isset($field['value'])) {
                                $values[$field['id']] = $field['value'];
                            } else {
                                 $values[$field['id']] = '';
                            }
                        }
                    }
                }
            }
        }
        return $values;
    }
    
    private function setValue($args) {
        $value = '';
        if(isset($this->options[$args['id']])) {
            $value = $this->options[$args['id']];
        }
        else {
            if(isset($args['value'])) {
                $value = $args['value'];
            }
        }
        return $value;
    } 
    
    private function generatSlug($slug = NULL) {
        if($slug === NULL) {
            return substr(strtolower(str_replace(" ",'_',$this->_name)),0,15);
        } else {
            return substr(strtolower(str_replace(" ",'_',$slug)),0,15);
        }
    }
}

