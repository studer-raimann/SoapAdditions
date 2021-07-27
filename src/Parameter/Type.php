<?php namespace srag\Plugins\SoapAdditions\Parameter;

/**
 * Interface Type
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Type
{
    /**
     * @inheritdoc
     */
    const TYPE_INT_ARRAY = 'tns:intArray';
    const TYPE_STRING = 'xsd:string';
    const TYPE_INT = 'xsd:int';
    const TYPE_BOOL = 'xsd:boolean';
    const TYPE_DOUBLE_ARRAY = 'tns:doubleArray';

}
