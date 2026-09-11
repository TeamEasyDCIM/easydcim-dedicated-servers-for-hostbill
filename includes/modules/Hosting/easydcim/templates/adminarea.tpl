<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/showcustomfn.js"></script>
<script src="{$assetsURL}/js/chart.js"></script>
<script src="{$assetsURL}/js/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="{$assetsURL}/js/aggregateTraffic.js"></script>
<script src="{$assetsURL}/js/ping.js"></script>
<script src="{$assetsURL}/js/status.js"></script>
<script src="{$assetsURL}/js/bandwidth.js"></script>

<ul class="accor">
    <li>
        <a href="#">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.statusWidget}</a>
        <div class="sor">
            <div id="layers">
                {if !$applyFeatures || $configuration.BootServer == 'on' || $configuration.ShutdownServer == 'on' || $configuration.RebootServer == 'on' || $configuration.BMCColdReset == 'on' || $configuration.RescueMode == 'on' || $configuration.noVNCKVMConsole == 'on' || $configuration.AutoLoginLink == 'on'}
                <div class="lu-col-md-12">
                    <div class="lu-h5 lu-m-b-3x lu-m-t-2x">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.statusWidgetTitle}</div>
                    <div class="lu-tiles lu-row lu-row--eq-height">
                        {if !$applyFeatures || $configuration.BootServer == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.startInstance.startForm.confirmStartInstance}','boot')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/powerOnButton.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.start.startTitle}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.ShutdownServer == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.stopInstance.stopForm.confirmStopInstance}','shutdown')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/powerOffButton.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.stopInstance.baseAcceptButton.title}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.RebootServer == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.resetInstance.resetForm.confirmResetInstance}','reboot')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/reboot.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.resetInstance.baseAcceptButton.title}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.BMCColdReset == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.bmcColdResetInstance.bmcColdResetForm.confirmBMCColdResetInstance}','bmcColdReset')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/reinstall.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.bmcColdResetInstance.modal.bmcColdResetInstance}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.RescueMode == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.enableRescueModeInstance.enableRescueModeForm.confirmEnableRescueModeInstance}','enableRescueMode')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/rescue.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.enableRescueModeInstance.modal.enableRescueModeInstance}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.noVNCKVMConsole == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.noVNCKVMConsoleInstance.noVNCKVMConsoleForm.confirmNoVNCKVMConsoleInstance}','noVNCConsole')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/novnc.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.noVNCKVMConsoleInstance.modal.noVNCKVMConsoleInstance}</span>
                            </a>
                        </div>
                        {/if}
                        {if !$applyFeatures || $configuration.AutoLoginLink == 'on'}
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.logInToPanelInstance.logInToPanelForm.confirmLogInToPanelInstance}','logIntoPanel')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/logIntopanel.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.logInToPanelInstance.modal.logInToPanelInstance}</span>
                            </a>
                        </div>
                        {/if}
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || ($configuration.BlockServerInformationTable != 'on' && ($configuration.ServiceID == 'on' || $configuration.ServerId == 'on' || $configuration.Label == 'on' || $configuration.ServerStatus == 'on' || $configuration.Hostname == 'on' || $configuration.ChangeHostname == 'on' || $configuration.IPAddresses == 'on' || $configuration.CurrentOS == 'on' || $configuration.MacAddress == 'on' || $configuration.InstallationStatus == 'on' || $metadata))}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget widgetActionComponent vueDatatableTable">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableTitle}
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div data-table-container="" data-check-container="" class="lu-t-c  datatableLoader">
                                    <div class="dataTables_wrapper no-footer">
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column" style="margin-top:0px!important">
                                                <tbody>
                                                    {if !$applyFeatures || $configuration.ServiceID == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.serviceID}</td>
                                                        <td>{$rawObject->serverInformation->getServiceID()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.ServerId == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serverID}</td>
                                                        <td>{$rawObject->serverInformation->getServerID()} <a href="{$rawObject->serverInformation->getServerLink()}" target="_blank">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.clickToView}</a></td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.Label == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.label}</td>
                                                        <td>{$rawObject->serverInformation->getLabel()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.ServerStatus == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.deviceStatus}</td>
                                                        <td{if $rawObject->serverInformation->getDeviceStatus() === 'Down'} class="lu-text-danger" {else} class="lu-text-success" {/if}>{$rawObject->serverInformation->getDeviceStatus()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.CurrentOS == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.os}</td>
                                                        <td>{$rawObject->serverInformation->getCurrentOS()}{if (!$applyFeatures || $configuration.InstallationStatus == 'on') && $rawObject->serverInformation->getInstallationStatus() != ''}<b> - {$rawObject->serverInformation->getInstallationStatus()}</b>{/if}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.Hostname == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.hostname}</td>
                                                        <td>{$rawObject->serverInformation->getHostname()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.IPAddresses == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.ipAddresses}</td>
                                                        <td><div class='overflow'>{$rawObject->serverInformation->getIPAddresses()}</div></td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.MacAddress == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.macAddress}</td>
                                                        <td>{$rawObject->serverInformation->getMacAddress()}</td>
                                                    </tr>
                                                    {/if}
                                                    {foreach from=$metadata key=myId item=i}
                                                        <tr role="row">
                                                            {if $i.header == 'SSH Password' || $i.header == 'SSH Root Password'}
                                                                {if $i.value == ''}
                                                                    <td class="informationTablesWidth">{$i.header}</td>
                                                                    <td>-</td>
                                                                {else}
                                                                    <td class="informationTablesWidth">{$i.header}</td>
                                                                    <td><span class="password_element"><input class="elementPasswordInput"
                                                                                                              type="password" value="{$i.value}"
                                                                                                              readonly=""><i
                                                                                    class="elementPasswordIcon lu-zmdi lu-zmdi-eye-off"
                                                                                    onclick="changePasswordElement(this)"></i></span>
                                                                    </td>
                                                                {/if}
                                                            {elseif $i.header == 'Additional IP Addresses'}
                                                                <td class="informationTablesWidth">{$i.header}</td>
                                                                <td><div class='overflow'>{$i.value}</div></td>
                                                            {else}
                                                                <td class="informationTablesWidth">{$i.header}</td>
                                                                <td>{$i.value}</td>
                                                            {/if}
                                                        </tr>
                                                    {/foreach}
                                                </tbody>
                                            </table>
                                            <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay" style="display: none;">
                                                <div class="lu-preloader lu-preloader--sm">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || ($configuration.BlockGeneralInformationTable != 'on' && ($configuration.StatusInformation == 'on' || $configuration.OrderId == 'on' || $configuration.ServiceStatus == 'on' || $configuration.Model == 'on' || $configuration.SerialNumber == 'on' || $configuration.PurchaseDate == 'on' || $configuration.WarrantyMonths == 'on'))}
                <div class="lu-row">
                    <div  class="lu-col-md-12">
                        <div class="lu-widget widgetActionComponent vueDatatableTable">
                            <div class="lu-widget__header"><div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableTitle}
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div data-table-container="" data-check-container="" class="lu-t-c  datatableLoader">
                                    <div class="dataTables_wrapper no-footer">
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column" style="margin-top:0px!important">
                                                <tbody>
                                                    {if !$applyFeatures || $configuration.StatusInformation == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.status}</td>
                                                        <td>{$rawObject->generalInformation->getStatus()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.OrderId == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.orderID}</td>
                                                        <td>{$rawObject->generalInformation->getOrderID()} <a href="{$rawObject->generalInformation->getOrderLink()}" target="_blank">Click to view in EasyDCIM</a></td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.ServiceStatus == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serviceStatus}</td>
                                                        <td {if $rawObject->generalInformation->getServiceStatus() == 'Activated'} class="lu-text-success" {else} class="lu-text-danger" {/if}>{$rawObject->generalInformation->getServiceStatus()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.Model == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.model}</td>
                                                        <td>{$rawObject->generalInformation->getModel()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.SerialNumber == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serialNumber}</td>
                                                        <td>{$rawObject->generalInformation->getSerialNumber()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.PurchaseDate == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.purchaseDate}</td>
                                                        <td>{$rawObject->generalInformation->getPurchaseDate()}</td>
                                                    </tr>
                                                    {/if}
                                                    {if !$applyFeatures || $configuration.WarrantyMonths == 'on'}
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.warrantyMonths}</td>
                                                        <td>{$rawObject->generalInformation->getWarrantyMonths()}</td>
                                                    </tr>
                                                    {/if}
                                                </tbody>
                                            </table>
                                            <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay" style="display: none;">
                                                <div class="lu-preloader lu-preloader--sm">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || ($configuration.BlockLocationInformationTable != 'on' && ($configuration.Location == 'on' || $configuration.LabeledRack == 'on' || $configuration.Floor == 'on' || $configuration.Address == 'on' || $configuration.PhoneNumber == 'on' || $configuration.Description == 'on'))}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget widgetActionComponent vueDatatableTable">
                            <div class="lu-widget__header"><div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.location.location}
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div data-table-container="" data-check-container="" class="lu-t-c  datatableLoader">
                                    <div class="dataTables_wrapper no-footer">
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column" style="margin-top:0px!important">
                                                <tbody>
                                                {if !$applyFeatures || $configuration.Location == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.locationName}</td>
                                                    <td><a href="{$rawObject->locationInformation->getLocationLink()}" target="_blank" class="">{$rawObject->locationInformation->getLocationName()} </a><a href="{$rawObject->locationInformation->getRackLink()}" target="_blank" class="lu-font-weight-bold">({$rawObject->locationInformation->getRackName()})</a></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.LabeledRack == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.labeledRackWithPosition}</td>
                                                    <td><a href="{$rawObject->locationInformation->getRackLink()}" target="_blank">{$rawObject->locationInformation->getRackWithPosition()}</a></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.Floor == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.floor}</td>
                                                    <td>{$rawObject->locationInformation->getFloor()}</td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.Address == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.address}</td>
                                                    <td>{$rawObject->locationInformation->getAddress()}</td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.PhoneNumber == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.phone}</td>
                                                    <td>{$rawObject->locationInformation->getPhoneNumber()}</td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.Description == 'on'}
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.description}</td>
                                                    <td >{$rawObject->locationInformation->getDescription()}</td>
                                                </tr>
                                                {/if}
                                                </tbody>
                                            </table>
                                            <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay" style="display: none;">
                                                <div class="lu-preloader lu-preloader--sm">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || $configuration.BlockBandwidthTable != 'on'}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget widgetActionComponent vueDatatableTable">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.bandwidthTable}
                                    </div>
                                    <div class="lu-top__toolbar">
                                        <a data-toggle="modal" data-target="#bandwidthModal">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div data-table-container="" data-check-container=""
                                     class="lu-t-c  datatableLoader">
                                    <div class="dataTables_wrapper no-footer">
                                        <div>
                                            <table width="100%" role="grid"
                                                   class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                                <thead>
                                                    <tr role="row">
                                                        <th><span class="lu-table__text">{$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.table.bandwidthInterval}</span></th>
                                                        <th><span class="lu-table__text">{$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.table.bandwidthIn}</span></th>
                                                        <th><span class="lu-table__text">{$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.table.bandwidthOut}</span></th>
                                                        <th><span class="lu-table__text">{$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.table.bandwidthTotal}</span></th>
                                                    </tr>
                                                </thead>
                                                {* filled by bandwidth.js for the period picked in #bandwidthModal *}
                                                <tbody id="bandwidthRows"></tbody>
                                            </table>
                                            <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay"
                                                 style="display: none;">
                                                <div class="lu-preloader lu-preloader--sm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || $configuration.AggregateTraffic == 'on'}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.aggregateTraffic.title}
                                    </div>
                                    <div class="lu-top__toolbar">
                                        <a data-toggle="modal" data-target="#aggregateModal">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <canvas id="aggregateTraffic" style="height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || $configuration.Ping == 'on'}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.pingGraph.title}
                                    </div>
                                    <div class="lu-top__toolbar">
                                        <a data-toggle="modal" data-target="#pingModal">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <canvas id="pingGraph" style="height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {if !$applyFeatures || $configuration.Status == 'on'}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.statusGraph.title}
                                    </div>
                                    <div class="lu-top__toolbar">
                                        <a data-toggle="modal" data-target="#statusModal">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <canvas id="statusGraph" style="height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
            </div>
        </div>
    </li>
</ul>

<!-- Modals -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Scope <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></h5>
            </div>
            <div class="modal-body">
                <select id="scope" class="mg-select2" onchange="$('#scopeRange').toggle(this.value === 'custom')">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                    <option value="custom">{$lang.serverAA.adminServicesTabFields.custom_dates}</option>
                </select>
                <div id="scopeRange" style="display: none; margin-top: 10px;">
                    <input type="date" id="scopeStart" class="lu-form-control" style="display: inline-block; width: auto;">
                    <input type="date" id="scopeEnd" class="lu-form-control" style="display: inline-block; width: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reloadstatusGraph" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pingModal" tabindex="-1" role="dialog" aria-labelledby="pingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pingModalLabel">Scope <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></h5>
            </div>
            <div class="modal-body">
                <select id="scope2" class="mg-select2" onchange="$('#scope2Range').toggle(this.value === 'custom')">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                    <option value="custom">{$lang.serverAA.adminServicesTabFields.custom_dates}</option>
                </select>
                <div id="scope2Range" style="display: none; margin-top: 10px;">
                    <input type="date" id="scope2Start" class="lu-form-control" style="display: inline-block; width: auto;">
                    <input type="date" id="scope2End" class="lu-form-control" style="display: inline-block; width: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reloadpingGraph" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="aggregateModal" tabindex="-1" role="dialog" aria-labelledby="aggregateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aggregateModalLabel">Scope  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></h5>
            </div>
            <div class="modal-body">
                <select id="scope3" class="mg-select2" onchange="$('#scope3Range').toggle(this.value === 'custom')">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                    <option value="custom">{$lang.serverAA.adminServicesTabFields.custom_dates}</option>
                </select>
                <div id="scope3Range" style="display: none; margin-top: 10px;">
                    <input type="date" id="scope3Start" class="lu-form-control" style="display: inline-block; width: auto;">
                    <input type="date" id="scope3End" class="lu-form-control" style="display: inline-block; width: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reloadAggregateTraffic" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bandwidthModal" tabindex="-1" role="dialog" aria-labelledby="bandwidthModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bandwidthModalLabel">Scope <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></h5>
            </div>
            <div class="modal-body">
                <select id="bandwidthScope" class="mg-select2" onchange="$('#bandwidthRange').toggle(this.value === 'custom')">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                    <option value="custom">{$lang.serverAA.adminServicesTabFields.custom_dates}</option>
                </select>
                <div id="bandwidthRange" style="display: none; margin-top: 10px;">
                    <input type="date" id="bandwidthStart" class="lu-form-control" style="display: inline-block; width: auto;">
                    <input type="date" id="bandwidthEnd" class="lu-form-control" style="display: inline-block; width: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reloadBandwidth" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->