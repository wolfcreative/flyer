<?php

/**
 * The home manager controller for flyer.
 *
 */
class flyerHomeManagerController extends flyerMainController
{
    /* @var flyer $flyer */
    public $flyer;


    /**
     * @param array $scriptProperties
     */
    public function process(array $scriptProperties = array())
    {
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('flyer');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->flyer->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->flyer->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/sections/home.js');
        $this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "flyer-page-home"});
		});
		</script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->flyer->config['templatesPath'] . 'home.tpl';
    }
}