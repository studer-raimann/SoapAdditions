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

## Documentation
<!-- BEGIN definitions -->
### Route: blockRole
Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)
Parameters:
- role_id (xsd:int): Internal ID of a Role
- node_id (xsd:int): ILIAS Ref-ID of the Object
```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:blockRole soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <role_id xsi:type="xsd:int">?</role_id>
         <node_id xsi:type="xsd:int">?</node_id>
      </urn:blockRole>
   </soapenv:Body>
</soapenv:Envelope>
```

### Route: updateCourseSettings
Updates the settings of a course to the data given
Parameters:
- ref_id (xsd:int)
- show_title_and_icon (xsd:boolean) 1: true, 0: false
- show_header_actions (xsd:boolean) 1: true, 0: false
- passed_determination (xsd:int) 1: Through Learning Progress, 2: Only Manual by Tutors
- sorting (xsd:int) 0: Titles in Alphabetical Order, 4: By Creation Date, 2: Sort by Activation, 1: Manually
- sorting_direction (xsd:string) asc: ASC, desc: DESC
- activate_add_to_favourites (xsd:boolean) 1: true, 0: false
- position_for_new_objects (xsd:string) top: Top, bottom: Bottom
- order_for_new_objects (xsd:int) 0: Titles in Alphabetical Order, 1: By Creation Date, 2: Sort by Activation
- learning_progress_mode (xsd:int) 0: Learning Progress is Deactivated, 11: Tutors Monitor and Set Status, 5: Status is Determined by a Collection of Items
- activate_news (xsd:boolean) 1: true, 0: false
- activate_news_timeline (xsd:boolean) 1: true, 0: false
- position_for_new_objects (xsd:string) top: Top, bottom: Bottom
- activate_news_timeline_auto_entries (xsd:boolean) 1: true, 0: false
- activate_news_timeline_landing_page (xsd:boolean) 1: true, 0: false
```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateCourseSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <ref_id xsi:type="xsd:int">?</ref_id>
         <show_title_and_icon xsi:type="xsd:boolean">?</show_title_and_icon>
         <show_header_actions xsi:type="xsd:boolean">?</show_header_actions>
         <passed_determination xsi:type="xsd:int">?</passed_determination>
         <sorting xsi:type="xsd:int">?</sorting>
         <sorting_direction xsi:type="xsd:string">?</sorting_direction>
         <activate_add_to_favourites xsi:type="xsd:boolean">?</activate_add_to_favourites>
         <position_for_new_objects xsi:type="xsd:string">?</position_for_new_objects>
         <order_for_new_objects xsi:type="xsd:int">?</order_for_new_objects>
         <learning_progress_mode xsi:type="xsd:int">?</learning_progress_mode>
         <activate_news xsi:type="xsd:boolean">?</activate_news>
         <activate_news_timeline xsi:type="xsd:boolean">?</activate_news_timeline>
         <activate_news_timeline_auto_entries xsi:type="xsd:boolean">?</activate_news_timeline_auto_entries>
         <activate_news_timeline_landing_page xsi:type="xsd:boolean">?</activate_news_timeline_landing_page>
      </urn:updateCourseSettings>
   </soapenv:Body>
</soapenv:Envelope>
```

### Route: updateUserSettings
Updates the settings of a course to the data given
Parameters:
- user_id (xsd:int)
- activate_public_profile (xsd:boolean) 1: true, 0: false
- show_title (xsd:boolean) 1: true, 0: false
- show_birthday (xsd:boolean) 1: true, 0: false
- show_gender (xsd:boolean) 1: true, 0: false
- show_upload (xsd:boolean) 1: true, 0: false
- show_interests_general (xsd:boolean) 1: true, 0: false
- show_interests_help_offered (xsd:boolean) 1: true, 0: false
- show_interests_help_looking (xsd:boolean) 1: true, 0: false
- show_org_units (xsd:boolean) 1: true, 0: false
- show_institution (xsd:boolean) 1: true, 0: false
- show_department (xsd:boolean) 1: true, 0: false
- show_street (xsd:boolean) 1: true, 0: false
- show_zipcode (xsd:boolean) 1: true, 0: false
- show_city (xsd:boolean) 1: true, 0: false
- show_country (xsd:boolean) 1: true, 0: false
- show_sel_country (xsd:boolean) 1: true, 0: false
- show_phone_office (xsd:boolean) 1: true, 0: false
- show_phone_home (xsd:boolean) 1: true, 0: false
- show_phone_mobile (xsd:boolean) 1: true, 0: false
- show_fax (xsd:boolean) 1: true, 0: false
- show_email (xsd:boolean) 1: true, 0: false
- show_second_email (xsd:boolean) 1: true, 0: false
- show_hobby (xsd:boolean) 1: true, 0: false
- show_matriculation (xsd:boolean) 1: true, 0: false
```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateUserSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <user_id xsi:type="xsd:int">?</user_id>
         <activate_public_profile xsi:type="xsd:boolean">?</activate_public_profile>
         <show_title xsi:type="xsd:boolean">?</show_title>
         <show_birthday xsi:type="xsd:boolean">?</show_birthday>
         <show_gender xsi:type="xsd:boolean">?</show_gender>
         <show_upload xsi:type="xsd:boolean">?</show_upload>
         <show_interests_general xsi:type="xsd:boolean">?</show_interests_general>
         <show_interests_help_offered xsi:type="xsd:boolean">?</show_interests_help_offered>
         <show_interests_help_looking xsi:type="xsd:boolean">?</show_interests_help_looking>
         <show_org_units xsi:type="xsd:boolean">?</show_org_units>
         <show_institution xsi:type="xsd:boolean">?</show_institution>
         <show_department xsi:type="xsd:boolean">?</show_department>
         <show_street xsi:type="xsd:boolean">?</show_street>
         <show_zipcode xsi:type="xsd:boolean">?</show_zipcode>
         <show_city xsi:type="xsd:boolean">?</show_city>
         <show_country xsi:type="xsd:boolean">?</show_country>
         <show_sel_country xsi:type="xsd:boolean">?</show_sel_country>
         <show_phone_office xsi:type="xsd:boolean">?</show_phone_office>
         <show_phone_home xsi:type="xsd:boolean">?</show_phone_home>
         <show_phone_mobile xsi:type="xsd:boolean">?</show_phone_mobile>
         <show_fax xsi:type="xsd:boolean">?</show_fax>
         <show_email xsi:type="xsd:boolean">?</show_email>
         <show_second_email xsi:type="xsd:boolean">?</show_second_email>
         <show_hobby xsi:type="xsd:boolean">?</show_hobby>
         <show_matriculation xsi:type="xsd:boolean">?</show_matriculation>
      </urn:updateUserSettings>
   </soapenv:Body>
</soapenv:Envelope>
```

 
<!-- END definitions -->
