<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/chart.js"></script>
<script src="{$assetsURL}/js/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="{$assetsURL}/js/sensors.js"></script>
<div id="layers">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget widgetActionComponent vueDatatableTable">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.sensors.mainContainer.sensorsTable.sensorsTable}
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div class="lu-t-c">
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <table id="sensors" width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th aria-sort="descending" name="name" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.name}</span></th>
                                        <th aria-sort="descending" name="type" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.type}</span></th>
                                        <th aria-sort="descending" name="class" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.class}</span></th>
                                        <th aria-sort="descending" name="reading" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.reading}</span></th>
                                        <th aria-sort="descending" name="lastPolled" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.lastPolled}</span></th>
                                        <th name="actionsCol" class="mgTableActionsHeader"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$sensors key=myId item=i}
                                        <tr id="sensor-{$i.id}" role="row">
                                            <td>
                                                {$i.name}
                                            </td>
                                            <td>
                                                <span class="lu-label lu-label--status {$i.typeClass}"
                                                      style="margin-left: 0px; margin-right: 10px; margin-bottom: 5px;">{$i.type}</span>
                                            </td>
                                            <td>
                                                {$i.class}
                                            </td>
                                            <td>
                                                {$i.reading}
                                            </td>
                                            <td>
                                                {$i.lastPolled}
                                            </td>
                                            <td class="lu-cell-actions mgTableActions">
                                                <a href="javascript:;"
                                                   onclick="showSensorGraph('{$i.id}','{$i.name|escape:'javascript'}','{$i.unit|escape:'javascript'}')"
                                                   data-toggle="lu-tooltip"
                                                   class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip drop-target
                                                   drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"
                                                   data-title="{$lang.serverCA.sensors.mainContainer.sensorsTable.graphButton.button.graphButton}">
                                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-chart"></i>
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
