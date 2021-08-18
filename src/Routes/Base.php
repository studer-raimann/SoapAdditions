<?php namespace srag\Plugins\SoapAdditions\Routes;

use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Parameter\Factory;
use srag\Plugins\SoapAdditions\Parameter\Parameter;

/**
 * Class Base
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class Base implements Route
{

    /**
     * @var Factory
     */
    protected $param_factory;

    public function __construct()
    {
        $this->param_factory = new Factory();
    }

    /**
     * @return Parameter[]
     */
    abstract public function getAdditionalInputParams() : array;

    public function checkParameters(array $params)
    {
        $needed_parameters = $this->getAdditionalInputParams();
        if (count($needed_parameters) !== count($params) - 1) {
            $keys_needed = implode(", ", array_keys($needed_parameters));
            //throw new ilSoapPluginException("Request is missing at least one of the following parameters: " . $keys_needed);
        }
    }

    abstract public function getCommand(array $params);

    abstract public function getShortDocumentation();

    public function getSampleRequest()
    {
        return '';
    }

}
