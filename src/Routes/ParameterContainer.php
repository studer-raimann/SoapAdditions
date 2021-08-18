<?php namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;

/**
 * Class ParameterContainer
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class ParameterContainer implements \ilWsdlType
{
    /**
     * @var Parameter
     */
    protected $parameter;

    /**
     * @param Parameter $parameter
     */
    public function __construct(Parameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public function getName()
    {
        if ($this->parameter instanceof ComplexParameter) {
            return $this->parameter->getTypeWithoutPrefix();
        }
        return $this->parameter->getKey();
    }

    public function getTypeClass()
    {
        if ($this->parameter instanceof ComplexParameter) {
            return 'complexType';
        }
        return $this->parameter->getType();
    }

    public function getPhpType()
    {
        return 'struct';
    }

    public function getCompositor()
    {
        return 'all';
    }

    public function getRestrictionBase()
    {
        return '';
    }

    public function getElements()
    {
        $elements = [];
        if ($this->parameter instanceof ComplexParameter) {
            foreach ($this->parameter->getSubParameters() as $parameter) {
                $key = $parameter->getKey();
                $optional = $parameter->isOptional();
                $elements[$key] = [
                    'name' => $key,
                    'type' => $parameter->getType(),
                    'nillable' => $optional ? 'true' : 'false',
                    'minOccurs' => $optional ? 0 : 1,
                ];
            }
        }

        return $elements;
    }

    /*
     * addComplexType($name,$typeClass='complexType',$phpType='array',$compositor='',$restrictionBase='',$elements=array(),$attrs=array(),$arrayType='') {
     *
     *
     * $this->server->wsdl->addComplexType(
            'ilUserData',
            'complexType',
            'struct',
            'all',
            '',
            array('usr_id' => array('name' => 'usr_id','type' => 'xsd:int'),
                                                  'login' => array('name' => 'login', 'type' =
     *
     *
     *  $this->server->wsdl->addComplexType(
                $type->getName(), 'ilUserData',
                $type->getTypeClass(), 'complexType',
                $type->getPhpType(), 'struct',
                $type->getCompositor(), 'all',
                $type->getRestrictionBase(), '',
                $type->getElements(),   array('usr_id' => array('name' => 'usr_id','type' => 'xsd:int'),
                                                  'login' => array('name' => 'login', 'type' => 'xsd:string'),
                $type->getAttributes(),
                $type->getArrayType()
            );
     *
     *
     *
     *   $this->server->wsdl->addComplexType(





     */

    public function getAttributes()
    {
        return [];
    }

    public function getArrayType()
    {
        return '';
    }

}
