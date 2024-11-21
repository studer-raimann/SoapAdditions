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
 * Class BaseComplexParameter
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BaseComplexParameter extends BaseParameter implements ComplexParameter
{
    /**
     * @var Parameter[]
     */
    protected array $sub_parameters;
    protected string $type_without_prefix;

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
            $possible_values
        );
        foreach ($sub_parameters as $sub_parameter) {
            if (!$sub_parameter instanceof Parameter || $sub_parameter instanceof ComplexParameter) {
                throw new \LogicException('a ComplexParamater currently only holds Parameters');
            }
        }
        $this->sub_parameters = $sub_parameters;
        $this->type_without_prefix = $type;
    }

    public function getSubParameters(): array
    {
        return $this->sub_parameters;
    }

    public function getTypeWithoutPrefix(): string
    {
        return $this->type_without_prefix;
    }

}
