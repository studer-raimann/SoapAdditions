<?php namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Factory;
use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Parameter\PossibleValue;

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
                $parameters = $needed_parameter->getSubParameters();
                $required_fields = array_map(function (Parameter $p) : string {
                    return $p->getKey();
                }, array_filter($parameters, function (Parameter $p) : bool {
                    return !$p->isOptional();
                }));
                $sent_parameters = array_keys((array) $params[$k]);
                $missing_fields = array_diff($required_fields, $sent_parameters);
                if (count($missing_fields) > 0) {
                    $keys_needed = implode(", ", $required_fields);
                    throw new \ilSoapPluginException("Request is missing at least one of the following parameters: " . $keys_needed);
                }

                // check possible values
                array_walk($parameters, static function (Parameter $p) use ($params, $k) {
                    if (count($p->getPossibleValues()) > 0) {
                        $possible_values = array_map(function (PossibleValue $v) {
                            return $v->getValue();
                        }, $p->getPossibleValues());
                        $needle = $params[$k]->{$p->getKey()};
                        if ($needle === null && $p->isOptional()) {
                            return;
                        }

                        if (!in_array($needle, $possible_values, true)) {
                            throw new \ilSoapPluginException("Wrong value for field: " . $p->getKey() . ". Possible values: " . implode(", ",
                                    $possible_values));
                        }
                    }
                });
            }
            $k++;
        }
    }
}
