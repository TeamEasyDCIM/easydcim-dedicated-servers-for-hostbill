<link href="{$assetsURL}/css/fonts.css" rel="stylesheet">
<link rel="stylesheet" href="{$assetsURL}/css/datatables.min.css">
<link rel="stylesheet" href="{$assetsURL}/css/layers-ui.css">
<link rel="stylesheet" href="{$assetsURL}/css/mg_styles.css">
<link rel="stylesheet" href="{$assetsURL}/css/select2.css">
<script src="{$assetsURL}/js/datatables.js"></script>
<script src="{$assetsURL}/js/select2.js"></script>
<script src="{$assetsURL}/js/accessList.js"></script>
<script src="{$assetsURL}/js/index.js"></script>

<div id="layers">
    <div class="lu-row">
        <div class="lu-col-md-12">
            <div class="lu-widget">
                <div class="lu-widget__header">
                    <div class="lu-widget__top lu-top">
                        <div class="lu-top__title">
                            {$lang.serverCA.accessList.mainContainer.accessListTable.accessListTable}
                        </div>
                    </div>
                </div>
                <div class="lu-widget__body">
                    <div data-table-container="" data-check-container=""
                         class="lu-t-c  datatableLoader">
                        <div class="dataTables_wrapper no-footer">
                            <div>
                                <table id="accessListTable" width="100%" role="grid"
                                       class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">
                                    <thead>
                                    <tr role="row">
                                        <th aria-sort="descending" name="name" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.accessList.mainContainer.accessListTable.table.name}  </span></th>
                                        <th aria-sort="descending" name="username" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.accessList.mainContainer.accessListTable.table.username}  </span></th>
                                        <th aria-sort="descending" name="password" class="sorting "><span
                                                    class="lu-table__text">{$lang.serverCA.accessList.mainContainer.accessListTable.table.password}  </span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$accessList key=myId item=i}
                                        <tr role="row">
                                            <td>{$i.name}</td>
                                            <td>{$i.username}</td>
                                            <td>
                                                <span class="password_element"><input class="elementPasswordInput"
                                                                                      type="password" value="{$i.password}"
                                                                                      readonly=""><i
                                                            class="elementPasswordIcon lu-zmdi lu-zmdi-eye-off"
                                                            onclick="changePasswordElement(this)"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                                <div style="padding: 15px; text-align: center; border-top: 1px solid rgb(233, 235, 240); display: none;">
                                    No Data Available
                                </div>
                                <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay"
                                     style="display: none;">
                                    <div class="lu-preloader lu-preloader--sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>