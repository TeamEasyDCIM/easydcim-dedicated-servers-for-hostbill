<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<link rel="stylesheet" href="{$assetsURL}/css/flatpickr.min.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/flatpickr.min.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/apexcharts.min.js"></script>
<script src="{$assetsURL}/js/easydcimGraphs.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/aggregateTraffic.js"></script>
<script src="{$assetsURL}/js/ping.js"></script>
<script src="{$assetsURL}/js/status.js"></script>
{* The WHMCS graph pages: each graph has its own "Filter Graph" period in the toolbar. *}
<div id="layers" data-edc-service="{$serviceId}" data-edc-scopes="{$edcScopes|escape}">
    {if $configuration.AggregateTraffic == 'on'}
        <div class="lu-row">
            <div class="lu-col-md-12">
                <div class="lu-widget">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.aggregate_traffic}</div>
                            <div class="lu-top__toolbar">
                                <button type="button" id="aggregateTrafficScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <div id="aggregateTraffic" class="lu-graph"></div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {if $configuration.Ping == 'on'}
        <div class="lu-row">
            <div class="lu-col-md-12">
                <div class="lu-widget">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.ping_graph}</div>
                            <div class="lu-top__toolbar">
                                <button type="button" id="pingGraphScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <div id="pingGraph" class="lu-graph"></div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {if $configuration.Status == 'on'}
        <div class="lu-row">
            <div class="lu-col-md-12">
                <div class="lu-widget">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.status_graph}</div>
                            <div class="lu-top__toolbar">
                                <button type="button" id="statusGraphScope" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--default lu-tooltip" data-toggle="lu-tooltip" data-title="{$lang.edcUi.scope}">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i><span class="tooltiptext">{$lang.edcUi.scope}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <div id="statusGraph" class="lu-graph"></div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
</div>
