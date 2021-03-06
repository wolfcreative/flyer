<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $corePath = $modx->getOption('flyer_core_path', null,
            $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/flyer/');
        /** @var flyer $flyer */
        $flyer = $modx->getService(
            'flyer',
            'flyer',
            $corePath . 'model/flyer/',
            array(
                'core_path' => $corePath
            )
        );

        if (!$flyer) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[flyerExtraPlugins] Could not load flyer');

            return false;
        }

        $variables = array(
            'string'  => array(
                'skin',
                'language',
                'allowedContent',
                'uiColor',
                'removePlugins',
                'format_tags',
                'codeSnippet_theme',
                'codemirror_theme',
                'extraPlugins',
            ),
            'integer' => array(
                'enterMode',
                'shiftEnterMode'
            ),
            'boolean' => array(
                'entities',
                'autoParagraph',
                'toolbarCanCollapse',
                'disableObjectResizing',
                'disableNativeSpellChecker',
                'fillEmptyBlocks',
                'basicEntities',
                'htmlEncodeOutput',
                'indentWithTabs'
            ),
            'array'   => array(
                'toolbar',
                'toolbarGroups',
                'contentsCss',
                'editorCompact',
                'addExternalPlugins',
                'addExternalSkin',
                'addTemplates',
            ),
        );

        foreach ($variables as $type => $row) {
            foreach ($row as $name) {
                $flyer->addConfigVariable($type, $name);
            }
        }

        /* add devtags */
        $settings = array(
            array(
                'key'   => 'extraPlugins',
                'area'  => 'flyer_cfg',
                'type'  => 'string',
                'value' => array(
                    'devtags'
                )
            ),
            array(
                'key'   => 'addExternalPlugins',
                'area'  => 'flyer_cfg',
                'type'  => 'array',
                'value' => array(
                    'devtags' => 'vendor/plugins/devtags/plugin.js'
                )
            ),
            array(
                'key'   => 'extraPlugins',
                'area'  => 'flyer_cfg',
                'type'  => 'string',
                'value' => array(
                    'codemirror'
                )
            ),
            array(
                'key'   => 'addExternalPlugins',
                'area'  => 'flyer_cfg',
                'type'  => 'array',
                'value' => array(
                    'codemirror' => 'vendor/plugins/codemirror/codemirror/plugin.js'
                )
            ),
        );

        foreach ($settings as $row) {
            $flyer->addConfigSetting($row);
        }


        /* core */
        $key = 'which_editor';
        if (!$tmp = $modx->getObject('modSystemSetting', array('key' => $key))) {
            $tmp = $modx->newObject('modSystemSetting');
            $tmp->fromArray(array(
                'key'       => $key,
                'xtype'     => 'modx-combo-rte',
                'namespace' => 'core',
                'area'      => 'editor',
                'editedon'  => null,
            ), '', true, true);
        }
        $tmp->set('value', 'flyer');
        $tmp->save();

        $key = 'use_editor';
        if (!$tmp = $modx->getObject('modSystemSetting', array('key' => $key))) {
            $tmp = $modx->newObject('modSystemSetting');
            $tmp->fromArray(array(
                'key'       => $key,
                'xtype'     => 'combo-boolean',
                'namespace' => 'core',
                'area'      => 'editor',
                'editedon'  => null,
            ), '', true, true);
        }
        $tmp->set('value', 1);
        $tmp->save();

        break;
    case xPDOTransport::ACTION_UNINSTALL:

        /* core */

        $key = 'which_editor';
        if ($tmp = $modx->getObject('modSystemSetting', array('key' => $key))) {
            $tmp->set('value', '');
            $tmp->save();
        }

        $key = 'use_editor';
        if ($tmp = $modx->getObject('modSystemSetting', array('key' => $key))) {
            $tmp->set('value', 0);
            $tmp->save();
        }

        $modx->removeCollection('modSystemSetting', array('namespace' => 'flyer'));

        break;
}

return true;