<?php
defined('ENTIRE_FRAMEWORK_URL') or define('ENTIRE_FRAMEWORK_URL',get_template_directory_uri().'/admin/entire-framework/');
defined('ENTIRE_FRAMEWORK_DIR') or define('ENTIRE_FRAMEWORK_DIR',__DIR__.'/');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/entire-framework.php');
require_once(ENTIRE_FRAMEWORK_DIR.'classes/tests/test.php');

$pages = array(
    'general' => array(
        'sub-pages' => array(
            array(
                'name' => 'Home',
                'title' => 'Home',
                'icon' => 'home',
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
            array(
                'name' => 'General',
                'title' => 'General',
                'icon' => 'cog',
                'fields' => array(
                     array(
                        'id' => 'field1b_text',
                        'type' => 'text',
                        'title' => 'Field 1b Text',
                        'sub_desc' => 'Subdesc for testfield1b',
                        'desc' => 'Desc for testField1b',
                        'std' => "I'm looking for 1b"
                    )
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
                'id' => 'field2_text',
                'type' => 'text',
                'title' => 'Field 2 Text',
                'sub_desc' => 'Subdesc for testfield2',
                'desc' => 'Desc for testField2',
                'std' => "I'm looking for 2"
            ),
             array(
                'id' => 'field3_text',
                'type' => 'text',
                'title' => 'Field 3 Text',
                'sub_desc' => 'Subdesc for testfield3',
                'desc' => 'Desc for testFiel3',
                'std' => "I'm looking for 3"
            )
        )
    ),
);

$framework = new EntireFramework('Theme options','Theme options','dashicons-format-image');
$framework->addPages($pages);
//$test = new Test();
