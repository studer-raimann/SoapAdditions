<?php namespace srag\Plugins\SoapAdditions\Routes;

use ilAbstractSoapMethod;
use ilSoapAdditionsPlugin;
use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Parameter\Factory;
use srag\Plugins\SoapAdditions\Parameter\Parameter;

/**
 * Class Base
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class Base extends ilAbstractSoapMethod
{

    /**
     * @inheritdoc
     */
    const TYPE_INT_ARRAY = 'tns:intArray';
    const TYPE_STRING = 'xsd:string';
    const TYPE_INT = 'xsd:int';
    const TYPE_BOOL = 'xsd:boolean';
    const TYPE_DOUBLE_ARRAY = 'tns:doubleArray';
    const SID = 'sid';

    /**
     * @var Factory
     */
    protected $param_factory;

    public function __construct()
    {
        parent::__construct();
        $this->param_factory = new Factory();
    }

    /**
     * @inheritdoc
     */
    public function getServiceNamespace()
    {
        return 'urn:' . ilSoapAdditionsPlugin::PLUGIN_NAME;
    }

    /**
     * @return Parameter[]
     */
    protected abstract function getAdditionalInputParams() : array;

    /**
     * @return Parameter[]
     */
    public function getInputParamsObjects() : array
    {
        return array_merge([
            $this->param_factory->string(self::SID)
        ], $this->getAdditionalInputParams());
    }

    /**
     * @inheritdoc
     */
    final public function getInputParams()
    {
        $params = [];
        foreach ($this->getInputParamsObjects() as $p) {
            if (!$p instanceof Parameter) {
                throw new ilSoapPluginException("All parameters in getAdditionalInputParams() MUST be of type Paramteter");
            }
            $params[$p->getKey()] = $p->getType();
        }
        return $params;
    }

    protected function checkParameters(array $params)
    {
        $needed_parameters = $this->getInputParams();
        if (count($needed_parameters) !== count($params)) {
            $keys_needed = implode(", ", array_keys($needed_parameters));
            throw new ilSoapPluginException("Request is missing at least one of the following parameters: " . $keys_needed);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    abstract protected function run(array $params);

    /**
     * @param array $params
     * @return mixed
     * @throws ilSoapPluginException
     */
    public function execute(array $params)
    {
        $this->checkParameters($params);
        $session_id = $params[0] ?? '';
        $this->init($session_id);

        $clean_params = [];
        $i = 1;
        foreach ($this->getAdditionalInputParams() as $p) {
            $clean_params[$p->getKey()] = $params[$i];
            $i++;
        }

        return $this->run($clean_params);
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

    abstract protected function getShortDocumentation();

    final public function getDocumentation()
    {
        $documentation = $this->getShortDocumentation();
        foreach ($this->getInputParamsObjects() as $parameter) {
            if (count($parameter->getPossibleValues()) > 0) {
                $documentation .= "<br>{$parameter->getKey()}: ";
                foreach ($parameter->getPossibleValues() as $value) {
                    $documentation .= "{$value->getValue()}: {$value->getDescription()}, ";
                }
            }
        }

        return $documentation;
    }

    protected function getSampleRequest()
    {
        return '';
    }
}
