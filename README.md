# SoapAdditions

## Installation
Start at your ILIAS root directory 

```
mkdir -p Customizing/global/plugins/Services/WebServices/SoapHook
cd Customizing/global/plugins/Services/WebServices/SoapHook
git clone https://github.com/studer-raimann/SoapAdditions.git
```

As ILIAS administrator go to "Administration->Plugins" and install/activate the plugin.  

## Usage


**Important! When using SOAP-Plugins in ILIAS you MUST append the client_id with every Request (this is a Limitation in SOAP-Plugins. E.g.:**

`http://localhost:8053/webservice/soap/server.php`

becomes

`http://localhost:8053/webservice/soap/server.php?client_id=default`

You find your client_id in the ILIAS-Administration in General Settings -> Server. 


The method `blockRole` requires three parameters:
* `sid`: A valid sesison-ID obtained via the `login` method
* `role_id`: Obj-ID of a ILIAS role
* `node_id`: Ref-ID of a ILIAS container object where the role should be blocked.

**Example request body:**

```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:blockRole soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">f192b18811b612a9e73e7ae888432661::default</sid>
         <role_id xsi:type="xsd:int">2793</role_id>
         <node_id xsi:type="xsd:int">69</node_id>
      </urn:blockRole>
   </soapenv:Body>
</soapenv:Envelope>
```

## ILIAS Plugin SLA

Wir lieben und leben die Philosophie von Open Soure Software! Die meisten unserer Entwicklungen, welche wir im Kundenauftrag oder in Eigenleistung entwickeln, stellen wir öffentlich allen Interessierten kostenlos unter https://github.com/studer-raimann zur Verfügung.

Setzen Sie eines unserer Plugins professionell ein? Sichern Sie sich mittels SLA die termingerechte Verfügbarkeit dieses Plugins auch für die kommenden ILIAS Versionen. Informieren Sie sich hierzu unter https://studer-raimann.ch/produkte/ilias-plugins/plugin-sla.

Bitte beachten Sie, dass wir nur Institutionen, welche ein SLA abschliessen Unterstützung und Release-Pflege garantieren.

## Contact
info@studer-raimann.ch  
https://studer-raimann.ch  
