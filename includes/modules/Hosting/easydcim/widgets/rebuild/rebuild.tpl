<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/rebuild.js"></script>
{* The WHMCS ReinstallWidget: Rebuild Server / Cancel Installation in the toolbar, the server details below. *}
<div id="layers" data-edc-service="{$serviceId}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="reinstallWidget" class="lu-widget lu-ed-no-padding-widget-content"
                 data-edc-templates="{$caTemplates|escape}" data-edc-title="{$rebuildTitle|escape}" data-edc-hostname="{$rebuildHostname|escape}"
                 data-edc-signature="{if $installationInformation.installing}installing:{$installationInformation.installationMessage|escape}{else}idle{/if}">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">{$lang.edcUi.rebuild_server}</div>
                        <div class="lu-top__toolbar">
                            {if $installationInformation.installing}
                            <button type="button" class="lu-btn lu-btn--plain lu-btn--danger" data-edc-action="cancel">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-close-circle-o"></i>
                                <span class="lu-btn__text">{$lang.edcUi.cancel_installation}</span>
                            </button>
                            {else}
                            <button type="button" class="lu-btn lu-btn--plain lu-btn--primary" data-edc-action="rebuild">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-refresh"></i>
                                <span class="lu-btn__text">{$lang.edcUi.rebuild_server}</span>
                            </button>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-widget__content">
                        <div id="reinstallTable">
                            <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                                <div class="dataTables_wrapper no-footer">
                                    <div class="lu-d-grid">
                                        <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                            <thead>
                                            <tr role="row">
                                                <th name="label"><span class="lu-table__text"></span></th>
                                                <th name="value"><span class="lu-table__text"></span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.edcUi.current_os}</span></div></td>
                                                <td>
                                                    <div class="lu-image-text">
                                                        <div class="lu-m-r-1x"><img src="{$installationInformation.path}" alt=""></div>
                                                        <span class="lu-text">{$installationInformation.currentOS|escape}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.edcUi.host_information}</span></div></td>
                                                <td><div>{if $installationInformation.hostname != ''}{$installationInformation.hostname|escape}{else}-{/if}</div></td>
                                            </tr>
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.edcUi.mac_address}</span></div></td>
                                                <td><div>{if $installationInformation.macAddress != ''}{$installationInformation.macAddress|escape}{else}-{/if}</div></td>
                                            </tr>
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.edcUi.installation_in_progress}</span></div></td>
                                                <td>{if $installationInformation.installing}<span class="lu-text-success">{$lang.edcUi.yes}</span>{else}<span class="lu-text-danger">{$lang.edcUi.no}</span>{/if}</td>
                                            </tr>
                                            {if $installationInformation.installing && $installationInformation.installationMessage != ''}
                                            <tr class="lu-table-row">
                                                <td><div><span class="lu-font-weight-bold">{$lang.edcUi.installation_status}</span></div></td>
                                                <td><div>{$installationInformation.installationMessage|escape}</div></td>
                                            </tr>
                                            {/if}
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
</div>
