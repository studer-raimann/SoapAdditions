<?php namespace srag\Plugins\SoapAdditions\Routes;

use srag\Plugins\SoapAdditions\Parameter\Parameter;
use srag\Plugins\SoapAdditions\Command\Command;

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

    /**
     * @param array $params
     * @return Command
     */
    public function getCommand(array $params);

    public function getShortDocumentation();

    public function getSampleRequest();
}
