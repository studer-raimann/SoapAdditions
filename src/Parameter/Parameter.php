<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Interface Parameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Parameter
{
    /**
     * @return string
     */
    public function getKey();

    /**
     * @return PossibleValue[]
     */
    public function getPossibleValues() : array;

    /**
     * @return string
     */
    public function getType() : string;

}

