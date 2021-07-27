<?php

use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRole;
use srag\Plugins\SoapAdditions\Routes\Course\Settings as CourseSettings;
use srag\Plugins\SoapAdditions\Routes\User\Settings as UserSettings;

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
        return [
            new BlockRole(),
            new CourseSettings(),
            new UserSettings()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWsdlTypes()
    {
        return array();
    }
}
