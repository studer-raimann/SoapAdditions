<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Interface ComplexParameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface ComplexParameter extends Parameter
{
    /**
     * @return Parameter[]
     */
    public function getSubParameters() : array;

    public function getTypeWithoutPrefix() : string;

}

