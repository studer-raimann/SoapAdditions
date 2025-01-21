<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Command;

/**
 * Interface Command
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Command
{
    public function run();

    /**
     * @return void
     */
    public function revert();

    /**
     * @return bool
     */
    public function wasSuccessful(): bool;

    /**
     * @return string
     */
    public function getUnsuccessfulReason(): string;
}
