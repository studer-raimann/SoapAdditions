<?php

use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRoleRoute;
use srag\Plugins\SoapAdditions\Routes\Course\UpdateCourseSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\Favourites\AddToFavouritesRoute;
use srag\Plugins\SoapAdditions\Routes\User\UpdateUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\User\GetUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\RouteContainer;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Routes\ParameterContainer;

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
            new RouteContainer(new BlockRoleRoute()),
            new RouteContainer(new UpdateCourseSettingsRoute()),
            new RouteContainer(new AddToFavouritesRoute()),
            new RouteContainer(new UpdateUserSettingsRoute()),
            new RouteContainer(new GetUserSettingsRoute()),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWsdlTypes()
    {
        $types = [];
        foreach ($this->getSoapMethods() as $method) {
            $o = $method->getOriginalRoute();
            foreach ($o->getAdditionalInputParams() as $parameter) {
                if ($parameter instanceof ComplexParameter) {
                    $types[$parameter->getKey()] = new ParameterContainer($parameter);
                }
            }
            foreach ($o->getOutputParams() as $parameter) {
                if ($parameter instanceof ComplexParameter) {
                    $types[$parameter->getKey()] = new ParameterContainer($parameter);
                }
            }

        }

        return $types;
    }
}
