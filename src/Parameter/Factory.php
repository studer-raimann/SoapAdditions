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
 * Interface Factory
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Factory
{
    private function checkPossibleValues(array $possible_values): void
    {
        foreach ($possible_values as $possible_value) {
            if (!$possible_value instanceof PossibleValue) {
                throw new \ilSoapPluginException("");
            }
        }
    }

    public function int(string $key, string $description = '', array $possible_values = []): Parameter
    {
        $this->checkPossibleValues($possible_values);
        return new BaseParameter(Type::TYPE_INT, $key, $description, $possible_values);
    }

    public function arrayOfInt(string $key, string $description = '', array $possible_values = []): Parameter
    {
        $this->checkPossibleValues($possible_values);
        return new BaseParameter(Type::TYPE_INT_ARRAY, $key, $description, $possible_values);
    }

    public function bool(string $key, string $description = ''): Parameter
    {
        return new BaseParameter(Type::TYPE_BOOL, $key, $description, [
            $this->possibleValue(true, 'Yes'),
            $this->possibleValue(false, 'No'),
        ]);
    }

    public function dateTime(string $key, string $description = ''): Parameter
    {
        return new BaseParameter(Type::TYPE_DATE_TIME, $key, $description, []);
    }

    public function string(string $key, string $description = '', array $possible_values = []): Parameter
    {
        $this->checkPossibleValues($possible_values);
        return new BaseParameter(Type::TYPE_STRING, $key, $description, $possible_values);
    }

    public function complex(
        string $key,
        string $type,
        array $nested,
        string $description = '',
        array $possible_values = []
    ): ComplexParameter {
        return new BaseComplexParameter(
            $type,
            $key,
            $description,
            $nested,
            $possible_values
        );
    }

    public function possibleValue($value, string $description): PossibleValue
    {
        return new PossibleValue($value, $description);
    }

}
