<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Interface ComplexParameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface ComplexParameter extends Parameter
{
    /**
     * @return Parameter[]
     */
    public function getSubParameters(): array;

    public function getTypeWithoutPrefix(): string;

}
