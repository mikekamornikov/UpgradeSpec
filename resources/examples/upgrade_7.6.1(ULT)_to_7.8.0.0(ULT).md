# SugarCRM upgrade: 7.6.1(ULT) -> 7.8.0.0(ULT)

## Review release notes

### Version 7.6.2.1

#### Development Changes

Developer-level feature enhancements in release 7.6.2.1 include the following:

  
- **Language file hierarchy** : The order that language strings are loaded from the file system has changed. See the [Sugar Developer Guide](http://support.sugarcrm.com/Documentation/Sugar_Developer/Sugar_Developer_Guide_7.6/Language_Framework/Application_Labels_and_Lists) for more details on the updates language file hierarchy.

### Version 7.7.0.0

#### Feature Enhancements

Feature enhancements in release 7.7.0.0 include the following. To view new features added for versions 7.5.0.0 through 7.6.0.0, please refer to the [Sugar 7.6.0.0 Release Notes](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.6/Ult/Sugar_7.6.0.0_Release_Notes/ "Sugar Ultimate 7.6.0.0 Release Notes").

  
- **[Improvements to Global Search](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Search/#Global_Search "Search")** : Improvements have been made to the Global Search user interface and functionality (e.g. search tags, etc.).
- **[Knowledge Base user interface](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Knowledge_Base/ "Knowledge Base")** : The Knowledge Base module now uses the Sidecar user interface.
- **[Tag Management](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/Tag_Management "Tag Management")** : Users with administrator or developer access can utilize the Tags module to manage the system-wide tag repository.
- **[Tagging](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Tags/#Working_With_Tags "Tags")**  : Sidecar modules contain a Tags field where users can create and share tags which can be used to identify records in filters, dashlets, and reports.
- **[Additional lead conversion options](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Leads/#Steps_to_Convert_a_Lead "Leads")**  : Leads can now be converted by clicking the Unconverted button in the Leads record view, as well as by selecting the Convert option from the Leads subpanel actions menu.
- [**Automatically associate module during lead conversion**](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Leads/#Steps_to_Convert_a_Lead) : Records will now be automatically associated during lead conversion if no duplicate records are found.
- [**Lead Conversion Options setting**](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/System/#User_Interface "System"): The Lead Conversion Options setting is now available in Admin > System Settings to handle activity records during lead conversion.
- **[Collapse all subpanels option](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/System/#User_Interface "System")** : Administrators now have the option to collapse all subpanels in Sidecar modules by default via Admin > System Settings.
- **Configuring team sets in process definitions** : Administrators can now append and replace teams via Change Fields and Add Related Record actions.
- **[Link to records in process emails](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/Process_Author/Process_Email_Templates/#Using_the_Related_Link_Selector_Tool)** : Related record URLs may now be embedded in process email templates.
- **Configuring team sets in workflows**  : Administrators can now differentiate between a record's primary team and its current team set in workflows.
- **[Contact Type filter criteria added to D&B Build a List](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Contacts/#People_Filter_Panel "Contacts")** : The Contact Type field is now available as a filter criteria in the D&B People panel.
- **[D&B Usage Meter dashlet](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/User_Interface/Intelligence_Pane#DB_Usage_Meter "Intelligence Pane")** : The D&B Usage Meter dashlet is now available to view a summary of used and remaining credit information for each available metered service (e.g. Accounts, Family Tree, etc.).
- **[GU DUNS filter criteria added to D&B Build a List](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Accounts/#Company_Information_Filter_Panel "Accounts")**  : The GU DUNS field is now available as a filter criteria in the D&B Company Information panel.
- **Expanded list views preserved** : Filtered list views with "More records..." loaded remain expanded after in-line edits are saved.
- **Group reports by week** : Summation Report, Summation Report with Details, and Matrix Report can now be grouped by "Week" for Date and Datetime fields (e.g. Start Date, Date Created, etc.).
- **Intelligent subpanel filters for Cases module**  : When linking records via the Contacts subpanel in the Cases record view, the Search and Add Contacts drawer will automatically be filtered to only display contact records associated to the case's parent account.
- **[Move recipients across To, CC, and BCC fields](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Emails/#Composing_Emails "Emails")** : Recipients can now be dragged and dropped across the To, CC, and BCC fields in the Compose Email window for Sidecar modules.
- **Move To BCC option** : The Move To BCC option is now available when composing emails in the Emails module.
- **[Notification count in favicon](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/User_Interface/#Notifications "User Interface")** : The favicon (SugarCRM cube icon) in the browser tab now displays the same number corresponding to the count in the notifications box.
- **Quotes Bill To and Ship To subpanels** : The Quotes (Bill To) and Quotes (Ship To) subpanels are now available in the Accounts and Contacts record views in order to display the related quote records accordingly.
- **Search filter support for multiple Assigned to users**  : Multiple users can now be selected when creating search filters using the Assigned to field in Sidecar modules.
- **[Timestamp for forecast's commit history](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Forecasts/#Summary_and_Commit_History)** : The Forecast module's commit history now displays a timestamp.
- **[Total record count](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/User_Interface/#Total_Record_Count "User Interface")** : The total count of records are now available in Module list views, Subpanel list views, as well as Search and Select list views.
- **Tracker support for Sidecar modules** : Tracker sessions are now logged for Sidecar modules.
- **[Traditional Chinese language supported](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Application_Guide/Getting_Started#Setting_Your_Language "Getting Started")** : Users may now choose the traditional Chinese language as their preferred language in Sugar.
- **User selection list sort order** : User selection lists previously sorted by username are now sorted by last name, first name.
- **PHPMailer** : PHPMailer is now being installed by composer and upgraded to version 5.2.9.
- **Record view performance improvement** : Improvements have been made to load record view layouts faster when multiple dropdown fields and values exist in the layout.
- **[Additional option for SAML authentication](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/Password_Management#SAML "Password Management")** : The "Load login screen in same window to avoid pop-up blocking" option can now be enabled via Admin > Password Management to load the SAML login screen in the current window and prevent pop-up blockers from disallowing single sign-on.
- **SimpleSAMLphp library 2.6.1 supported**  : SimpleSAMLphp library 2.6.1 is now supported in Sugar.
- **[Knowledge Base Categories & Published Articles dashlet on Knowledge Base list view in portal](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Portal_User_Guide/#Knowledge_Base_List_View)** : The Knowledge Base Categories & Published Articles dashlet is now available on the Knowledge Base list view in the portal.
- **Sugar logic support for portal** : Sugar logic is now supported in the portal.
- **[Upgrade support on all database stacks](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Installation_and_Upgrade_Guide/#Upgrade_Prerequisites "Sugar 7.7 Installation and Upgrade Guide")** : Upgrades are now supported on all database stacks (MySQL, DB2, Oracle, MSSQL).
#### Development Changes

Changes in release 7.7.0.0 which may affect developers include the following:

  
- SSL connections are now supported for connecting to MySQL databases.
- A new lead's Status field is no longer hard coded to "New" in the bean's `save()` method. The default status value for new leads can now be controlled using metadata as in other dropdown fields.
- The previously deprecated `DBHelper` class has been removed in Sugar 7.7. Developers should rely on the `DBManager` class instead.
- The `side-pane` layout has been removed from default layout metadata used throughout the application. The `side-pane` layout was not used in the Sugar application and was therefore superfluous. This change does not affect the `dashboard-pane` or the `preview-pane` layouts.
- The deprecated `timeago` Handlebars helper has been removed. This helper has been deprecated since Sugar 7.2.0. Developers should use the `relativeTime` Handlebars helper instead.
- A new currency `SugarObject` implementation has been introduced that can be used in Vardefs. This makes it easier to add consistent currency field support to any Sugar module. To use it, add the `currencyimplementation` into the `VardefManager::createVardefcall` within a module's Vardefs as shown below:
  
    
  ```
  VardefManager::createVardef(
      'Opportunities',
      'Opportunity',
      array(
          'default',
          'assignable',
          'team_security',
          'currency'
      )
  );
  ```
- The Sidecar bean `getSyncedAttributes()` function has been deprecated and will be removed in a future release. Developers should instead use `getSynced()` which has a different signature and allows you to check for specific attributes or retrieve them all.
- Significant changes have been made to the Lead Convert panel in order to support automatically associating modules during lead conversion and to allow related activities to be moved. Existing customizations to the Lead Convert panel may not work after upgrade. Developers should verify that any existing customizations to the following Sidecar components work in a sandbox prior to upgrading: `convert-main`, `convert-panel`, `convert-headerpane`, `convert-options`, and `convert-panel-header`.
- Global Search has been changed to use a new view containing new code. Developers who have customized the previous view will need to manually migrate their changes.
- The "Rebuild Minified JS Files", "Rebuild JS Compressed Files", and "Repair JS Files"options have been removed from Admin > Repair. These actions can be triggered manually if necessary. See [this post](http://developer.sugarcrm.com/2016/04/04/handling-of-javascript-files-in-sugar-7-7/) for more details.
- The Duration fields in the Calls and Meetings modules have been changed to Integer fields.
- The `getSyncedAttributes()` has been deprecated and will be removed in a future release. Developers should instead use `getSynced()` which has a different signature and allows you to check for specific attributes or retrieve them all.
- The following config parameters have been added to support application-level caching in the database: `external_cache_force_backend`, `cache_expire_timeout`, `external_cache_db_gc_probability`, and `external_cache_disabled_db`.
- The config parameter `SAML_provisionUser` has been added to define whether non-existing users should be auto-provisioned in Sugar when logging in via SAML.
- CSRF tokens for form submissions are now supported.
- API requests will not return records in excess of the "Listview items per page" setting in Admin > System Settings which is known in the config file as `list_max_entries_per_page`.
- A new API endpoint `/globalsearch` has been added. For compatibility, the older `/search` API is still available.
- The following entrypoints have been added to the REST API: 
  - `GET /rest/v10/Administration/search/status`
  - `GET /rest/v10/Administration/search/fields`
  - `POST /rest/v10/Administration/search/reindex`
  - `GET /rest/v10/Administration/elasticsearch/mapping`
  - `GET /rest/v10/Administration/elasticsearch/indices`
  - `GET /rest/v10/Administration/elasticsearch/routing`
  - `GET /rest/v10/Administration/elasticsearch/queue`
- The Relationships module has been deprecated. Developers should now be using `SugarRelationshipFactory` to manage bean relationships. The Relationships table has been removed because it was superfluous.
- Additional password hashing methods have been added and can be configured using `$sugar_config`.
- A change has been made to Sugar's API to no longer JSON encode database-stored settings except for arrays. This may affect custom PHP code which reads administrative config settings which were previously unnecessarily JSON encoded. Values which appear to be JSON encoded (i.e. begin with `{, [, "`) will now be JSON decoded.
- The `usePreparedStatements` config flag has been deprecated. The use of prepared statements will be implemented and enforced in a future release.
- The help page documentation for the `MassDelete` API cal has been corrected.
- Sidecar modules now support the `AssignToUserAction` Sugar Logic action.
- Developers who have created custom Sugar field types should obey a new `ellipsis_inline` setting used in Sugar Field metadata to ensure the field displays properly in different views. This can be tested by adding your custom field type to a Global search (where `ellipsis_inline` is false) or List views (where `ellipsis_inline` is true).
- The `partial` Handlebars helper now requires mandatory `component` and `context` values. The signature is now `partial 'name' component object custom=options` where `'name'` is the name of the partial template (unchanged), `component` is the component used (e.g. layout, field, or view), `object` is the context, and `custom=options` are the hashed options (unchanged).
- The jQuery UI library has been upgraded to version 1.11. Developers should re-test any custom code that makes direct use of jQuery UI APIs to ensure there are no unanticipated changes in behavior.
- The `app.utils.addNumberSeperators` API has been deprecated and will be removed in 7.9. It is replaced by `app.utils.addNumberSeparators` which has the same functionality and signature.
- The behavior of the `SugarAnalytics` API has been altered to improve performance. Existing customizations that use Analytics API functions may need to be updated.
- The `currentModule` property in the config-drawer layout `ConfigDrawerLayout` has been deprecated. The `this.module` property should be used instead.
- Customizable filter operators are now available on a per-module basis using metadata. For an example, see `modules/KBContents/clients/base/filters/operators/operators.php`.
- Sidecar's `View.Views.Base.PasswordmodalView` has been deprecated and will be removed in a future release. Developers should ensure they are not using or customizing this view which was only used in Sugar Portal.
- PHP 4 constructors have been deprecated in common `SugarBean` classes for Bugs, Cases, Contacts, etc. For example, use `Bug::__construct()` instead of `Bug::Bug()`
- Use of `CreateActionsLayout` and `CreateActionsView` (create-actions) has been deprecated in favor of `CreateLayout` and `CreateView` (create). The Sugar upgrade wizard will make a best effort migration of deprecated `create-actions` customizations. Refer to [this post](http://developer.sugarcrm.com/2015/12/29/update-on-createactionsview-changes-in-sugar-7-7/) for more details.
- For Knowledge Base Categories module, new REST APIs were added for reading and manipulating KB category hierarchies.
- A new boolean configuration setting `SAML_provisionUser` has been added that allows administrators to control SAML user auto provisioning. This setting is enabled (i.e. set to "true") by default.
- The `Select2` library used within the Sugar user interface has been upgraded to version 3.5.2. `Select2` is used to display drop down fields, etc. Refer to the [Select2 page on GitHub](https://github.com/select2/select2/tree/3.5.2) for more information. Developers should re-test any custom code that makes direct use of `Select2` APIs to ensure there are no unanticipated changes in behavior.
- A new config setting `rest_response_etag_cache_age` has been added that allows you to control the max-age value for the Cache-Control response header on REST API endpoints that support HTTP caching.
- Cross Site Request Forgery (CSRF) authentication has been added and can be enabled using a config setting, though it will be required in future Sugar versions. Developers need to use CSRF tokens on HTML forms used in Sugar's legacy modules. Refer to [this post](http://developer.sugarcrm.com/2015/12/01/csrf-tokens-in-sugar-7-7/) for more details
- The `$_SESSION` object is no longer a standard PHP array but an object that implements the `ArrayAccess` interface. Because of this, developers should no longer use standard PHP array utility functions to access the `$_SESSION` object. Refer to [this post](http://developer.sugarcrm.com/2016/01/11/php-session-changes-in-sugar-7-7/) for more details.
- Sugar's Global Search framework now includes support for Elasticsearch Aggregations. Aggregation results based on Module, Assigned User, etc, can be returned by global search queries that include `xmod_args=true` parameter. Query results can also be filtered based on these aggregation buckets.
- As part of the new tagging feature, a new `tag` field type has been introduced as well as a `taggable` SugarObject template that can be used to add tagging support to Sugar modules.
- The Sugar REST v10 `POST <module>/filter/count` endpoint has been deprecated. The equivalent `GET <module>/filter/count` endpoint should be used instead.
- Developers can now register multiple HTTP verbs at once for a single REST endpoint. When registering REST API endpoints using `SugarApi::registerApiRest`, the `reqType` parameter now supports passing an array of HTTP verbs. Refer to the example below:  
    
  ```
  public function registerApiRest() {
    return array(
      'ping' => array( 
       'reqType' => array('GET', 'POST'),
        'path' => array('ping'),
        'pathVars' => array(''),
        'method' => 'ping',
        'shortHelp' => 'An example API only responds with pong',       
        'longHelp' => 'include/api/help/ping_get_help.html',
      ),
    );
  }
  ```
- For Logic Hooks, it is now possible to use PHP namespaces to define your hook class. When a namespaced class is used, the `file_path` parameter should be left null. Refer to the example below:  
    
  ```
  $hook_array['after_save'][] = array(
    1,
    'example logic hook',
    null,
    'Sugarcrm\\Sugarcrm
    MyClass',
    'myMethod'
  );
  ```

### Version 7.7.1.0

#### Feature Enhancements

Feature enhancements in release 7.7.1.0 include the following:

  
- **[PHP 5.6 Support](http://support.sugarcrm.com/Resources/Supported_Platforms/Sugar_7.7.x_Supported_Platforms/)**  : PHP version 5.6 is now supported in Sugar.
#### Development Changes

Changes in release 7.7.1.0 which may affect developers include the following:

  
- A Command Line Interface (CLI) tool, located at `bin/sugarcrm`, and associated CLI framework has been added to the Sugar application. This CLI framework is in Beta so there could be significant changes to it in upcoming Sugar releases. This framework allows you to register commands using a new application-level Console extension point or by registering them using Composer.
- With the introduction of a new input validation framework, two new Sugar Config settings have been added, `validation.soft_fail` and `validation.compat_mode`. These settings are `true` by default to ensure compatibility, but these defaults will change in a future Sugar release. For more information, please refer to the Developer Guide or this SugarCON [security breakout presentation](https://community.sugarcrm.com/docs/DOC-3471).
- The following PHP methods and classes have been deprecated in order to add future support for prepared statements:  
  
  - `SugarVisibility::addVisibilityFrom()`, `SugarVisibility::addVisibilityWhere()`, and `SugarVisibility::addVisibilityFromQuery()` have been deprecated. Use `SugarQuery` and `SugarVisibility::addVisibilityQuery()` instead.
  - `BeanVisibility::addVisibilityFrom()`, `BeanVisibility::addVisibilityWhere()`, and `BeanVisibility::addVisibilityFromQuery()` have been deprecated. Use `SugarQuery` and `BeanVisibility::addVisibilityQuery()` instead.
  - `SugarQuery_Builder_Delete` has been deprecated. Use `SugarBean::mark_deleted()` instead.
  - `SugarQuery_Builder_Insert` and `SugarQuery_Builder_Update` have been deprecated. Use `SugarBean::save()` instead.
  - `SugarQuery_Builder_Literal` has been deprecated. There is not alternative because the class was never fully implemented.
  - `SugarQuery_Compiler` has been deprecated. Use `SugarQuery_Compiler_SQL` instead.
  - `SugarQuery::joinRaw()` has been deprecated. Use `SugarQuery::joinTable()` instead. You can specify aliases and join types using parameters that will allow you to continue to specify any custom join.
  - `SugarQuery::compileSql()` is deprecated. Use `SugarQuery::execute()` instead or use `$query->compile()->getSQL()` and `$query>compile()->getParameters()`. Executed SQL can also be viewed in sugarcrm.log by adjusting the Sugar log level to DEBUG or INFO.
  - The `$execute` parameter on `DBManager::insertParams()` is deprecated. In the future, `insertParams()` will always execute.
  - The `$execute` parameter on `DBManager::updateParams()` is deprecated. In the future, `updateParams()` will always execute.
  - The `$where` parameter on `SugarBean::update()` is deprecated. This parameter is not necessary.
  - `DBManager::delete()` is deprecated. Use `SugarBean::mark_deleted()` instead.
  - `DBManager::retrieve()` is deprecated. Use `SugarBean::retrieve()` instead.
  - `DBManager::insertSQL()` is deprecated. Use `DBManager::insert()` instead.
  - `DBManager::updateSQL()` is deprecated. Use `DBManager::update()` instead.
  - `DBManager::deleteSQL()` is deprecated. Use `SugarBean::mark_deleted()` instead.
  - `DBManager::retrieveSQL() is deprecated. Use `DBManager::retrieve()` instead.`
  - `DBManager::preparedQuery()`, `DBManager::pQuery()`, `DBManager::prepareQuery()`, `DBManager::prepareTypeData()`, and `DBManager::prepareStatement()` have been deprecated. These `DBManager` methods are no longer necessary.
- The `jssource` directory which contained copies of JavaScript sources has been removed from Sugar. Unminified JavaScript sources are available at their home locations such as under the `clients`, `include/javascript`, or `sidecar` directories. For more information, refer to this [Developer Blog post](https://developer.sugarcrm.com/2016/04/04/handling-of-javascript-files-in-sugar-7-7/).
- JSONP support for v4\_1 REST API and earlier versions is now disabled by default. A new config option `jsonp_web_service_enabled` should be set to `true` to enable JSONP support on these API versions.

### Version 7.7.2.0

#### Development Changes

Changes in release 7.7.2.0 which may affect developers include the following:

  
- The News dashlet has been disabled in this release since it relied on the Google News Search API which has been [deprecated since 2011](https://developers.google.com/news-search/ "Google News"). Any code that relied on this News dashlet or the Google News Search API will need to be updated to use an [alternative news API](https://en.wikipedia.org/wiki/List_of_news_media_APIs "List of News APIs").
- Some `PreviewLayout` metadata customizations that were non-functional in 7.7.0 have been corrected.
- Sidecar math functions will now return strings instead of numbers in order to improve the way Sidecar handles math and currency values. This will prevent floating point errors, specifically when dealing with currencies. The improved implementation relies on the `big.js` version 3.1.3 library that was introduced in this release.

### Version 7.8.0.0

#### Feature Enhancements

The following feature enhancements are included in the 7.8.0.0 release:

  
- **[Team-based Permissions](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Application_Guide/User_Interface/#Using_Team-Based_Permissions)** : When enabled by administrators, users can leverage a record's Teams field to grant viewing, editing, etc. permissions to users with specific role configurations.
- **Additional recurrence types** : Calls and meetings now have expanded types of recurrence available, especially concerning monthly recurrences.
- **[Invitee missing email address indicator](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Application_Guide/Calls/#Call_Invitees)**  : Users will now be alerted of call and meeting invitees who will not receive email invites due to empty or invalid email addresses in Sugar.
- **Start Date color coding in Calls, Meetings, Tasks subpanels** : The start dates in the Calls, Meetings, and Tasks subpanels are now highlighted according to when their start date occurs.
- **[Sugar Process Author renamed to Advanced Workflow](http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/What_to_Expect_When_Upgrading_to_7.8/#Process_Author_is_Now_Advanced_Workflow)** : Sugar's business process management tool, Process Author, is now called "Advanced Workflow".
- **Role access control for Processes module**  : Administrators now have the ability to disable the Processes module via Administration > Role Management.
- **[Improvements to locked fields in Advanced Workflow](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Administration_Guide/Advanced_Workflow/Process_Definitions/#Locked_Fields "Process Definitions")**  : For records involved in running processes, locked fields are now clearly marked with a lock icon in record view, and alerts have been added to enforce locked fields in list view and import.
- **Simplified rule selection in the process definition designer** : The Settings pop-up for business rule action elements now uses a dropdown list with type-ahead functionality.
- **Email address validation in Compose Email window** : Email addresses are now validated when composing emails from Sidecar modules (e.g. via Emails subpanel in Accounts module) in order to detect any invalid emails.
- **[Refresh option for list views and subpanels](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Application_Guide/User_Interface/#Refreshing_Search_Results)**  : Users now have the ability to refresh the records displayed in list views and subpanels by clicking the Refresh button to the right of the search bar.
- **Quantities of zero** : Revenue Line Items, Quoted Line Items, and Product Catalog records can now have quantities of zero and allow for manual entry of fields typically calculated based on a non-zero quantity.
- **[View Change Log option in Tasks module](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Application_Guide/Tasks/#Record_View_Actions_Menu)** : Users can now view a history of changes to audited fields for task records.
- **Command key supported for keyboard shortcuts** : The shortcut key now supports the use of "Command" for Macs.
- **[Customizable shortcut keys](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Application_Guide/User_Interface/Accessibility/#Customizing_Shortcut_Keys "Accessibility")** : Users can now customize the key combinations which trigger Sugar's shortcuts via the Keyboard Shortcuts page.
- **Dependent fields respected in list view's intelligence pane** : Dependent field formulas controlling a field's visibility are now respected when previewing records via the list view's intelligence pane.
- **T otal for grouped data in report chart dashlets** : Bar charts can now display the total for grouped data in report chart dashlets.
- **UTF-8 non-English characters supported for email address**  : Email addresses containing UTF-8 non-English characters may now be saved.
#### Development Changes

The following changes in release 7.8.0.0 may affect developers:

  
- The `oracle_enable_ci` config setting has been removed because case insensitivity no longer impacts performance for instances on Oracle databases.
- The `['csrf']['soft_fail_form']` config secodeing now defaults to `false` and the `['csrf']['opt_in']` setting has been removed. This means that CSRF tokens are now enabled out-of-the-box. If necessary, developers can set `$sugar_config['csrf']['soft_fail_form'] = true;` in non-production instances to disable enforcement of CSRF tokens, but FATAL notices will be generated in the `sugarcrm.log` whenever a CSRF authentication failure happens. For more information, please refer to [this developer blog post](https://developer.sugarcrm.com/2015/12/01/csrf-tokens-in-sugar-7-7/).
- The new config setting `allow_oauth_via_get` can be set to true to permit an `oauth_token` URL parameter to be used to pass the access token to Sugar's v10 REST API. The default value is `false`. This setting is provided for compatibility reasons, but enabling it is not recommended due to security concerns with passing session identifiers as URL parameters.
- The new config setting `email_mailer_timeout` can be used to change how long Sugar will wait for confirmation from an SMTP server as the default value of 20 seconds may be insufficient depending on your email server's processes and needs.
- Sugar Developers now have the ability to extend existing and customize Advanced Workflow (PMSE) classes using the custom directory. New custom actions can also be defined for use in Advanced Workflow processes. Developers can load custom Advanced Workflow objects using the new `ProcessAuthor\Factory::getProcessAuthorObject(string)` API. For example, `$obj = ProcessAuthor\Factory::getProcessAuthorObject('PMSEBusinessRule');`
- Advanced Workflow locked fields have been completely refactored using the ACL architecture.
- For those Sugar Developers with access to Sugar Test Tools, Gulp is now used instead of Grunt for unit test automation. Refer to the [Gulp website](http://gulpjs.com/ "Gulp") for more information.
- The `DashboardHeaderpaneView` has been changed to extend from `HeaderpaneView` instead of from `RecordView`.
- JavaScript source maps have been introduced for Sidecar libraries. The Sidecar source map will be loaded automatically by browser developer tools to allow you an unminified look at sidecar.min.js. This replaces the need for sidecar.js to be shipped with the product. Source Maps support may need to be enabled in your browser. For example, this [Chrome Dev Tools](https://developers.google.com/web/tools/chrome-devtools/debug/readability/source-maps?hl=en#source-maps-in-devtools-sources-panel "Chrome Dev Tools") page provides guidance for doing so in Chrome. The Sidecar source map is located at `sidecar/minified/sidecar.min.js.map`.
- Empty Sidecar components `BaseLayout` and `BaseView` have been added which can be useful for Sugar Developers who want to override existing Sidecar Layouts and Views without inheriting from an existing implementation.
- Previously, the Preview components were initialized only when first rendering the page, which sometimes meant the Preview components were not properly initialized for the correct module when a record was previewed. The Preview components (such as the `PreviewView`) are now re-initialized and re-rendered whenever a preview icon is clicked to ensure it is properly initialized.
- The `oauth_token` URL parameter can should longer be used with Sugar v10 REST API due to security concerns with passing session identifiers as a URL parameter. This parameter is now disabled by default. Please use the `OAuth-Token` HTTP header to pass access tokens to Sugar v10 REST API.
- The default model class for Sidecar's `Data.BeanCollection` is now `Data.Bean` instead of `Backbone.Model`.
- The parent Sidecar controller used with a Sidecar component can be controlled using the `type` property in view metadata. A warning has been added when new Sidecar controllers are created that only extend from a different parent controller since using the `type` property is preferred and will reduce use of browser memory and increase performance.
- The Sugar user interface can now be embedded as an iframe within other websites.
- The Sugar `ModuleInstaller` class can now be customized using the custom directory and is located at `ModuleInstall/ModuleInstaller.php`.
- With the addition of new password hashing backends, legacy (MD5) password hashing is now disabled by default but can be enabled by using the `$sugar_config['passwordHash']['allowLegacy'] = true;` config setting. A utility for working with new Sugar password hashing methods is available on [Github](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Sugar_7.8.0.0_Release_Notes/%20https:/github.com/skymeyer/password_hash).
- Sugar installs will fail if an unsupported version of Elasticsearch is installed. Please review the [Supported Platforms](http://support.sugarcrm.com/Resources/Supported_Platforms/Sugar_7.8.x_Supported_Platforms/ "Sugar 7.8.x Supported Platforms") documentation for supported Elasticsearch versions.
- The following commands have been added to the `sugarcrm` command line interface:   
  ```
  elastic:explain  Return search results with the "explain" details to show relevance score. 
  password:config  Show password hash configuration.
  password:reset   Reset user password for local user authentication.
  password:weak    Show users having weak or non-compliant password hashes.
  ```
- The `SugarQuery` object by `FilterApi`class can now be extended by overriding the newly introduced `FilterApi#newSugarQuery()` static method. This makes it easy to inject custom `SugarQuery` objects into `FilterApi`subclasses.
- The Sidecar routes used with the Home module have been moved from `include/javascript/sugar7.js` to `modules/Home/clients/base/routes/routes.js`.
- There has been a change in the supported parameters for Sidecar's `Layout#loadData()` and `View#loadData()`. Previously, the optional `setFields` parameter could be used to change the fields set on the current context. This allowed a single component on the page to alter the behavior of other components on the page, which was unwise. Support for the `setFields` parameter has been removed. The method signature for Sidecar `loadData()` functions are now `loadData(options);`.
- A new boolean flag called `fetch` has been added to Sidecar `Context`. This flag can be used to control if the current `Context` will fetch data from the server. For example,   
  ```
  var context = app.context.getContext({
      collection: new app.BeanCollection(),
      fetch: false,
  });
  
  ```  
  When `fetch === false` then the `Context#loadData()`method will immediately return when called.
- The method signature for error callbacks for `Model#fetch`, `Model#destroy`, `Model#save`, and `Collection#fetch` has changed. The `Backbone.Model` or `Backbone.Collection` is passed as the first parameter and the second parameter is now the HttpError XHR object.  
  Example using the previous method signature:   
  ```
  >this.model.save({}, {
      error: function(error) {
          ...
      }
  });
  
  ```  
  Example using the new signature:   
  ```
  this.model.save({}, {
      error: function(model, error) {
          ...
   }
  });
  ```
- The Sidecar `app.metadata.getField()` API has been updated to allow access to module-specific field metadata. This additional behavior relies on new method signature with an `options` object. The existing method signature for `app.metadata.getField()` continues to work but is deprecated in this Sugar release. For example, to fetch the metadata for the Accounts module's description field you can use `app.metadata.getField({ module: 'Accounts', name: 'description' });`.
- Sugar Developers are advised in this and future Sugar releases to not modify the `this.meta` property in Sidecar controllers. Sidecar metadata should be defined in PHP and not modified at runtime by the JavaScript controller. Doing so can introduce errors.
- The function signature for `app.acl.hasAccess((action, module, ownerId, field, recordAcls)` has been refactored. It is now possible to pass an `options` object for the optional parameters ( `field` and `recordAcls`). The `ownerId` parameter was not previously used or supported since the current user was respected. Calling `app.acl.hasAccess()` using the old convention continues to work for compatibility reasons.  
  Example using previous signature:   
  `app.acl.hasAccess('edit', 'Accounts', null, 'industry', null);`  
  Example using new signature:   
  `app.acl.hasAccess('edit', 'Accounts', {field: 'industry'});`
- The default automatic close timeout when using Sidecar Alerts is now 5 seconds instead of 9 seconds. Sugar Developers can optionally provide a delay time in milliseconds to change the delay before closing. For example:   
  ```
  // This Sidecar Alert message will automatically close after 10 seconds
  app.alert.show('message-id', {
      level: 'success',
      messages: 'Task completed!',
      autoClose: true
      autoCloseDelay : 10000
  });
  ```
- A boolean `lazy_loaded` metadata property is now supported in Sidecar Layouts. When set to `true`, the Layout components will not be initialized automatically when the Layout is initialized which prevents data from being loaded automatically. Sugar Developers can later manually initialize components by calling `this.initComponents(this._componentsMeta)` and fetch data when necessary.
- The SugarBean `update_date_modified` flag now behaves as expected for `before_save` logic hooks. Refer to the [SugarBean](http://support.sugarcrm.com/Documentation/Sugar_Developer/Sugar_Developer_Guide_7.8/Data_Framework/Models/SugarBean/ "SugarBean") documentation for more details.
- The structure of the Preview Layout metadata has changed as a result of performance improvements in the design. This means that custom Preview Layout metadata must set the `lazy_loaded` flag to `true`. For example,   
  ```
  $viewdefs['base']['layout']['preview'] = array(
      'lazy_loaded' => 'true,
      'components' => array(
          ...
      ),
      ...
  )
  ```
- The Sugar record view (RecordView) was being rendered twice on each page load. This performance issue has been corrected. Now the record view renders once and the individual field components are re-rendered when data is available. Sugar Developers should test their record view customizations to ensure this does not introduce any regressions in code that relied on this behavior. Specifically, Developers should test any custom Sidecar code which relies on field data being available during record view render, since it will likely break as the views are rendered before fields.
- The following classes are now loaded using the `SugarAutoLoader::requireWithCustom()` API which allows overriding and extending the following Module Builder parser classes via the custom directory:
- `DashletMetaDataParser`
- `GridLayoutMetaDataParser`
- `ListLayoutMetaDataParser`
- `ParserDropDown`
- `ParserLabel`
- `ParserVisibility`
- `PopupMetaDataParser`
- `SearchViewMetaDataParser`
- `SidecarFilterLayoutMetaDataParser`
- `SidecarGridLayoutMetaDataParser`
- `SidecarListLayoutMetaDataParser`
- `SidecarPortalListLayoutMetaDataParser`
- `SidecarSubpanelLayoutMetaDataParser`
- `SubpanelMetaDataParser`

- The Sidecar Router has a new method called `app.router.get(name)`. It returns the callback function associated with the route `name`. This can be used, for example, to allow fallback behavior to an existing core Sidecar route, as demonstrated below:   
  ```
          var routes = [
              {
                  name: 'myRouteCreate',
                  route: 'HelloWorld/create',
                  callback: function() {
                      // HelloWorld module specific logic for record creation
                      // ...
                      // then fallback to default create record route
                      app.router.get('create')('HelloWorld');
                  }
              },
              {
                  name:"myRoute",
                  route: "HelloWorld(/:my_custom_route)",
                  callback: myRoute
              },
              ...
          ];
  ```
- It is now possible for Sugar Developers to mark global Sidecar Events (events triggered on `app.events`) as deprecated. When registering a global event, you can specify an optional `deprecated` boolean parameter using an `options` object argument. This will trigger warnings in the JavaScript console whenever a listener subscribes using `app.events.on()`. For example,   
  ```
  app.events.register('app:old_event:start', this, {deprecated: true});
  ...
  app.events.on('app:old_event:start', ...); // Throws deprecation warning
  ```
- The Filter metadata property called `filter_relate` should only be used to dynamically filter based upon a Relate field. All other field types should use the `filter_populate` property which allows filtering based upon pre-defined values. See the [Developer Guide](https://support.sugarcrm.com/Documentation/Sugar_Developer/Sugar_Developer_Guide_7.8/Architecture/Filters/ "Developer Guide") for full documentation on Filters. An example of the supported usage is shown below:
- ```
  //record to filter related fields by
  var contact = app.data.createBean('Contacts', {
      'first_name': 'John',
      'last_name': 'Smith',		
      'assigned_user_id': 'seed_sally_id'
  });
  
  //create filter
  var filterOptions = new app.utils.FilterOptions()
      .config({
          'initial_filter': 'filterAccountTemplate',
          'initial_filter_label': 'LBL_FILTER_ACCOUNT_TEMPLATE',
          'filter_populate': {
              'account_type': ['Customer'],
          },
          'filter_relate': {
              'assigned_user_id': 'assigned_user_id'
          }
      })
      .populateRelate(contact)
      .format();
  
  //open drawer
  app.drawer.open({
      layout: 'selection-list',
      context: {
          module: 'Accounts',
          filterOptions: filterOptions,
          parent: this.context
      }
  });
  ```
- Sugar Developers can now provide the filter ID as part of a Filter API request rather than passing full filter definitions. This means a user's filters do not need to be fetched from server prior to being used. The Filter API will now throw a `SugarApiExceptionInvalidParameter` whenever a filter ID is improperly specified. For example, `<instance>/rest/v10/<module>/filter?filter_id=<filter id>` would execute a pre-existing filter with the given ID. Another example, `<instance>/rest/v10/<module>/filter?filter=<filter definition>&filter_id=<filter id>` would append additional filter criteria to a pre-existing filter.
- The Sidecar property `app.config.logLevel` has been deprecated and will be removed in a future release. Use `app.config.logger.level` instead.
- The SubpanelCreateLayout controller (`clients/base/layouts/subpanel-create`) has been deprecated. The SubpanelCreateLayout will use the SubpanelLayout controller instead of extending it.
- Sidecar's `Core.CacheManager#add` method has been deprecated and will be removed in a future release.
- The Sidecar `meta` property in views and layout definitions has been deprecated. This property allowed you to anonymously define Sidecar components within a Sidecar Layout. Sugar Developers should define Sidecar components within individual metadata files and reference them by name within Layout metadata. Sugar Developers that want to extend metadata for a particular component within a Sidecar Layout should use the `xmeta` property instead.  
  For example, if you wanted to create a custom filterpanel that overrides the metadata defined in base filterpanel, then you could create a component like the following.   
  ```
  $viewdefs['base']['layout']['custom-filterpanel'] = array(
      'components' => array(
          array(
              'layout' => 'filterpanel',
              'xmeta' => array(
                  'filter_options' => array(
                      'auto_apply' => false,
                      'stickiness' => false,
                      'show_actions' => false,
   ), ), ), ), );
  ```
- The `./clients/base/layouts/subpanels-create/subpanels-create` Sidecar layout has been deprecated and will be removed in a future release.
- The Sidecar Field controller's property `this.def`has been deprecated in this release. `this.def` is the combination of a field's definition from Vardefs (set of properties defining the field and its internal behavior) and the field's definition in Viewdefs (set of properties defining how the field will render from a view/UI standpoint) which caused problems when there were name collisions. Sugar Developers should rely on `this.viewDefs` and `this.fieldDef` when accessing metadata from Sidecar Field controllers.
- The jQuery `timepicker` plugin has been upgraded from version 1.4.10 to version 1.8.8. No changelog is available, so please use the [jQuery timepicker Github repository](https://github.com/jonthornton/jquery-timepicker/tree/1.8.8 "Follow link") to review API changes.
- The Tooltip plug-in has been deprecated and will be removed in a future release. There has been a change in behavior for how tooltips are attached to UI elements, resulting in a significant rendering performance improvement. Sugar Developers using custom tooltips on sidecar components will no longer need to use Tooltip plug-in. If the `rel=tooltip` attribute is in the Handlebars template, then tooltips will continue to work.
- The EllipsisInline plug-in has been deprecated and will be removed in a future release. Sugar Developers using the EllipsisInline plugin will no longer need to use this plug-in for their Sidecar components. If the ellipsis\_inline class is in component's Handlebars template, then ellipsis behavior will continue to work. Event bubbling is being used to implement these features rather than a DOM search, which significantly improves rendering performance. Developers should verify that the `ellipsis_inline` class and `rel=tooltip` attribute are not used where it is not needed to prevent ellipsis and tooltips from appearing.
- The Sidecar Field controller functions named `createErrorTooltips` and `destroyAllErrorTooltips`have been deprecated and will be removed in a future release.
- The `ErrorDecoration` Sidecar plug-in functions named `showTooltip` and `hideTooltip` have been deprecated and will be removed in a future release.
- The `app.utils.tooltip` JavaScript class has been deprecated and will be removed in a future Sugar release.
- The v10 REST `GET /<module>/filter/:record` endpoint has been deprecated in favor of the `GET /<module>/filter` endpoint and will be removed in future REST API versions. An equivalent call to `GET /<module>/filter/?` can be accomplished using `GET/<module>/filter?filter_id=?`.
- The deprecated `PasswordmodalView` has been removed for both portal and base platforms in this Sugar release. There is no replacement API because these views were rarely used. The views were located at `./clients/base/views/passwordmodal` and `./clients/portal/views/passwordmodal`.
- The unused and empty SugarMVC Notifications module controller has been removed. The file was located at `./modules/Notifications/controller.php`.
- The `AvatarField#_getModuleName()` method has been removed from AvatarField (`clients/base/fields/avatar/avatar.js`).
- The deprecated Sidecar method `app.lang.getModuleSingular` has been removed in this release. Sugar Developers should use `app.lang.getModuleName` instead.
- The Sidecar `NewsView` which was used for the News dashlet has been removed after previously being disabled and deprecated in Sugar 7.7.2.0. The `./clients/base/views/news/` directory was removed. Any remaining News dashlets appearing on user dashboards will be removed during upgrade.
- The code for an external job queue framework that was added in Sugar 7.7 has been removed including `queueManager.php` and `src/JobQueue/`. The 7.7 implementation of job queue will not be completed. The `cron.php` based job queue and scheduler continues to be supported.
- The deprecated boolean `visible` and string `access` parameters supported by Sidecar `app.metadata.getModuleNames()`method have been removed in this release. The `app.metadata.getModuleNames(options)` method now only accepts an `options` hash.
- The following elements were previously deprecated and have now been removed:  
  JavaScript functions: 
  - `Data.Bean.setDefaultAttributes`
  - `Data.Bean.setDefaultAttribute`
  - `Data.Bean.removeDefaultAttribute`
  - `Data.Bean.getDefaultAttribute`
  - `Data.Bean.getDefaultAttributes`
  - `App.File.checkFileFieldsAndProcessUpload`
  - `App.view.View.getTemplateFromMeta`
  - `App.view.fields.BaseParentField.checkAcl`
  - `App.view.layouts.BaseHeaderLayout.showMenu`
  - `App.view.layouts.BaseHeaderLayout.hideMenu`
  - `App.view.views.BaseBwcView.beforeRoute`
  
  Handlebars Helper functions: 
  - `getFieldValue`
  
  JavaScript classes and associated files: 
  - `App.view.layouts.CreateActionsLayout`
  - `App.view.views.BaseCreateActionsView`
  - `App.view.views.BaseRecordlistView.setScrollAtLeftBorder`
  - `App.view.views.BaseRecordlistView.setScrollAtRightBorder`
  
  JavaScript namespaces: 
  - `App.file` (It is now hardcoded to an unmodifiable empty object)
  
  Sidecar utility functions: 
  - `app.date.compareDates()` (use `app.util.compare()` instead)
  - `app.date.isDateAfter()` (use `app.util.isAfter()` instead)
  - `app.date.isDateBefore()` (use `app.util.isBefore()` instead)
  - `app.date.isDateOn()` (use `app.util.isSame()` instead)
  - `app.date.isDateBetween()` (use `app.util.isBetween()` instead)
- jQuery has been updated from version 1.7.1 to version 1.11.3. The jQuery Migrate 1.2.1 plug-in has been included to preserve compatibility for custom code using pre-1.9 jQuery APIs. The jQuery Migrate plug-in will be removed in a future release so Sugar Developers should start migrating code using pre-1.9 jQuery APIs to prevent future breakages. Refer to the JQuery Migrate Readme for more details. Refer to the [JQuery Migrate Readme](https://github.com/jquery/jquery-migrate#readme "JQuery Migrate Readme") for more details.
- The version of jQuery that is used within Legacy modules has been upgraded to version 1.11.1. BWC customizations that used jQuery APIs should be retested to verify they continue to work with this version of jQuery.
- The TinyMCE library has been upgraded from version 3.5.8 to version 4.1.8.
- The `Backbone.js` library has been upgraded from version 0.9.10 to version 1.2.3. Developers that have written code directly against Backbone.js APIs should test their customizations to ensure regressions have not occurred. There are, in some cases, a change in order of parameters used in some Backbone APIs. Usage of Sidecar provided APIs would be unaffected. Refer to the [Backbone documentation](https://cdn.rawgit.com/jashkenas/backbone/1.2.3/index.html "Follow link") for more details.
- The `Underscore.js` library has been upgraded from version 1.4.4 to version 1.8.3. Developers that have written code directly against Underscore APIs should test their customizations to ensure regressions have not occurred. There are, in some cases, a change in order of parameters used in some Underscore APIs. Usage of Sidecar-provided APIs are unaffected. An Underscore API change introduced in version 1.5.0 means that using `_.bindAll(object)` no longer works. You must specify the specific method names to bind using `_.bindAll(object, methodNames)`. Any custom Sugar code that relies on `_.bindAll(object)` needs to be updated. We recommend Sugar Developers use Underscore `_.bind()` or some other alternative to pass context to individual callback methods instead.



## Review / rewrite existing core changes

If your build sources are GIT driven ("sugarcrm/Mango" fork) find all your core changes and (if possible) rewrite them in upgrade safe way. This way you'll avoid merge conflicts during the upgrade.
If it's not possible be sure to track and backup such changes. There is a big chance some of them:
- are implemented by core dev team in the version you plan to upgrade to
- make no sense anymore
- cause additional issues on its own (for example require missing file)

Please review [developer guide](http://support.sugarcrm.com/Documentation/Sugar_Developer/Sugar_Developer_Guide_7.8/Architecture/index.html#Extensions).


## Review upgrade changes and fix possible customization conflicts

### Apply upgrade packages in the following order:

1. /Users/m.kamornikov/Downloads/upgrade_packages/SugarUlt-Upgrade-7.6.x-to-7.7.2.0.zip
2. /Users/m.kamornikov/Downloads/upgrade_packages/SugarUlt-Upgrade-7.7.x-to-7.8.0.0.zip


### You have direct customizations of the following modified core files:

- ./ModuleInstall/ModuleInstaller.php
- ./clients/base/api/BulkApi.php
- ./clients/base/api/CurrentUserApi.php
- ./clients/base/api/DuplicateCheckApi.php
- ./clients/base/api/ExportApi.php
- ./clients/base/api/FileApi.php
- ./clients/base/api/FilterApi.php
- ./clients/base/api/MassUpdateApi.php
- ./clients/base/api/MetadataApi.php
- ./clients/base/api/ModuleApi.php
- ./clients/base/api/OAuth2Api.php
- ./clients/base/api/PipelineChartApi.php
- ./clients/base/api/RecentApi.php
- ./clients/base/api/RelateRecordApi.php
- ./clients/base/api/UnifiedSearchApi.php
- ./clients/base/fields/actiondropdown/actiondropdown.js
- ./clients/base/fields/actionmenu/actionmenu.js
- ./clients/base/fields/avatar/avatar.js
- ./clients/base/fields/avatar/module-icon.hbs
- ./clients/base/fields/base/base.js
- ./clients/base/fields/bool/bool.js
- ./clients/base/fields/currency/currency.js
- ./clients/base/fields/date/date.js
- ./clients/base/fields/datetimecombo/datetimecombo.js
- ./clients/base/fields/editablelistbutton/editablelistbutton.js
- ./clients/base/fields/email/email.js
- ./clients/base/fields/email/list.hbs
- ./clients/base/fields/enum/detail.hbs
- ./clients/base/fields/enum/enum.js
- ./clients/base/fields/enum/list.hbs
- ./clients/base/fields/enum/massupdate.hbs
- ./clients/base/fields/file/file.js
- ./clients/base/fields/fullname/detail.hbs
- ./clients/base/fields/fullname/fullname.js
- ./clients/base/fields/fullname/list.hbs
- ./clients/base/fields/mass-email-button/list-header.hbs
- ./clients/base/fields/mass-email-button/mass-email-button.js
- ./clients/base/fields/phone/detail.hbs
- ./clients/base/fields/phone/edit.hbs
- ./clients/base/fields/phone/list.hbs
- ./clients/base/fields/phone/phone.js
- ./clients/base/fields/quickcreate/quickcreate.js
- ./clients/base/fields/radioenum/edit.hbs
- ./clients/base/fields/relate/detail.hbs
- ./clients/base/fields/relate/list.hbs
- ./clients/base/fields/relate/relate.js
- ./clients/base/filters/operators/operators.php
- ./clients/base/layouts/dupecheck-filter/dupecheck-filter.js
- ./clients/base/layouts/filter/filter.js
- ./clients/base/layouts/first-login-wizard/first-login-wizard.php
- ./clients/base/layouts/footer/footer.hbs
- ./clients/base/layouts/footer/footer.js
- ./clients/base/layouts/footer/footer.php
- ./clients/base/layouts/header/header.js
- ./clients/base/layouts/header/header.php
- ./clients/base/layouts/login/login.php
- ./clients/base/layouts/preview/preview.php
- ./clients/base/layouts/record/record.php
- ./clients/base/layouts/records/records.php
- ./clients/base/views/audit-footer/audit-footer.hbs
- ./clients/base/views/audit-footer/audit-footer.js
- ./clients/base/views/audit/audit.hbs
- ./clients/base/views/audit/audit.js
- ./clients/base/views/audit/audit.php
- ./clients/base/views/bwc/bwc.js
- ./clients/base/views/create/create.js
- ./clients/base/views/dashablelist/dashablelist.js
- ./clients/base/views/dupecheck-list-multiselect/dupecheck-list-multiselect.js
- ./clients/base/views/dupecheck-list/dupecheck-list.js
- ./clients/base/views/filter-filter-dropdown/filter-filter-dropdown.js
- ./clients/base/views/filter-quicksearch/filter-quicksearch.js
- ./clients/base/views/filter-rows/filter-rows.js
- ./clients/base/views/filtered-list/filtered-list.js
- ./clients/base/views/filtered-search/filtered-search.js
- ./clients/base/views/flex-list/flex-list.hbs
- ./clients/base/views/footer-actions/footer-actions.hbs
- ./clients/base/views/footer-actions/footer-actions.js
- ./clients/base/views/help-dashlet/help-dashlet.hbs
- ./clients/base/views/help-dashlet/help-dashlet.js
- ./clients/base/views/learning-resources/learning-resources.php
- ./clients/base/views/list/list.js
- ./clients/base/views/logout/logout.hbs
- ./clients/base/views/massupdate/massupdate.js
- ./clients/base/views/module-menu/module-menu.js
- ./clients/base/views/multi-selection-list-link/multi-selection-list-link.js
- ./clients/base/views/notifications/notifications-alert.hbs
- ./clients/base/views/notifications/notifications.hbs
- ./clients/base/views/notifications/notifications.js
- ./clients/base/views/notifications/notifications.php
- ./clients/base/views/panel-top/panel-top.js
- ./clients/base/views/panel-top/panel-top.php
- ./clients/base/views/preview/preview.hbs
- ./clients/base/views/preview/preview.js
- ./clients/base/views/quickcreate/quickcreate.js
- ./clients/base/views/setup-complete-wizard-page/setup-complete-wizard-page.hbs
- ./clients/base/views/setup-complete-wizard-page/setup-complete-wizard-page.js
- ./clients/base/views/subpanel-list/subpanel-list.js
- ./clients/base/views/user-locale-wizard-page/user-locale-wizard-page.js
- ./clients/mobile/api/CurrentUserMobileApi.php
- ./clients/platforms.php
- ./data/SugarBeanApiHelper.php
- ./data/acl/SugarACLAdministration.php
- ./data/acl/SugarACLOAuthKeys.php
- ./include/CalendarEvents/CalendarEvents.php
- ./include/DashletContainer/Containers/DCActions.php
- ./include/Dashlets/DashletGenericConfigure.tpl
- ./include/Dashlets/DashletGenericDisplay.tpl
- ./include/DetailView/DetailView.tpl
- ./include/DetailView/header.tpl
- ./include/EditView/SugarVCR.tpl
- ./include/EditView/header.tpl
- ./include/Expressions/javascript/dependency.js
- ./include/ListView/ListView.php
- ./include/ListView/ListViewGeneric.tpl
- ./include/Localization/Localization.php
- ./include/MVC/Controller/action_file_map.php
- ./include/MVC/Controller/action_view_map.php
- ./include/MVC/Controller/entry_point_registry.php
- ./include/MVC/Controller/wireless_module_registry.php
- ./include/MVC/SugarApplication.php
- ./include/MVC/View/tpls/Importvcard.tpl
- ./include/MVC/View/tpls/fts_full.tpl
- ./include/MVC/View/tpls/sidecar.tpl
- ./include/MVC/View/views/view.edit.php
- ./include/MVC/View/views/view.fts.php
- ./include/MVC/View/views/view.modulelistmenu.php
- ./include/MVC/View/views/view.plugins.php
- ./include/MVC/View/views/view.popup.php
- ./include/MVC/View/views/view.sidecar.php
- ./include/MetaDataManager/MetaDataHacks.php
- ./include/MetaDataManager/MetaDataManagerMobile.php
- ./include/MySugar/javascript/MySugar.js
- ./include/MySugar/tpls/MySugar.tpl
- ./include/Popups/tpls/header.tpl
- ./include/QuickSearchDefaults.php
- ./include/SearchForm/SearchForm2.php
- ./include/SearchForm/tpls/SearchFormGeneric.tpl
- ./include/SearchForm/tpls/SearchFormGenericAdvanced.tpl
- ./include/SearchForm/tpls/header.tpl
- ./include/SubPanel/SubPanelViewer.php
- ./include/SugarEmailAddress/SugarEmailAddress.js
- ./include/SugarEmailAddress/templates/forEditView.tpl
- ./include/SugarFields/Fields/Address/DetailView.tpl
- ./include/SugarFields/Fields/Address/EditView.tpl
- ./include/SugarFields/Fields/Address/SugarFieldAddress.php
- ./include/SugarFields/Fields/Address/en_us.DetailView.tpl
- ./include/SugarFields/Fields/Address/en_us.EditView.tpl
- ./include/SugarFields/Fields/Base/EditView.tpl
- ./include/SugarFields/Fields/Base/ListView.tpl
- ./include/SugarFields/Fields/Bool/DetailView.tpl
- ./include/SugarFields/Fields/Bool/EditView.tpl
- ./include/SugarFields/Fields/Currency_id/SugarFieldCurrency_id.php
- ./include/SugarFields/Fields/Date/SugarFieldDate.php
- ./include/SugarFields/Fields/Datetime/EditView.tpl
- ./include/SugarFields/Fields/Datetime/SugarFieldDatetime.php
- ./include/SugarFields/Fields/Email/SugarFieldEmail.php
- ./include/SugarFields/Fields/Enum/EditView.tpl
- ./include/SugarFields/Fields/Enum/SearchView.tpl
- ./include/SugarFields/Fields/Enum/SugarFieldEnum.php
- ./include/SugarFields/Fields/Fullname/SugarFieldFullname.php
- ./include/SugarFields/Fields/Id/SugarFieldId.php
- ./include/SugarFields/Fields/Multienum/ListView.tpl
- ./include/SugarFields/Fields/Multienum/SugarFieldMultienum.php
- ./include/SugarFields/Fields/Parent/EditView.tpl
- ./include/SugarFields/Fields/Parent/SearchView.tpl
- ./include/SugarFields/Fields/Phone/DetailView.tpl
- ./include/SugarFields/Fields/Phone/ListView.tpl
- ./include/SugarFields/Fields/Radioenum/EditView.tpl
- ./include/SugarFields/Fields/Relate/DetailView.tpl
- ./include/SugarFields/Fields/Relate/EditView.tpl
- ./include/SugarFields/Fields/Relate/SearchView.tpl
- ./include/SugarFields/Fields/Relate/SugarFieldRelate.php
- ./include/SugarFields/Fields/Teamset/TeamsetCollectionEditView.tpl
- ./include/SugarFields/Fields/Text/EditView.tpl
- ./include/SugarOAuth2/SugarOAuth2Server.php
- ./include/SugarOAuth2/SugarOAuth2Storage.php
- ./include/SugarOAuth2/SugarOAuth2StorageMobile.php
- ./include/SugarObjects/templates/basic/vardefs.php
- ./include/SugarSearchEngine/Elastic/SugarSearchEngineElastic.php
- ./include/SugarSearchEngine/Elastic/SugarSearchEngineElasticResultSet.php
- ./include/SugarSmarty/Sugar_Smarty.php
- ./include/SugarSmarty/plugins/function.sugar_button.php
- ./include/SugarSmarty/plugins/function.sugar_currency_format.php
- ./include/SugarSmarty/plugins/function.sugar_getjspath.php
- ./include/api/RestRequest.php
- ./include/api/RestResponse.php
- ./include/connectors/utils/ConnectorHtmlHelper.php
- ./include/generic/LayoutManager.php
- ./include/generic/SugarWidgets/SugarWidgetFieldbool.php
- ./include/generic/SugarWidgets/SugarWidgetFielddatetime.php
- ./include/generic/SugarWidgets/SugarWidgetFielddatetimecombo.php
- ./include/generic/SugarWidgets/SugarWidgetFieldenum.php
- ./include/generic/SugarWidgets/SugarWidgetFieldid.php
- ./include/generic/SugarWidgets/SugarWidgetFieldimage.php
- ./include/generic/SugarWidgets/SugarWidgetFieldmultienum.php
- ./include/generic/SugarWidgets/SugarWidgetFieldname.php
- ./include/generic/SugarWidgets/SugarWidgetFieldtag.php
- ./include/generic/SugarWidgets/SugarWidgetFieldteam_name.php
- ./include/generic/SugarWidgets/SugarWidgetFieldtext.php
- ./include/generic/SugarWidgets/SugarWidgetFieldvarchar.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelCloseButton.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelDetailViewLink.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelIcon.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelRemoveButton.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelTopButtonQuickCreate.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelTopCreateAccountNameButton.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelTopCreateLeadNameButton.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelTopCreateNoteButton.php
- ./include/generic/SugarWidgets/SugarWidgetSubPanelTopCreateTaskButton.php
- ./include/globalControlLinks.php
- ./include/javascript/calendar.js
- ./include/javascript/jsAlerts.php
- ./include/javascript/popup_helper.js
- ./include/javascript/quicksearch.js
- ./include/javascript/reportCriteria.js
- ./include/javascript/reports.js
- ./include/javascript/select2/select2.js
- ./include/javascript/sugar7.js
- ./include/javascript/sugar7/bwc.js
- ./include/javascript/sugar7/hbs-helpers.js
- ./include/language/en_us.lang.php
- ./include/tabConfig.php
- ./include/utils/class_map.php
- ./include/vCard.php
- ./install/install_utils.php
- ./jssource/JSGroupings.php
- ./metadata/accounts_contactsMetaData.php
- ./metadata/accounts_opportunitiesMetaData.php
- ./metadata/calls_usersMetaData.php
- ./metadata/email_addressesMetaData.php
- ./metadata/meetings_usersMetaData.php
- ./metadata/opportunities_contactsMetaData.php
- ./modules/ACLFields/ACLField.php
- ./modules/ACLRoles/ACLRoleSet.php
- ./modules/Accounts/Account.js
- ./modules/Accounts/Dashlets/MyAccountsDashlet/MyAccountsDashlet.data.php
- ./modules/Accounts/Dashlets/MyAccountsDashlet/MyAccountsDashlet.meta.php
- ./modules/Accounts/Dashlets/MyAccountsDashlet/MyAccountsDashlet.php
- ./modules/Accounts/ShowDuplicates.php
- ./modules/Accounts/clients/base/filters/default/default.php
- ./modules/Accounts/clients/base/menus/header/header.php
- ./modules/Accounts/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Accounts/clients/base/views/dupecheck-list/dupecheck-list.php
- ./modules/Accounts/clients/base/views/list/list.php
- ./modules/Accounts/clients/base/views/record/record.php
- ./modules/Accounts/clients/base/views/selection-list/selection-list.php
- ./modules/Accounts/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Accounts/clients/mobile/views/detail/detail.php
- ./modules/Accounts/clients/mobile/views/edit/edit.php
- ./modules/Accounts/clients/mobile/views/list/list.php
- ./modules/Accounts/language/en_us.lang.php
- ./modules/Accounts/metadata/SearchFields.php
- ./modules/Accounts/metadata/acldefs.php
- ./modules/Accounts/metadata/additionalDetails.php
- ./modules/Accounts/metadata/detailviewdefs.php
- ./modules/Accounts/metadata/editviewdefs.php
- ./modules/Accounts/metadata/listviewdefs.php
- ./modules/Accounts/metadata/metafiles.php
- ./modules/Accounts/metadata/popupdefs.php
- ./modules/Accounts/metadata/quickcreatedefs.php
- ./modules/Accounts/metadata/searchdefs.php
- ./modules/Accounts/views/view.detail.php
- ./modules/Accounts/views/view.edit.php
- ./modules/Accounts/views/view.list.php
- ./modules/Activities/language/en_us.lang.php
- ./modules/Administration/PasswordManager.php
- ./modules/Administration/PasswordManager.tpl
- ./modules/Administration/QuickRepairAndRebuild.php
- ./modules/Administration/RebuildJSLang.php
- ./modules/Administration/SupportPortal.php
- ./modules/Administration/UpgradeWizard_commit.php
- ./modules/Administration/action_view_map.php
- ./modules/Administration/controller.php
- ./modules/Administration/language/en_us.lang.php
- ./modules/Administration/repairDatabase.php
- ./modules/Administration/views/view.configureshortcutbar.php
- ./modules/Administration/views/view.configuretabs.php
- ./modules/Administration/views/view.repair.php
- ./modules/Audit/Audit.php
- ./modules/Audit/clients/base/fields/fieldtype/fieldtype.js
- ./modules/Audit/field_assoc.php
- ./modules/Audit/language/en_us.lang.php
- ./modules/Bugs/Dashlets/MyBugsDashlet/MyBugsDashlet.meta.php
- ./modules/Bugs/Dashlets/MyBugsDashlet/MyBugsDashlet.php
- ./modules/Bugs/language/en_us.lang.php
- ./modules/Calendar/CalendarDisplay.php
- ./modules/Calendar/Dashlets/CalendarDashlet/CalendarDashlet.en_us.lang.php
- ./modules/Calendar/Dashlets/CalendarDashlet/CalendarDashlet.meta.php
- ./modules/Calendar/Dashlets/CalendarDashlet/CalendarDashlet.php
- ./modules/Calendar/Dashlets/CalendarDashlet/CalendarDashletOptions.tpl
- ./modules/Calendar/controller.php
- ./modules/Calendar/index.php
- ./modules/Calendar/language/en_us.lang.php
- ./modules/Calendar/tpls/main.tpl
- ./modules/Calls/CallHelper.php
- ./modules/Calls/CallsApiHelper.php
- ./modules/Calls/Dashlets/MyCallsDashlet/MyCallsDashlet.data.php
- ./modules/Calls/Dashlets/MyCallsDashlet/MyCallsDashlet.meta.php
- ./modules/Calls/Dashlets/MyCallsDashlet/MyCallsDashlet.php
- ./modules/Calls/Save.php
- ./modules/Calls/clients/base/filters/default/default.php
- ./modules/Calls/clients/base/layouts/list-dashboard/list-dashboard.php
- ./modules/Calls/clients/base/layouts/subpanels/subpanels.php
- ./modules/Calls/clients/base/menus/header/header.php
- ./modules/Calls/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Calls/clients/base/views/create/create.js
- ./modules/Calls/clients/base/views/list/list.php
- ./modules/Calls/clients/base/views/preview/preview.php
- ./modules/Calls/clients/base/views/record/record.js
- ./modules/Calls/clients/base/views/record/record.php
- ./modules/Calls/clients/base/views/recordlist/recordlist.php
- ./modules/Calls/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Calls/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Calls/clients/mobile/views/detail/detail.php
- ./modules/Calls/clients/mobile/views/edit/edit.php
- ./modules/Calls/clients/mobile/views/list/list.php
- ./modules/Calls/controller.php
- ./modules/Calls/language/en_us.lang.php
- ./modules/Calls/metadata/SearchFields.php
- ./modules/Calls/metadata/additionalDetails.php
- ./modules/Calls/metadata/detailviewdefs.php
- ./modules/Calls/metadata/editviewdefs.php
- ./modules/Calls/metadata/listviewdefs.php
- ./modules/Calls/metadata/quickcreatedefs.php
- ./modules/Calls/metadata/searchdefs.php
- ./modules/Calls/metadata/subpanels/ForActivities.php
- ./modules/Calls/metadata/subpanels/ForHistory.php
- ./modules/Calls/tpls/footer.tpl
- ./modules/Calls/views/view.edit.php
- ./modules/Calls/views/view.list.php
- ./modules/Campaigns/Dashlets/TopCampaignsDashlet/TopCampaignsDashlet.meta.php
- ./modules/Campaigns/Dashlets/TopCampaignsDashlet/TopCampaignsDashlet.php
- ./modules/Cases/Dashlets/MyCasesDashlet/MyCasesDashlet.meta.php
- ./modules/Cases/Dashlets/MyCasesDashlet/MyCasesDashlet.php
- ./modules/Cases/language/en_us.lang.php
- ./modules/Charts/Dashlets/CampaignROIChartDashlet/CampaignROIChartDashlet.php
- ./modules/Charts/Dashlets/OpportunitiesByLeadSourceByOutcomeDashlet/OpportunitiesByLeadSourceByOutcomeDashlet.php
- ./modules/Charts/Dashlets/OpportunitiesByLeadSourceDashlet/OpportunitiesByLeadSourceDashlet.php
- ./modules/Charts/Dashlets/OutcomeByMonthDashlet/OutcomeByMonthDashlet.php
- ./modules/Charts/Dashlets/PipelineBySalesStageDashlet/PipelineBySalesStageDashlet.php
- ./modules/Charts/language/en_us.lang.php
- ./modules/Configurator/controller.php
- ./modules/Connectors/connectors/formatters/ext/rest/twitter/tpls/default.tpl
- ./modules/Connectors/connectors/formatters/ext/rest/twitter/tpls/twitter.gif
- ./modules/Connectors/connectors/formatters/ext/rest/twitter/twitter.php
- ./modules/Connectors/connectors/sources/ext/rest/twitter/config.php
- ./modules/Connectors/connectors/sources/ext/rest/twitter/language/en_us.lang.php
- ./modules/Connectors/controller.php
- ./modules/Connectors/metadata/searchdefs.php
- ./modules/Connectors/tpls/modify_properties.tpl
- ./modules/Connectors/tpls/source_properties.tpl
- ./modules/Contacts/ContactFormBase.php
- ./modules/Contacts/ContactsApiHelper.php
- ./modules/Contacts/ShowDuplicates.php
- ./modules/Contacts/clients/base/filters/default/default.php
- ./modules/Contacts/clients/base/menus/header/header.php
- ./modules/Contacts/clients/base/views/dupecheck-list/dupecheck-list.php
- ./modules/Contacts/clients/base/views/record/record.php
- ./modules/Contacts/clients/base/views/selection-list/selection-list.php
- ./modules/Contacts/clients/base/views/subpanel-for-opportunities/subpanel-for-opportunities.php
- ./modules/Contacts/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Contacts/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Contacts/clients/mobile/views/detail/detail.php
- ./modules/Contacts/clients/mobile/views/edit/edit.php
- ./modules/Contacts/clients/mobile/views/list/list.php
- ./modules/Contacts/controller.php
- ./modules/Contacts/language/en_us.lang.php
- ./modules/Contacts/metadata/SearchFields.php
- ./modules/Contacts/metadata/additionalDetails.php
- ./modules/Contacts/metadata/detailviewdefs.php
- ./modules/Contacts/metadata/editviewdefs.php
- ./modules/Contacts/metadata/listviewdefs.php
- ./modules/Contacts/metadata/metafiles.php
- ./modules/Contacts/metadata/popupdefs.php
- ./modules/Contacts/metadata/quickcreatedefs.php
- ./modules/Contacts/metadata/searchdefs.php
- ./modules/Contacts/metadata/subpanels/ForAccounts.php
- ./modules/Contacts/metadata/subpanels/ForCalls.php
- ./modules/Contacts/metadata/subpanels/ForCases.php
- ./modules/Contacts/metadata/subpanels/ForContacts.php
- ./modules/Contacts/metadata/subpanels/ForEmails.php
- ./modules/Contacts/metadata/subpanels/ForEmailsByAddr.php
- ./modules/Contacts/metadata/subpanels/ForMeetings.php
- ./modules/Contacts/metadata/subpanels/ForOpportunities.php
- ./modules/Contacts/metadata/subpanels/ForProject.php
- ./modules/Contacts/metadata/subpanels/default.php
- ./modules/Contacts/views/view.contactaddresspopup.php
- ./modules/Contacts/views/view.detail.php
- ./modules/Contacts/views/view.edit.php
- ./modules/Contacts/views/view.list.php
- ./modules/Contacts/views/view.quickcreate.php
- ./modules/Contracts/language/en_us.lang.php
- ./modules/Currencies/EditView.js
- ./modules/Currencies/EditView.tpl
- ./modules/Currencies/ListCurrency.php
- ./modules/Currencies/index.php
- ./modules/Currencies/language/en_us.lang.php
- ./modules/CustomQueries/BindMapView.php
- ./modules/CustomQueries/CustomQuery.php
- ./modules/CustomQueries/DetailView.php
- ./modules/CustomQueries/EditView.html
- ./modules/CustomQueries/EditView.php
- ./modules/CustomQueries/RepairQuery.php
- ./modules/CustomQueries/index.php
- ./modules/Dashboards/clients/base/api/DashboardApi.php
- ./modules/DocumentRevisions/language/en_us.lang.php
- ./modules/DocumentRevisions/metadata/editviewdefs.php
- ./modules/Documents/DocumentExternalApiDropDown.php
- ./modules/Documents/language/en_us.lang.php
- ./modules/Documents/metadata/detailviewdefs.php
- ./modules/Documents/metadata/editviewdefs.php
- ./modules/Documents/metadata/quickcreatedefs.php
- ./modules/Documents/metadata/searchdefs.php
- ./modules/Documents/views/view.detail.php
- ./modules/Documents/views/view.edit.php
- ./modules/DynamicFields/language/en_us.lang.php
- ./modules/EAPM/language/en_us.lang.php
- ./modules/EAPM/metadata/editviewdefs.php
- ./modules/EmailAddresses/language/en_us.lang.php
- ./modules/Emails/Dashlets/MyEmailsDashlet/MyEmailsDashlet.data.php
- ./modules/Emails/Dashlets/MyEmailsDashlet/MyEmailsDashlet.meta.php
- ./modules/Emails/Dashlets/MyEmailsDashlet/MyEmailsDashlet.php
- ./modules/Emails/DetailView.html
- ./modules/Emails/DetailView.php
- ./modules/Emails/DetailViewSent.html
- ./modules/Emails/clients/base/fields/quickcreate/quickcreate.hbs
- ./modules/Emails/clients/base/fields/quickcreate/quickcreate.js
- ./modules/Emails/clients/base/layouts/records/records.php
- ./modules/Emails/clients/base/menus/header/header.php
- ./modules/Emails/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Emails/clients/base/views/panel-top/panel-top.php
- ./modules/Emails/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Emails/language/en_us.lang.php
- ./modules/Emails/metadata/subpanels/ForHistory.php
- ./modules/Emails/metadata/subpanels/ForUnlinkedEmailHistory.php
- ./modules/Employees/EmployeesSearchForm.php
- ./modules/Employees/Save.php
- ./modules/Employees/clients/base/views/selection-list/selection-list.php
- ./modules/Employees/controller.php
- ./modules/Employees/language/en_us.lang.php
- ./modules/Employees/metadata/SearchFields.php
- ./modules/Employees/metadata/detailviewdefs.php
- ./modules/Employees/metadata/editviewdefs.php
- ./modules/Employees/metadata/listviewdefs.php
- ./modules/Employees/metadata/searchdefs.php
- ./modules/Employees/views/view.detail.php
- ./modules/Employees/views/view.edit.php
- ./modules/Employees/views/view.list.php
- ./modules/ExpressionEngine/controller.php
- ./modules/ExpressionEngine/language/en_us.lang.php
- ./modules/Forecasts/controller.php
- ./modules/Forecasts/language/en_us.lang.php
- ./modules/Home/Dashlets/InvadersDashlet/InvadersDashlet.meta.php
- ./modules/Home/Dashlets/InvadersDashlet/InvadersDashlet.php
- ./modules/Home/Dashlets/SugarNewsDashlet/SugarNewsDashlet.meta.php
- ./modules/Home/Dashlets/SugarNewsDashlet/SugarNewsDashlet.php
- ./modules/Home/QuickSearch.php
- ./modules/Home/UnifiedSearch.php
- ./modules/Home/UnifiedSearchAdvanced.php
- ./modules/Home/clients/base/layouts/record-dashboard/record-dashboard.php
- ./modules/Home/clients/base/menus/header/header.php
- ./modules/Home/clients/base/views/module-menu/module-menu.hbs
- ./modules/Home/language/en_us.lang.php
- ./modules/Home/views/view.additionaldetailsretrieve.php
- ./modules/Home/views/view.list.php
- ./modules/Import/controller.php
- ./modules/Import/language/en_us.lang.php
- ./modules/Import/tpls/confirm.tpl
- ./modules/Import/tpls/step3.tpl
- ./modules/Import/tpls/wizardWrapper.tpl
- ./modules/Import/views/view.confirm.php
- ./modules/Import/views/view.last.php
- ./modules/Import/views/view.step2.php
- ./modules/Import/views/view.step3.php
- ./modules/Import/views/view.step4.php
- ./modules/Import/views/view.undo.php
- ./modules/Leads/Dashlets/MyLeadsDashlet/MyLeadsDashlet.data.php
- ./modules/Leads/Dashlets/MyLeadsDashlet/MyLeadsDashlet.meta.php
- ./modules/Leads/Dashlets/MyLeadsDashlet/MyLeadsDashlet.php
- ./modules/Leads/LeadConvert.php
- ./modules/Leads/LeadsApiHelper.php
- ./modules/Leads/clients/base/api/LeadsApi.php
- ./modules/Leads/clients/base/filters/default/default.php
- ./modules/Leads/clients/base/layouts/convert-main/convert-main.js
- ./modules/Leads/clients/base/layouts/convert-main/convert-main.php
- ./modules/Leads/clients/base/layouts/convert-panel/convert-panel.hbs
- ./modules/Leads/clients/base/layouts/convert-panel/convert-panel.js
- ./modules/Leads/clients/base/layouts/record-dashboard/record-dashboard.php
- ./modules/Leads/clients/base/layouts/subpanels/subpanels.php
- ./modules/Leads/clients/base/menus/header/header.php
- ./modules/Leads/clients/base/views/convert-panel-header/convert-panel-header.hbs
- ./modules/Leads/clients/base/views/convert-panel-header/convert-panel-header.js
- ./modules/Leads/clients/base/views/convert-panel-header/dupecheck-pending.hbs
- ./modules/Leads/clients/base/views/convert-panel-header/dupecheck-results.hbs
- ./modules/Leads/clients/base/views/convert-panel-header/title.hbs
- ./modules/Leads/clients/base/views/list/list.php
- ./modules/Leads/clients/base/views/record/record.js
- ./modules/Leads/clients/base/views/record/record.php
- ./modules/Leads/clients/base/views/recordlist/recordlist.php
- ./modules/Leads/clients/base/views/selection-list/selection-list.php
- ./modules/Leads/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Leads/controller.php
- ./modules/Leads/language/en_us.lang.php
- ./modules/Leads/metadata/editviewdefs.php
- ./modules/Leads/metadata/popupdefs.php
- ./modules/Leads/metadata/subpanels/default.php
- ./modules/Meetings/Dashlets/MyMeetingsDashlet/MyMeetingsDashlet.data.php
- ./modules/Meetings/Dashlets/MyMeetingsDashlet/MyMeetingsDashlet.meta.php
- ./modules/Meetings/Dashlets/MyMeetingsDashlet/MyMeetingsDashlet.php
- ./modules/Meetings/action_view_map.php
- ./modules/Meetings/clients/base/menus/header/header.php
- ./modules/Meetings/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Meetings/clients/base/views/record/record.php
- ./modules/Meetings/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Meetings/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Meetings/clients/mobile/views/detail/detail.php
- ./modules/Meetings/clients/mobile/views/edit/edit.php
- ./modules/Meetings/clients/mobile/views/list/list.php
- ./modules/Meetings/controller.php
- ./modules/Meetings/language/en_us.lang.php
- ./modules/Meetings/metadata/SearchFields.php
- ./modules/Meetings/metadata/detailviewdefs.php
- ./modules/Meetings/metadata/editviewdefs.php
- ./modules/Meetings/metadata/listviewdefs.php
- ./modules/Meetings/metadata/quickcreatedefs.php
- ./modules/Meetings/metadata/searchdefs.php
- ./modules/Meetings/metadata/subpanels/ForActivities.php
- ./modules/Meetings/metadata/subpanels/ForHistory.php
- ./modules/Meetings/tpls/header.tpl
- ./modules/Meetings/tpls/reminders.tpl
- ./modules/Meetings/views/view.list.php
- ./modules/MergeRecords/Merge.js
- ./modules/MergeRecords/Step1.html
- ./modules/MergeRecords/Step1.php
- ./modules/MergeRecords/Step2.php
- ./modules/MergeRecords/language/en_us.lang.php
- ./modules/ModuleBuilder/controller.php
- ./modules/ModuleBuilder/javascript/studio2.js
- ./modules/ModuleBuilder/javascript/studio2PanelDD.js
- ./modules/ModuleBuilder/language/en_us.lang.php
- ./modules/ModuleBuilder/parsers/MetaDataFile.php
- ./modules/ModuleBuilder/parsers/MetaDataFiles.php
- ./modules/ModuleBuilder/parsers/parser.label.php
- ./modules/ModuleBuilder/tpls/includes.tpl
- ./modules/ModuleBuilder/tpls/layoutView.tpl
- ./modules/ModuleBuilder/views/view.layoutview.php
- ./modules/ModuleBuilder/views/view.main.php
- ./modules/ModuleBuilder/views/view.modulefield.php
- ./modules/ModuleBuilder/views/view.relationship.php
- ./modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.data.php
- ./modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.meta.php
- ./modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.php
- ./modules/Notes/NotesApiHelper.php
- ./modules/Notes/clients/base/filters/default/default.php
- ./modules/Notes/clients/base/layouts/list-dashboard/list-dashboard.php
- ./modules/Notes/clients/base/menus/header/header.php
- ./modules/Notes/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Notes/clients/base/views/list/list.php
- ./modules/Notes/clients/base/views/record/record.php
- ./modules/Notes/clients/mobile/views/detail/detail.php
- ./modules/Notes/clients/mobile/views/edit/edit.php
- ./modules/Notes/clients/mobile/views/list/list.php
- ./modules/Notes/controller.php
- ./modules/Notes/language/en_us.lang.php
- ./modules/Notes/metadata/SearchFields.php
- ./modules/Notes/metadata/additionalDetails.php
- ./modules/Notes/metadata/detailviewdefs.php
- ./modules/Notes/metadata/editviewdefs.php
- ./modules/Notes/metadata/listviewdefs.php
- ./modules/Notes/metadata/quickcreatedefs.php
- ./modules/Notes/metadata/searchdefs.php
- ./modules/Notes/metadata/subpanels/ForCalls.php
- ./modules/Notes/metadata/subpanels/ForHistory.php
- ./modules/Notes/metadata/subpanels/ForMeetings.php
- ./modules/Notes/metadata/subpanels/ForTasks.php
- ./modules/Notifications/language/en_us.lang.php
- ./modules/Notifications/views/view.systemquicklist.php
- ./modules/OAuthKeys/controller.php
- ./modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashlet.meta.php
- ./modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashlet.php
- ./modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashlet.tpl
- ./modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashletConfigure.tpl
- ./modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashletOptions.tpl
- ./modules/Opportunities/Dashlets/MyOpportunitiesDashlet/MyOpportunitiesDashlet.data.php
- ./modules/Opportunities/Dashlets/MyOpportunitiesDashlet/MyOpportunitiesDashlet.meta.php
- ./modules/Opportunities/Dashlets/MyOpportunitiesDashlet/MyOpportunitiesDashlet.php
- ./modules/Opportunities/Save.php
- ./modules/Opportunities/clients/base/fields/rowaction/rowaction.js
- ./modules/Opportunities/clients/base/filters/default/default.php
- ./modules/Opportunities/clients/base/layouts/record-dashboard/record-dashboard.php
- ./modules/Opportunities/clients/base/layouts/subpanels/subpanels.php
- ./modules/Opportunities/clients/base/menus/header/header.php
- ./modules/Opportunities/clients/base/views/dupecheck-list/dupecheck-list.php
- ./modules/Opportunities/clients/base/views/list/list.php
- ./modules/Opportunities/clients/base/views/massupdate/massupdate.js
- ./modules/Opportunities/clients/base/views/record/record.js
- ./modules/Opportunities/clients/base/views/record/record.php
- ./modules/Opportunities/clients/base/views/selection-list/selection-list.php
- ./modules/Opportunities/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Opportunities/clients/mobile/views/detail/detail.php
- ./modules/Opportunities/clients/mobile/views/edit/edit.php
- ./modules/Opportunities/clients/mobile/views/list/list.php
- ./modules/Opportunities/language/en_us.lang.php
- ./modules/Opportunities/metadata/SearchFields.php
- ./modules/Opportunities/metadata/acldefs.php
- ./modules/Opportunities/metadata/additionalDetails.php
- ./modules/Opportunities/metadata/detailviewdefs.php
- ./modules/Opportunities/metadata/editviewdefs.php
- ./modules/Opportunities/metadata/listviewdefs.php
- ./modules/Opportunities/metadata/metafiles.php
- ./modules/Opportunities/metadata/popupdefs.php
- ./modules/Opportunities/metadata/quickcreatedefs.php
- ./modules/Opportunities/metadata/searchdefs.php
- ./modules/Opportunities/tpls/QuickCreate.tpl
- ./modules/Opportunities/views/view.detail.php
- ./modules/Opportunities/views/view.edit.php
- ./modules/ProductTemplates/language/en_us.lang.php
- ./modules/Products/language/en_us.lang.php
- ./modules/Project/language/en_us.lang.php
- ./modules/ProjectTask/Dashlets/MyProjectTaskDashlet/MyProjectTaskDashlet.meta.php
- ./modules/ProjectTask/Dashlets/MyProjectTaskDashlet/MyProjectTaskDashlet.php
- ./modules/ProjectTask/language/en_us.lang.php
- ./modules/Prospects/language/en_us.lang.php
- ./modules/Quotes/Dashlets/MyQuotesDashlet/MyQuotesDashlet.meta.php
- ./modules/Quotes/Dashlets/MyQuotesDashlet/MyQuotesDashlet.php
- ./modules/Quotes/language/en_us.lang.php
- ./modules/Quotes/metadata/editviewdefs.php
- ./modules/ReportMaker/views/view.list.php
- ./modules/Reports/ListView.php
- ./modules/Reports/ReportCriteriaResults.php
- ./modules/Reports/ReportsWizard.php
- ./modules/Reports/ReportsWizard.tpl
- ./modules/Reports/SearchForm.html
- ./modules/Reports/SeedReports.php
- ./modules/Reports/clients/base/api/ReportsDashletsApi.php
- ./modules/Reports/clients/base/api/ReportsSearchApi.php
- ./modules/Reports/clients/base/menus/header/header.php
- ./modules/Reports/index.php
- ./modules/Reports/language/en_us.lang.php
- ./modules/Reports/metadata/reportmodulesdefs.php
- ./modules/Reports/metadata/searchdefs.php
- ./modules/Reports/sugarpdf/sugarpdf.listview.php
- ./modules/Reports/templates/_reportCriteriaWithResult.tpl
- ./modules/Reports/templates/_template_detail_and_total_list_view.tpl
- ./modules/Reports/templates/_template_list_view.tpl
- ./modules/Reports/templates/_template_summary_combo_view.tpl
- ./modules/Reports/templates/_template_summary_list_view.tpl
- ./modules/Reports/templates/_template_summary_list_view_2gpby.tpl
- ./modules/Reports/templates/_template_summary_list_view_3gpbyL1.tpl
- ./modules/Reports/templates/_template_summary_list_view_3gpbyL2.tpl
- ./modules/Reports/templates/_template_total_view.tpl
- ./modules/Reports/templates/templates_export.php
- ./modules/Reports/templates/templates_list_view.php
- ./modules/Reports/templates/templates_modules_def_js.php
- ./modules/Reports/templates/templates_reports.php
- ./modules/Reports/templates/templates_reports_index.php
- ./modules/Reports/templates/templates_reports_request_js.php
- ./modules/Reports/tpls/AddSchedule.tpl
- ./modules/Reports/tpls/reports.css
- ./modules/Reports/views/view.buildreportmoduletree.php
- ./modules/Reports/views/view.classic.php
- ./modules/Reports/views/view.schedule.php
- ./modules/RevenueLineItems/clients/base/menus/quickcreate/quickcreate.php
- ./modules/SavedSearch/SavedSearchForm.tpl
- ./modules/SavedSearch/SavedSearchSelects.tpl
- ./modules/SavedSearch/index.php
- ./modules/SavedSearch/language/en_us.lang.php
- ./modules/Schedulers/_AddJobsHere.php
- ./modules/Schedulers/language/en_us.lang.php
- ./modules/SugarFavorites/Dashlets/SugarFavoritesDashlet/SugarFavoritesDashlet.en_us.lang.php
- ./modules/SugarFavorites/Dashlets/SugarFavoritesDashlet/SugarFavoritesDashlet.meta.php
- ./modules/SugarFavorites/Dashlets/SugarFavoritesDashlet/SugarFavoritesDashlet.php
- ./modules/SugarFavorites/Dashlets/SugarFavoritesDashlet/SugarFavoritesDashletOptions.tpl
- ./modules/SugarFavorites/language/en_us.lang.php
- ./modules/Tasks/Dashlets/MyTasksDashlet/MyTasksDashlet.data.php
- ./modules/Tasks/Dashlets/MyTasksDashlet/MyTasksDashlet.meta.php
- ./modules/Tasks/Dashlets/MyTasksDashlet/MyTasksDashlet.php
- ./modules/Tasks/Save.php
- ./modules/Tasks/TasksApiHelper.php
- ./modules/Tasks/clients/base/filters/default/default.php
- ./modules/Tasks/clients/base/layouts/subpanels/subpanels.php
- ./modules/Tasks/clients/base/menus/header/header.php
- ./modules/Tasks/clients/base/menus/quickcreate/quickcreate.php
- ./modules/Tasks/clients/base/views/list/list.php
- ./modules/Tasks/clients/base/views/record/record.php
- ./modules/Tasks/clients/base/views/recordlist/recordlist.php
- ./modules/Tasks/clients/base/views/subpanel-list/subpanel-list.php
- ./modules/Tasks/clients/mobile/layouts/subpanels/subpanels.php
- ./modules/Tasks/clients/mobile/views/detail/detail.php
- ./modules/Tasks/clients/mobile/views/edit/edit.php
- ./modules/Tasks/clients/mobile/views/list/list.php
- ./modules/Tasks/language/en_us.lang.php
- ./modules/Tasks/metadata/SearchFields.php
- ./modules/Tasks/metadata/additionalDetails.php
- ./modules/Tasks/metadata/detailviewdefs.php
- ./modules/Tasks/metadata/editviewdefs.php
- ./modules/Tasks/metadata/listviewdefs.php
- ./modules/Tasks/metadata/quickcreatedefs.php
- ./modules/Tasks/metadata/searchdefs.php
- ./modules/Tasks/metadata/subpanels/ForActivities.php
- ./modules/Tasks/metadata/subpanels/ForHistory.php
- ./modules/Tasks/views/view.edit.php
- ./modules/TeamNotices/Dashlets/TeamNoticesDashlet/TeamNoticesDashlet.meta.php
- ./modules/TeamNotices/Dashlets/TeamNoticesDashlet/TeamNoticesDashlet.php
- ./modules/Teams/views/view.list.php
- ./modules/Teams/views/view.popup.php
- ./modules/Trackers/Dashlets/TrackerDashlet/TrackerDashlet.meta.php
- ./modules/Trackers/Dashlets/TrackerDashlet/TrackerDashlet.php
- ./modules/Trackers/store/TrackerQueriesDatabaseStore.php
- ./modules/Trackers/store/TrackerSessionsDatabaseStore.php
- ./modules/Users/Logout.php
- ./modules/Users/Save.php
- ./modules/Users/UserEditView.js
- ./modules/Users/authentication/AuthenticationController.php
- ./modules/Users/authentication/SAMLAuthenticate/settings.php
- ./modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php
- ./modules/Users/authentication/SugarAuthenticate/SugarAuthenticateUser.php
- ./modules/Users/clients/base/filters/default/default.php
- ./modules/Users/clients/base/views/selection-list/selection-list.php
- ./modules/Users/clients/mobile/views/edit/edit.php
- ./modules/Users/clients/mobile/views/list/list.php
- ./modules/Users/controller.php
- ./modules/Users/language/en_us.lang.php
- ./modules/Users/metadata/SearchFields.php
- ./modules/Users/metadata/detailviewdefs.php
- ./modules/Users/metadata/editviewdefs.php
- ./modules/Users/metadata/listviewdefs.php
- ./modules/Users/metadata/popupdefs.php
- ./modules/Users/metadata/quickcreatedefs.php
- ./modules/Users/metadata/searchdefs.php
- ./modules/Users/metadata/subpanels/ForCalls.php
- ./modules/Users/reassignUserRecords.php
- ./modules/Users/tpls/AuthenticateParent.tpl
- ./modules/Users/tpls/DetailViewFooter.tpl
- ./modules/Users/tpls/DetailViewHeader.tpl
- ./modules/Users/tpls/EditViewFooter.tpl
- ./modules/Users/tpls/EditViewHeader.tpl
- ./modules/Users/tpls/wizard.tpl
- ./modules/Users/views/view.authenticate.php
- ./modules/Users/views/view.detail.php
- ./modules/Users/views/view.edit.php
- ./modules/Users/views/view.list.php
- ./modules/Users/views/view.wizard.php
- ./modules/pmse_Business_Rules/clients/base/menus/header/header.php
- ./modules/pmse_Business_Rules/clients/base/views/businessrules-import/businessrules-import.hbs
- ./modules/pmse_Business_Rules/clients/base/views/businessrules-import/businessrules-import.js
- ./modules/pmse_Business_Rules/clients/base/views/businessrules-import/businessrules-import.php
- ./modules/pmse_Business_Rules/clients/base/views/record/record.js
- ./modules/pmse_Business_Rules/clients/base/views/record/record.php
- ./modules/pmse_Business_Rules/clients/base/views/recordlist/recordlist.js
- ./modules/pmse_Business_Rules/clients/base/views/recordlist/recordlist.php
- ./modules/pmse_Emails_Templates/clients/base/fields/subject/edit.hbs
- ./modules/pmse_Emails_Templates/clients/base/menus/header/header.php
- ./modules/pmse_Emails_Templates/clients/base/views/record/record.js
- ./modules/pmse_Emails_Templates/clients/base/views/record/record.php
- ./modules/pmse_Emails_Templates/clients/base/views/recordlist/recordlist.js
- ./modules/pmse_Emails_Templates/clients/base/views/recordlist/recordlist.php
- ./modules/pmse_Inbox/Dashlets/pmse_InboxDashlet/pmse_InboxDashlet.meta.php
- ./modules/pmse_Inbox/Dashlets/pmse_InboxDashlet/pmse_InboxDashlet.php
- ./modules/pmse_Inbox/clients/base/views/record/record.php
- ./modules/pmse_Inbox/engine/PMSEBusinessRuleExporter.php
- ./modules/pmse_Inbox/engine/PMSEBusinessRuleImporter.php
- ./modules/pmse_Inbox/engine/PMSEEmailTemplateImporter.php
- ./modules/pmse_Inbox/engine/PMSELogicHook.php
- ./modules/pmse_Inbox/engine/PMSEProjectExporter.php
- ./modules/pmse_Inbox/engine/PMSEProjectImporter.php
- ./modules/pmse_Inbox/metadata/dashletviewdefs.php
- ./modules/pmse_Project/clients/base/api/PMSEProjectImportExportApi.php
- ./modules/pmse_Project/clients/base/api/wrappers/PMSECrmDataWrapper.php
- ./modules/pmse_Project/clients/base/api/wrappers/PMSEProjectWrapper.php
- ./modules/pmse_Project/clients/base/views/project-import/project-import.hbs
- ./modules/pmse_Project/clients/base/views/project-import/project-import.js
- ./modules/pmse_Project/clients/base/views/project-import/project-import.php
- ./modules/pmse_Project/clients/base/views/record/record.js
- ./modules/pmse_Project/clients/base/views/record/record.php
- ./modules/pmse_Project/clients/base/views/recordlist/recordlist.js
- ./modules/pmse_Project/clients/base/views/recordlist/recordlist.php
- ./styleguide/assets/img/logo.svg
- ./themes/508/images/themePreview.png
- ./themes/Amore/images/themePreview.png
- ./themes/Green/images/themePreview.png
- ./themes/RTL/images/themePreview.png
- ./themes/RacerX/css/style.css
- ./themes/RacerX/css/wizard.css
- ./themes/RacerX/images/advanced_search.gif
- ./themes/RacerX/js/style.js
- ./themes/Sugar/css/style.css
- ./themes/Sugar/images/themePreview.png
- ./themes/default/images/advanced_search.gif
- ./themes/default/images/basic_search.gif
- ./themes/default/images/helpInline.gif
- ./themes/default/images/id-ff-clear.png
- ./themes/default/images/id-ff-select.png
- ./themes/default/images/id-ff-vcard.png


### You have direct customizations of the following deleted core files:

- ./include/SugarSearchEngine/Elastic/SugarSearchEngineElasticIndexStrategyMulti.php
- ./include/SugarSearchEngine/Elastic/SugarSearchEngineElasticMapping.php
- ./include/SugarSearchEngine/SugarSearchEngineFullIndexer.php
- ./include/SugarSearchEngine/SugarSearchEngineQueueManager.php
- ./modules/Calls/clients/base/views/create-actions/create-actions.js
- ./modules/Calls/clients/base/views/create-actions/create-actions.php
- ./modules/Leads/clients/base/views/create-actions/create-actions.js
- ./modules/Opportunities/clients/base/layouts/create-actions/create-actions.php
- ./modules/Opportunities/clients/base/views/create-actions/create-actions.js
- ./modules/Tasks/clients/base/views/create-actions/create-actions.php



## Run Health Check and fix all errors

Prior to attempting to upgrade to any 7.x release, Sugar recommends using the Health Check tool. The health check will notify you of any issues within your instance which will affect your ability to upgrade to your target version.

### Performing the Health Check

1. From the command line of the web server, navigate to the directory containing the above files downloaded and extracted in the [Downloading the Necessary Files](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Installation_and_Upgrade_Guide/#Downloading_the_Necessary_Files) section above:  
    
  `php CliUpgrader.php -z <upgradePackage> -l <logFile> -s <pathToSugar> -u <adminUser> -m <mask> -b <backup> -S <stage> -A <autoConfirm> -H <sendLog>`  
  **Note** : To invoke only the health check stage of the silent upgrade process, populate the parameters above with specific values in your situation: 
  - **upgradePackage** : The full file path to the upgrade package.
  - **logFile** : The path to the log file to store the results of the silent upgrade. A relative path to the Sugar instance may be used.
  - **pathToSugar** : The full file path to the instance being upgraded.
  - **adminUser** : A valid administrative user name.
  - **mask** : Script mask specifying which types of scripts to run. Supported types include: core, db, custom, all, and none. The default value is 'all'.
  - **backup** : Determines whether a backup of deleted files will be made with a default of "1" (true). Changing the option to "0" will not create a backup while.
  - **stage** : Instructs the upgrader to begin at a specific stage; "healthcheck" will cause only the health check portion to run while "continue" will cause it to start where it stopped on the previous run.
  - **autoConfirm** : Determines whether the confirmation prompt to continue with upgrade is bypassed and allows upgrade to automatically proceed when health check passes with a green or yellow flag. The option defaults to "0" (false). Change the option to "1" to enable the autoconfirm and proceed directly to upgrading after the health check. Do not alter this option when attempting to only run the health check without also completing an upgrade.
  - **sendLog** : Determines whether a log file is sent to SugarCRM with a default of "0" (false). Changing the setting to "1" (true), you are agreeing to send the health check logs to SugarCRM.
  
  For example, when running Sugar on a Linux-based server where your web root directory is located at `/var/www/html/sugarcrm` and the upgrade zip file and extracted files are all located at `/home/users/<yourUserName>/sugarupgrade`, use the following commands to perform a silent upgrade with the user "admin" and a log file of "silentUpgrade\_7800.log":   
    
  ```
  cd /home/users/<yourUserName>/sugarupgrade/ 
  
  php CliUpgrader.php -z /home/users/<yourUserName>/sugarupgrade/SugarPro-Upgrade-7.7.x-to-7.8.0.0.zip -l ./silentUpgrade_7800.log -s /var/www/html/sugarcrm/ -u admin -S healthcheck
  ```
2. The health check results will display whether the health check passed or failed for your instance. 
  - **Green Flag** : Health check passed successfully. Please refer to the log file if you wish to view details of the health check.
  - **Yellow Flag** : Health check passed. Please refer to the log file if you wish to view any errors or details of the health check. Should you choose to proceed with the upgrade, please keep in mind that customizations were found in your instance that may:  
      
      - Prevent certain modules from getting upgraded to Sugar 7's Sidecar user interface and will be available with the Legacy user interface.
      - Be modified or disabled to facilitate the upgrade of certain modules to Sugar 7's Sidecar user interface.
  - **Red Flag** : Health check failed. Issues deemed incompatible for upgrade must be resolved before proceeding with the upgrade. Please refer to the log file in order to view the errors and details of the health check.


## Upgrade your instance

To get the most out of Sugar we recommend being on the latest version. Newer versions of Sugar come with increased performance, bug fixes, and new features in general. Before upgrading Sugar it is highly recommended that the upgrade be run on a test or backup copy of your production system first. This will not only allow you to be familiar with the process, but can point out any potential issue(s) you may encounter when upgrading your production instance

### Performing the Upgrade

1. From the command line of the web server, navigate to the directory containing the above files downloaded and extracted in the [Downloading the Necessary Files](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Installation_and_Upgrade_Guide/#Downloading_the_Necessary_Files) section above:  
    
  `php CliUpgrader.php -z <upgradePackage> -l <logFile> -s <pathToSugar> -u <adminUser> -m <mask> -b <backup> -S <stage> -A <autoConfirm> -H <sendLog>`  
  **Note** : To invoke the silent upgrade process with all the necessary stages (including health check), populate the parameters above with specific values in your situation and exclude the "-S" parameter: 
  - **upgradePackage** : The full file path to the upgrade package.
  - **logFile** : The path to the log file to store the results of the silent upgrade. A relative path to the Sugar instance may be used.
  - **pathToSugar** : The full file path to the instance being upgraded.
  - **adminUser** : A valid administrative user name.
  - **mask** : Script mask specifying which types of scripts to run. Supported types include: core, db, custom, all, and none. The default value is 'all'.
  - **backup** : Determines whether a backup of deleted files will be made with a default of "1" (true). Changing the option to "0" will not create a backup while.
  - **stage** : Instructs the upgrader to begin at a specific stage; "healthcheck" will cause only the health check portion to run while "continue" will cause it to start where it stopped on the previous run.
  - **autoConfirm** : Determines whether the confirmation prompt to continue with upgrade is bypassed and allows upgrade to automatically proceed when health check passes with a green or yellow flag. The option defaults to "0" (false). Change the option to "1" to enable the autoconfirm and proceed directly to upgrading after the health check. Do not alter this option when attempting to only run the health check without also completing an upgrade.
  - **sendLog** : Determines whether a log file is sent to SugarCRM with a default of "0" (false). Changing the setting to "1" (true), you are agreeing to send the health check logs to SugarCRM.
  
  For example, when running Sugar on a Linux-based server where your web root directory is located at `/var/www/html/sugarcrm` and the upgrade zip file and extracted files are all located at `/home/users/<yourUserName>/sugarupgrade`, use the following commands to perform a silent upgrade with the user "admin" and a log file of "silentUpgrade\_7800.log":   
    
  `php CliUpgrader.php -z /home/users/<yourUserName>/sugarupgrade/SugarPro-Upgrade-7.7.x-to-7.8.0.0.zip -l ./silentUpgrade_7800.log -s /var/www/html/sugarcrm/ -u admin`
2. The Health Check scanner will automatically run to evaluate whether your instance is ready for upgrade.  
  The results will display whether the health check passed or failed for your instance:  
  
  - **Green Flag** : Health check passed successfully and you can proceed with the upgrade. A message will display asking for confirmation (Yes or No) to proceed with the upgrade. Please refer to the log file if you wish to view details of the health check.
  - **Yellow Flag** : Health check passed and you can proceed with the upgrade. A message will display asking for confirmation (Yes or No) to proceed with the upgrade. Please refer to the log file if you wish to view any errors or details of the health check. Should you choose to proceed with the upgrade, please keep in mind that customizations were found in your instance that may:  
      
      - Prevent certain modules from getting upgraded to Sugar 7's Sidecar user interface and will be available with the Legacy user interface.
      - Be modified or disabled to facilitate the upgrade of certain modules to Sugar 7's Sidecar user interface.
  - **Red Flag** : Health check failed and you cannot proceed with the upgrade. Issues deemed incompatible for upgrade must be resolved prior to upgrading. Please refer to the log file in order to view the errors and details of the health check.
3. After the upgrade is completed successfully, fix ownership and permissions of Sugar's root directory:   
  ```
  chown apache:apache -R <Sugar root directory>
  chmod 755 -R <Sugar root directory>
  ```
4. Log into Sugar and as a final cleanup, navigate to Administration > Repair and perform "Quick Repair and Rebuild" and "Rebuild Relationships". For more information on the functions performed by the repair, please refer to the [Repair](http://support.sugarcrm.com/Documentation/Sugar_Versions/7.8/Ult/Administration_Guide/System/Repair/ "Repair") documentation.

  
Now that your instance has successfully been upgraded to 7.8, please upgrade your stack components to be in compliance with the [7.8.x Supported Platforms](http://support.sugarcrm.com/Resources/Supported_Platforms/Sugar_7.8.x_Supported_Platforms "7.8.x Supported Platforms") including updating ElasticSearch to version 1.4.4 or 1.7.5.
