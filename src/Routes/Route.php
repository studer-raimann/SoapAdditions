<?php /*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes;

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

    public function getName() : string;

    public function getCommand(array $params) : \srag\Plugins\SoapAdditions\Command\Command;

    public function getShortDocumentation() : string;

    public function getSampleRequest() : string;
}
