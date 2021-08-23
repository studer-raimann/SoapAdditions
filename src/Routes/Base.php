<?php namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Factory;
use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;

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
            throw new \ilSoapPluginException("Request is missing at least one of the following parameters: " . $keys_needed);
        }
        $k = 1;
        foreach ($needed_parameters as $needed_parameter) {
            if ($needed_parameter instanceof ComplexParameter) {
                $required_fields = array_map(function (Parameter $p) : string {
                    return $p->getKey();
                }, array_filter($needed_parameter->getSubParameters(), function (Parameter $p) : bool {
                    return !$p->isOptional();
                }));
                $sent_parameters = array_keys((array) $params[$k]);
                $missing_fields = array_diff($required_fields, $sent_parameters);
                if (count($missing_fields) > 0) {
                    $keys_needed = implode(", ", $required_fields);
                    throw new \ilSoapPluginException("Request is missing at least one of the following parameters: " . $keys_needed);
                }
            }
            $k++;
        }
    }

    abstract public function getCommand(array $params) : \srag\Plugins\SoapAdditions\Command\Command;

    abstract public function getShortDocumentation() : string;

    public function getSampleRequest() : string
    {
        return '';
    }

}
