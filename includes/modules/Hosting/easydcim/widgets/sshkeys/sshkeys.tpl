<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/sshkeys.js"></script>
<div id="layers">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget widgetActionComponent vueDatatableTable">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.sshKeys.mainContainer.sshKeysTable.sshKeysTable}
                        </div>
                        <div class="lu-top__toolbar">
                            <a onclick="showSshKeyModal()" data-toggle="modal" data-target="#statusModal"
                               class="lu-btn lu-btn--primary pmCreateButton"><i
                                        class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i> <span
                                        class="lu-btn__text">{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.createButton.button.createButton}</span></a>
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-t-c">
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <table id="sshKeys" width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th aria-sort="descending" name="name" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.table.name}</span></th>
                                        <th aria-sort="descending" name="fingerprint" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.table.fingerprint}</span></th>
                                        <th aria-sort="descending" name="default" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.table.default}</span></th>
                                        <th aria-sort="descending" name="created" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.table.created}</span></th>
                                        <th name="actionsCol" class="mgTableActionsHeader"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$sshKeys key=myId item=i}
                                        <tr id="{$i.id}" role="row">
                                            <td>
                                                {$i.name}
                                            </td>
                                            <td>
                                                <code>{$i.fingerprint}</code>
                                            </td>
                                            <td>
                                                {if $i.default}
                                                    <span class="lu-label lu-label--status lu-label--success"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$lang.serverCA.sshKeys.default}</span>
                                                {else}
                                                    <span class="lu-label lu-label--status lu-label--default"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">-</span>
                                                {/if}
                                            </td>
                                            <td>
                                                {$i.created}
                                            </td>
                                            <td class="lu-cell-actions mgTableActions">
                                                {if !$i.default}
                                                    <a href="javascript:;" onclick="setSshKeyAsDefault('{$i.id}')" data-toggle="lu-tooltip"
                                                       class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip drop-target
                                                       drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                       data-title="{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.defaultButton.button.defaultButton}">
                                                        <i class="lu-btn__icon lu-zmdi lu-zmdi-star-outline"></i>
                                                    </a>
                                                {/if}
                                                <a href="javascript:;" onclick="editSshKey('{$i.id}','{$i.name|escape:'javascript'}')" data-toggle="lu-tooltip"
                                                   class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip drop-target
                                                   drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                   data-title="{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.updateButton.button.updateButton}">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                                </a>
                                                <a href="javascript:;" onclick="deleteSshKey('{$i.id}')" data-toggle="lu-tooltip"
                                                   class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link lu-btn--icon lu-btn--plain lu-tooltip drop-target
                                                   drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                   data-title="{$lang.serverCA.sshKeys.mainContainer.sshKeysTable.deleteButton.button.deleteButton}">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>
                                                </a>
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
