<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

require_once __DIR__ . '/../vendor/autoload.php';

use srag\Plugins\SoapAdditions\Routes\RouteContainer;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Routes\ParameterContainer;
use srag\Plugins\SoapAdditions\Routes\Route;

/**
 * @noinspection AutoloadingIssuesInspection
 */

class ilSoapAdditionsPlugin extends ilSoapHookPlugin
{
    public const PLUGIN_NAME = 'SoapAdditions';

    /**
     * @return mixed
     */
    protected function getRoutes()
    {
        $routes = include './Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/src/routes.php';
        return $routes;
    }

    /**
     * @inheritdoc
     */
    public function getSoapMethods(): array
    {
        return array_map(static function (Route $route): RouteContainer {
            return new RouteContainer($route);
        }, $this->getRoutes());
    }

    /**
     * @inheritdoc
     */
    public function getWsdlTypes(): array
    {
        $types = [];
        foreach ($this->getRoutes() as $route) {
            foreach ($route->getAdditionalInputParams() as $parameter) {
                if ($parameter instanceof ComplexParameter) {
                    $types[$parameter->getKey()] = new ParameterContainer($parameter);
                }
            }
            foreach ($route->getOutputParams() as $parameter) {
                if ($parameter instanceof ComplexParameter) {
                    $types[$parameter->getKey()] = new ParameterContainer($parameter);
                }
            }
        }

        return $types;
    }
}
