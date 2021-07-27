<?php

use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRole;
use srag\Plugins\SoapAdditions\Routes\Course\Settings;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilSoapAdditionsPlugin
 */
class ilSoapAdditionsPlugin extends ilSoapHookPlugin
{

    const PLUGIN_NAME = 'SoapAdditions';

    /**
     * @return string
     */
    public function getPluginName()
    {
        return self::PLUGIN_NAME;
    }

    /**
     * @inheritdoc
     */
    public function getSoapMethods()
    {
        return array(
            new BlockRole(),
            new Settings()
        );
    }

    /**
     * @inheritdoc
     */
    public function getWsdlTypes()
    {
        return array();
    }
}
