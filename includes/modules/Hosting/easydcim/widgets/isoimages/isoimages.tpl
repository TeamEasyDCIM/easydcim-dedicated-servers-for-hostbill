<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/isoimages.js"></script>
<script src="{$assetsURL}/js/index.js"></script>

<div id="layers">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget widgetActionComponent vueDatatableTable">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.isoImages.mainContainer.isoImagesTable.isoImagesTable}
                        </div>
                        <div class="lu-top__toolbar">
                            <a onclick='showIsoImagesModal()' class="lu-btn lu-btn--primary pmCreateButton">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                                <span class="lu-btn__text">{$lang.serverCA.isoImages.mainContainer.isoImagesTable.createButton.button.createButton}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-t-c">
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <table id="isoImages" width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th aria-sort="descending" name="Id" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.isoImages.mainContainer.isoImagesTable.table.Id}</span></th>
                                        <th aria-sort="descending" name="name" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.isoImages.mainContainer.isoImagesTable.table.name}</span></th>
                                        <th aria-sort="descending" name="iso_url" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.isoImages.mainContainer.isoImagesTable.table.iso_url}</span></th>
                                        <th aria-sort="descending" name="status" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.isoImages.mainContainer.isoImagesTable.table.status}</span></th>
                                        <th name="actionsCol" class="mgTableActionsHeader"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$isoImages key=myId item=i}
                                        <tr role="row">
                                            <td>
                                                {$i.Id}
                                            </td>
                                            <td>
                                                {$i.name}
                                            </td>
                                            <td>
                                                {$i.iso_url}
                                            </td>
                                            <td>
                                                {if $i.status eq 'Finished'}
                                                    <span class="lu-label lu-label--status {$i.colorStatus} lu-tooltip drop-target
                                                drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                          data-toggle="lu-tooltip" data-title="The ISO image has been downloaded"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$i.status}
                                                    <span class="tooltiptext">{$lang.serverCA.isoImages.Downloadingisfinished}</span></span>
                                                {elseif $i.status eq 'Error'}
                                                    <span class="lu-label lu-label--status {$i.colorStatus} lu-tooltip drop-target
                                                drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                          data-toggle="lu-tooltip" data-title="The ISO image has been downloaded"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$i.status}
                                                    <span class="tooltiptext">Error: {$i.data.message}</span></span>
                                                {elseif $i.status eq 'Started'}
                                                    <span class="lu-label lu-label--status {$i.colorStatus} lu-tooltip drop-target
                                                drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                          data-toggle="lu-tooltip" data-title="The ISO image has been downloaded"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$i.status}
                                                    <span class="tooltiptext"><div style="padding:5px ">
                                                        <div class="progress" style="margin-bottom:0px; width: 100%;">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="{$i.progress}" aria-valuemin="1" aria-valuemax="100" style="width:{$i.progress}% ">
                                                                {$i.progress}%
                                                            </div>
                                                        </div>
                                                    </div></span></span>
                                                {else}
                                                    <span class="lu-label lu-label--status {$i.colorStatus} lu-tooltip drop-target
                                                drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                          data-toggle="lu-tooltip" data-title="The ISO image has been downloaded"
                                                          style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$i.status}
                                                    <span class="tooltiptext">{$lang.serverCA.isoImages.Waitingfordownloadingtostart}</span></span>
                                                {/if}
                                            </td>
                                            <td class="lu-cell-actions mgTableActions">
                                                <a href="javascript:;" onclick="editIsoImageModal('{$i.Id}','{$i.name}','{$i.iso_url}')" data-toggle="lu-tooltip" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon
                                                lu-btn--plain lu-btn--default lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center
                                                 drop-target-attached-top drop-target-attached-center" data-title="{$lang.serverCA.isoImages.mainContainer.isoImagesTable.updateButton.button.updateButton}">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                                </a>
                                                <a href="javascript:;" onclick="deleteIsoImageModal('{$i.Id}')" data-toggle="lu-tooltip" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link
                                                 lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center
                                                  drop-target-attached-top drop-target-attached-center" data-title="{$lang.serverCA.isoImages.mainContainer.isoImagesTable.deleteButton.button.deleteButton}">
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