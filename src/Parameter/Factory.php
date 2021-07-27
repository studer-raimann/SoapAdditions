<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Interface Factory
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Factory
{
    private function checkPossibleValues(array $possible_values)
    {
        foreach ($possible_values as $possible_value) {
            if (!$possible_value instanceof PossibleValue) {
                throw new \ilSoapPluginException("");
            }
        }
    }

    public function int(string $key, array $possible_values = []) : Parameter
    {
        $this->checkPossibleValues($possible_values);
        return new BaseParameter(Type::TYPE_INT, $key, $possible_values);
    }

    public function bool(string $key) : Parameter
    {
        return new BaseParameter(Type::TYPE_BOOL, $key, [
            $this->possibleValue(1, 'true'),
            $this->possibleValue(1, 'false'),
        ]);
    }

    public function string(string $key, array $possible_values = []) : Parameter
    {
        $this->checkPossibleValues($possible_values);
        return new BaseParameter(Type::TYPE_STRING, $key, $possible_values);
    }

    public function possibleValue($value, string $description) : PossibleValue
    {
        return new PossibleValue($value, $description);
    }

}
