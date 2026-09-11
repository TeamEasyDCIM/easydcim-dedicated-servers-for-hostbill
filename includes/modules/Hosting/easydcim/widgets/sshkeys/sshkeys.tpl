<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/sshkeys.js"></script>
{* The WHMCS SshKeys DataTable: search on name and fingerprint, Create in the toolbar, Set as Default / Edit / Delete per row. *}
<div id="layers" data-edc-service="{$serviceId}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="sshKeysTable" class="lu-widget">
                <div class="lu-widget__body">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.ssh_keys}</div>
                        </div>
                    </div>
                    <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                        <div data-edc-toolbar>
                            <button type="button" class="lu-btn lu-btn--plain lu-btn--primary pmCreateButton" data-edc-action="create">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                                <span class="lu-btn__text">{$lang.edcUi.ssh_create}</span>
                            </button>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div class="lu-d-grid">
                                <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th name="id"><span class="lu-table__text">{$lang.edcUi.ssh_id}</span></th>
                                        <th name="name"><span class="lu-table__text">{$lang.edcUi.ssh_name}</span></th>
                                        <th name="fingerprint"><span class="lu-table__text">{$lang.edcUi.ssh_fingerprint}</span></th>
                                        <th name="isDefault"><span class="lu-table__text">{$lang.edcUi.ssh_default}</span></th>
                                        <th class="mgTableActionsHeader" name="actionsCol"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$sshKeys item=i}
                                    <tr class="lu-table-row" data-id="{$i.id}" data-name="{$i.name|escape}" data-ssh-key="{$i.sshKey|escape}" data-default="{if $i.default}1{else}0{/if}">
                                        <td><div>{$i.id}</div></td>
                                        <td><div>{$i.name|escape}</div></td>
                                        <td><div>{$i.fingerprint|escape}</div></td>
                                        <td>{if $i.default}<span class="lu-badge lu-value lu-badge--success">{$lang.edcUi.yes}</span>{else}<span class="lu-badge lu-value lu-badge--danger">{$lang.edcUi.no}</span>{/if}</td>
                                        <td class="lu-cell-actions">
                                            {if !$i.default}
                                            <button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--info lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.ssh_set_default}" data-edc-action="default">
                                                <i class="lu-btn__icon lu-zmdi lu-zmdi-check"></i><span class="tooltiptext">{$lang.edcUi.ssh_set_default}</span>
                                            </button>
                                            {/if}
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
