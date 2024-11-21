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
 * Class Base
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class Base implements Command
{
    protected bool $status = true;
    protected string $error_message = "";

    public function revert(): void
    {
        throw new \LogicException("unable to revert");
    }

    public function wasSuccessful(): bool
    {
        return $this->status;
    }

    public function getUnsuccessfulReason(): string
    {
        return $this->error_message;
    }

}
