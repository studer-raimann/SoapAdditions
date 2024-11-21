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
 * Class PossibleValue
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class PossibleValue
{
    /**
     * PossibleValue constructor.
     * @param string $description
     */
    public function __construct(protected mixed $value, protected string $description)
    {
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
