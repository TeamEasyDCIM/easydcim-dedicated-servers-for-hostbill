<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/reverseDNS.js"></script>
<div id="layers">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget widgetActionComponent vueDatatableTable">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.reverseDNSTable}
                        </div>
                        <div class="lu-top__toolbar"><a onclick='showReverseDNSModal({$jsonIpAddresses})' data-toggle="modal" data-target="#statusModal"
                                                        class="lu-btn lu-btn--primary pmCreateButton"><i
                                        class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i> <span
                                        class="lu-btn__text">{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.createButton.button.createButton}</span></a>
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-t-c">
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <table id="reverseDNS" width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th aria-sort="descending" name="ipAddress" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.table.ipAddress}</span></th>
                                        <th aria-sort="descending" name="hostname" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.table.hostname}</span></th>
                                        <th aria-sort="descending" name="created" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.table.created}</span></th>
                                        <th name="actionsCol" class="mgTableActionsHeader"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$dnsRecords key=myId item=i}
                                        <tr id="{$i.id}" role="row">
                                            <td>
                                                {$i.ipAddress}
                                            </td>
                                            <td>
                                                {$i.hostname}
                                            </td>
                                            <td>
                                                {$i.created}
                                            </td>
                                            <td class="lu-cell-actions mgTableActions">
                                                <a href="javascript:;" onclick="editDnsRecord('{$i.id}','{$i.hostname}','{$i.ipAddress}')" data-toggle="lu-tooltip" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon
                                                lu-btn--plain lu-btn--default lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center
                                                 drop-target-attached-top drop-target-attached-center" data-title="{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.updateButton.button.updateButton}">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                                </a>
                                                <a href="javascript:;" onclick="deleteDnsRecord('{$i.id}','{$i.hostname}','{$i.ipAddress}')" data-toggle="lu-tooltip" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link
                                                 lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center
                                                  drop-target-attached-top drop-target-attached-center" data-title="{$lang.serverCA.reverseDNS.mainContainer.reverseDNSTable.deleteButton.button.deleteButton}">
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


