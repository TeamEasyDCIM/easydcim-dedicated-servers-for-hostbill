<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/tom-select.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/flatpickr.min.css">
<script src="{$assetsURL}/js/tom-select.complete.min.js"></script>
<script src="{$assetsURL}/js/flatpickr.min.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/showcustomfn.js"></script>
<script src="{$assetsURL}/js/apexcharts.min.js"></script>
<script src="{$assetsURL}/js/easydcimGraphs.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/aggregateTraffic.js"></script>
<script src="{$assetsURL}/js/ping.js"></script>
<script src="{$assetsURL}/js/status.js"></script>
<script src="{$assetsURL}/js/bandwidth.js"></script>

<ul class="accor">
    <li>
        <a href="#">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.statusWidget}</a>
        <div class="sor">
            <div id="layers" data-edc-service="{$serviceId}" data-edc-scopes="{$edcScopes|escape}">
                {* StatusWidget: a TilesBar, each tile opens its confirmation modal *}
                {if !$applyFeatures || $configuration.BootServer == 'on' || $configuration.ShutdownServer == 'on' || $configuration.RebootServer == 'on' || $configuration.BMCColdReset == 'on' || $configuration.RescueMode == 'on' || $configuration.noVNCKVMConsole == 'on' || $configuration.AutoLoginLink == 'on'}
                <div id="StatusWidget" class="lu-col-md-12">
                    <div class="lu-tiles-wrapper">
                        <div class="h4 lu-m-b-3x lu-m-t-3x">{$lang.edcUi.server_actions}</div>
                        <div class="lu-tiles lu-row lu-row--eq-height">
                            {if !$applyFeatures || $configuration.BootServer == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="boot">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.boot_server}" src="{$assetsURL}/img/server-start.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.boot_server}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.ShutdownServer == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="shutdown">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.shutdown_server}" src="{$assetsURL}/img/server-stop.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.shutdown_server}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.RebootServer == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="reboot">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.reboot_server}" src="{$assetsURL}/img/server-reboot.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.reboot_server}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.BMCColdReset == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="bmcColdReset">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.bmc_cold_reset}" src="{$assetsURL}/img/server-reset.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.bmc_cold_reset}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.RescueMode == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="enableRescueMode">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.rescue_mode}" src="{$assetsURL}/img/rescue-new.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.rescue_mode}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.noVNCKVMConsole == 'on'}
                            <div class="lu-col-sm-20p" role="button">
                                <a href="javascript:;" class="lu-tile lu-tile--btn" data-edc-service-action="noVNCConsole">
                                    <div class="lu-i-c-6x"><img alt="{$lang.edcUi.novnc_console}" src="{$assetsURL}/img/console-vnc.png"></div>
                                    <div class="lu-tile__title">{$lang.edcUi.novnc_console}</div>
                                </a>
                            </div>
                            {/if}
                            {if !$applyFeatures || $configuration.AutoLoginLink == 'on'}
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
                {* Service Information: a DataTable with its title, pages and no search *}
                {if !$applyFeatures || ($configuration.BlockServerInformationTable != 'on' && ($configuration.ServiceID == 'on' || $configuration.ServerId == 'on' || $configuration.Label == 'on' || $configuration.ServerStatus == 'on' || $configuration.Hostname == 'on' || $configuration.ChangeHostname == 'on' || $configuration.IPAddresses == 'on' || $configuration.CurrentOS == 'on' || $configuration.MacAddress == 'on' || $configuration.InstallationStatus == 'on' || $metadata))}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div id="ServerInformationTable" class="lu-widget">
                            <div class="lu-widget__body">
                                <div class="lu-widget__header">
                                    <div class="lu-widget__top lu-top">
                                        <div class="lu-top__title">{$lang.edcUi.service_information}</div>
                                    </div>
                                </div>
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
                                                {if !$applyFeatures || $configuration.ServiceID == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.serviceID}</span></div></td>
                                                    <td><div>{$rawObject->serverInformation->getServiceID()}</div></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.ServerId == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serverID}</span></div></td>
                                                    <td><span>{$rawObject->serverInformation->getServerID()} - <a href="{$rawObject->serverInformation->getServerLink()}" target="_blank">{$lang.edcUi.click_to_view}</a></span></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.Label == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.label}</span></div></td>
                                                    <td><div>{$rawObject->serverInformation->getLabel()}</div></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.ServerStatus == 'on'}
                                                {assign var=edcDeviceStatus value=$rawObject->serverInformation->getDeviceStatus()}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.deviceStatus}</span></div></td>
                                                    <td><span class="{if $edcDeviceStatus == 'Running'}lu-text-success{elseif $edcDeviceStatus == 'Halted'}lu-text-danger{else}lu-text-info{/if}">{if $edcDeviceStatus == '-'}{$lang.edcUi.unassigned}{else}{$edcDeviceStatus}{/if}</span></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.CurrentOS == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.os}</span></div></td>
                                                    <td><span>{$rawObject->serverInformation->getCurrentOS()}{if (!$applyFeatures || $configuration.InstallationStatus == 'on') && $rawObject->serverInformation->getInstallationStatus() != ''}<span class="lu-font-weight-bold"> - {$rawObject->serverInformation->getInstallationStatus()}</span>{/if}</span></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.Hostname == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.hostname}</span></div></td>
                                                    <td><div>{$rawObject->serverInformation->getHostname()}</div></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.IPAddresses == 'on'}
                                                <tr class="lu-table-row">
                                                    <td><div><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.ipAddresses}</span></div></td>
                                                    <td><div class="lu-ed-overflow">{$rawObject->serverInformation->getIPAddresses()}</div></td>
                                                </tr>
                                                {/if}
                                                {if !$applyFeatures || $configuration.MacAddress == 'on'}
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
                {/if}
                {* General Information: a Widget holding a simple aligned table *}
                {if !$applyFeatures || ($configuration.BlockGeneralInformationTable != 'on' && ($configuration.StatusInformation == 'on' || $configuration.OrderId == 'on' || $configuration.ServiceStatus == 'on' || $configuration.Model == 'on' || $configuration.SerialNumber == 'on' || $configuration.PurchaseDate == 'on' || $configuration.WarrantyMonths == 'on'))}
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
                                    <table id="GeneralInformationTable" class="lu-table lu-table--mob-collapsible no-footer lu-table-simple lu-table-layout-fixed" role="grid">
                                        <tbody>
                                        {if !$applyFeatures || $configuration.StatusInformation == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.status}</span></td>
                                            <td><span>{$rawObject->generalInformation->getStatus()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.OrderId == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.orderID}</span></td>
                                            <td><span>{$rawObject->generalInformation->getOrderID()} - <a href="{$rawObject->generalInformation->getOrderLink()}" target="_blank">{$lang.edcUi.click_to_view}</a></span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.ServiceStatus == 'on'}
                                        {assign var=edcServiceStatus value=$rawObject->generalInformation->getServiceStatus()}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serviceStatus}</span></td>
                                            <td><span class="lu-ed-status-{$edcServiceStatus|lower}">{$edcServiceStatus}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.Model == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.model}</span></td>
                                            <td><span>{$rawObject->generalInformation->getModel()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.SerialNumber == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serialNumber}</span></td>
                                            <td><span>{$rawObject->generalInformation->getSerialNumber()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.PurchaseDate == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.purchaseDate}</span></td>
                                            <td><span>{$rawObject->generalInformation->getPurchaseDate()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.WarrantyMonths == 'on'}
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
                {* Location Information: a Widget holding a simple aligned table *}
                {if !$applyFeatures || ($configuration.BlockLocationInformationTable != 'on' && ($configuration.Location == 'on' || $configuration.LabeledRack == 'on' || $configuration.Floor == 'on' || $configuration.Address == 'on' || $configuration.PhoneNumber == 'on' || $configuration.Description == 'on'))}
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
                                    <table id="LocationInformationTable" class="lu-table lu-table--mob-collapsible no-footer lu-table-simple lu-table-layout-fixed" role="grid">
                                        <tbody>
                                        {if !$applyFeatures || $configuration.Location == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.locationName}</span></td>
                                            <td><span><a href="{$rawObject->locationInformation->getLocationLink()}" target="_blank">{$rawObject->locationInformation->getLocationName()}</a>{if $edcRackName != '' && $edcRackName != '-'}<a href="{$rawObject->locationInformation->getRackLink()}" target="_blank"><span class="lu-font-weight-bold"> ({$edcRackName})</span></a>{/if}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.LabeledRack == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.labeledRackWithPosition}</span></td>
                                            <td>{if $edcRackName != '' && $edcRackName != '-'}<a href="{$rawObject->locationInformation->getRackLink()}" target="_blank">{$rawObject->locationInformation->getRackWithPosition()}</a>{else}<span>{$lang.edcUi.unassigned}</span>{/if}</td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.Floor == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.floor}</span></td>
                                            <td><span>{$rawObject->locationInformation->getFloor()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.Address == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.address}</span></td>
                                            <td><span>{$rawObject->locationInformation->getAddress()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.PhoneNumber == 'on'}
                                        <tr>
                                            <td><span class="lu-font-weight-bold">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.phone}</span></td>
                                            <td><span>{$rawObject->locationInformation->getPhoneNumber()}</span></td>
                                        </tr>
                                        {/if}
                                        {if !$applyFeatures || $configuration.Description == 'on'}
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
                {* Bandwidth: one row for the period set with "Filter Bandwidth" (bandwidth.js) *}
                {if !$applyFeatures || $configuration.BlockBandwidthTable != 'on'}
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
                {* Graphs, each with its "Filter Graph" period (aggregateTraffic.js, ping.js, status.js) *}
                {if !$applyFeatures || $configuration.AggregateTraffic == 'on'}
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">{$lang.edcUi.aggregate_traffic}</div>
                                    <div class="lu-top__toolbar">
                                        <button type="button" id="aggregateTrafficScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div id="aggregateTraffic" class="lu-graph" data-edc-height-scale="0.667"></div>
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
                                    <div class="lu-top__title">{$lang.edcUi.ping_graph}</div>
                                    <div class="lu-top__toolbar">
                                        <button type="button" id="pingGraphScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div id="pingGraph" class="lu-graph" data-edc-height-scale="0.667"></div>
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
                                    <div class="lu-top__title">{$lang.edcUi.status_graph}</div>
                                    <div class="lu-top__toolbar">
                                        <button type="button" id="statusGraphScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                            <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div id="statusGraph" class="lu-graph" data-edc-height-scale="0.667"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
            </div>
        </div>
    </li>
</ul>
