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

 
<!-- END definitions -->
