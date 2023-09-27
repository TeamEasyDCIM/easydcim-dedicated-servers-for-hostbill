<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/layout.css">
<link rel="stylesheet" href="{$assetsURL}/css/font-awesome.css">
<link rel="stylesheet" href="{$assetsURL}/css/helpers.css">
<link rel="stylesheet" href="{$assetsURL}/css/loader.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/rebuild.js"></script>
<div id="layers">
    <div class="lu-row">
        <div id="reinstallTable" class="lu-col-md-12">
            <div id="reinstallTable" class="lu-widget widgetActionComponent vueDatatableTable">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.reinstall}
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div id="reinstallTable" data-table-container="" data-check-container=""
                         class="lu-t-c  datatableLoader">
                        <div class="lu-t-c__mass-actions lu-top">
                            <div class="lu-top__title"><span class="lu-badge lu-badge--primary lu-value">0</span> Items
                                Selected
                            </div>
                            <div class="lu-top__toolbar"></div>
                            <div class="drop-arrow"></div>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <input id="instalationStatusForReload" type="hidden" value="{$installationInformation.installationStatus}">
                                <table width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable dtr-column">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr role="row">
                                        <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.currentOS}</td>
                                        {if $installationInformation.osIsCurrentlyBeingInstalled eq 'NO'}
                                            {if $installationInformation.currentOS eq ''}
                                                <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.currentOS}</td>
                                            {else}
                                                <td><img width="32" height="32" src="{$installationInformation.path}"> {$installationInformation.currentOS}</td>
                                            {/if}
                                        {else}
                                            <td><img width="32" height="32" src="{$installationInformation.path}"> {$installationInformation.currentOS} - <b>{$installationInformation.installationStatus}</b> <div class="icon-container">
                                                    <i class="loader"></i>
                                                </div></td>
                                        {/if}
                                    </tr>
                                    <tr role="row">
                                        <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.hostInformation}</td>
                                        <td>{$installationInformation.hostInformation}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.macAddress}</td>
                                        <td>{$installationInformation.macAddress}</td>
                                    </tr>
                                    <tr role="row">
                                        <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.osIsCurrentlyBeingInstalled}</td>
                                        {if $installationInformation.osIsCurrentlyBeingInstalled eq 'YES'}
                                            <td><span class="lu-text-success">{$lang.Yes}</span></td>
                                        {else}
                                            <td><span class="lu-text-danger">{$lang.No}</span></td>
                                        {/if}
                                    </tr>
                                    <tr role="row">
                                        <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.actions}</td>
                                        <td>
                                            {if $installationInformation.osIsCurrentlyBeingInstalled eq 'NO'}
                                                <a onclick='generateRBModal(this,{$jsonEncodeinstallationInformation},{$caTemplates})' class="lu-btn lu-btn--primary" style="cursor: pointer;">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-refresh-alt" aria-hidden="true"></i> <span
                                                            class="lu-btn__text">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.reinstall}<span></span></a>
                                            {else}
                                                <a onclick='generateCIModal(this,{$jsonEncodeinstallationInformation})' data-edc-modal="1" class="lu-btn lu-btn--danger" data-edc-modal-init="true" style="cursor: pointer;">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-block-alt" aria-hidden="true"></i> <span
                                                            class="lu-btn__text">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.cancelInstallation}</span></a>
                                            {/if}
                                    </tr>
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


