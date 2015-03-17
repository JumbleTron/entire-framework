<?php
defined('ENTIRE_FRAMEWORK_URL') or define('ENTIRE_FRAMEWORK_URL',get_template_directory_uri().'/admin/entire-framework/');
defined('ENTIRE_FRAMEWORK_DIR') or define('ENTIRE_FRAMEWORK_DIR',__DIR__.'/');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/entire-framework.php');

$pages = array(
    'general' => array(
        'sub-page' => array(
            array(
                'name' => 'Home',
                'title' => 'Home',
                'icon' => 'home',
                'fields' => array(
                    
                )
            ),
        ),
        'name' => 'General',
        'title' => 'General',
        'icon' => ''
    ),
    'test' => array(
        'name' => 'Home settings',
        'title' => 'Home settings',
        'icon' => '',
        'fields' => array(
            array(
                'id' => 'field1_text',
                'type' => 'text',
                'title' => 'Field 1 Text',
                'sub_desc' => 'Subdesc for testfield1',
                'desc' => 'Desc for testField1',
                'std' => "I'm looking for"
            )
        )
    ),
);

$framework = new EntireFramework('Theme options','Theme options');
$framework->addPages($pages);
