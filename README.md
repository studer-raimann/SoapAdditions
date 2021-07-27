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

# Documentation
<!-- BEGIN definitions -->
 ### Route: blockRole
Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)
Parameters:
- sid
- role_id
- node_id


 
<!-- END definitions -->
