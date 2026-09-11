<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/isoimages.js"></script>
{* The WHMCS IsoImages DataTable: search on name and URL, Create in the toolbar, Edit / Delete per row. *}
<div id="layers" data-edc-service="{$serviceId}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="isoImagesTable" class="lu-widget">
                <div class="lu-widget__body">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.iso_images}</div>
                        </div>
                    </div>
                    <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                        <div data-edc-toolbar>
                            <button type="button" class="lu-btn lu-btn--plain lu-btn--primary" data-edc-action="create">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                                <span class="lu-btn__text">{$lang.edcUi.create}</span>
                            </button>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div class="lu-d-grid">
                                <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th name="name"><span class="lu-table__text">{$lang.edcUi.iso_name}</span></th>
                                        <th name="iso_url"><span class="lu-table__text">{$lang.edcUi.iso_url}</span></th>
                                        <th name="status"><span class="lu-table__text">{$lang.edcUi.iso_status}</span></th>
                                        <th class="mgTableActionsHeader" name="actionsCol"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$isoImages item=i}
                                    <tr class="lu-table-row" data-id="{$i.Id}" data-name="{$i.name|escape}" data-iso-url="{$i.iso_url|escape}">
                                        <td><div>{$i.name|escape}</div></td>
                                        <td><div>{$i.iso_url|escape}</div></td>
                                        <td>
                                            <span class="lu-badge lu-value lu-tooltip {$i.badgeClass}"{if $i.message != ''} data-title="{$i.message|escape}"{/if}>{if $i.statusKey == 'iso_waiting'}{$lang.edcUi.iso_waiting}{elseif $i.statusKey == 'iso_downloading'}{$lang.edcUi.iso_downloading}{elseif $i.statusKey == 'iso_completed'}{$lang.edcUi.iso_completed}{elseif $i.statusKey == 'iso_error'}{$lang.edcUi.iso_error}{else}{$lang.edcUi.iso_unknown}{/if}{if $i.message != ''}<span class="tooltiptext">{$i.message|escape}</span>{/if}</span>
                                        </td>
                                        <td class="lu-cell-actions">
                                            <button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.edit}" data-edc-action="update">
                                                <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.edit}</span>
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
