<?php namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Parameter;

/**
 * Interface Route
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Route
{
    /**
     * @return Parameter[]
     */
    public function getAdditionalInputParams() : array;

    /**
     * @return Parameter[]
     */
    public function getOutputParams() : array;

    public function checkParameters(array $params);

    public function getCommand(array $params) : \srag\Plugins\SoapAdditions\Command\Command;

    public function getShortDocumentation() : string;

    public function getSampleRequest() : string;
}
