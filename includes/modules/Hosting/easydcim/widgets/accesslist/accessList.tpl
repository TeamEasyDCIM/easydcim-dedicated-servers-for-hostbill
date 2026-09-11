<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<script src="{$assetsURL}/js/index.js"></script>
<script>window.EdcLang = {$edcLang|default:'null'};</script>
<script src="{$assetsURL}/js/edcUi.js"></script>
<script src="{$assetsURL}/js/accessList.js"></script>
{* The WHMCS AccessListTable: pages, no search; the password shows as ****** until clicked. *}
<div id="layers" data-edc-service="{$serviceId}">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div id="accessListTable" class="lu-widget">
                <div class="lu-widget__body">
                    <div class="lu-widget__header">
                        <div class="lu-widget__top lu-top">
                            <div class="lu-top__title">{$lang.edcUi.access_list}</div>
                        </div>
                    </div>
                    <div class="lu-t-c datatableLoader" data-table-container data-check-container>
                        <div class="dataTables_wrapper no-footer">
                            <div class="lu-d-grid">
                                <table class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th name="name"><span class="lu-table__text">{$lang.edcUi.al_name}</span></th>
                                        <th name="username"><span class="lu-table__text">{$lang.edcUi.al_username}</span></th>
                                        <th name="password"><span class="lu-table__text">{$lang.edcUi.al_password}</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$accessList item=i}
                                    <tr class="lu-table-row">
                                        <td><div>{$i.name|escape}</div></td>
                                        <td><div>{$i.username|escape}</div></td>
                                        <td><span class="copy-text-inline-component">{if $i.password != ''}<span role="button" data-edc-secret="{$i.password|escape}">******</span>{/if}</span></td>
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
