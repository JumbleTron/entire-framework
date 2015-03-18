<?php
class Test
{
    private $current;
    
    public function __construct()
    {
        add_action('admin_menu', array($this,'add_plugin_page'));
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }
    public function add_plugin_page()
    {
        add_menu_page(
            'Settings Admin', 
            'My Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
        for($i=0;$i<5;$i++) {
            $p = add_submenu_page(
                'my-setting-admin',
                'Test child '.$i,
                'Test child '.$i,
                'manage_options',
                'child_slug_'.$i,
                array($this,'create_admin_page')
            );
            add_action('load-'.$p,array($this,'current_page'));
        }
    }
    
    public function current_page() {
        $screen = get_current_screen();
        $id = explode('_',$screen->base);
        $this->current = end($id);
    }
    
    public function create_admin_page()
    {
        $i = $this->current;
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h2>My Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections('child_slug_'.$i);
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }
    
    public function page_init()
    {        
        register_setting(
            'my_option_name', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        for($i=0;$i<5;$i++) {
            add_settings_section(
                'setting_section_id_'.$i, // ID
                'My Custom Settings '.$i, // Title
                array( $this, 'print_section_info' ), // Callback
                'child_slug_'.$i // Page
            );  
            add_settings_field(
                'id_number_'.$i, // ID
                'ID Number '.$i, // Title 
                array( $this,'id_number_callback'), // Callback
                'child_slug_'.$i, // Page
                'setting_section_id_'.$i // Section           
            );
            if($i == 2 || $i == 4) {
                add_settings_section(
                    'setting_section_id_'.$i.'_b', // ID
                    'My Custom Settings '.$i.'_b', // Title
                    array( $this, 'print_section_info' ), // Callback
                    'child_slug_'.$i // Page
                ); 
                add_settings_field(
                    'title', 
                    'Title', 
                    array( $this, 'title_callback' ), 
                    'child_slug_'.$i,
                    'setting_section_id_'.$i
                ); 
                add_settings_field(
                    'id_number_'.$i, // ID
                    'ID Number '.$i, // Title 
                    array( $this,'id_number_callback'), // Callback
                    'child_slug_'.$i, // Page
                    'setting_section_id_'.$i.'_b' // Section           
                );
            }
        }           
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}
