<?php

$settings = array();

$tmp = array(

    /* CKEditor config */

    'cfg_skin'              => array(
        'value' => 'icy_orange',
        'xtype' => 'textfield',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_language'          => array(
        'value' => 'ru',
        'xtype' => 'textfield',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_allowedContent'    => array(
        'value' => '',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_uiColor'           => array(
        'value' => '',
        'xtype' => 'textfield',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_removePlugins'     => array(
        'value' => '["about","autogrow","bidi","font","forms","liststyle","pagebreak","preview","print","colorbutton","indentblock","newpage","language","save","selectall","sourcearea","smiley","scayt","templates","wsc"]',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_format_tags'       => array(
        'value' => 'p;h1;h2;h3;h4;h5;h6;pre;div',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_codeSnippet_theme' => array(
        'value' => 'default',
        'xtype' => 'textfield',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_codemirror_theme' => array(
        'value' => 'neo',
        'xtype' => 'textfield',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_extraPlugins'      => array(
        'value' => '["uploadimage","image","embed","lineutils","sourcedialog","widget"]',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),


    'cfg_enterMode'         => array(
        'value' => 1,
        'xtype' => 'numberfield',
        'area'  => 'flyer_cfg',
        'type'  => 'integer'
    ),
    'cfg_shiftEnterMode'    => array(
        'value' => 1,
        'xtype' => 'numberfield',
        'area'  => 'flyer_cfg',
        'type'  => 'integer'
    ),


    'cfg_entities'                  => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_htmlEncodeOutput'          => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_toolbarCanCollapse'        => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_disableObjectResizing'     => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_disableNativeSpellChecker' => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_fillEmptyBlocks'           => array(
        'value' => false,
        'xtype' => 'combo-boolean',
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),
    'cfg_basicEntities'             => array(
        'value' => false,
        'xtype' => 'combo-boolean',
        'area'  => 'flyer_cfg',
        'type'  => 'boolean'
    ),

    'cfg_toolbar'       => array(
        'value' => '',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'array'
    ),
    'cfg_toolbarGroups' => array(
        'value' => '[{"name":"document","groups":["mode","document","doctools"]},{"name":"clipboard","groups":["clipboard","undo"]},{"name":"editing","groups":["find","selection"]},{"name":"links"},{"name":"insert"},{"name":"forms"},"/",{"name":"basicstyles","groups":["basicstyles","cleanup"]},{"name":"paragraph","groups":["list","indent","blocks","align","bidi"]},{"name":"styles"},{"name":"colors"},{"name":"tools"},{"name":"others"},{"name":"about"}]',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'string'
    ),
    'cfg_contentsCss'   => array(
        'value' => '',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'array'
    ),
    'cfg_editorCompact' => array(
        'value' => '{"ta":false,"modx-richtext":true}',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'array'
    ),

    'cfg_addExternalPlugins' => array(
        'value' => '',
        //'value' => '{"pagecut":"vendor/plugins/pagecut/pagecut/plugin.js"}',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'array'
    ),
    'cfg_addExternalSkin'    => array(
        'value' => '{"icy_orange":"vendor/skins/icy_orange/"}',
        'xtype' => 'textarea',
        'area'  => 'flyer_cfg',
        'type'  => 'array'
    ),


    'source_default'           => array(
        'value' => '0',
        'xtype' => 'modx-combo-source',
        'area'  => 'flyer_main',
    ),
    'source_fileName'          => array(
        'value' => '{name}.{ext}',
        'xtype' => 'textfield',
        'area'  => 'flyer_main',
    ),
    'source_filePath'          => array(
        'value' => '{class_key}/{id}/',
        'xtype' => 'textfield',
        'area'  => 'flyer_main',
    ),
    'config_variables'         => array(
        'value' => '',
        'xtype' => 'textarea',
        'area'  => 'flyer_main',
    ),
    'remove_devtags'           => array(
        'value' => true,
        'xtype' => 'combo-boolean',
        'area'  => 'flyer_main',
    ),
    'additional_editor_fields' => array(
        'value' => '["modx-richtext","modx-resource-introtext"]',
        'xtype' => 'textarea',
        'area'  => 'flyer_main',
        'type'  => 'array'
    ),


    //временные
    /* 'assets_path'    => array(
         'value' => '{base_path}flyer/assets/components/flyer/',
         'xtype' => 'textfield',
         'area'  => 'flyer_temp',
     ),
     'assets_url'     => array(
         'value' => '/flyer/assets/components/flyer/',
         'xtype' => 'textfield',
         'area'  => 'flyer_temp',
     ),
     'core_path'      => array(
         'value' => '{base_path}flyer/core/components/flyer/',
         'xtype' => 'textfield',
         'area'  => 'flyer_temp',
     ),*/

);

foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key'       => 'flyer_' . $k,
            'namespace' => 'flyer',
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}

unset($tmp);
return $settings;
