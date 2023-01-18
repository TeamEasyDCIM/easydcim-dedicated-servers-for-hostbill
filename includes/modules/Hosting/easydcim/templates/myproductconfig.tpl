<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<link rel="stylesheet" href="{$assetsURL}/css/buttonLoader.css">
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/productconfig.js"></script>
<script src="{$assetsURL}/js/jquery.buttonLoader.js"></script>
<div id="layers">
    <div class="lu-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.defaultOptions}
                </div>
            </div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content">
                <div class="lu-alert lu-alert--sm lu-alert--info lu-alert--faded modal-alert-top">
                    <div class="lu-alert__body">
                        {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.message}
                    </div>
                </div>
                <div class="lu-row">
                    <div id="igRow" class="lu-col-md-12 ">
                        <div id="igRow" class="lu-col-md-12 ">
                            <div class="lu-form-group">
                                <label for="ModelID" class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.ModelID.ModelID}
                                    <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.ModelID.description}" data-toggle="lu-tooltip"
                                       class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target drop-enabled drop-abutted-top drop-element-attached-bottom
                                       drop-element-attached-center drop-target-attached-top drop-target-attached-center">
                                        <span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.ModelID.description}</span></i>
                                </label>
                                <select name="options[ModelID]" id="ModelID" class="mg-select2" >
                                    {foreach from=$modelList item=model }
                                        <option {if $moduleConfiguration->ModelID == $model->id}selected{/if} value="{$model->id}">{$model->name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="lu-form-group">
                                <label class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.LocationID.LocationID}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.LocationID.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.LocationID.description}</span></i>
                                </label>
                                <select name="options[LocationID]"  id="LocationID" class="mg-select2" tabindex="-1">
                                    {foreach from=$locationList item=location }
                                        <option {if $moduleConfiguration->LocationID == $location->id}selected{/if} value="{$location->id}">{$location->name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="lu-form-group">
                                <label class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.OsTemplateID.OsTemplateID}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.OsTemplateID.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.OsTemplateID.description}</span></i>
                                </label>
                                <select name="options[OsTemplateID]" id="OsTemplateID" class="mg-select2" tabindex="-1">
                                    {foreach from=$templateList item=template }
                                        <option {if $moduleConfiguration->OsTemplateID == $template->id}selected{/if} value="{$template->id}">{$template->name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="lu-form-group">
                                <label class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.AdditionalIPAddresses.AdditionalIPAddresses}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.AdditionalIPAddresses.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.AdditionalIPAddresses.description}</span></i>
                                </label>
                                <input type="number" placeholder="" name="options[AdditionalIPAddresses]" value="{$moduleConfiguration->AdditionalIPAddresses}" class="lu-form-control">
                            </div>
                            <div class="lu-form-group">
                                <label class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.diskLayoutID.diskLayoutID}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.diskLayoutID.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.diskLayoutID.description}</span></i>
                                </label>
                                <select name="options[diskLayoutID]" id="diskLayoutID" class="mg-select2" tabindex="-1">
                                    {foreach from=$addonsList item=addons }
                                        {if $addons->type == 'disklayout'}
                                            <option {if $moduleConfiguration->diskLayoutID == $addons->id}selected{/if} value="{$addons->id}">{$addons->description}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                            <div class="lu-form-group">
                                <label class="lu-form-label">
                                    {$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.extras.Extras}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.extras.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.defaultOptions.igRow.extras.description}</span></i>
                                </label>
                                <select multiple="multiple" name="options[extras][]" id="Extras" class="mg-select2" tabindex="-1">
                                    {foreach from=$addonsList item=addons }
                                        {if $addons->type != 'disklayout'}
                                            <option  value="{$addons->id}" {if $addons->id|in_array:$moduleConfiguration->extras}selected{/if}>{$addons->description}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lu-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.easyDCIMAutomationSettings}
                </div>
            </div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content">
                <div class="lu-row">
                    <div class="lu-alert lu-alert--sm lu-alert--info lu-alert--faded modal-alert-top">
                        <div class="lu-alert__body">
                            {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.message}
                        </div>
                    </div>
                    <div class="lu-col-md-12">
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.AutoAccept.AutoAccept}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.AutoAccept.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.AutoAccept.description}</span></i>
                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[AutoAccept]" {if $moduleConfiguration->AutoAccept == 'on'}checked{/if} class="lu-switch__checkbox">
                                    <span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequirePDU.RequirePDU}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequirePDU.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequirePDU.description}</span></i>
                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[RequirePDU]" {if $moduleConfiguration->RequirePDU == 'on'}checked{/if} class="lu-switch__checkbox"><span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequireSwitch.RequireSwitch}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequireSwitch.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.RequireSwitch.description}</span></i>
                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[RequireSwitch]" {if $moduleConfiguration->RequireSwitch == 'on'}checked{/if} class="lu-switch__checkbox">                                    <span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.SuspensionAction.SuspensionAction}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.SuspensionAction.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.SuspensionAction.description}</span></i>
                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[SuspensionAction]" {if $moduleConfiguration->SuspensionAction == 'on'}checked{/if} class="lu-switch__checkbox">                                    <span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.UnsuspensionAction.UnsuspensionAction}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.UnsuspensionAction.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.UnsuspensionAction.description}</span></i>                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[UnsuspensionAction]" {if $moduleConfiguration->UnsuspensionAction == 'on'}checked{/if} class="lu-switch__checkbox">
                                    <span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-check lu-m-b-2x">
                            <label>
                            <span class="lu-form-text">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.TerminateAction.TerminateAction}
                                <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.TerminateAction.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center drop-abutted drop-abutted-top"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.TerminateAction.description}</span></i>                            </span>
                                <div class="lu-switch">
                                    <input type="checkbox" name="options[TerminateAction]" {if $moduleConfiguration->TerminateAction == 'on'}checked{/if} class="lu-switch__checkbox">                                    <span class="lu-switch__container">
                                    <span class="lu-switch__handle">

                                    </span>
                                </span>
                                </div>
                            </label>
                        </div>
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.Bandwidth.Bandwidth}<i
                                        data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.Bandwidth.description}"
                                        data-toggle="lu-tooltip"
                                        class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center drop-abutted drop-abutted-top"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.Bandwidth.description}</span></i></label>
                            <input type="number" placeholder="" name="options[Bandwidth]" value="{$moduleConfiguration->Bandwidth}" class="lu-form-control">
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                        <div class="lu-form-group">
                            <label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.serviceAccessID.serviceAccessID}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.serviceAccessID.description}" data-toggle="lu-tooltip" class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.easyDCIMAutomationSettings.igRow.serviceAccessID.description}</span></i>
                            </label>
                            <select name="options[serviceAccessID]" id="serviceAccessID" class="mg-select2">
                                {foreach from=$accessLevelList item=level }
                                    <option {if $moduleConfiguration->serviceAccessID == $level->id}selected{/if} value="{$level->id}">{$level->name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lu-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    {$lang.serverAA.productConfig.mainContainer.configForm.additionalPartsSection.additionalPartsSection}
                </div>
                <div class="lu-top__toolbar"><a href="javascript:;" onclick="appendPartsModal()" class="lu-btn lu-btn--primary"><i
                                class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i> <span class="lu-btn__text">{$lang.serverAA.productConfig.mainContainer.configForm.additionalPartsSection.addPart.button.addPart}</span></a>
                </div>
            </div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content">
                <div class="lu-alert lu-alert--sm lu-alert--info lu-alert--faded modal-alert-top">
                    <div class="lu-alert__body">
                        {$lang.serverAA.configOptions.message}
                    </div>
                </div>
                <div class="lu-row">
                    <div id="additionalPartsRow" class="lu-col-md-12 ">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lu-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.clientAreaFeaturesSection}
                </div>
            </div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content">
                <div class="lu-alert lu-alert--sm lu-alert--info lu-alert--faded modal-alert-top">
                    <div class="lu-alert__body">
                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.message}
                    </div>
                </div>
                <div class="lu-row">
                    <div class="lu-col-md-6">
                        <div id="serviceInfo" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div  class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.serviceInfo}
                                    </div>
                                    <div  class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.serviceInfoSelectAll.serviceInfoSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="serviceInfoSelectAll"
                                                                               class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div  class="lu-widget__body">
                                <div class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.baseFeatures.ServerId.ServerId}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[ServerId]"
                                                                {if $moduleConfiguration->ServerId == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.Label.Label}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Label]"
                                                                                  {if $moduleConfiguration->Label == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.DeviceStatus.DeviceStatus}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[ServerStatus]"
                                                                                  {if $moduleConfiguration->ServerStatus == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.Hostname.Hostname}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[Hostname]"
                                                                                  {if $moduleConfiguration->Hostname == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.ChangeHostname.ChangeHostname}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[ChangeHostname]"
                                                                                  {if $moduleConfiguration->ChangeHostname == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.IPAddresses.IPAddresses}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[IPAddresses]"
                                                                                  {if $moduleConfiguration->IPAddresses == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.CurrentOS.CurrentOS}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[CurrentOS]"
                                                                                  {if $moduleConfiguration->CurrentOS == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.MacAddress.MacAddress}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[MacAddress]"
                                                                                   {if $moduleConfiguration->MacAddress == 'on'}checked{/if}
                                                                                   onchange="checkOptionUnderSection(event)"
                                                                                   class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.InstallationStatus.InstallationStatus}</span>
                                                    <div  class="lu-switch"><input type="checkbox"
                                                                                  name="options[InstallationStatus]"
                                                                                  {if $moduleConfiguration->InstallationStatus == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.serviceInfo.HideHostingInformation.HideHostingInformation}</span>
                                                    <div class="lu-switch"><input type="checkbox"
                                                                                  name="options[HideHostingInformation]"
                                                                                  {if $moduleConfiguration->HideHostingInformation == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-group"><label class="lu-form-label">
                                                    {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.customFeatures.caMetadata.CustomMetadata}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.customFeatures.caMetadata.description}" data-toggle="lu-tooltip"
                                                                       class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"></i></label>
                                                <select multiple="multiple" name="options[caMetadata][]" id="CustomMetadata"
                                                        data-options="removeButton:true; resotreOnBackspace:true; dragAndDrop:true; maxItems: null;"
                                                        class="mg-select2">
                                                    {foreach from=$metadataList item=meta }
                                                        <option  value="{$meta->label}" {if $meta->label|in_array:$moduleConfiguration->caMetadata}selected{/if}>{$meta->label}</option>
                                                    {/foreach}
                                                </select>
                                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="generalInfo" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div  class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.generalInfo}
                                    </div>
                                    <div class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.generalInfoSelectAll.generalInfoSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="generalInfoSelectAll"
                                                                               class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div  class="lu-widget__body">
                                <div  class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.Status.Status}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[StatusInformation]"
                                                                                  {if $moduleConfiguration->StatusInformation == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.OrderID.OrderID}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[OrderId]"
                                                                                  {if $moduleConfiguration->OrderId == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.ServiceStatus.ServiceStatus}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[ServiceStatus]"
                                                                                  {if $moduleConfiguration->ServiceStatus == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.Model.Model}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Model]"
                                                                                  {if $moduleConfiguration->Model == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.SerialNumber.SerialNumber}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[SerialNumber]"
                                                                                  {if $moduleConfiguration->SerialNumber == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.PurchaseDate.PurchaseDate}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[PurchaseDate]"
                                                                                  {if $moduleConfiguration->PurchaseDate == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.generalInfo.WarrantyMonths.WarrantyMonths}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[WarrantyMonths]"
                                                                                  {if $moduleConfiguration->WarrantyMonths == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="locationInfo" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div  class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.locationInfo}
                                    </div>
                                    <div class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.locationInfoSelectAll.locationInfoSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="locationInfoSelectAll"
                                                                              class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div  class="lu-widget__body">
                                <div  class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.Location.Location}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Location]"
                                                                                  {if $moduleConfiguration->Location == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.LabeledRack.LabeledRack}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[LabeledRack]"
                                                                                  {if $moduleConfiguration->LabeledRack == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.Floor.Floor}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Floor]"
                                                                                  {if $moduleConfiguration->Floor == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.Address.Address}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Address]"
                                                                                  {if $moduleConfiguration->Address == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.PhoneNumber.PhoneNumber}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[PhoneNumber]"
                                                                                  {if $moduleConfiguration->PhoneNumber == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.leftSection.locationInfo.Description.Description}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Description]"
                                                                                  {if $moduleConfiguration->Description == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lu-col-md-6">
                        <div id="graphTypes" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div  class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.graphTypes.graphTypes}
                                    </div>
                                    <div class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.graphTypes.graphTypesSelectAll.graphTypesSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="graphTypesSelectAll"
                                                                               class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div  class="lu-widget__body">
                                <div class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.graphTypes.Ping.Ping}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Ping]"
                                                                                  {if $moduleConfiguration->Ping == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.graphTypes.Status.Status}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[Status]"
                                                                                  {if $moduleConfiguration->Status == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.graphTypes.AggregateTraffic.AggregateTraffic}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[AggregateTraffic]"
                                                                                  {if $moduleConfiguration->AggregateTraffic == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="serverActions" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.serverActions}
                                    </div>
                                    <div class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.serverActionsSelectAll.serverActionsSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="serverActionsSelectAll"
                                                                               class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.RebootServer.RebootServer}</span>
                                                    <div  class="lu-switch"><input type="checkbox" name="options[RebootServer]"
                                                                                  {if $moduleConfiguration->RebootServer == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.BootServer.BootServer}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[BootServer]"
                                                                                  {if $moduleConfiguration->BootServer == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.ShutdownServer.ShutdownServer}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[ShutdownServer]"
                                                                                  {if $moduleConfiguration->ShutdownServer == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.BMCColdReset.BMCColdReset}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[BMCColdReset]"
                                                                                  {if $moduleConfiguration->BMCColdReset == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.RescueMode.RescueMode}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[RescueMode]"
                                                                                  {if $moduleConfiguration->RescueMode == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.AutoLoginLink.AutoLoginLink}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[AutoLoginLink]"
                                                                                  {if $moduleConfiguration->AutoLoginLink == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.KVMJavaConsole.KVMJavaConsole}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[KVMJavaConsole]"
                                                                                  {if $moduleConfiguration->KVMJavaConsole == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.serverActions.noVNCKVMConsole.noVNCKVMConsole}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[noVNCKVMConsole]"
                                                                                  {if $moduleConfiguration->noVNCKVMConsole == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modules" class="lu-widget">
                            <div class="lu-widget__header">
                                <div class="lu-widget__top lu-top">
                                    <div class="lu-top__title">
                                        {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.modules}
                                    </div>
                                    <div class="lu-top__toolbar" style="padding-top: 15px;">
                                        <div onchange="checkSection('',[],event)"
                                             class="lu-form-check lu-m-b-2x configSelectAllButton"><label><span
                                                        class="lu-form-text">
                            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.modulesSelectAll.modulesSelectAll}</span>
                                                <div class="lu-switch"><input type="checkbox" name="modulesSelectAll"
                                                                               class="lu-switch__checkbox">
                                                    <span class="lu-switch__container"><span
                                                                class="lu-switch__handle"></span></span></div>
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="lu-widget__body">
                                <div class="lu-widget__content">
                                    <div class="lu-row">
                                        <div class="lu-col-md-6 lu-p-r-4x">
                                            <div  class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.DevicesTraffic.DevicesTraffic}</span>
                                                    <div class="lu-switch"><input type="checkbox"
                                                                                  name="options[TrafficStatistics]"
                                                                                  {if $moduleConfiguration->TrafficStatistics == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.OsInstallation.OsInstallation}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[OsInstallation]"
                                                                                  {if $moduleConfiguration->OsInstallation == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.DNSManager.DNSManager}</span>
                                                    <div class="lu-switch"><input type="checkbox" name="options[DNSManager]"
                                                                                  {if $moduleConfiguration->DNSManager == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">
            {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.rightSection.modules.PasswordManagement.PasswordManagement}</span>
                                                    <div class="lu-switch"><input type="checkbox"
                                                                                  name="options[PasswordManagement]"
                                                                                  {if $moduleConfiguration->PasswordManagement == 'on'}checked{/if}
                                                                                  onchange="checkOptionUnderSection(event)"
                                                                                  class="lu-switch__checkbox"> <span
                                                                class="lu-switch__container"><span class="lu-switch__handle"></span></span>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lu-col-md-12">
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.customFeatures.caTemplates.OsTemplates}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.clientAreaFeaturesSection.customFeatures.caTemplates.description}" data-toggle="lu-tooltip"
                                                class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target drop-abutted drop-abutted-top drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center"></i></label>
                            <select multiple="multiple" name="options[caTemplates][]" id="OsTemplates"
                                    data-options="removeButton:true; resotreOnBackspace:true; dragAndDrop:true; maxItems: null;"
                                    class="mg-select2">
                                {foreach from=$caTemplateList item=template }
                                    <option value="{$template->name}_{$template->id}" {if $template->id|in_array:$moduleConfiguration->caTemplates}selected{/if}>{$template->name}</option>
                                {/foreach}
                            </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lu-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.serviceNotification}
                </div>
            </div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content">
                <div class="lu-row">
                    <div class="lu-col-md-6 lu-p-r-4x">
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.CreateServerNotification.CreateServerNotification}<i
                                        data-title="{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.CreateServerNotification.description}"
                                        data-toggle="lu-tooltip"
                                        class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.CreateServerNotification.description}</span></i></label>
                            <select name="options[CreateServerNotification]" id="CreateServerNotification"
                                    class="mg-select2" tabindex="-1">
                                {foreach from=$clientEmailTemplateList item=emailTemplate }
                                    <option {if $moduleConfiguration->CreateServerNotification == $emailTemplate->id}selected{/if} value="{$emailTemplate->id}">{$emailTemplate->tplname}</option>
                                {/foreach}                               </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.SuspensionTemplate.SuspensionTemplate} <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.SuspensionTemplate.description}" data-toggle="lu-tooltip"
                                                       class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.SuspensionTemplate.description}</span></i></label>
                            <select name="options[SuspensionTemplate]" id="SuspensionTemplate"
                                    class="mg-select2" tabindex="-1">
                                {foreach from=$adminEmailTemplateList item=emailTemplate }
                                    <option {if $moduleConfiguration->SuspensionTemplate == $emailTemplate->id}selected{/if} value="{$emailTemplate->id}">{$emailTemplate->tplname}</option>
                                {/foreach}                                </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.TerminateTemplate.TerminateTemplate} <i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.TerminateTemplate.description}" data-toggle="lu-tooltip"
                                                      class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.TerminateTemplate.description}</span></i></label>
                            <select name="options[TerminateTemplate]" id="TerminateTemplate"
                                    class="mg-select2" tabindex="-1">
                                {foreach from=$adminEmailTemplateList item=emailTemplate }
                                    <option {if $moduleConfiguration->TerminateTemplate == $emailTemplate->id}selected{/if} value="{$emailTemplate->id}">{$emailTemplate->tplname}</option>
                                {/foreach}                            </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                    </div>
                    <div class="lu-col-md-6">
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.adminID.adminID} <i
                                        data-title="{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.adminID.description}"
                                        data-toggle="lu-tooltip"
                                        class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.adminID.description}</span></i></label>
                            <select name="options[adminID]" id="adminID" class="mg-select2"
                                    tabindex="-1">
                                {foreach from=$adminList item=admin }
                                    <option {if $moduleConfiguration->adminID == $admin->id}selected{/if} value="{$admin->id}">{$admin->firstname} {$admin->lastname}</option>
                                {/foreach}                            </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                        <div class="lu-form-group"><label class="lu-form-label">
                                {$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.UnsuspensionTemplate.UnsuspensionTemplate}<i data-title="{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.UnsuspensionTemplate.description}" data-toggle="lu-tooltip"
                                                         class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">{$lang.serverAA.productConfig.mainContainer.configForm.serviceNotification.hps.UnsuspensionTemplate.description}</span></i></label>
                            <select name="options[UnsuspensionTemplate]" id="UnsuspensionTemplate"
                                    class="mg-select2" tabindex="-1">
                                {foreach from=$adminEmailTemplateList item=emailTemplate }
                                    <option {if $moduleConfiguration->UnsuspensionTemplate == $emailTemplate->id}selected{/if} value="{$emailTemplate->id}">{$emailTemplate->tplname}</option>
                                {/foreach}                                </select>
                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="optionsWidget" class="lu-widget mg-configurable-options-panel mg-configurable-options-widget">
        <div class="lu-widget__header">
            <div class="lu-widget__top lu-top">
                <div class="lu-top__title">
                    Configurable Options
                </div>
            </div>
            <div class="lu-top__toolbar"></div>
        </div>
        <div class="lu-widget__body">
            <div class="lu-widget__content config-option-box">
                <div class="col-md-12 confirm-row">
                    <a id="first" href="javascript:;" class="lu-btn lu-btn--success has-spinner" onclick="createConfigurableOptions(this)">
                        <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                        <span class="lu-btn__text">Create Configurable Options</span>
                    </a>
                    <a id="second" href="javascript:;" class="lu-btn lu-btn--success has-spinner" onclick="appendConfigurableOptionsPartsModal()">
                        <i class="lu-btn__icon lu-zmdi lu-zmdi-plus"></i>
                        <span class="lu-btn__text">Create Configurable Options For Parts</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>