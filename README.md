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

You find your client_id in the ILIAS-Administration in General UpdateUserSettingsRoute -> Server. 

## Documentation
<!-- BEGIN definitions -->
### Route: blockRole
Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)
Parameters:
* role_id (xsd:int): Internal ID of a Role
* node_id (xsd:int): ILIAS Ref-ID of the Object

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
Updates the settings of a course (ref_id) to the data given
Parameters:
* course_settings (tns:courseSettings)
	* ref_id (xsd:int)
	* show_title_and_icon (xsd:boolean, optional) true: Yes, false: No
	* show_header_actions (xsd:boolean, optional) true: Yes, false: No
	* passed_determination (xsd:int, optional) 1: Through Learning Progress, 2: Only Manual by Tutors
	* sorting (xsd:int, optional) 0: Titles in Alphabetical Order, 4: By Creation Date, 2: Sort by Activation, 1: Manually
	* sorting_direction (xsd:string, optional) 'asc': ASC, 'desc': DESC
	* activate_add_to_favourites (xsd:boolean, optional) true: Yes, false: No
	* position_for_new_objects (xsd:string, optional) 'top': Top, 'bottom': Bottom
	* order_for_new_objects (xsd:int, optional) 0: Titles in Alphabetical Order, 1: By Creation Date, 2: Sort by Activation
	* learning_progress_mode (xsd:int, optional) 0: Learning Progress is Deactivated, 11: Tutors Monitor and Set Status, 5: Status is Determined by a Collection of Items
	* activate_news (xsd:boolean, optional) true: Yes, false: No
	* activate_news_timeline (xsd:boolean, optional) true: Yes, false: No
	* position_for_new_objects (xsd:string, optional) 'top': Top, 'bottom': Bottom
	* activate_news_timeline_auto_entries (xsd:boolean, optional) true: Yes, false: No
	* activate_news_timeline_landing_page (xsd:boolean, optional) true: Yes, false: No

```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateCourseSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">976d27aa4ba2c532d8905945b363eb26::default</sid>
         <course_settings xsi:type="urn:courseSettings" xmlns:urn="urn:ilUserAdministration">
            <!--You may enter the following 14 items in any order-->
            <ref_id xsi:type="xsd:int">76</ref_id>
            <!--Optional:-->
            <show_title_and_icon xsi:type="xsd:boolean">true</show_title_and_icon>
            <!--Optional:-->
            <show_header_actions xsi:type="xsd:boolean">true</show_header_actions>
            <!--Optional:-->
            <passed_determination xsi:type="xsd:int">2</passed_determination>
            <!--Optional:-->
            <sorting xsi:type="xsd:int">4</sorting>
            <!--Optional:-->
            <sorting_direction xsi:type="xsd:string">asc</sorting_direction>
            <!--Optional:-->
            <activate_add_to_favourites xsi:type="xsd:boolean">true</activate_add_to_favourites>
            <!--Optional:-->
            <position_for_new_objects xsi:type="xsd:string">top</position_for_new_objects>
            <!--Optional:-->
            <order_for_new_objects xsi:type="xsd:int">2</order_for_new_objects>
            <!--Optional:-->
            <learning_progress_mode xsi:type="xsd:int">5</learning_progress_mode>
            <!--Optional:-->
            <activate_news xsi:type="xsd:boolean">true</activate_news>
            <!--Optional:-->
            <activate_news_timeline xsi:type="xsd:boolean">true</activate_news_timeline>
            <!--Optional:-->
            <activate_news_timeline_auto_entries xsi:type="xsd:boolean">true</activate_news_timeline_auto_entries>
            <!--Optional:-->
            <activate_news_timeline_landing_page xsi:type="xsd:boolean">true</activate_news_timeline_landing_page>
         </course_settings>
      </urn:updateCourseSettings>
   </soapenv:Body>
</soapenv:Envelope>
```


### Route: addToFavourites
Adds the objects given (ref_id) as favourites to A) a list of users or B) to the inherited users (e.g. members of a course) if possible.
Parameters:
* ref_id (xsd:int): ILIAS Ref-ID of the Object
* user_ids (tns:intArray, optional): List of user ids
* inherit (xsd:boolean, optional): Inherit from object if possible true: Yes, false: No

```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
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
</soapenv:Envelope>
```


### Route: updateUserSettings
Updates the settings of a user to the data given
Parameters:
* user_settings (tns:userSettings, optional)
	* user_id (xsd:int)
	* activate_public_profile (xsd:string, optional) 'n': Deactivated, 'y': Internally activated, 'g': Globally activated
	* show_title (xsd:boolean, optional) true: Yes, false: No
	* show_birthday (xsd:boolean, optional) true: Yes, false: No
	* show_gender (xsd:boolean, optional) true: Yes, false: No
	* show_upload (xsd:boolean, optional) true: Yes, false: No
	* show_interests_general (xsd:boolean, optional) true: Yes, false: No
	* show_interests_help_offered (xsd:boolean, optional) true: Yes, false: No
	* show_interests_help_looking (xsd:boolean, optional) true: Yes, false: No
	* show_org_units (xsd:boolean, optional) true: Yes, false: No
	* show_institution (xsd:boolean, optional) true: Yes, false: No
	* show_department (xsd:boolean, optional) true: Yes, false: No
	* show_street (xsd:boolean, optional) true: Yes, false: No
	* show_zipcode (xsd:boolean, optional) true: Yes, false: No
	* show_city (xsd:boolean, optional) true: Yes, false: No
	* show_country (xsd:boolean, optional) true: Yes, false: No
	* show_sel_country (xsd:boolean, optional) true: Yes, false: No
	* show_phone_office (xsd:boolean, optional) true: Yes, false: No
	* show_phone_home (xsd:boolean, optional) true: Yes, false: No
	* show_phone_mobile (xsd:boolean, optional) true: Yes, false: No
	* show_fax (xsd:boolean, optional) true: Yes, false: No
	* show_email (xsd:boolean, optional) true: Yes, false: No
	* show_second_email (xsd:boolean, optional) true: Yes, false: No
	* show_hobby (xsd:boolean, optional) true: Yes, false: No
	* show_matriculation (xsd:boolean, optional) true: Yes, false: No

```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateUserSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">637ec4aaad34be151b7e1548e0a7515f::default</sid>
         <user_settings xsi:type="ns2:userSettings" xmlns:urn="urn:ilUserAdministration">
            <!--You may enter the following 25 items in any order-->
            <user_id xsi:type="xsd:int">6</user_id>
            <!--Optional:-->
            <activate_public_profile xsi:type="xsd:boolean">true</activate_public_profile>
            <!--Optional:-->
            <show_title xsi:type="xsd:boolean">true</show_title>
            <!--Optional:-->
            <show_birthday xsi:type="xsd:boolean">false</show_birthday>
            <!--Optional:-->
            <show_gender xsi:type="xsd:boolean">true</show_gender>
            <!--Optional:-->
            <show_interests_general xsi:type="xsd:boolean">true</show_interests_general>
            <!--Optional:-->
            <show_interests_help_offered xsi:type="xsd:boolean">true</show_interests_help_offered>
            <!--Optional:-->
            <show_interests_help_looking xsi:type="xsd:boolean">true</show_interests_help_looking>
            <!--Optional:-->
            <show_org_units xsi:type="xsd:boolean">true</show_org_units>
            <!--Optional:-->
            <show_institution xsi:type="xsd:boolean">true</show_institution>
            <!--Optional:-->
            <show_department xsi:type="xsd:boolean">true</show_department>
            <!--Optional:-->
            <show_street xsi:type="xsd:boolean">true</show_street>
            <!--Optional:-->
            <show_zipcode xsi:type="xsd:boolean">true</show_zipcode>
            <!--Optional:-->
            <show_city xsi:type="xsd:boolean">true</show_city>
            <!--Optional:-->
            <show_country xsi:type="xsd:boolean">true</show_country>
            <!--Optional:-->
            <show_sel_country xsi:type="xsd:boolean">true</show_sel_country>
            <!--Optional:-->
            <show_phone_office xsi:type="xsd:boolean">true</show_phone_office>
            <!--Optional:-->
            <show_phone_home xsi:type="xsd:boolean">true</show_phone_home>
            <!--Optional:-->
            <show_phone_mobile xsi:type="xsd:boolean">true</show_phone_mobile>
            <!--Optional:-->
            <show_fax xsi:type="xsd:boolean">true</show_fax>
            <!--Optional:-->
            <show_email xsi:type="xsd:boolean">true</show_email>
            <!--Optional:-->
            <show_second_email xsi:type="xsd:boolean">true</show_second_email>
            <!--Optional:-->
            <show_hobby xsi:type="xsd:boolean">true</show_hobby>
            <!--Optional:-->
            <show_matriculation xsi:type="xsd:boolean">true</show_matriculation>
         </user_settings>
      </urn:updateUserSettings>
   </soapenv:Body>
</soapenv:Envelope>
```


### Route: getUserSettings
Shows the settings of a user to the user_id given
Parameters:
* user_id (xsd:int) 
<!-- END definitions -->
