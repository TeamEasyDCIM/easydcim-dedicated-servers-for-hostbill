<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/reverseDNS.js"></script>
{* The WHMCS ReverseDNS DataTable: search on IP and hostname, Create in the toolbar, Update / Delete per row, mass Delete. *}
<div id="layers" data-edc-service="{$serviceId}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="reverseDNSTable" class="lu-widget" data-edc-ips="{$ipList|escape}">
                <div class="lu-widget__body">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.reverse_dns}</div>
                        </div>
                    </div>
                    <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                        <div data-edc-toolbar>
                            <button type="button" class="lu-btn lu-btn--plain lu-btn--primary" data-edc-action="create">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                                <span class="lu-btn__text">{$lang.edcUi.rdns_create}</span>
                            </button>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div class="lu-d-grid">
                                <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th name="ipAddress"><span class="lu-table__text">{$lang.edcUi.rdns_ip}</span></th>
                                        <th name="hostname"><span class="lu-table__text">{$lang.edcUi.rdns_hostname}</span></th>
                                        <th name="created"><span class="lu-table__text">{$lang.edcUi.rdns_created}</span></th>
                                        <th class="mgTableActionsHeader" name="actionsCol"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$dnsRecords item=i}
                                    <tr class="lu-table-row" data-id="{$i.id}" data-hostname="{$i.hostname|escape}">
                                        <td><div>{$i.ipAddress|escape}</div></td>
                                        <td><div>{$i.hostname|escape}</div></td>
                                        <td><div>{$i.created|escape}</div></td>
                                        <td class="lu-cell-actions">
                                            <button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.update}" data-edc-action="update">
                                                <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.update}</span>
                                            </button>
                                            <button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--danger lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.delete}" data-edc-action="delete">
                                                <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i><span class="tooltiptext">{$lang.edcUi.delete}</span>
                                            </button>
                                        </td>
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
