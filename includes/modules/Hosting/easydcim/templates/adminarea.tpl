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

<ul class="accor">
    <li>
        <a href="#">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.statusWidget}</a>
        <div class="sor">
            <div id="layers">
                <div class="lu-col-md-12">
                    <div class="lu-h5 lu-m-b-3x lu-m-t-2x">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.statusWidgetTitle}</div>
                    <div class="lu-tiles lu-row lu-row--eq-height">
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.startInstance.startForm.confirmStartInstance}','boot')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/powerOnButton.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.servicePageIntegration.mainContainer.statusWidget.start.startTitle}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.stopInstance.stopForm.confirmStopInstance}','shutdown')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/powerOffButton.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.stopInstance.baseAcceptButton.title}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.resetInstance.resetForm.confirmResetInstance}','reboot')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/reboot.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.resetInstance.baseAcceptButton.title}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.bmcColdResetInstance.bmcColdResetForm.confirmBMCColdResetInstance}','bmcColdReset')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/reinstall.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.bmcColdResetInstance.modal.bmcColdResetInstance}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.enableRescueModeInstance.enableRescueModeForm.confirmEnableRescueModeInstance}','enableRescueMode')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/rescue.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.enableRescueModeInstance.modal.enableRescueModeInstance}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.kVMJavaConsoleInstance.kVMJavaConsoleForm.confirmKVMJavaConsoleInstance}','kvmConsole')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/vnc.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.kVMJavaConsoleInstance.modal.kVMJavaConsoleInstance}</span>
                            </a>
                        </div>
                        <div class="lu-col-xs-6 lu-col-md-20p">
                            <a href="javascript:;" class="lu-tile lu-tile--btn lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center" onclick="generateModal(this,'{$lang.serverAA.adminServicesTabFields.noVNCKVMConsoleInstance.noVNCKVMConsoleForm.confirmNoVNCKVMConsoleInstance}','noVNCConsole')">
                                <div class="lu-i-c-6x">
                                    <img class="serviceActionsImages" src="{$assetsURL}/img/novnc.png" alt="">
                                </div>
                                <span class="lu-tile__title">{$lang.serverAA.adminServicesTabFields.noVNCKVMConsoleInstance.modal.noVNCKVMConsoleInstance}</span>
                            </a>
                        </div>
                    </div>
                </div>
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
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serverID}</td>
                                                        <td>{$rawObject->serverInformation->getServerID()} <a href="{$rawObject->serverInformation->getServerLink()}" target="_blank">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.clickToView}</a></td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.label}</td>
                                                        <td>{$rawObject->serverInformation->getLabel()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.deviceStatus}</td>
                                                        <td{if $rawObject->serverInformation->getDeviceStatus() === 'Down'} class="lu-text-danger" {else} class="lu-text-success" {/if}>{$rawObject->serverInformation->getDeviceStatus()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.os}</td>
                                                        <td>{$rawObject->serverInformation->getCurrentOS()} - <b>{$rawObject->serverInformation->getInstallationStatus()}</b></td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.hostname}</td>
                                                        <td>{$rawObject->serverInformation->getHostname()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.ipAddresses}</td>
                                                        <td class="overflow">{$rawObject->serverInformation->getIPAddresses()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.serverInformation.tableField.macAddress}</td>
                                                        <td>{$rawObject->serverInformation->getMacAddress()}</td>
                                                    </tr>
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
                                                                <td class="overflow">{$i.value}</td>
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
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.status}</td>
                                                        <td>{$rawObject->generalInformation->getStatus()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.orderID}</td>
                                                        <td>{$rawObject->generalInformation->getOrderID()} <a href="{$rawObject->generalInformation->getOrderLink()}" target="_blank">Click to view in EasyDCIM</a></td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serviceStatus}</td>
                                                        <td {if $rawObject->generalInformation->getServiceStatus() == 'Activated'} class="lu-text-success" {else} class="lu-text-danger" {/if}>{$rawObject->generalInformation->getServiceStatus()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.model}</td>
                                                        <td>{$rawObject->generalInformation->getModel()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.serialNumber}</td>
                                                        <td>{$rawObject->generalInformation->getSerialNumber()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.purchaseDate}</td>
                                                        <td>{$rawObject->generalInformation->getPurchaseDate()}</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.generalInformation.tableField.warrantyMonths}</td>
                                                        <td>{$rawObject->generalInformation->getWarrantyMonths()}</td>
                                                    </tr>
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
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.locationName}</td>
                                                    <td><a href="{$rawObject->locationInformation->getLocationLink()}" target="_blank" class="">{$rawObject->locationInformation->getLocationName()} </a><a href="{$rawObject->locationInformation->getRackLink()}" target="_blank" class="lu-font-weight-bold">({$rawObject->locationInformation->getRackName()})</a></td>
                                                </tr>
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.labeledRackWithPosition}</td>
                                                    <td><a href="{$rawObject->locationInformation->getRackLink()}" target="_blank">{$rawObject->locationInformation->getRackWithPosition()}</a></td>
                                                </tr>
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.floor}</td>
                                                    <td>{$rawObject->locationInformation->getFloor()}</td>
                                                </tr>
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.address}</td>
                                                    <td>{$rawObject->locationInformation->getAddress()}</td>
                                                </tr>
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.phone}</td>
                                                    <td>{$rawObject->locationInformation->getPhoneNumber()}</td>
                                                </tr>
                                                <tr role="row">
                                                    <td class="informationTablesWidth">{$lang.serverAA.servicePageIntegration.mainContainer.location.tableField.description}</td>
                                                    <td >{$rawObject->locationInformation->getDescription()}</td>
                                                </tr>
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
                <div class="lu-row">
                    <div class="lu-col-md-12">
                        <div class="lu-widget widgetActionComponent vueDatatableTable">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.servicePageIntegration.mainContainer.bandwidthTable.bandwidthTable}
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
                                                <tbody>
                                                {foreach from=$rawObject->bandwidth->getData() key=myId item=i}
                                                    <tr role="row">
                                                        <td>{$i.bandwidthInterval}</td>
                                                        <td>{$i.bandwidthIn}</td>
                                                        <td>{$i.bandwidthOut}</td>
                                                        <td>{$i.bandwidthTotal}</td>
                                                    </tr>
                                                {/foreach}
                                                </tbody>
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
                <select id="scope" class="mg-select2">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                </select>
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
                <select id="scope2" class="mg-select2">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                </select>
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
                <select id="scope3" class="mg-select2">
                    <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                    <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                    <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                    <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                    <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                    <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                    <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                    <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reloadAggregateTraffic" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->