<?php /*********************************************************************
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
    /**
     * @inheritdoc
     */
    const TYPE_INT_ARRAY = 'tns:intArray';
    const TYPE_STRING = 'xsd:string';
    const TYPE_DATE_TIME = 'xsd:dateTime';
    const TYPE_INT = 'xsd:int';
    const TYPE_BOOL = 'xsd:boolean';
    const TYPE_DOUBLE_ARRAY = 'tns:doubleArray';
    const TYPE_COMPLEX = 'tns:complexType';
}
