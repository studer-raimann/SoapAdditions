<?php /*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

declare(strict_types=1);

namespace srag\Plugins\SoapAdditions\Routes\ItemGroup;

use srag\Plugins\SoapAdditions\Command\ItemGroup\AddToItemGroupCommand;
use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * @author Thibeau Fuhrer <thibeau@sr.solutions>
 */
class AddToItemGroupRoute extends Base
{
    public const ITEM_GROUP_REF_ID = 'target_ref_id';
    public const OBJECT_REF_IDS = 'ref_ids';
    public const APPEND_OBJECTS = 'append';

    public function getName() : string
    {
        return 'addToItemGroup';
    }

    public function getCommand(array $params) : Command
    {
        return new AddToItemGroupCommand(
            $params[self::ITEM_GROUP_REF_ID],
            $params[self::OBJECT_REF_IDS],
            $params[self::APPEND_OBJECTS] ?? true
        );
    }

    public function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(
                self::ITEM_GROUP_REF_ID,
                'ILIAS ref-id of the ItemGroup object'
            )->setOptional(false),

            $this->param_factory->arrayOfInt(
                self::OBJECT_REF_IDS,
                'List of object ref-ids for the ItemGroup'
            )->setOptional(false),

            //$this->param_factory->bool(
            //    self::APPEND_OBJECTS,
            //    'Whether the given ref-ids should be appended (true) or replaced with (false).'
            //)->setOptional(false),
        ];
    }

    public function getOutputParams() : array
    {
        return [
            $this->param_factory->arrayOfInt(self::OBJECT_REF_IDS),
        ];
    }

    public function getShortDocumentation() : string
    {
        return 'Adds the given objects (ref_ids) to the given ItemGroup target (ref_id).';
    }

    public function getSampleRequest() : string
    {
        return '
            <soapenv:Envelope
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                xmlns:urn="urn:SoapAdditions"
                xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
                <soapenv:Header/>
                <soapenv:Body>
                    <urn:addToItemGroup soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                        <sid xsi:type="xsd:string">?</sid>
                        <target_ref_id xsi:type="xsd:int">?</target_ref_id>
                        <ref_ids xsi:type="urn:intArray" SOAP-ENC:arrayType="xsd:int[]" xmlns:urn="urn:ilUserAdministration">
                            <item xsi:type="xsd:int">?</item>
                        </ref_ids>
                        <append xsi:type="xsd:boolean">?</append>
                    </urn:addToItemGroup>
                </soapenv:Body>
            </soapenv:Envelope>
        ';
    }
}