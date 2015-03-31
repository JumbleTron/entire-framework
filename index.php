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
                'desc' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
                'fields' => array(
                    array(
                        'id' => 'field1_text',
                        'type' => 'text',
                        'label' => 'Field 1 Text',
                        'desc' => 'Desc for testField1',
                        'value' => "I'm looking for"
                    ),
                    array(
                        'id' => 'color_field1',
                        'type' => 'color',
                        'label' => 'Label for 1 color',
                        'desc' => 'Desc for testField1',
                        'value' => "#1e73be"
                    ),
                    array(
                        'id' => 'google_font',
                        'type' => 'font',
                        'label' => 'Choose font',
                        'desc' => 'Desc for Google Font',
                    ),
                    array(
                        'id' => 'checkbox_1',
                        'type' => 'checkbox',
                        'label' => 'Select 1',
                        'desc' => 'Desc for checkbox1',
                        'options' => array('value 1','value 2','value 3'),
                        'value' => '2',
                    ),
                     array(
                        'id' => 'editor_1',
                        'type' => 'wyswig',
                        'label' => 'Label for WYSWIG',
                        'desc' => 'Desc for WYSWIG',
                        'value' => "",
                        'options' => array()
                    ),
                    array(
                        'id' => 'page_select',
                        'type' => 'wp_pages',
                        'label' => 'Page Select 1',
                        'desc' => 'Page Select 1 desc',
                        'page_type' => array('page','post'), //avalible pages,posts,CPT
                        'display' => 'name', //avalible slug,id,name
                        'element_value' => 'id', //avalible slug,id,name
                        'elementy_type' => 'select', //avalible radio,checkbox, select
                        'value' => '5',
                    ),
                    array(
                        'id' => 'select_1',
                        'type' => 'select',
                        'label' => 'Select 1',
                        'desc' => 'Desc for select11',
                        'options' => array('value 1','value 2','value 3'),
                        'value' => '0',
                    ),
                     array(
                        'id' => 'switcher_1',
                        'type' => 'switcher',
                        'label' => 'ON/OFF',
                        'desc' => 'Desc for switcher_1',
                        'options' => array('ON','OFF')
                    ),
                    array(
                        'id' => 'radio_1',
                        'type' => 'radio',
                        'label' => 'Radio 1',
                        'desc' => 'Desc for radio1',
                        'options' => array('value 1','value 2','value 3'),
                         'value' => '1',
                    ),
                    array(
                        'id' => 'textarea_text_1',
                        'type' => 'textarea',
                        'label' => 'Textarea 1 Text',
                        'desc' => 'Desc for textarea',
                        'value' => "I'm looking for textarea"
                    ),
                    array(
                        'id' => 'first_image',
                        'type' => 'file',
                        'label' => 'First image',
                        'desc' => 'Desc for image1',
                        'value' => "cwiczenie",
                        'file_type' => 'image',
                    ),
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
                        'label' => 'Field 1b Text',
                        'desc' => 'Desc for testField1b',
                        'value' => "I'm looking for 1b"
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
                'label' => 'Field 2 Text',
                'desc' => 'Desc for testField2',
                'value' => "I'm looking for 2"
            ),
             array(
                'id' => 'field3_text',
                'type' => 'text',
                'label' => 'Field 3 Text',
                'desc' => 'Desc for testFiel3',
                'value' => "I'm looking for 3"
            )
        )
    ),
);
$framework = new EntireFramework('Theme options','Theme options','dashicons-format-image');
$framework->addPages($pages);
//$test = new Test();
