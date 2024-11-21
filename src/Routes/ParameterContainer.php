<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;

/**
 * Class ParameterContainer
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class ParameterContainer implements \ilWsdlType
{
    /**
     * @param Parameter $parameter
     */
    public function __construct(protected Parameter $parameter)
    {
    }

    public function getName(): string
    {
        if ($this->parameter instanceof ComplexParameter) {
            return $this->parameter->getTypeWithoutPrefix();
        }
        return $this->parameter->getKey();
    }

    public function getTypeClass(): string
    {
        if ($this->parameter instanceof ComplexParameter) {
            return 'complexType';
        }
        return $this->parameter->getType();
    }

    public function getPhpType(): string
    {
        return 'struct';
    }

    public function getCompositor(): string
    {
        return 'all';
    }

    public function getRestrictionBase(): string
    {
        return '';
    }

    public function getElements(): array
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

    public function getAttributes(): array
    {
        return [];
    }

    public function getArrayType(): string
    {
        return '';
    }

}
