{*
 * The EasyDCIM part of the client area service page, included by every theme
 * branch of service_details.tpl. Laid out as the WHMCS module's Home page:
 * StatusWidget tiles, Service / General / Location Information and Bandwidth.
 *}
<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<link rel="stylesheet" href="{$assetsURL}/css/flatpickr.min.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/flatpickr.min.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/overview.js"></script>
<script src="{$assetsURL}/js/bandwidth.js"></script>

<div id="layers" data-edc-service="{$serviceId}" data-edc-scopes="{$edcScopes|escape}">
    {if $configuration.BootServer == 'on' || $configuration.ShutdownServer == 'on' || $configuration.RebootServer == 'on' || $configuration.BMCColdReset == 'on' || $configuration.RescueMode == 'on' || $configuration.noVNCKVMConsole == 'on' || $configuration.AutoLoginLink == 'on'}
    <div id="StatusWidget" class="lu-col-md-12">
        <div class="lu-tiles-wrapper">
            <div class="h4 lu-m-b-3x lu-m-t-3x">{$lang.edcUi.server_actions}</div>
            <div class="lu-tiles lu-row lu-row--eq-height">
                {if $configuration.BootServer == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="boot">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.boot_server}" src="{$assetsURL}/img/server-start.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.boot_server}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.ShutdownServer == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="shutdown">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.shutdown_server}" src="{$assetsURL}/img/server-stop.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.shutdown_server}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.RebootServer == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="reboot">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.reboot_server}" src="{$assetsURL}/img/server-reboot.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.reboot_server}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.BMCColdReset == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="bmcColdReset">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.bmc_cold_reset}" src="{$assetsURL}/img/server-reset.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.bmc_cold_reset}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.RescueMode == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="enableRescueMode">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.rescue_mode}" src="{$assetsURL}/img/rescue-new.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.rescue_mode}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.noVNCKVMConsole == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="noVNCConsole">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.novnc_console}" src="{$assetsURL}/img/console-vnc.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.novnc_console}</div>
                    </a>
                </div>
                {/if}
                {if $configuration.AutoLoginLink == 'on'}
                <div class="lu-col-sm-20p" role="button">
                    <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="logIntoPanel">
                        <div class="lu-i-c-6x"><img alt="{$lang.edcUi.auto_login}" src="{$assetsURL}/img/logIntopanel.png"></div>
                        <div class="lu-tile__title">{$lang.edcUi.auto_login}</div>
                    </a>
                </div>
                {/if}
            </div>
        </div>
    </div>
    {/if}
    {if ($configuration.ServiceID == 'on' || $configuration.ServerId == 'on' || $configuration.Label == 'on' || $configuration.ServerStatus == 'on' || $configuration.CurrentOS == 'on' || $configuration.Hostname == 'on' || $configuration.IPAddresses == 'on' || $configuration.MacAddress == 'on' || !empty($metadata)) && $configuration.BlockServerInformationTable != 'on'}
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="serverInformationWidget" class="lu-widget lu-ed-no-padding-widget-content lu-ed-no-border-header">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">{$lang.edcUi.service_information}</div>
                        {if $configuration.ChangeHostname == 'on'}
                        <div class="lu-top__toolbar">
                            <button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.change_hostname}" data-edc-change-hostname="{$rawObject->serverInformation->getHostname()|escape}">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.change_hostname}</span>
                            </button>
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-widget__content">
                        <div id="caServerInformationTable">
                            <div class="lu-t-c datatableLoader" data-table-container data-check-container data-edc-table="info">
                                <div class="dataTables_wrapper no-footer">
                                    <div class="lu-d-grid">
                                        <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                            <thead>
                                            <tr role="row">
                                                <th name="label"><span class="lu-table__text">{$lang.edcUi.property}</span></th>
                                                <th name="value"><span class="lu-table__text">{$lang.edcUi.value}</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {if $configuration.ServiceID == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.serviceID}</span></div></td>
                                                <td><div>{$rawObject->serverInformation->getServiceID()}</div></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.ServerId == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serverID}</span></div></td>
                                                <td><div>{$rawObject->serverInformation->getServerID()}</div></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.Label == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.label}</span></div></td>
                                                <td><div>{$rawObject->serverInformation->getLabel()}</div></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.ServerStatus == 'on'}
                                            {assign var=edcDeviceStatus value=$rawObject->serverInformation->getDeviceStatus()}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.deviceStatus}</span></div></td>
                                                <td><span class="{if $edcDeviceStatus == 'Running'}lu-text-success{elseif $edcDeviceStatus == 'Halted'}lu-text-danger{else}lu-text-info{/if}">{if $edcDeviceStatus == '-'}{$lang.edcUi.unassigned}{else}{$edcDeviceStatus}{/if}</span></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.CurrentOS == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.os}</span></div></td>
                                                <td><span>{$rawObject->serverInformation->getCurrentOS()}{if $configuration.InstallationStatus == 'on' && $rawObject->serverInformation->getInstallationStatus() != ''}<span class="lu-font-weight-bold"> - {$rawObject->serverInformation->getInstallationStatus()}</span>{/if}</span></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.Hostname == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.hostname}</span></div></td>
                                                <td><div>{$rawObject->serverInformation->getHostname()}</div></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.IPAddresses == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.ipAddresses}</span></div></td>
                                                <td><div class="lu-ed-overflow">{$rawObject->serverInformation->getIPAddresses()}</div></td>
                                            </tr>
                                            {/if}
                                            {if $configuration.MacAddress == 'on'}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.macAddress}</span></div></td>
                                                <td><div>{$rawObject->serverInformation->getMacAddress()}</div></td>
                                            </tr>
                                            {/if}
                                            {foreach from=$metadata item=i}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$i.header}</span></div></td>
                                                {if $i.header == 'SSH Password' || $i.header == 'SSH Root Password'}
                                                <td>{if $i.value == ''}<div>-</div>{else}<span class="copy-text-inline-component"><span role="button" data-edc-secret="{$i.value|escape}">******</span></span>{/if}</td>
                                                {elseif $i.header == 'Additional IP Addresses'}
                                                <td><span class="lu-ed-overflow">{$i.value}</span></td>
                                                {else}
                                                <td><div>{$i.value}</div></td>
                                                {/if}
                                            </tr>
                                            {/foreach}
                                            </tbody>
                                        </table>
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
    {if ($configuration.StatusInformation == 'on' || $configuration.OrderId == 'on' || $configuration.ServiceStatus == 'on' || $configuration.Model == 'on' || $configuration.SerialNumber == 'on' || $configuration.PurchaseDate == 'on' || $configuration.WarrantyMonths == 'on') && $configuration.BlockGeneralInformationTable != 'on'}
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget lu-ed-no-padding-widget-content">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">{$lang.edcUi.general_information}</div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-widget__content">
                        <table id="caGeneralInformationTable" class="lu-table lu-table--mob-collapsible no-footer lu-table-simple lu-table-layout-fixed" role="grid">
                            <tbody>
                            {if $configuration.StatusInformation == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.status}</span></td>
                                <td><span>{$rawObject->generalInformation->getStatus()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.OrderId == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.orderID}</span></td>
                                <td><span>{$rawObject->generalInformation->getOrderID()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.ServiceStatus == 'on'}
                            {assign var=edcServiceStatus value=$rawObject->generalInformation->getServiceStatus()}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serviceStatus}</span></td>
                                <td><span class="lu-ed-status-{$edcServiceStatus|lower}">{$edcServiceStatus}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.Model == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.model}</span></td>
                                <td><span>{$rawObject->generalInformation->getModel()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.SerialNumber == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serialNumber}</span></td>
                                <td><span>{$rawObject->generalInformation->getSerialNumber()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.PurchaseDate == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.purchaseDate}</span></td>
                                <td><span>{$rawObject->generalInformation->getPurchaseDate()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.WarrantyMonths == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.warrantyMonths}</span></td>
                                <td><span>{$rawObject->generalInformation->getWarrantyMonths()}</span></td>
                            </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}
    {if ($configuration.Location == 'on' || $configuration.LabeledRack == 'on' || $configuration.Floor == 'on' || $configuration.Address == 'on' || $configuration.PhoneNumber == 'on' || $configuration.Description == 'on') && $configuration.BlockLocationInformationTable != 'on'}
    {assign var=edcRackName value=$rawObject->locationInformation->getRackName()}
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget lu-ed-no-padding-widget-content">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">{$lang.edcUi.location_information}</div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-widget__content">
                        <table id="caLocationInformationTable" class="lu-table lu-table--mob-collapsible no-footer lu-table-simple lu-table-layout-fixed" role="grid">
                            <tbody>
                            {if $configuration.Location == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.locationName}</span></td>
                                <td><span>{$rawObject->locationInformation->getLocationName()}{if $edcRackName != '' && $edcRackName != '-'} ({$edcRackName}){/if}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.LabeledRack == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.labeledRackWithPosition}</span></td>
                                <td><span>{$rawObject->locationInformation->getRackWithPosition()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.Floor == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.floor}</span></td>
                                <td><span>{$rawObject->locationInformation->getFloor()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.Address == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.address}</span></td>
                                <td><span>{$rawObject->locationInformation->getAddress()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.PhoneNumber == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.phone}</span></td>
                                <td><span>{$rawObject->locationInformation->getPhoneNumber()}</span></td>
                            </tr>
                            {/if}
                            {if $configuration.Description == 'on'}
                            <tr>
                                <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.description}</span></td>
                                <td><span>{$rawObject->locationInformation->getDescription()}</span></td>
                            </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}
    {if $configuration.BlockBandwidthTable != 'on'}
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="bandwidthWidget" class="lu-widget lu-ed-no-padding-widget-content">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">{$lang.edcUi.bandwidth}</div>
                        <div class="lu-top__toolbar">
                            <button type="button" id="bandwidthScopeButton" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-widget__content">
                        <div id="bandwidthTable">
                            <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                                <div class="dataTables_wrapper no-footer">
                                    <div class="lu-d-grid">
                                        <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                            <thead>
                                            <tr role="row">
                                                <th name="bandwidthInterval"><span class="lu-table__text">{$lang.edcUi.bandwidth_interval}</span></th>
                                                <th name="bandwidthIn"><span class="lu-table__text">{$lang.edcUi.bandwidth_in}</span></th>
                                                <th name="bandwidthOut"><span class="lu-table__text">{$lang.edcUi.bandwidth_out}</span></th>
                                                <th name="bandwidthTotal"><span class="lu-table__text">{$lang.edcUi.bandwidth_total}</span></th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
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
</div>
