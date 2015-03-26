<?php
class Resources {
		
    public static $style = array(
        'ef-font-awsome' => array(
            'link' => 'assets/css/font-awesome.min.css',
            'depth' => array()
        ),
        'ef-framework-main-style' => array(
            'link' => 'assets/css/style.css',
            'depth' => array()
        ),
    );
    public static $script = array(
        'ef-framework-main-script' => array(
            'link' => 'assets/js/main-script.js',
            'depth' => array('jquery','jquery-ui-tabs','wp-color-picker')
        ),
    );
}
