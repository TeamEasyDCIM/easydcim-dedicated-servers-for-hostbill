<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/chart.js"></script>
<script src="{$assetsURL}/js/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="{$assetsURL}/js/aggregateTraffic.js"></script>
<script src="{$assetsURL}/js/ping.js"></script>
<script src="{$assetsURL}/js/status.js"></script>
<div id="layers">
    {if $configuration.AggregateTraffic == 'on'}
        <div class="lu-row">
            <div class="lu-col-md-12">
                <div class="lu-widget">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">
                                {$lang.serverAA.servicePageIntegration.mainContainer.aggregateTraffic.title}
                            </div>
                            <div class="lu-top__toolbar">
                                <a data-toggle="modal" data-target="#aggregateModal" onclick="showTrafficModal()">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <canvas id="aggregateTraffic" style="height: 400px;"></canvas>
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
                            <div class="lu-top__title">
                                {$lang.serverAA.servicePageIntegration.mainContainer.pingGraph.title}
                            </div>
                            <div class="lu-top__toolbar">
                                <a data-toggle="modal" data-target="#pingModal" onclick="showPingModal()">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <canvas id="pingGraph" style="height: 400px;"></canvas>
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
                            <div class="lu-top__title">
                                {$lang.serverAA.servicePageIntegration.mainContainer.statusGraph.title}
                            </div>
                            <div class="lu-top__toolbar">
                                <a data-toggle="modal" data-target="#statusModal" onclick="showStatusModal()">
                                    <i class="lu-btn__icon lu-zmdi lu-zmdi-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lu-widget__body">
                        <canvas id="statusGraph" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    {/if}


    <div id="confirmationModal1" class="lu-modal lu-modal--md">
        <div class="lu-modal__dialog">
            <div id="mgModalContainer" class="lu-modal__content">
                <div class="lu-modal__top lu-top">
                    <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">
                        Scope                    </span></div>
                    <div class="lu-top__toolbar">
                        <button data-dismiss="lu-modal" aria-label="Close"
                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="hideTrafficModal()">
                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>
                    </div>
                </div>
                <div class="lu-modal__body">
                    <div class="lu-row">
                        <div class="lu-col-md-12">
                            <form>
                                <div class="lu-form-group">
                                    <label class="lu-form-label"> Period </label>
                                    <select id="scope3" class="mg-select2">
                                        <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                                        <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                                        <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                                        <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                                        <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                                        <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                                        <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                                        <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="lu-modal__actions">
                    <button id="reloadAggregateTraffic" class="lu-btn lu-btn--success submitForm mg-submit-form">
                        Save Changes
                    </button>
                    <a class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain" onclick="hideTrafficModal()">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal2" class="lu-modal lu-modal--md">
        <div class="lu-modal__dialog">
            <div id="mgModalContainer" class="lu-modal__content">
                <div class="lu-modal__top lu-top">
                    <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">
                        Scope                    </span></div>
                    <div class="lu-top__toolbar">
                        <button data-dismiss="lu-modal" aria-label="Close"
                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="hidePingModal()">
                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>
                    </div>
                </div>
                <div class="lu-modal__body">
                    <div class="lu-row">
                        <div class="lu-col-md-12">
                            <form>
                                <div class="lu-form-group">
                                    <label class="lu-form-label"> Period </label>
                                    <select id="scope2" class="mg-select2">
                                        <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                                        <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                                        <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                                        <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                                        <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                                        <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                                        <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                                        <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="lu-modal__actions">
                    <button id="reloadpingGraph" class="lu-btn lu-btn--success submitForm mg-submit-form">
                        Save Changes
                    </button>
                    <a class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain" onclick="hidePingModal()">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal3" class="lu-modal lu-modal--md">
        <div class="lu-modal__dialog">
            <div id="mgModalContainer" class="lu-modal__content">
                <div class="lu-modal__top lu-top">
                    <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">
                        Scope                    </span></div>
                    <div class="lu-top__toolbar">
                        <button data-dismiss="lu-modal" aria-label="Close"
                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="hideStatusModal()">
                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>
                    </div>
                </div>
                <div class="lu-modal__body">
                    <div class="lu-row">
                        <div class="lu-col-md-12">
                            <form>
                                <div class="lu-form-group">
                                    <label class="lu-form-label"> Period </label>
                                    <select id="scope" class="mg-select2">
                                        <option value="td">{$lang.serverAA.adminServicesTabFields.today}</option>
                                        <option value="yd">{$lang.serverAA.adminServicesTabFields.yesterday}</option>
                                        <option value="tw">{$lang.serverAA.adminServicesTabFields.this_1week}</option>
                                        <option value="lw">{$lang.serverAA.adminServicesTabFields.last_1week}</option>
                                        <option value="tm">{$lang.serverAA.adminServicesTabFields.this_1month}</option>
                                        <option value="lm">{$lang.serverAA.adminServicesTabFields.last_1month}</option>
                                        <option value="ty">{$lang.serverAA.adminServicesTabFields.this_1year}</option>
                                        <option value="ly">{$lang.serverAA.adminServicesTabFields.last_1year}</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="lu-modal__actions">
                    <button id="reloadstatusGraph" class="lu-btn lu-btn--success submitForm mg-submit-form">
                        Save Changes
                    </button>
                    <a class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain" onclick="hideStatusModal()">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


