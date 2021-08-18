<?php namespace srag\Plugins\SoapAdditions\Routes;

use ilAbstractSoapMethod;
use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Parameter\Type;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;

/**
 * Class Base
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class RouteContainer extends ilAbstractSoapMethod
{
    /**
     * @var Base
     */
    protected $route;

    /**
     * RouteContainer constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
        parent::__construct();
    }

    public function getOriginalRoute() : Route
    {
        return $this->route;
    }

    /**
     * @inheritdoc
     */
    public function getServiceNamespace()
    {
        return 'urn:' . \ilSoapAdditionsPlugin::PLUGIN_NAME;
    }

    /**
     * @inheritdoc
     */
    final public function getInputParams()
    {
        $params = [
            'sid' => Type::TYPE_STRING
        ];
        foreach ($this->route->getAdditionalInputParams() as $p) {
            if (!$p instanceof Parameter) {
                throw new ilSoapPluginException("All parameters in getAdditionalInputParams() MUST be of type Parameter");
            }
            $params[$p->getKey()] = $p->getType();
        }
        return $params;
    }

    protected function checkParameters(array $params)
    {
        $this->route->checkParameters($params);
    }

    /**
     * @param $message
     * @throws ilSoapPluginException
     */
    protected function error($message)
    {
        throw new ilSoapPluginException($message);
    }

    /**
     * @param $session_id
     * @throws ilSoapPluginException
     */
    private function init($session_id)
    {
        $this->initIliasAndCheckSession($session_id); // Throws exception if session is not valid
    }

    /**
     * @param array $params
     * @return array
     * @throws ilSoapPluginException
     */
    public function execute(array $params)
    {
        $this->checkParameters($params);
        $session_id = $params[0] ?? '';
        $this->init($session_id);

        $clean_params = [];
        $i = 1;
        foreach ($this->route->getAdditionalInputParams() as $p) {
            if ($p instanceof ComplexParameter) {
                $elements = (array) $params[$i];
                $clean_params[$p->getKey()] = $elements;
            } else {
                $clean_params[$p->getKey()] = $params[$i];
            }
            $i++;
        }
        try {
            $command = $this->route->getCommand($clean_params);
            $return = $command->run();
            if ($command->wasSuccessful()) {
                return $return;
            }
            $this->error($command->getUnsuccessfulReason());
        } catch (\Throwable $t) {
            $this->error($t->getMessage());
        }

    }

    final public function getDocumentation()
    {
        $documentation = $this->route->getShortDocumentation();
        foreach ($this->route->getAdditionalInputParams() as $parameter) {
            if ($parameter->getDescription() || count($parameter->getPossibleValues()) > 0) {
                $documentation .= "<br>{$parameter->getKey()}: {$parameter->getDescription()} ";
                foreach ($parameter->getPossibleValues() as $value) {
                    $documentation .= "{$value->getValue()}: {$value->getDescription()}, ";
                }
            }

        }

        return $documentation;
    }

    public function getOutputParams()
    {
        $params = [];
        foreach ($this->route->getOutputParams() as $param) {
            $params[$param->getKey()] = $param->getType();
        }

        return $params;
    }

    public function getName()
    {
        return $this->route->getName();
    }

}
