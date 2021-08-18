<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Class BaseComplexParameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BaseComplexParameter extends BaseParameter implements ComplexParameter
{
    /**
     * @var Parameter[]
     */
    protected $sub_parameters = [];
    /**
     * @var string
     */
    protected $type_without_prefix;

    /**
     * BaseParameter constructor.
     * @param string          $type
     * @param string          $key
     * @param string          $description
     * @param Parameter[]     $sub_parameters
     * @param PossibleValue[] $possible_values
     */
    public function __construct(
        string $type,
        string $key,
        string $description,
        array $sub_parameters,
        array $possible_values
    ) {
        parent::__construct(
            'tns:' . $type,
            $key,
            $description,
            $possible_values);
        $this->sub_parameters = $sub_parameters;
        $this->type_without_prefix = $type;
    }

    public function getSubParameters() : array
    {
        return $this->sub_parameters;
    }

    public function getTypeWithoutPrefix() : string
    {
        return $this->type_without_prefix;
    }

}
