<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('flyer_core_path', null,
                    $modx->getOption('core_path') . 'components/flyer/') . 'model/';
            $modx->addPackage('flyer', $modelPath);

            $manager = $modx->getManager();
            $objects = array(
                //'flyerItem',
            );
            foreach ($objects as $tmp) {
                $manager->createObjectContainer($tmp);
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
