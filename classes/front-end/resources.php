<?php
class Resources {
		
    public static $style = array(
        'ef-font-awsome' => array(
            'link' => 'assets/css/font-awesome.min.css',
            'depth' => array()
        ),
        'chosen-library-style' => array(
            'link' => 'assets/css/chosen.min.css',
            'depth' => array()
        ),
        'ef-framework-main-style' => array(
            'link' => 'assets/css/style.css',
            'depth' => array()
        ),
    );
    public static $script = array(
        'chosen-library' => array(
            'link' => 'assets/js/chosen.jquery.min.js',
        ),
        'ef-framework-main-script' => array(
            'link' => 'assets/js/main-script.js',
            'depth' => array('jquery','jquery-ui-tabs','wp-color-picker')
        ),
    );
}
