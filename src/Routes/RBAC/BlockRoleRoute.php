<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes\RBAC;

use srag\Plugins\SoapAdditions\Command\RBAC\BlockRoleCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class BlockRoleRoute
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRoleRoute extends Base
{
    public const P_ROLE_ID = 'role_id';
    public const P_NODE_ID = 'node_id';

    public function getCommand(array $params): \srag\Plugins\SoapAdditions\Command\Command
    {
        $role_id = (int) $params[self::P_ROLE_ID];
        $node_id = (int) $params[self::P_NODE_ID];

        return new BlockRoleCommand($role_id, $node_id);
    }

    public function getName(): string
    {
        return "blockRole";
    }

    public function getAdditionalInputParams(): array
    {
        return [
            $this->param_factory->int(self::P_ROLE_ID, 'Internal ID of a Role')->setOptional(false),
            $this->param_factory->int(self::P_NODE_ID, 'ILIAS Ref-ID of the Object')->setOptional(false),
        ];
    }

    public function getOutputParams(): array
    {
        return [$this->param_factory->bool('success')];
    }

    public function getShortDocumentation(): string
    {
        return "Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)";
    }

    public function getSampleRequest(): string
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:blockRole soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <role_id xsi:type="xsd:int">?</role_id>
         <node_id xsi:type="xsd:int">?</node_id>
      </urn:blockRole>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
