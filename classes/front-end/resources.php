<?php
class Resources {
		
    public static $style = array(
        'ef-font-awsome' => array(
            'link' => 'assets/css/font-awesome.min.css',
            'depth' => array()
        ),
        'ef-jqueru-ui-style' => array(
            'link' => 'assets/css/jquery-ui.min.css',
            'depth' => array()
        ),
        'ef-framework-main-style' => array(
            'link' => 'assets/css/style.css',
            'depth' => array('ef-jqueru-ui-style')
        ),
    );
    public static $script = array(
        'ef-framework-main-script' => array(
            'link' => 'assets/js/main-script.js',
            'depth' => array('jquery','jquery-ui-tabs')
        ),
    );
}
