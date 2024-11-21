<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes\Favourites;

use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Command\Favourites\AddToFavouritesCommand;

/**
 * Class AddToFavouritesRoute
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class AddToFavouritesRoute extends Base
{
    public const REF_ID = 'ref_id';

    public function getCommand(array $params): \srag\Plugins\SoapAdditions\Command\Command
    {
        return new AddToFavouritesCommand($params[self::REF_ID], $params);
    }

    public function getName(): string
    {
        return "addToFavourites";
    }

    public function getAdditionalInputParams(): array
    {
        return [
            $this->param_factory->int(self::REF_ID, 'ILIAS Ref-ID of the Object')->setOptional(false),
            $this->param_factory->arrayOfInt('user_ids', 'List of user ids'),
            $this->param_factory->bool('inherit', 'Inherit from object if possible'),
        ];
    }

    public function getOutputParams(): array
    {
        return [
            $this->param_factory->arrayOfInt('user_ids')
        ];
    }

    public function getShortDocumentation(): string
    {
        return "Adds the objects given (ref_id) as favourites to A) a list of users or B) to the inherited users (e.g. members of a course) if possible.";
    }

    public function getSampleRequest(): string
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:addToFavourites soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">637ec4aaad34be151b7e1548e0a7515f::default</sid>
         <ref_id xsi:type="xsd:int">76</ref_id>
         <user_ids xsi:type="urn:intArray" SOAP-ENC:arrayType="xsd:int[]" xmlns:urn="urn:ilUserAdministration">
         		<item xsi:type="xsd:int">6</item>
            <item xsi:type="xsd:int">256</item>
         </user_ids>
         <inherit xsi:type="xsd:boolean">true</inherit>
      </urn:addToFavourites>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
