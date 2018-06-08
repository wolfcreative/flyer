<?php

abstract class flyerPlugin
{
    /** @var modX $modx */
    protected $modx;
    /** @var flyer $flyer */
    protected $flyer;
    /** @var array $scriptProperties */
    protected $scriptProperties;


    public function __construct(& $modx, &$scriptProperties)
    {
        $this->scriptProperties =& $scriptProperties;
        $this->modx = &$modx;
        $this->flyer = &$this->modx->flyer;

        if (!$this->flyer) {
            return;
        }

        $this->flyer->initialize($this->modx->context->key);
    }

    abstract public function run();
}