<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/tom-select.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/flatpickr.min.css">
<script src="{$assetsURL}/js/tom-select.complete.min.js"></script>
<script src="{$assetsURL}/js/flatpickr.min.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/apexcharts.min.js"></script>
<script src="{$assetsURL}/js/easydcimGraphs.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/sensors.js"></script>
{* The WHMCS Sensors DataTable (no title): search on name and class, five a page, the period filter in the toolbar, an inline graph per sensor. *}
<div id="layers" data-edc-service="{$serviceId}" data-edc-scopes="{$edcScopes|escape}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="sensorsTable" class="lu-widget">
                <div class="lu-widget__body">
                    <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                        <div data-edc-toolbar>
                            <button type="button" id="sensorsScopeButton" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.serverCA.sensors.mainContainer.sensorsTable.scopeButton.button.scopeButton}">
                                <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.serverCA.sensors.mainContainer.sensorsTable.scopeButton.button.scopeButton}</span>
                            </button>
                        </div>
                        <div class="dataTables_wrapper no-footer">
                            <div class="lu-d-grid">
                                <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th name="name"><span class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.name}</span></th>
                                        <th name="type"><span class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.type}</span></th>
                                        <th name="class"><span class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.class}</span></th>
                                        <th name="reading"><span class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.reading}</span></th>
                                        <th name="graph"><span class="lu-table__text">{$lang.serverCA.sensors.mainContainer.sensorsTable.table.graph}</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$sensors item=i}
                                    <tr class="lu-table-row" data-id="{$i.id}">
                                        <td><div>{$i.name|escape}</div></td>
                                        <td><span class="lu-badge lu-value {$i.typeClass}">{$i.type|escape}</span></td>
                                        <td><div>{$i.class|escape}</div></td>
                                        <td><div>{$i.reading|escape}</div></td>
                                        <td>
                                            {* inline 150x35 graph, one per sensor as in WHMCS *}
                                            <div id="sensorGraph_{$i.id}" class="lu-graph sensorGraph" data-sensor-id="{$i.id}"
                                                 data-unit="{$i.unit|escape}" data-name="{$i.name|escape}"></div>
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
