<?php namespace srag\Plugins\SoapAdditions\Command;

/**
 * Class Base
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class Base implements Command
{
    /**
     * @var bool
     */
    protected $status = true;
    /**
     * @var string
     */
    protected $error_message = "";

    /**
     * @inheritDoc
     */
    public function revert()
    {
        throw new \LogicException("unable to revert");
    }

    /**
     * @inheritDoc
     */
    public function wasSuccessful() : bool
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getUnsuccessfulReason() : string
    {
        return $this->error_message;
    }

}
