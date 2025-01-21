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
 * Interface Parameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Parameter
{
    public function getKey();

    /**
     * @return PossibleValue[]
     */
    public function getPossibleValues(): array;

    public function getType(): string;

    public function getDescription(): string;

    public function isOptional(): bool;

    public function setOptional(bool $optional): self;

}
