<?php

$lang['token']                  = ', Error Token:';
$lang['generalError']           = 'Something has gone wrong. Check the logs and contact the administrator.';
$lang['generalErrorClientArea'] = 'Something has gone wrong. Contact the administrator.';
$lang['permissionsStorage']     = ':storage_path: settings are not sufficient. Please set up permissions to the \'storage\' directory as writable.';
$lang['permissionsStorageReadable'] = ':storage_path: settings are not sufficient. Please set up permissions to the \'storage\' directory as readable.';
$lang['invalidServerType']      = 'Selected server type is invalid, please select a proper server group with the ":provisioning_name:" servers in order to proceed. Not sure how to configure the module? ';
$lang['documentationLink']      = 'Go to module documentation.';
$lang['notSureHowToConfigureMOdule']      = 'Not sure how to configure the module? ';
$lang['undefinedAction']        = 'Undefined Action';
$lang['ajaxResponses']['undefinedAction'] = 'Undefined Action';
$lang['changesHasBeenSaved']    = 'Changes have been saved successfully';
$lang['Monthly']                = 'Monthly';
$lang['Free Account']           = 'Free Account';
$lang['Passwords']              = 'Passwords';
$lang['Nothing to display']     = 'Nothing to display';
$lang['Search']                 = 'Search';
$lang['Previous']               = 'Previous';
$lang['Next']                   = 'Next';
$lang['searchPlacecholder']     = 'Search...';
$lang['snapshotNameEmpty']      = 'The snapshot name cannot be empty.';
$lang['snapshotNotMatchRegex']  = 'The snapshot name must be a match of regex "(?:[a-z](?:[-a-z0-9]{0,61}[a-z0-9])?)"';
$lang['creatingSnapshotStart']  = "The snapshot creation has been started successfully. The process may take a few minutes.";
$lang['massDeleteSnapshot']       = "The snapshots have been deleted successfully";
$lang['deleteSnapshot']           = "The snapshot has been deleted successfully";
$lang['restoreFromSnapshotStart'] = "The disk restoration from a snapshot has been started successfully. The process may take a few minutes.";

$lang['noDataAvalible']                 = 'No Data Available';
$lang['datatableItemsSelected']         = 'Items Selected';
$lang['validationErrors']['emptyField'] = 'This field cannot be empty';
$lang['bootstrapswitch']['disabled']    = 'Disabled';
$lang['bootstrapswitch']['enabled']     = 'Enabled';

$lang['ajaxResponses']['changesHasBeenSaved'] = 'Changes have been saved successfully';
$lang['ajaxResponses']['configurableOptionsCreated'] = 'The configurable options have been generated successfully';
$lang['ajaxResponses']['configurableOptionsUpdated'] = 'The configurable options have been updated successfully';

$lang['addonCA']['pageNotFound']['title'] = 'No page has been found';
$lang['addonCA']['pageNotFound']['description'] = 'The provided URL does not exist on this page. If you are sure that an error occurred here, please contact support.';
$lang['addonCA']['pageNotFound']['button'] = 'Return to the product page';

$lang['addonCA']['errorPage']['title'] = 'AN ERROR OCCURRED';
$lang['addonCA']['errorPage']['description'] = 'An error occurred. Please contact administrator and pass the details:';
$lang['addonCA']['errorPage']['button'] = 'Return to the product page';
$lang['addonCA']['errorPage']['error'] = 'ERROR';

$lang['addonCA']['errorPage']['errorCode'] = 'Error Code';
$lang['addonCA']['errorPage']['errorToken'] = 'Error Token';
$lang['addonCA']['errorPage']['errorTime'] = 'Time';
$lang['addonCA']['errorPage']['errorMessage'] = 'Message';

$lang['addonAA']['pageNotFound']['title'] = 'PAGE NOT FOUND';
$lang['addonAA']['pageNotFound']['description'] = 'An error occurred. Please contact administrator.';
$lang['addonAA']['pageNotFound']['button'] = 'Return to the module page';

$lang['addonAA']['errorPage']['title'] = 'AN ERROR OCCURRED';
$lang['addonAA']['errorPage']['description'] = 'An error occurred. Please contact administrator and pass the details:';
$lang['addonAA']['errorPage']['button'] = 'Return to the module page';
$lang['addonAA']['errorPage']['error'] = 'ERROR';

$lang['addonAA']['errorPage']['errorCode'] = 'Error Code';
$lang['addonAA']['errorPage']['errorToken'] = 'Error Token';
$lang['addonAA']['errorPage']['errorTime'] = 'Time';
$lang['addonAA']['errorPage']['errorMessage'] = 'Message';

$lang['addonCA']['buttons']['panelLoginTitle'] = 'Log In To Panel';

/* * ********************************************************************************************************************
 *                                                   ERROR CODES                                                        *
 * ******************************************************************************************************************** */
$lang['errorCodeMessage']['Uncategorised error occured'] = 'Unexpected Error';
$lang['errorCodeMessage']['Database error'] = 'Database error';
$lang['errorCodeMessage']['Provided controller does not exists'] = 'Page not found';
$lang['errorCodeMessage']['Invalid Error Code!'] = 'Unexpected Error';
$lang['errorCodeMessage']['Data validation failed. Please fix the errors.. Rdata - dns-manager::backend.rdns_unable_to_find'] = 'Data validation failed. Please fix the errors.';

/* * ********************************************************************************************************************
 *                                                   MODULE REQUIREMENTS                                                *
 * ******************************************************************************************************************** */
$lang['unfulfilledRequirement']['In order for the module to work correctly, please remove the following file: :remove_file_requirement:'] = 'In order for the module to work correctly, please remove the following file: :remove_file_requirement:';
$lang['unfulfilledRequirement']['In order for the module to work correctly, it requires the :class_name: class.'] = 'In order for the module to work correctly, it requires the :class_name: class.';
$lang['unfulfilledRequirement']['In order for the module to work correctly, it requires the :extension_name: PHP extension to be installed.']= 'In order for the module to work correctly, it requires the :extension_name: PHP extension to be installed.';
/* * ********************************************************************************************************************
 *                                                   ADMIN AREA                                                         *
 * ******************************************************************************************************************** */

$lang['addonAA']['datatables']['next']                                                                        = 'Next';
$lang['addonAA']['datatables']['previous']                                                                    = 'Previous';
$lang['addonAA']['datatables']['zeroRecords']                                                                 = 'Nothing to display';
$lang['formValidationError']                                                                                  = 'A form validation error has occurred';
$lang['FormValidators']['thisFieldCannotBeEmpty']                                                             = 'This field cannot be empty';
$lang['FormValidators']['PleaseProvideANumericValue']                                                         = 'Please provide a numeric value';
$lang['FormValidators']['PleaseProvideANumericValueBetween']                                                  = 'Please provide a numeric value between :minValue: and :maxValue:';

$lang['changesSaved']                             = 'Changes Have Been Saved Successfully';
$lang['ItemNotFound']                             = 'Item Not Found';
$lang['formValidationError']                                 = 'Form Validation Error';
$lang['FormValidators']['thisFieldCannotBeEmpty']            = 'This Field Cannot Be Empty';
$lang['FormValidators']['PleaseProvideANumericValue']        = 'Please Provide A Numeric Value';
$lang['FormValidators']['PleaseProvideANumericValueBetween'] = 'Please Provide A Numeric Value Between :minValue: AND :maxValue:';

// -------------------------------------------------> MODULE <--------------------------------------------------------- //
$lang['serverAA']['productConfig']['mainContainer']['optionsWidget']['message'] = 'Define what options can be chosen by your customers when placing an order. You can define what values are available and pricing for each in the Configurable Options settings in HostBill once you create it here. These values will override Default Options of the product.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['message'] = 'These options will be used for an order placement in EasyDCIM when the service is ordered and activated in the HostBill. It will be overridden by Configurable Options if enabled.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['defaultOptions']= 'Default Options';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['ModelID']['ModelID'] ='Server Model';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['ModelID']['description'] = 'Server model used as a base for the product. Server will be assigned to an order when it matches.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['LocationID']['LocationID']  ='Location';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['LocationID']['description'] ='Location where the server will be assigned from.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['OsTemplateID']['OsTemplateID'] ='OS Template';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['OsTemplateID']['description'] ='OS Template that will be installed on the server when activated.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['AdditionalIPAddresses']['AdditionalIPAddresses'] ='Number of additional IP addresses';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['AdditionalIPAddresses']['description'] ='A number of additional IP addresses that are to be assigned to the server. After successful OS installation, they are added to the network config of the server.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['Bandwidth']['Bandwidth'] ='Bandwith';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['Bandwidth']['description'] ='Type Bandwith [GB]';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['diskLayoutID']['diskLayoutID'] = 'Disk Layout';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['diskLayoutID']['description'] = 'Choose disk layout addons for chosen template and location';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['extras']['Extras'] = 'Extras';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['defaultOptions']['igRow']['extras']['description'] = 'Choose extras addons for chosen template and location';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['customSection']['customSection']= 'Custom Section';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['customFeatures']['caTemplates']['OsTemplates'] = 'OS Templates';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['customFeatures']['caTemplates']['description']= 'Choose the OS Templates';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['customFeatures']['caMetadata']['CustomMetadata'] = 'Custom Metadata';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['customFeatures']['caMetadata']['description']= 'Choose the Custom Metadata';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['easyDCIMAutomationSettings'] = 'Automation Settings';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['serviceSettings']['ServiceSettings'] = 'Service Settings';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['SystemActions'] = 'System Actions';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['serviceAccessID']['serviceAccessID'] =  "Service Access Level";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['serviceAccessID']['description'] =  "Choose the Service Access Level";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['AutoAccept']['AutoAccept'] =  "Auto Accept";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['AutoAccept']['description'] =  "Automatically accept order and assign a matching server";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['RequirePDU']['RequirePDU'] =  "Require PDU";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['RequirePDU']['description'] =  "Connect the server to the PDU device";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['RequireSwitch']['RequireSwitch'] =  "Require Switch";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['RequireSwitch']['description'] =  "Connect the server to the Switch device";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['Debug']['Debug'] =  "Debug";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['leftSection']['Debug']['description'] =  "Display extended logs in the HostBill Module Log";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['SuspensionAction']['SuspensionAction'] =  "BLOCK Automatic Suspension";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['SuspensionAction']['description'] =  "DO NOT SUSPEND SERVER automatically when server is suspended in HostBill and ONLY send an email to the administrator";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['UnsuspensionAction']['UnsuspensionAction'] =  "BLOCK Automatic Suspension";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['UnsuspensionAction']['description'] =  "DO NOT UNSUSPEND SERVER automatically when server is unsuspended in HostBill and ONLY send an email to the administrator";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['TerminateAction']['TerminateAction'] =  "BLOCK Automatic Termination";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['systemActions']['rightSection']['TerminateAction']['description'] =  "DO NOT TERMINATE SERVER automatically when server is terminated in HostBill and ONLY send an email to the administrator";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['serviceSettings']['rightSection']['adminID']['adminID'] =  "Administrators";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['serviceSettings']['rightSection']['adminID']['description'] =  "Choose Administrators";

$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['AutoAccept']['AutoAccept'] = 'Auto Accept Order';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['AutoAccept']['description'] = 'If enabled, EasyDCIM will handle automatic server assignment and provisioning if found based on the criteria of the product Default Options and Configurable Options.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['RequirePDU']['RequirePDU'] = 'Require PDU';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['RequirePDU']['description'] = 'Assign server only if it has a PDU attached.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['RequireSwitch']['RequireSwitch'] = 'Require Switch';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['RequireSwitch']['description'] = 'Assign server only if it has a PDU attached.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['Debug']['Debug'] = 'Debug';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['Debug']['description'] = 'Enable Debug';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['SuspensionAction']['SuspensionAction'] = 'Block Automatic Suspension By HostBill';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['SuspensionAction']['description'] = 'DO NOT SUSPEND SERVER automatically when server is suspended in HostBill and ONLY send an email to the administrator.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['UnsuspensionAction']['UnsuspensionAction'] = 'Block Automatic Unsuspension By HostBill';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['UnsuspensionAction']['description'] = 'DO NOT UNSUSPEND SERVER automatically when server is unsuspended in HostBill and ONLY send an email to the administrator.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['TerminateAction']['TerminateAction'] = 'Block Automatic Termination By HostBill';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['TerminateAction']['description'] = 'DO NOT TERMINATE SERVER automatically when server is terminated in HostBill and ONLY send an email to the administrator.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['Bandwidth']['description'] = 'Limit of bandwidth per month above which administrator will get notifications about in EasyDCIM. It is NOT a HARD limit of bandwidth nor used for any billing. To enable billing, please use the Usage Billing feature.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['Bandwidth']['Bandwidth'] = 'Bandwidth Notification Limit [GB]';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['easyDCIMAutomationSettings']['igRow']['message'] = 'Define actions related to this product that will happen automatically based on actions taken in HostBill.';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsSection']['additionalPartsSection'] = 'Part Requirements';
$lang['serverAA']['configOptions']['message'] = 'Configure additional parts that will be required on a server when automatically assigned after an order. For example, you can define that a server must have 4 GB of RAM in order to be assigned. ';
$lang['serverAA']['configOptions']['note'] = 'Please note: If configurable options are enabled for this product, it will prioritize the configurable option choice instead of this config.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsSection']['additionalPartsRow']['partsType']['partsType'] = 'Choose Part';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsSection']['igRow']['mgpci[type]']['mgpci[type]'] = 'Select an Option';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsRowSection']['mgpci[parts][size][]']['mgpci[parts][size][]'] = 'Size';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsRowSection']['mgpci[parts][model][]']['mgpci[parts][model][]'] = 'Model';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsRowSection']['removePart']['button']['removePart'] = 'Remove';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['additionalPartsSection']['addPart']['button']['addPart'] = 'Add Part Requirement';
$lang['serverAA']['configOptions']['addPartModal']['modal']['addPartModal'] = 'Add Part Requirement';
$lang['serverAA']['configOptions']['addPartModal']['addPartForm']['partsType']['partsType'] = 'Part Type';
$lang['serverAA']['configOptions']['addPartModal']['baseAcceptButton']['title'] = 'Add';
$lang['serverAA']['configOptions']['addPartModal']['baseCancelButton']['title'] = 'Cancel';
$lang['ajaxResponses']['partAddedSuccessfully'] = 'Part Requirement Added Successfully';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['message'] = 'Define what features and information will be available for customers in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['clientAreaFeaturesSection'] = 'Client Area Features';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['generalInfo'] = 'General Information';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['generalInfoSelectAll']['generalInfoSelectAll'] = 'Select All General Information Features';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['serviceInfo'] = 'Service Information';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['serviceInfoSelectAll']['serviceInfoSelectAll'] = 'Select All Service Information Features';
//$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['baseFeatures'] = 'Base Features';
//$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['baseFeaturesSelectAll']['baseFeaturesSelectAll'] = 'Select All Base Features';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['ServerId']['ServerId'] = 'Server Id';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Image']['Image'] = 'Image';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Image']['description'] = 'Enable if you want clients to have access to the "Image" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['Model']['Model'] = 'Server Model';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['Status']['Status'] = 'Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['OrderID']['OrderID'] = 'Order Id';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['ServiceStatus']['ServiceStatus'] = 'Service Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Model']['description'] = 'Enable if you want clients to have access to the "Model" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['Label']['Label'] = 'Label';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['DeviceStatus']['DeviceStatus'] = 'Device Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Label']['description'] = 'Enable if you want clients to have access to the "Label" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['ServerStatus']['ServerStatus'] = 'Server Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['ServerStatus']['description'] = 'Enable if you want clients to have access to the "Server Status" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['SerialNumber']['SerialNumber'] = 'Serial Number';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['SerialNumber']['description'] = 'Enable if you want clients to have access to the "Serial Number" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['PurchaseDate']['PurchaseDate'] = 'Purchase Date';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['PurchaseDate']['description'] = 'Enable if you want clients to have access to the "Purchase Date" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['WarrantyMonths']['WarrantyMonths'] = 'Warranty Date';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['WarrantyMonths']['description'] = 'Enable if you want clients to have access to the "Warranty Months" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['Hostname']['Hostname'] = 'Hostname';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Hostname']['description'] = 'Enable if you want clients to have access to the "Hostname" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['ChangeHostname']['ChangeHostname'] = 'Change Hostname';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['ChangeHostname']['description'] = 'Enable if you want clients to have access to the "Change Hostname" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['IPAddresses']['IPAddresses'] = 'IP Addresses';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['IPAddresses']['description'] = 'Enable if you want clients to have access to the "IP Addresses" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['Location']['Location'] = 'Location';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Location']['description'] = 'Enable if you want clients to have access to the "Location" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Rack']['Rack'] = 'Rack';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Rack']['description'] = 'Enable if you want clients to have access to the "Rack" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['Graphs']['Graphs'] = 'Graphs';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['Graphs']['description'] = 'Enable if you want clients to have access to the "Graphs" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['generalInfo']['SSHDetails']['SSHDetails'] = 'SSH Details';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['SSHDetails']['description'] = 'Enable if you want clients to have access to the "SSH Details" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['CurrentOS']['CurrentOS'] = 'OS';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['MacAddress']['MacAddress'] = 'MAC Address';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['CurrentOS']['description'] = 'Enable if you want clients to have access to the "Current OS" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['InstallationStatus']['InstallationStatus'] = 'Installation Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['InstallationStatus']['description'] = 'Enable if you want clients to have access to the "Installation Status" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['serviceInfo']['HideHostingInformation']['HideHostingInformation'] = 'Hide general Hosting Information on Service Details Page in Client Area';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['baseFeatures']['HideHostingInformation']['description'] = 'Hide general Hosting Information on Service Details Page in Client Area';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['locationInfo'] = 'Location Information';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['locationInfoSelectAll']['locationInfoSelectAll'] = 'Select All Location Information Features';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['Location']['Location'] = 'Location Name';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['LabeledRack']['LabeledRack'] = 'Labeled Rack With Position';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['Floor']['Floor'] = 'Floor';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['Address']['Address'] = 'Address';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['PhoneNumber']['PhoneNumber'] = 'Phone Number';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['leftSection']['locationInfo']['Description']['Description'] = 'Description';


$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['graphTypes'] = 'View Graphs';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['graphTypesSelectAll']['graphTypesSelectAll'] = 'Select All Graph Types';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['Ping']['Ping'] = 'Ping';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['Ping']['description'] = 'Enable if you want clients to have access to the "Ping" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['Status']['Status'] = 'Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['Status']['description'] = 'Enable if you want clients to have access to the "Status" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['AggregateTraffic']['AggregateTraffic'] = 'Aggregate Traffic';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['AggregateTraffic']['description'] = 'Enable if you want clients to have access to the "Aggregate Traffic" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['ProcessorsLoad']['ProcessorsLoad'] = 'Server Status';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['ProcessorsLoad']['description'] = 'Enable if you want clients to have access to the "Processors Load" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['PollerDuration']['PollerDuration'] = 'Poller Duration';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['graphTypes']['PollerDuration']['description'] = 'Enable if you want clients to have access to the "Poller Duration" section in the client area.';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['serverActions'] = 'Server Actions';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['serverActionsSelectAll']['serverActionsSelectAll'] = 'Select All Server Actions';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['RebootServer']['RebootServer'] = 'Reboot Server';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['RebootServer']['description'] = 'Enable if you want clients to have access to the "Reboot Server" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['BootServer']['BootServer'] = 'Boot Server';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['BootServer']['description'] = 'Enable if you want clients to have access to the "Boot Server" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['ShutdownServer']['ShutdownServer'] = 'Shutdown Server';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['ShutdownServer']['description'] = 'Enable if you want clients to have access to the "Shutdown Server" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['BMCColdReset']['BMCColdReset'] = 'BMC Cold Reset';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['BMCColdReset']['description'] = 'Enable if you want clients to have access to the "BMC Cold Reset" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['RescueMode']['RescueMode'] = 'Enable Rescue Mode';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['RescueMode']['description'] = 'Enable if you want clients to have access to the "Rescue Mode" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['AutoLoginLink']['AutoLoginLink'] = 'Auto Login Link';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['AutoLoginLink']['description'] = 'Enable if you want clients to have access to the "Auto Login Link" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['KVMJavaConsole']['KVMJavaConsole'] = 'KVM Java Console';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['KVMJavaConsole']['description'] = 'Enable if you want clients to have access to the "KVM Java Console" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['noVNCKVMConsole']['noVNCKVMConsole'] = 'noVNC KVM Console';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['serverActions']['noVNCKVMConsole']['description'] = 'Enable if you want clients to have access to the "noVNC KVM Console" section in the client area.';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['modules'] = 'Modules';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['modulesSelectAll']['modulesSelectAll'] = 'Select All Modules';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['TrafficStatistics']['TrafficStatistics'] = 'Traffic Statistics';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['TrafficStatistics']['description'] = 'Enable if you want clients to have access to the "Traffic Statistics" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['DevicesTraffic']['DevicesTraffic'] = 'Devices Traffic';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['DevicesTraffic']['description'] = 'Enable if you want clients to have access to the "Devices Traffic" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['OsInstallation']['OsInstallation'] = 'Rebuild';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['OsInstallation']['description'] = 'Enable if you want clients to have access to the "Os Installation" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['DNSManager']['DNSManager'] = 'DNS Management';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['DNSManager']['description'] = 'Enable if you want clients to have access to the "DNS Manager" section in the client area.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['PasswordManagement']['PasswordManagement'] = 'Password Management';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['clientAreaFeaturesSection']['rightSection']['modules']['PasswordManagement']['description'] = 'Enable if you want clients to have access to the "Password Management" section in the client area.';

$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['message'] = '';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['serviceNotification'] = "Email Notifications";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['CreateServerNotification']['CreateServerNotification'] ='Create Server Notification Template (To Client)';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['CreateServerNotification']['description'] ='A template notification sent to end-customer after the server has been successfully installed and is available for customer to be used. It is NOT the same as the Welcome Email sent by HostBill which happens immediately after activating the service.';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['SuspensionTemplate']['SuspensionTemplate'] =  "Suspension Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['SuspensionTemplate']['description'] =  "Choose the Suspension Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['TerminateTemplate']['TerminateTemplate'] =  "Terminate Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['TerminateTemplate']['description'] =  "Choose the Terminate Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['hps']['UnsuspensionTemplate']['UnsuspensionTemplate'] =  "Unsuspension Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['hps']['UnsuspensionTemplate']['description'] =  "Choose the Unsuspension Template";
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['hps']['adminID']['adminID'] = 'Notified Administrator';
$lang['serverAA']['productConfig']['mainContainer']['configForm']['serviceNotification']['hps']['adminID']['description'] = "Administrator from HostBill who will receive below email notifications. Leave EMPTY if you don't want to receive these email notifications.";

$lang['serverAA']['productConfig']['mainContainer']['optionsWidget']['optionsWidgetTitle'] = 'Configurable Options';
$lang['serverAA']['productConfig']['mainContainer']['optionsWidget']['addOptionsButton']['button']['addOptionButtonsTitle'] = 'Create Configurable Options';
$lang['serverAA']['configOptions']['addOptionsModal']['modal']['addOptionsModalTitle'] = 'Create Configurable Options';
$lang['serverAA']['configOptions']['addOptionsModal']['baseAcceptButton']['title'] = 'Create';
$lang['serverAA']['configOptions']['addOptionsModal']['baseCancelButton']['title'] = 'Cancel';
$lang['serverAA']['configOptions']['addOptionsModal']['addOptionsForm']['configurableOptionsNameInfo'] = 'Below you can choose which configurable options will be generated for this product. Please note that these options are divided into two parts separated by a | sign, where the part on the left indicates the sent variable and the part on the right the friendly name displayed to customers. After generating these options you can edit the friendly part on the right, but not the variable part on the left. More information about configurable options and their editing can be found :configurableOptionsNameUrl:.';

$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['statusWidget'] = 'Details';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['statusWidgetTitle'] = 'Service Actions';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['start']['startTitle'] = 'Boot';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['stop']['stopTitle'] = 'Shutdown';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['reset']['reset']  = 'Reboot';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['bmcColdReset']['bmcColdReset'] = 'BMC Cold Reset';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['bmcColdReset']['tooltip'] = 'BMC Cold Reset Server';
$lang['serverAA']['adminServicesTabFields']['bmcColdResetInstance']['bmcColdResetForm']['confirmBMCColdResetInstance'] = "Are you sure that you want to boot BMC cold reset.";
$lang['serverAA']['adminServicesTabFields']['bmcColdResetInstance']['baseAcceptButton']['title'] = "Confirm";
$lang['serverAA']['adminServicesTabFields']['bmcColdResetInstance']['baseCancelButton']['title'] = "Cancel";
$lang['serverAA']['adminServicesTabFields']['bmcColdResetInstance']['modal']['bmcColdResetInstance'] = 'Bmc Cold Reset';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['getRdpFile']['getRdpFileTitle']  = 'Download RDP File';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['noDataAvalible'] = 'No Instance Details Available';
$lang['serverAA']['servicePageIntegration']['mainContainer']['graphAndBandwidth']['rangeSelect]']['rangeSelect'] = "Data Range";
$lang['serverAA']['servicePageIntegration']['mainContainer']['graphAndBandwidth']['rangeSelect]']['description'] = "Choose Range";
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationTable']['year'] = 'Year';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationTable']['month'] = 'Month';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationTable']['years'] = 'Years';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationTable']['months'] = 'Months';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationTable']['Expired'] = 'Expired';


$lang['serverCA']['home']['mainContainer']['statusWidget']['bmcColdReset']['tooltip'] = 'Bmc Cold Reset';
$lang['serverCA']['home']['mainContainer']['statusWidget']['bmcColdReset']['bmcColdReset'] = 'Bmc Cold Reset';
$lang['serverCA']['home']['mainContainer']['statusWidget']['enableRescueMode']['tooltip'] = 'Enable Rescue Mode';
$lang['serverCA']['home']['mainContainer']['statusWidget']['enableRescueMode']['enableRescueMode'] = 'Enable Rescue Mode';
$lang['serverCA']['home']['mainContainer']['statusWidget']['kVMJavaConsole']['tooltip'] = 'KVM Java Console';
$lang['serverCA']['home']['mainContainer']['statusWidget']['kVMJavaConsole']['kVMJavaConsole'] = 'KVM Java Console';
$lang['serverCA']['home']['mainContainer']['statusWidget']['noVNCKVMConsole']['tooltip'] = 'noVNC KVM Console';
$lang['serverCA']['home']['mainContainer']['statusWidget']['noVNCKVMConsole']['noVNCKVMConsole'] = 'noVNC KVM Console';

$lang['serverCA']['home']['mainContainer']['detailsTable']['detailsTable'] = 'Metadata';
$lang['serverCA']['home']['mainContainer']['detailsTable']['table']['header'] = 'Header';
$lang['serverCA']['home']['mainContainer']['detailsTable']['table']['value'] = 'Value';


$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['bandwidthTable'] = 'Bandwidth Usage';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthInterval']     = 'Interval';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthIn']    = 'Bandwidth In';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthOut']    = 'Bandwidth Out';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthTotal']    = 'Bandwidth Total';
$lang['serverAA']['adminServicesTabFields']['current_month'] = 'Current Month';
$lang['serverAA']['adminServicesTabFields']['last_1day'] = 'Last Day';
$lang['serverAA']['adminServicesTabFields']['last_1hour'] = 'Last Hour';
$lang['serverAA']['adminServicesTabFields']['last_1month'] = 'Last Month';
$lang['serverAA']['adminServicesTabFields']['last_1week'] = 'Last Week';
$lang['serverAA']['adminServicesTabFields']['last_1year'] = 'Last Year';
$lang['serverAA']['adminServicesTabFields']['last_2days'] = 'Last Two Days';
$lang['serverAA']['adminServicesTabFields']['last_6hours'] = 'Last Six Hours';
$lang['serverAA']['adminServicesTabFields']['last_6months'] = 'Last Six Months';

$lang['serverAA']['adminServicesTabFields']['today'] = 'Today';
$lang['serverAA']['adminServicesTabFields']['yesterday'] = 'Yesterday';
$lang['serverAA']['adminServicesTabFields']['this_1month'] = 'This Month';
$lang['serverAA']['adminServicesTabFields']['this_1week'] = 'This Week';
$lang['serverAA']['adminServicesTabFields']['this_1year'] = 'This Year';


$lang['serverAA']['servicePageIntegration']['mainContainer']['aggregateTraffic']['title'] = 'Aggregate Traffic';
$lang['serverAA']['adminServicesTabFields']['Current Traffic Value'] = 'Current Traffic Value [GB]';
$lang['serverAA']['adminServicesTabFields']['Current Ping Value'] = 'Current Ping Value [ms]';
$lang['serverAA']['adminServicesTabFields']['Current Status Value'] = 'Current Status Value';
$lang['serverAA']['servicePageIntegration']['mainContainer']['pingGraph']['title'] = 'Ping';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusGraph']['title'] = 'Status';
$lang['serverAA']['adminServicesTabFields']['Current Month'] = 'Current Month';
$lang['serverAA']['adminServicesTabFields']['Last Month'] = 'Last Month';
$lang['serverAA']['adminServicesTabFields']['Last Quarter'] = 'Last Quarter';
$lang['serverAA']['adminServicesTabFields']['This Year'] = 'This Year';

$lang['serverAA']['adminServicesTabFields']['statusWidget']['InstanceDetailsTitle'] = 'Instance Details';
$lang['serverAA']['adminServicesTabFields']['statusWidget']['NetworkInterface'] = 'Network Interface';
$lang['serverAA']['adminServicesTabFields']['Network'] = 'Network';
$lang['serverAA']['adminServicesTabFields']['Private IP'] = 'Private IP';
$lang['serverAA']['adminServicesTabFields']['Public IP'] = 'Public IP';
$lang['serverAA']['adminServicesTabFields']['statusWidget']['Disk'] = 'Disk';
$lang['serverAA']['adminServicesTabFields']['Device Name'] = 'Device Name';
$lang['serverAA']['adminServicesTabFields']['Image'] = 'Image';
$lang['serverAA']['adminServicesTabFields']['Size'] = 'Size';
$lang['serverAA']['adminServicesTabFields']['Type'] = 'Type';
$lang['serverAA']['adminServicesTabFields']['Mode'] = 'Mode';
$lang['serverAA']['adminServicesTabFields']['diskType']['PERSISTENT'] = 'Persistent';
$lang['serverAA']['adminServicesTabFields']['diskMode']['READ_WRITE'] = 'Read / Write';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['start']['tooltip'] = 'Boot the machine';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['stop']['tooltip'] = 'Shutdown the machine';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['reset']['tooltip'] = 'Reboot the machine';
$lang['serverCA']['home']['mainContainer']['statusWidget']['getRdpFile']['tooltip'] = 'Download RDP File';
$lang['serverAA']['adminServicesTabFields']['Name']='Name';
$lang['serverAA']['adminServicesTabFields']['Status']='Status';
$lang['serverAA']['adminServicesTabFields']['RUNNING']='Running';
$lang['serverAA']['adminServicesTabFields']['TERMINATED']='Stopped';
$lang['serverAA']['adminServicesTabFields']['PROVISIONING']='Creating';
$lang['serverAA']['adminServicesTabFields']['Machine Type'] ='Machine Type';
$lang['serverAA']['adminServicesTabFields']['Created'] ='Created';
$lang['serverAA']['adminServicesTabFields']['Zone'] = 'Zone';
$lang['serverAA']['adminServicesTabFields']['CPU Platform'] = 'CPU Platform';
$lang['serverAA']['adminServicesTabFields']['stopInstance']['modal']['stopInstanceTitle'] = 'Shutdown Instance';
$lang['serverAA']['adminServicesTabFields']['stopInstance']['stopForm']['confirmStopInstance'] = 'Are you sure that you want to shutdown this device?';
$lang['serverAA']['adminServicesTabFields']['stopInstance']['baseAcceptButton']['title'] = 'Shutdown';
$lang['serverAA']['adminServicesTabFields']['stopInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['adminServicesTabFields']['resetInstance']['modal']['resetInstance'] = 'Reboot Instance';
$lang['serverAA']['adminServicesTabFields']['resetInstance']['resetForm']['confirmResetInstance'] = 'Are you sure that you want to reboot this device?';
$lang['serverAA']['adminServicesTabFields']['resetInstance']['baseAcceptButton']['title'] = 'Reboot';
$lang['serverAA']['adminServicesTabFields']['resetInstance']['baseCancelButton']['title'] = 'Cancel';


$lang['serverAA']['adminServicesTabFields']['startInstance']['modal']['startInstanceTitle'] = 'Boot Instance';
$lang['serverAA']['adminServicesTabFields']['startInstance']['startForm']['confirmStartInstance'] = 'Are you sure that you want to boot this device?';
$lang['serverAA']['adminServicesTabFields']['startInstance']['baseAcceptButton']['title'] = 'Boot';
$lang['serverAA']['adminServicesTabFields']['startInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['adminServicesTabFields']['enableRescueModeInstance']['modal']['enableRescueModeInstance'] = 'Enable Rescue Mode';
$lang['serverAA']['adminServicesTabFields']['enableRescueModeInstance']['enableRescueModeForm']['confirmEnableRescueModeInstance'] = 'Do you want to enable rescue mode?';
$lang['serverAA']['adminServicesTabFields']['enableRescueModeInstance']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverAA']['adminServicesTabFields']['enableRescueModeInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['adminServicesTabFields']['logInToPanelInstance']['modal']['logInToPanelInstance'] = 'Log In To Panel';
$lang['serverAA']['adminServicesTabFields']['logInToPanelInstance']['logInToPanelForm']['confirmLogInToPanelInstance'] = 'Do you want to be redirected to easyDCIM panel?';
$lang['serverAA']['adminServicesTabFields']['logInToPanelInstance']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverAA']['adminServicesTabFields']['logInToPanelInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['adminServicesTabFields']['kVMJavaConsoleInstance']['modal']['kVMJavaConsoleInstance'] = 'KVM Java Console';
$lang['serverAA']['adminServicesTabFields']['kVMJavaConsoleInstance']['kVMJavaConsoleForm']['confirmKVMJavaConsoleInstance'] = 'Do you want to lunch KVM Java Console?';
$lang['serverAA']['adminServicesTabFields']['kVMJavaConsoleInstance']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverAA']['adminServicesTabFields']['kVMJavaConsoleInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['adminServicesTabFields']['noVNCKVMConsoleInstance']['modal']['noVNCKVMConsoleInstance'] = 'noVNC KVM Console';
$lang['serverAA']['adminServicesTabFields']['noVNCKVMConsoleInstance']['noVNCKVMConsoleForm']['confirmNoVNCKVMConsoleInstance'] = 'Do you want to lunch noVNC KVM Console?';
$lang['serverAA']['adminServicesTabFields']['noVNCKVMConsoleInstance']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverAA']['adminServicesTabFields']['noVNCKVMConsoleInstance']['baseCancelButton']['title'] = 'Cancel';

$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['location'] = "Location Information";
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableTitle'] = "Location";
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['locationName'] = "Location Name";
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['address']	= 'Address';
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['phone']	= 'Phone Number';
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['description']	= 'Description';
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['labeledRackWithPosition']	= 'Labeled rack with position';
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['tableField']['floor']	= 'Floor';
$lang['serverAA']['servicePageIntegration']['mainContainer']['location']['noDataAvalible'] = 'No Data Avalible';

$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableTitle'] = 'Server Information';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['label'] = 'Label';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['deviceStatus'] = 'Device Status';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['os'] = 'OS';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['hostname'] = 'Hostname';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['ipAddresses'] = 'IP Addresses';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['macAddress'] = 'Mac address';
$lang['serverAA']['servicePageIntegration']['mainContainer']['serverInformation']['tableField']['clickToView'] = 'Click to view in EasyDCIM';

$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableTitle'] = 'General Information';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['serviceStatus'] = 'Service Status';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['status'] = 'Status';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['deviceStatus'] = 'Device Status';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['model'] = ' Server Model';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['label'] = 'Label';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['serialNumber'] = 'Serial Number';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['status'] = 'Status';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['purchaseDate'] = 'Purchase Date';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['warrantyMonths'] = 'Warranty Date';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['ipAddresses']	= 'IP Addresses';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['serverID'] = 'Server ID';
$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformation']['tableField']['orderID'] = 'Order ID';

$lang['serverAA']['servicePageIntegration']['mainContainer']['generalInformationAndLocationSection']['generalInformationAndLocationSection'] = 'Service Informations';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['enableRescueMode']['tooltip'] = 'Enable Rescue Mode';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['enableRescueMode']['enableRescueMode'] = 'Enable Rescue Mode';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['logInToPanel']['tooltip'] = 'Log In To Panel';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['logInToPanel']['logInToPanel'] = 'Log In To Panel';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['kVMJavaConsole']['tooltip'] = 'KVM Java Console';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['kVMJavaConsole']['kVMJavaConsole'] = 'KVM Java Console';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['noVNCKVMConsole']['tooltip'] = 'noVNC KVM Console';
$lang['serverAA']['servicePageIntegration']['mainContainer']['statusWidget']['noVNCKVMConsole']['noVNCKVMConsole'] = 'noVNC KVM Console';

$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['bandwidthTable'] = 'Bandwidth Usage';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthInterval'] 	= 'Interval';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthIn']	= 'Bandwidth In	';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthOut']	= 'Bandwidth Out';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['table']['bandwidthTotal']	= 'Bandwidth Total';

$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthSection']['bandwidthSection'] = 'Date range';
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthSection']['mgcpi[datepicker]']['datepicker'] = "Filter";
$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthSection']['mgcpi[datepicker]']['description'] = "Choose a date range";
$lang['serverAA']['servicePageIntegration']['mainContainer']['graphAndBandwidth']['graphAndBandwidth'] = 'Graphs And Bandwidth';
$lang['serverAA']['servicePageIntegration']['button']['settingButton'] = 'Scope';

$lang['serverAA']['servicePageIntegration']['mainContainer']['bandwidthTable']['interval']['interval'] = 'Interval';

$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['isoImagesTable'] = 'ISO Images';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['Id'] = 'Id';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['name'] = 'Name';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['iso_url'] = 'ISO URL';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['remote_agent'] = 'Remote Agents';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['users'] = 'Users';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['avaibility'] = 'Availability';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['table']['status'] = 'Status';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['createButton']['button']['createButton'] = 'Add ISO Image';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['updateButton']['button']['updateButton'] = 'Update';
$lang['serverCA']['isoImages']['mainContainer']['isoImagesTable']['deleteButton']['button']['deleteButton'] = 'Delete';

$lang['serverCA']['isoImages']['createModal']['modal']['createModal'] = 'Add ISO Image';
$lang['serverCA']['isoImages']['createModal']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverCA']['isoImages']['createModal']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['isoImages']['createModal']['createForm']['name']['name'] = 'Name';
$lang['serverCA']['isoImages']['createModal']['createForm']['iso_url']['iso_url'] = 'ISO URL';
$lang['serverCA']['isoImages']['createModal']['createForm']['message'] = 'ISO images are used to manually install the operating system. If you want to use an ISO image, you cannot perform an automatic OS installation within EasyDCIM. Available ISO images are accessible when a noVNC session is used. The images will be automatically mounted when creating a noVNC session in the “/home/iso” directory.';


$lang['serverCA']['isoImages']['updateModal']['modal']['updateModal'] = 'Update ISO Image';
$lang['serverCA']['isoImages']['updateModal']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverCA']['isoImages']['updateModal']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['isoImages']['updateModal']['editForm']['name']['name'] = 'Name';
$lang['serverCA']['isoImages']['updateModal']['editForm']['iso_url']['iso_url'] = 'ISO URL';

$lang['serverCA']['isoImages']['deleteModal']['modal']['deleteModal'] = 'Delete ISO Image';
$lang['serverCA']['isoImages']['deleteModal']['baseAcceptButton']['title'] = 'Delete';
$lang['serverCA']['isoImages']['deleteModal']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['isoImages']['deleteModal']['deleteForm']['confirmDelete'] = 'Are you sure that you want to delete this ISO Image?';

$lang['serverCA']['isoImages']['Finished'] = 'Finished';
$lang['serverCA']['isoImages']['Started'] = 'Started';
$lang['serverCA']['isoImages']['Waiting'] = 'Waiting';
$lang['serverCA']['isoImages']['Error'] = 'Error';

$lang['serverCA']['isoImages']['Downloading is finished'] = 'The ISO image has been downloaded';
$lang['serverCA']['isoImages']['Error ocured during downloading'] = 'An error occurred while downloading the ISO image';
$lang['serverCA']['isoImages']['Waiting for downloading to start'] = 'The ISO image is awaiting the download to begin';


$lang['addonAA']['breadcrumbs']['Home'] = '';
$lang['region']['asia-east1'] = 'asia-east1 (Taiwan)';
$lang['region']['asia-east2'] = 'asia-east2 (Hong Kong)';
$lang['region']['asia-northeast1'] = 'asia-northeast1 (Tokyo)';
$lang['region']['asia-northeast2'] = 'asia-northeast2 (Osaka)';
$lang['region']['asia-northeast3'] = 'asia-northeast3 (Seoul)';
$lang['region']['asia-south1'] = 'asia-south1 (Mumbai)';
$lang['region']['asia-southeast1'] = 'asia-southeast1 (Singapore)';
$lang['region']['australia-southeast1'] = 'australia-southeast1 (Sydney)';
$lang['region']['europe-north1'] = 'europe-north1 (Finland)';
$lang['region']['europe-west1'] = 'europe-west1 (Belgium)';
$lang['region']['europe-west2'] = 'europe-west2 (London)';
$lang['region']['europe-west3'] = 'europe-west3 (Frankfurt)';
$lang['region']['europe-west4'] = 'europe-west4 (Holland)';
$lang['region']['europe-west6'] = 'europe-west6 (Zürich)';
$lang['region']['northamerica-northeast1'] = 'northamerica-northeast (Montreal)';
$lang['region']['southamerica-east1'] = 'southamerica-east1 (São Paulo)';
$lang['region']['us-central1'] = 'us-central1 (Iowa)';
$lang['region']['us-east1'] = 'us-east1 (South Carolina)';
$lang['region']['us-east4'] = 'us-east4 (Northern Virginia)';
$lang['region']['us-west1'] = 'us-west1 (Oregon)';
$lang['region']['us-west2'] = 'us-west2 (Los Angeles)';
$lang['region']['us-west3'] = 'us-west3 (Salt Lake City)';
$lang['region']['us-west4'] = 'us-west4 (Las Vegas)';

$lang['zone']['us-central1-c'] = 'us-central1-c';
$lang['zone']['us-central1-a'] = 'us-central1-a';
$lang['zone']['us-central1-f'] = 'us-central1-f';
$lang['zone']['us-central1-b'] = 'us-central1-b';
$lang['zone']['asia-east1-a'] = 'asia-east1-a';
$lang['zone']['asia-east1-b'] = 'asia-east1-b';
$lang['zone']['asia-east1-c'] = 'asia-east1-c';
$lang['zone']['asia-east2-a'] = 'asia-east2-a';
$lang['zone']['asia-east2-b'] = 'asia-east2-b';
$lang['zone']['asia-east2-c'] = 'asia-east2-c';
$lang['zone']['asia-northeast1-a'] = 'asia-northeast1-a';
$lang['zone']['asia-northeast1-b'] = 'asia-northeast1-b';
$lang['zone']['asia-northeast1-c'] = 'asia-northeast1-c';
$lang['zone']['asia-northeast2-a'] = 'asia-northeast2-a';
$lang['zone']['asia-northeast2-b'] = 'asia-northeast2-b';
$lang['zone']['asia-northeast2-c'] = 'asia-northeast2-c';
$lang['zone']['asia-northeast3-a'] = 'asia-northeast3-a';
$lang['zone']['asia-northeast3-b'] = 'asia-northeast3-b';
$lang['zone']['asia-northeast3-c'] = 'asia-northeast3-c';
$lang['zone']['asia-south1-a'] = 'asia-south1-a';
$lang['zone']['asia-south1-b'] = 'asia-south1-b';
$lang['zone']['asia-south1-c'] = 'asia-south1-c';
$lang['zone']['asia-southeast1-a'] = 'asia-southeast1-a';
$lang['zone']['asia-southeast1-b'] = 'asia-southeast1-b';
$lang['zone']['asia-southeast1-c'] = 'asia-southeast1-c';
$lang['zone']['australia-southeast1-a'] = 'australia-southeast1-a';
$lang['zone']['australia-southeast1-b'] = 'australia-southeast1-b';
$lang['zone']['australia-southeast1-c'] = 'australia-southeast1-c';
$lang['zone']['europe-north1-a'] = 'europe-north1-a';
$lang['zone']['europe-north1-b'] = 'europe-north1-b';
$lang['zone']['europe-north1-c'] = 'europe-north1-c';
$lang['zone']['europe-west1-b'] = 'europe-west1-b';
$lang['zone']['europe-west1-c'] = 'europe-west1-c';
$lang['zone']['europe-west1-d'] = 'europe-west1-d';
$lang['zone']['europe-west2-a'] = 'europe-west2-a';
$lang['zone']['europe-west2-b'] = 'europe-west2-b';
$lang['zone']['europe-west2-c'] = 'europe-west2-c';
$lang['zone']['europe-west3-a'] = 'europe-west3-a';
$lang['zone']['europe-west3-b'] = 'europe-west3-b';
$lang['zone']['europe-west3-c'] = 'europe-west3-c';
$lang['zone']['europe-west4-a'] = 'europe-west4-a';
$lang['zone']['europe-west4-b'] = 'europe-west4-b';
$lang['zone']['europe-west4-c'] = 'europe-west4-c';
$lang['zone']['europe-west6-a'] = 'europe-west6-a';
$lang['zone']['europe-west6-b'] = 'europe-west6-b';
$lang['zone']['europe-west6-c'] = 'europe-west6-c';
$lang['zone']['northamerica-northeast1-a'] = 'northamerica-northeast1-a';
$lang['zone']['northamerica-northeast1-b'] = 'northamerica-northeast1-b';
$lang['zone']['northamerica-northeast1-c'] = 'northamerica-northeast1-c';
$lang['zone']['southamerica-east1-a'] = 'southamerica-east1-a';
$lang['zone']['southamerica-east1-b'] = 'southamerica-east1-b';
$lang['zone']['southamerica-east1-c'] = 'southamerica-east1-c';
$lang['zone']['us-east1-b'] = 'us-east1-b';
$lang['zone']['us-east1-c'] = 'us-east1-c';
$lang['zone']['us-east1-d'] = 'us-east1-d';
$lang['zone']['us-east4-b'] = 'us-east4-b';
$lang['zone']['us-east4-c'] = 'us-east4-c';
$lang['zone']['us-east4-a'] = 'us-east4-a';
$lang['zone']['us-west1-a'] = 'us-west1-a';
$lang['zone']['us-west1-b'] = 'us-west1-b';
$lang['zone']['us-west1-c'] = 'us-west1-c';
$lang['zone']['us-west2-a'] = 'us-west2-a';
$lang['zone']['us-west2-b'] = 'us-west2-b';
$lang['zone']['us-west2-c'] = 'us-west2-c';
$lang['zone']['us-west3-a'] = 'us-west3-a';
$lang['zone']['us-west3-b'] = 'us-west3-b';
$lang['zone']['us-west3-c'] = 'us-west3-c';
$lang['zone']['us-west4-a'] = 'us-west4-a';
$lang['zone']['us-west4-b'] = 'us-west4-b';
$lang['zone']['us-west4-c'] = 'us-west4-c';


/* * ********************************************************************************************************************
 *                                                    CLIENT AREA                                                      *
 * ******************************************************************************************************************** */

$lang['serverCA']['home']['mainContainer']['statusWidget']['statusWidgetTitle'] = 'Service Actions';
$lang['serverCA']['home']['mainContainer']['statusWidget']['statusTitle'] = 'Service Status:';
$lang['addonCA']['breadcrumbs']['MG Demo'] = '';
$lang['serverCA']['home']['mainContainer']['statusWidget']['start']['startTitle'] = 'Boot';
$lang['serverCA']['home']['mainContainer']['statusWidget']['stop']['stopTitle'] = 'Shutdown';
$lang['serverCA']['home']['mainContainer']['statusWidget']['reset']['reset'] = 'Reboot';
$lang['serverCA']['home']['mainContainer']['statusWidget']['getRdpFile']['getRdpFileTitle']  = 'Download RDP File';
$lang['serverCA']['home']['mainContainer']['statusWidget']['noDataAvalible'] = 'No Instance Details Available';
$lang['serverCA']['home']['mainContainer']['statusWidget']['start']['tooltip'] = 'Boot the machine';
$lang['serverCA']['home']['mainContainer']['statusWidget']['stop']['tooltip'] = 'Shutdown the machine';
$lang['serverCA']['home']['mainContainer']['statusWidget']['reset']['tooltip'] = 'Reboot the machine';

$lang['serverCA']['home']['mainContainer']['caServerInformationTable']['caServerInformationTable'] = 'Server Information';
$lang['serverCA']['home']['mainContainer']['caServerInformationTable']['changeHostname']['button']['changeHostname'] = '';
$lang['serverCA']['home']['mainContainer']['caServerInformationTable']['table']['header'] = 'Header';
$lang['serverCA']['home']['mainContainer']['caServerInformationTable']['table']['value'] = 'Value';

$lang['serverCA']['home']['mainContainer']['caGeneralInformationTable']['caGeneralInformationTable'] = 'General Information';
$lang['serverCA']['home']['mainContainer']['caGeneralInformationTable']['table']['header'] = 'Header';
$lang['serverCA']['home']['mainContainer']['caGeneralInformationTable']['table']['value'] = 'Value';
$lang['serverCA']['home']['Expired'] = 'Expired';
$lang['serverCA']['home']['year'] = 'Year';
$lang['serverCA']['home']['month'] = 'Month';
$lang['serverCA']['home']['years'] = 'Years';
$lang['serverCA']['home']['months'] = 'Months';

$lang['serverCA']['home']['mainContainer']['caLocationInformationTable']['caLocationInformationTable'] = 'Location';
$lang['serverCA']['home']['mainContainer']['caLocationInformationTable']['table']['header'] = 'Header';
$lang['serverCA']['home']['mainContainer']['caLocationInformationTable']['table']['value'] = 'Value';

$lang['serverCA']['devicesTraffic']['Current Traffic Value'] = 'Current Traffic Value';
$lang['serverCA']['devicesTraffic']['Current Ping Value'] = 'Current Ping Value';
$lang['serverCA']['devicesTraffic']['Current Status Value'] = 'Current Status Value';
$lang['serverCA']['devicesTraffic']['mainContainer']['aggregateTraffic']['title'] = 'Aggregate Traffic';
$lang['serverCA']['devicesTraffic']['button']['settingButton'] = 'SettingButton';
$lang['serverCA']['devicesTraffic']['mainContainer']['pingGraph']['title'] = 'Ping';
$lang['serverCA']['devicesTraffic']['mainContainer']['statusGraph']['title'] = 'Status';
$lang['serverCA']['devicesTraffic']['Current Month'] = 'Current Month';
$lang['serverCA']['devicesTraffic']['Last Month'] = 'Last Month';
$lang['serverCA']['devicesTraffic']['Last Quarter'] = 'Last Quarter';
$lang['serverCA']['devicesTraffic']['This Year'] = 'This Year';

$lang['serverCA']['trafficStatistics']['Current Traffic Value'] = 'Current Traffic Value';
$lang['serverCA']['trafficStatistics']['mainContainer']['aggregateTraffic']['title'] = 'Aggregate Traffic';
$lang['serverCA']['trafficStatistics']['button']['settingButton'] = 'Scope';

$lang['serverCA']['trafficStatistics']['Current Month'] = 'Current Month';
$lang['serverCA']['trafficStatistics']['Last Month'] = 'Last Month';
$lang['serverCA']['trafficStatistics']['Last Quarter'] = 'Last Quarter';
$lang['serverCA']['trafficStatistics']['This Year'] = 'This Year';

$lang['serverCA']['home']['statusWidget']['InstanceDetailsTitle'] = 'Instance Details';
$lang['serverCA']['home']['Name'] = 'Name';
$lang['serverCA']['home']['Status'] = 'Status';
$lang['serverCA']['home']['RUNNING']='Running';
$lang['serverCA']['home']['TERMINATED']='Stopped';
$lang['serverCA']['home']['PROVISIONING']='Creating';
$lang['serverCA']['home']['Machine Type'] = 'Machine Type';
$lang['serverCA']['home']['Created'] ='Created';
$lang['serverCA']['home']['Zone'] = 'Zone';
$lang['serverCA']['home']['CPU Platform'] = 'CPU Platform';
$lang['serverCA']['home']['statusWidget']['NetworkInterface'] = 'Network Interface';
$lang['serverCA']['home']['Network'] = 'Network';
$lang['serverCA']['home']['Private IP'] = 'Private IP';
$lang['serverCA']['home']['Public IP'] = 'Public IP';
$lang['serverCA']['home']['statusWidget']['Disk'] = 'Disk';
$lang['serverCA']['home']['Device Name'] = 'Device Name';
$lang['serverCA']['home']['Image'] = 'Image';
$lang['serverCA']['home']['Size'] = 'Size';
$lang['serverCA']['home']['Type'] = 'Type';
$lang['serverCA']['home']['Mode'] = 'Mode';
$lang['serverCA']['home']['diskType']['PERSISTENT'] = 'Persistent';
$lang['serverCA']['home']['diskMode']['READ_WRITE'] = 'Read / Write';

$lang['serverCA']['home']['stopInstance']['modal']['stopInstanceTitle'] = 'Shutdown Instance';
$lang['serverCA']['home']['stopInstance']['baseAcceptButton']['title'] = 'Shutdown';
$lang['serverCA']['home']['stopInstance']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['home']['stopInstance']['stopForm']['confirmStopInstance'] = 'Are you sure that you want to shutdown this instance?';
$lang['serverCA']['home']['startInstance']['modal']['startInstanceTitle'] = 'Boot Instance';
$lang['serverCA']['home']['startInstance']['startForm']['confirmStartInstance'] = 'Are you sure that you want to boot this instance?';
$lang['serverCA']['home']['startInstance']['baseAcceptButton']['title'] = 'Boot';
$lang['serverCA']['home']['startInstance']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['home']['resetInstance']['modal']['resetInstance'] = 'Reboot Instance';
$lang['serverCA']['home']['resetInstance']['resetForm']['confirmResetInstance'] = 'Are you sure that you want to reboot this instance?';
$lang['serverCA']['home']['resetInstance']['baseAcceptButton']['title'] = 'Reboot';
$lang['serverCA']['home']['resetInstance']['baseCancelButton']['title'] = 'Cancel';


$lang['serverCA']['home']['buttonModal']['button']['ButtonModal'] = "";
$lang['serverCA']['home']['mainContainer']['detailsTable']['changeHostname']['button']['changeHostname'] = "";
$lang['serverCA']['home']['changeHostnameModal']['modal']['changeHostnameModal'] = 'Change Hostname';
$lang['serverCA']['home']['changeHostnameModal']['changeHostname']['changeHostname']['changeHostname'] = 'Hostname';
$lang['serverCA']['home']['changeHostnameModal']['changeHostname']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverCA']['home']['changeHostnameModal']['changeHostname']['baseCancelButton']['title'] = 'Cancel';
$lang['ajaxResponses']['changeHostname'] = "Hostname was updated correctly";

$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['osInstalationTable'] = 'Os Instalation';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['hostInformation'] = 'Host Information';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['macAddress'] = 'MAC Address';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['currentOS'] = 'Current OS';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['noInfo'] = 'No Info';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['reinstall'] = 'Reinstall';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['osIsCurrentlyBeingInstalled'] = 'Os Is Currently Being Installed';
$lang['serverCA']['rebuild']['mainContainer']['osInstalationTable']['table']['actions'] = 'Actions';

$lang['serverCA']['rebuild']['mainContainer']['rebuildButton']['button']['rebuildButton'] = 'Rebuild';
$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['check']['check'] = '';
$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['check']['description'] = 'Choose Template';

$lang['serverCA']['rebuild']['rebuildModal']['modal']['rebuildModal'] = 'Rebuild';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildConfirmMessage'] = 'Are you sure that you want to rebuild the OS template? All data located on the virtual machine will be lost.';
$lang['serverCA']['rebuild']['rebuildModal']['baseAcceptButton']['title'] = 'Rebuild';
$lang['serverCA']['rebuild']['rebuildModal']['baseCancelButton']['title'] = 'Cancel';

$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildPassword']['rebuildPassword'] = 'Password';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildPassword']['Generate'] = 'Generate';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildHostname']['rebuildHostname'] = 'Hostname';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildUsername']['rebuildUsername'] = 'Username';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildRootSSHPassword']['rebuildRootSSHPassword'] = 'Root SSH Password';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildRootSSHPassword']['Generate'] = 'Generate';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildDiskLayout']['rebuildDiskLayout'] = 'Disk Layout';
$lang['serverCA']['rebuild']['rebuildModal']['rebuildForm']['rebuildExtras']['rebuildExtras'] = 'Extras';

$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['rebuildButton']['button']['rebuildButton'] = 'Rebuild';

$lang['serverCA']['accessList']['mainContainer']['accessListTable']['accessListTable'] = 'Access List';
$lang['serverCA']['accessList']['mainContainer']['accessListTable']['table']['name'] = 'Name';
$lang['serverCA']['accessList']['mainContainer']['accessListTable']['table']['username'] = 'Username';
$lang['serverCA']['accessList']['mainContainer']['accessListTable']['table']['password'] = 'Password';

$lang['serverCA']['reverseDNS']['mainContainer']['ipAddressesTable']['ipAddressesTable'] = 'IP Addresses';
$lang['serverCA']['reverseDNS']['mainContainer']['ipAddressesTable']['table']['ipAddresses'] = 'IP Addresses';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['reverseDNSTable'] = 'Reverse DNS';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['table']['ipAddress'] = 'IP Address';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['table']['hostname'] = 'Hostname';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['table']['created'] = 'Created';
$lang['serverCA']['reverseDNS']['createRuleModal']['createForm']['reverseDNSMask']['reverseDNSMask'] = 'Mask';
$lang['serverCA']['reverseDNS']['createRuleModal']['createForm']['reverseDNSMask']['description'] = 'Leave empty if you want to create only one record';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['createButton']['button']['createButton'] = 'Create';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['updateButton']['button']['updateButton'] = 'Update';
$lang['serverCA']['reverseDNS']['mainContainer']['reverseDNSTable']['deleteButton']['button']['deleteButton'] = 'Delete';

$lang['serverCA']['reverseDNS']['deleteModal']['modal']['deleteModal'] = 'Delete DNS Record';
$lang['serverCA']['reverseDNS']['deleteModal']['deleteForm']['confirmDelete'] = 'Are you sure that you want to delete a record. This process cannot be undone';
$lang['serverCA']['reverseDNS']['deleteModal']['baseAcceptButton']['title'] = 'Delete';
$lang['serverCA']['reverseDNS']['deleteModal']['baseCancelButton']['title'] = 'Cancel';

$lang['serverCA']['reverseDNS']['updateGroupModal']['modal']['updateGroupModal'] = 'Update DNS Record';
$lang['serverCA']['reverseDNS']['updateGroupModal']['updateForm']['ipAddress']['ipAddress'] = 'IP Address';
$lang['serverCA']['reverseDNS']['updateGroupModal']['updateForm']['hostname']['hostname'] = 'Hostname';
$lang['serverCA']['reverseDNS']['updateGroupModal']['baseAcceptButton']['title'] = 'Update';
$lang['serverCA']['reverseDNS']['updateGroupModal']['baseCancelButton']['title'] = 'Cancel';

$lang['serverCA']['reverseDNS']['createRuleModal']['modal']['createRuleModal'] = 'Create DNS Record';
$lang['serverCA']['reverseDNS']['createRuleModal']['createForm']['reverseDNSIpAddress']['reverseDNSIpAddress'] = 'IP Address';
$lang['serverCA']['reverseDNS']['createRuleModal']['createForm']['reverseDNSHostname']['reverseDNSHostname'] = 'Hostname';
$lang['serverCA']['reverseDNS']['createRuleModal']['baseAcceptButton']['title'] = 'Create';
$lang['serverCA']['reverseDNS']['createRuleModal']['baseCancelButton']['title'] = 'Cancel';


$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['osTemplateTable'] = 'Os Template';
$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['table']['Logo'] = 'Logo';
$lang['serverCA']['rebuild']['mainContainer']['osTemplateTable']['table']['Description'] = 'Description';

$lang['ajaxResponses']['ServiceStopped'] = 'Stopping the service. It may take a while to complete this process.';
$lang['ajaxResponses']['ServiceStarted'] = 'Starting the service. It may take a while to complete this process.';
$lang['ajaxResponses']['logInToPanel']= 'Logging to panel. It may take a while to complete this process.';
$lang['ajaxResponses']['kVMJavaConsole']= 'Lunching KVM Java Console. It may take a while to complete this process.';
$lang['ajaxResponses']['enableRescueMode']= 'Enabling Rescue Mode. It may take a while to complete this process.';
$lang['ajaxResponses']['ServiceBMCColdReset']= 'Service BMC Cold Reset. It may take a while to complete this process.';
$lang['ajaxResponses']['noVNCKVMConsole']= 'Lunching noVNC KVM Console. It may take a while to complete this process.';
$lang['ajaxResponses']['dnsRecordCreatedSuccessFully'] = 'DNS record created successfully';
$lang['ajaxResponses']['RebuildMessage'] = 'Rebuild was successfull';

//------------------------------------------------------------------------ Client Area Snapshots -------------------------------------------------------------------------

$lang['serverCA']['snapshot']['mainContainer']['snapshotsTable']['snapshots']                                                  = 'Snapshots';
$lang['serverCA']['snapshot']['mainContainer']['snapshotsTable']['createButton']['button']['createButton']                     = 'Create Snapshot';
$lang['serverCA']['snapshot']['mainContainer']['snapshotsTable']['restoreButton']['button']['restoreButton']                   = 'Restore Snapshot';
$lang['serverCA']['snapshot']['mainContainer']['snapshotsTable']['deleteButton']['button']['deleteButton']                     = 'Delete Snapshot';
$lang['serverCA']['snapshot']['mainContainer']['snapshotsTable']['deleteSnapshotButton']['button']['deleteSnapshotButton']     = 'Delete Snapshots';


$lang['serverCA']['snapshot']['confirmModal']['modal']['confirmModal']                                                         = 'Create New Snapshot';
$lang['serverCA']['snapshot']['confirmModal']['addSnapshotForm']['snapshotName']['snapshotName']                               = 'Snapshot Name';
$lang['serverCA']['snapshot']['confirmModal']['baseAcceptButton']['title']                                                     = 'Create';
$lang['serverCA']['snapshot']['confirmModal']['baseCancelButton']['title']                                                     = 'Cancel';


$lang['serverCA']['snapshot']['deleteSnapshotModal']['modal']['deleteSnapshotModal']                                           = 'Delete Snapshots';
$lang['serverCA']['snapshot']['deleteSnapshotModal']['deleteMassSnapshotForm']['confirmMassSnapshotDelete']                   = 'Are you sure that you want to delete the selected snapshots?';
$lang['serverCA']['snapshot']['deleteSnapshotModal']['baseAcceptButton']['title']                                              = 'Delete';
$lang['serverCA']['snapshot']['deleteSnapshotModal']['baseCancelButton']['title']                                              = 'Cancel';


$lang['serverCA']['snapshot']['confirmRestoreModal']['modal']['confirmRestoreModal']                                           = 'Restore Snapshots';
$lang['serverCA']['snapshot']['confirmRestoreModal']['restoreSnapshotForm']['confirmRestore']                                 = 'Are you sure that you want to restore the disk from a snapshot?';
$lang['serverCA']['snapshot']['confirmRestoreModal']['baseAcceptButton']['title']                                              = 'Restore';
$lang['serverCA']['snapshot']['confirmRestoreModal']['baseCancelButton']['title']                                              = 'Cancel';


$lang['serverCA']['snapshot']['confirmDeleteModal']['modal']['confirmDeleteModal']                                             = 'Delete Snapshot';
$lang['serverCA']['snapshot']['confirmDeleteModal']['deleteSnapshotForm']['confirmDelete']                                   = 'Are you sure that you want to delete the selected snapshot?';
$lang['serverCA']['snapshot']['confirmDeleteModal']['baseAcceptButton']['title']                                               = 'Delete';
$lang['serverCA']['snapshot']['confirmDeleteModal']['baseCancelButton']['title']                                               = 'Cancel';

// ---------------------------------------------------- Menu ---------------------------------------------------------
$lang['mg-provisioning-module'] = "Manage VM";
$lang['snapshot']               = 'Disk Snapshots';
$lang['instanceDoesNotExists'] = 'The instance does not exist in the Google Cloud Virtual Machines platform.';
$lang['sidebarMenu']['graph'] = 'Graphs';
$lang['sidebarMenu']['mg-provisioning-module'] = 'Manage Instance';
$lang['sidebarMenu']['snapshot'] = 'Snapshots';

$lang['sidebarMenu']['password-management'] = 'Password Manager';
$lang['sidebarMenu']['accessList'] = 'Access List';
$lang['sidebarMenu']['dns-manager'] = 'DNS Manager';
$lang['sidebarMenu']['reverseDNS'] = 'Reverse DNS';
$lang['sidebarMenu']['statistics'] = 'Statistics';
$lang['sidebarMenu']['devicesTraffic'] = 'View Graphs';
$lang['sidebarMenu']['trafficStatistics'] = 'Traffic Statistics';
$lang['sidebarMenu']['os-instalation'] = 'OS Instalation';
$lang['sidebarMenu']['rebuild'] = 'Rebuild';




// ---------------------------------------------------- Graphs ---------------------------------------------------------
$lang['serverCA']['graph']['mainContainer']['cpuGraph']['title'] = 'CPU Utilization';
$lang['serverCA']['graph']['mainContainer']['memoryGraph']['title'] = 'Memory Utilization';
$lang['serverCA']['graph']['mainContainer']['networkGraph']['title'] = 'Network Utilization';
$lang['serverCA']['graph']['mainContainer']['diskGraph']['title'] = 'Disks Utilization';

$lang['serverCA']['graph']['CPU Usage'] = 'CPU Usage';
$lang['serverCA']['graph']['Memory Usage'] = 'Memory Usage';
$lang['serverCA']['graph']['Total'] = 'Total';;
$lang['serverCA']['graph']['Received MB'] = 'Received MB';
$lang['serverCA']['graph']['Sent MB'] = 'Sent MB';

$lang['serverAA']['adminServicesTabFields']['Current Traffic Value'] = 'Current Traffic Value';

// ---------------------------------------------------- Reset Password ---------------------------------------------------------
$lang['serverCA']['home']['mainContainer']['statusWidget']['resetPassword']['resetPassword'] = 'Reset Password';
$lang['serverCA']['home']['mainContainer']['statusWidget']['resetPassword']['tooltip'] = 'Reset Password';
$lang['serverCA']['home']['resetWindowsPassword']['modal']['resetWindowsPassword'] = 'Reset Password';
$lang['serverCA']['home']['resetWindowsPassword']['resetPasswordForm']['confirmResetPassword'] = 'Are you sure that you want to generate a new password?';
$lang['serverCA']['home']['resetWindowsPassword']['baseAcceptButton']['title'] = 'Confirm';
$lang['serverCA']['home']['resetWindowsPassword']['baseCancelButton']['title'] = 'Cancel';
$lang['serverCA']['home']['resetWindowsPassword']['resetPasswordForm']['text']['NewPassword'] = 'New Password';
$lang['ajaxResponses']['PasswordReseted'] = 'A new password has been generated';