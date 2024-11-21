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
 * Interface Type
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface Type
{
    public const TYPE_INT_ARRAY = 'tns:intArray';
    public const TYPE_STRING = 'xsd:string';
    public const TYPE_DATE_TIME = 'xsd:dateTime';
    public const TYPE_INT = 'xsd:int';
    public const TYPE_BOOL = 'xsd:boolean';
    public const TYPE_DOUBLE_ARRAY = 'tns:doubleArray';
    public const TYPE_COMPLEX = 'tns:complexType';
}
