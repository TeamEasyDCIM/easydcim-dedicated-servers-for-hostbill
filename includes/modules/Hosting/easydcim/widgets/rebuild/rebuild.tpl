<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/noty.css">
<link rel="stylesheet" href="{$assetsURL}/css/layout.css">
<link rel="stylesheet" href="{$assetsURL}/css/alert.css">
<link rel="stylesheet" href="{$assetsURL}/css/font-awesome.css">
<link rel="stylesheet" href="{$assetsURL}/css/table.css">
<link rel="stylesheet" href="{$assetsURL}/css/panels.css">
<link rel="stylesheet" href="{$assetsURL}/css/boxes.css">
<link rel="stylesheet" href="{$assetsURL}/css/buttons.css">
<link rel="stylesheet" href="{$assetsURL}/css/helpers.css">
<link rel="stylesheet" href="{$assetsURL}/css/loader.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/index.js"></script>
<script src="{$assetsURL}/js/rebuild.js"></script>
<div id="layers">
</div>
{*<pre>{$installationInformation|@print_r}</pre>*}
<div class="newbox panel-no-padding">
    <div class="panel panel-default">
        <div class="panel-title panel-move">
            <h6 class="text-black">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.reinstall}</h6>
        </div>
        <div class="panel-body">
            <input id="instalationStatusForReload" type="hidden" value="{$installationInformation.installationStatus}">
            <table class="table newlayout">
                <tbody>
                <tr>
                    <td><span class="text-muted">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.currentOS}</span></td>
                    {if $installationInformation.osIsCurrentlyBeingInstalled eq 'NO'}
                        {if $installationInformation.currentOS eq ''}
                            <td>{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.currentOS}</td>
                        {else}
                            <td><img width="32" height="32" src="{$installationInformation.path}"> {$installationInformation.currentOS}</td>
                        {/if}
                    {else}
                    <td><img width="32" height="32" src="{$installationInformation.path}"> {$installationInformation.currentOS} - <b>{$installationInformation.installationStatus}</b> <div class="icon-container">
                            <i class="loader"></i>
                        </div></td>
                    {/if}
                </tr>
                <tr>
                    <td><span class="text-muted">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.hostInformation}</span></td>
                    <td>{$installationInformation.hostInformation}</td>
                </tr>
                <tr>
                    <td><span class="text-muted">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.macAddress}</span></td>
                    <td>{$installationInformation.macAddress}</td>
                </tr>
                <tr>
                    <td><span class="text-muted">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.osIsCurrentlyBeingInstalled}</span></td>
                    {if $installationInformation.osIsCurrentlyBeingInstalled eq 'YES'}
                        <td class="text-green">Yes</td>
                    {else}
                        <td>No</td>
                    {/if}
                </tr>
                <tr>
                    <td><span class="text-muted">{$lang.serverCA.rebuild.mainContainer.osInstalationTable.table.actions}</span></td>
                    <td>

                        {if $installationInformation.osIsCurrentlyBeingInstalled eq 'NO'}
                            <a onclick='generateRBModal(this,{$jsonEncodeinstallationInformation},{$caTemplates})' class="easy-btn easy-btn-primary easy-btn-sm" style="cursor: pointer;">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Reinstall OS</a>
                        {else}
                            <a onclick='generateCIModal(this,{$jsonEncodeinstallationInformation})' data-edc-modal="1" class="easy-btn easy-btn-danger easy-btn-sm" data-edc-modal-init="true" style="cursor: pointer;">
                                <i class="fa fa-ban" aria-hidden="true"></i> Cancel Installation</a>
                        {/if}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


