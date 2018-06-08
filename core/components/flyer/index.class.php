<?php

/**
 * Class flyerMainController
 */
abstract class flyerMainController extends modExtraManagerController
{
    /** @var flyer $flyer */
    public $flyer;


    /**
     * @return void
     */
    public function initialize()
    {
        $corePath = $this->modx->getOption('flyer_core_path', null,
            $this->modx->getOption('core_path') . 'components/flyer/');
        require_once $corePath . 'model/flyer/flyer.class.php';

        $this->flyer = new flyer($this->modx);
        $this->addCss($this->flyer->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->flyer->config['jsUrl'] . 'mgr/flyer.js');
        $this->addHtml('
		<script type="text/javascript">
			flyer.config = ' . $this->modx->toJSON($this->flyer->config) . ';
			flyer.config.connector_url = "' . $this->flyer->config['connectorUrl'] . '";
		</script>
		');

        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('flyer:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends flyerMainController
{

    /**
     * @return string
     */
    public static function getDefaultController()
    {
        return 'home';
    }
}