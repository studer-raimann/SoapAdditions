<?php /** @noinspection AutoloadingIssuesInspection */

use srag\Plugins\SoapAdditions\Routes\RouteContainer;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Routes\ParameterContainer;
use srag\Plugins\SoapAdditions\Routes\Route;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilSoapAdditionsPlugin
 */
class ilSoapAdditionsPlugin extends ilSoapHookPlugin
{

    const PLUGIN_NAME = 'SoapAdditions';

    /**
     * @return mixed
     */
    protected function getRoutes()
    {
        $routes = include './Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/src/routes.php';
        return $routes;
    }

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
        return array_map(static function (Route $route) : RouteContainer {
            return new RouteContainer($route);
        }, $this->getRoutes());
    }

    /**
     * @inheritdoc
     */
    public function getWsdlTypes()
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
