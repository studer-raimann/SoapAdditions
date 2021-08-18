<?php namespace srag\Plugins\SoapAdditions\Command;

/**
 * Interface Command
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Command
{

    public function run() : ?array;

    /**
     * @return void
     */
    public function revert();

    /**
     * @return bool
     */
    public function wasSuccessful() : bool;

    /**
     * @return string
     */
    public function getUnsuccessfulReason() : string;
}
