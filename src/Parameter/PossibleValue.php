<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Class PossibleValue
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class PossibleValue
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var string
     */
    protected $description;

    /**
     * PossibleValue constructor.
     * @param mixed  $value
     * @param string $description
     */
    public function __construct($value, string $description)
    {
        $this->value = $value;
        $this->description = $description;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDescription() : string
    {
        return $this->description;
    }
}

