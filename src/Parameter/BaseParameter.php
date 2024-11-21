<?php /*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Class BaseParameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BaseParameter implements Parameter
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var array
     */
    protected $possible_values = [];
    /**
     * @var bool
     */
    protected $optional = true;

    /**
     * BaseParameter constructor.
     * @param string $type
     * @param string $key
     * @param string $description
     * @param array  $possible_values
     */
    public function __construct(
        string $type,
        string $key,
        string $description,
        array $possible_values
    ) {
        $this->type = $type;
        $this->key = $key;
        $this->description = $description;
        $this->possible_values = $possible_values;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getPossibleValues() : array
    {
        return $this->possible_values;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isOptional() : bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional) : Parameter
    {
        $this->optional = $optional;

        return $this;
    }

}
