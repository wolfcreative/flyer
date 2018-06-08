<?php

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

$className = 'flyer' . $modx->event->name;
$modx->loadClass('flyerPlugin', $flyer->getOption('modelPath') . 'flyer/systems/', true, true);
$modx->loadClass($className, $flyer->getOption('modelPath') . 'flyer/systems/', true, true);
if (class_exists($className)) {
    /** @var $flyer $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}
return;
