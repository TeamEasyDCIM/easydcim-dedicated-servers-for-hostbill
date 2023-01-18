<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces;

/**
 * Description of IClient
 *
 * @author Mateusz Pawłowski
 */
interface IClient
{

    public function getServerHostname();

    public function getServerAPIKey();

    public function getAccountID();

    public function getServiceID();

    public function getUserID();

    public function getUsername();

    public function getPassword();

    public function getFirstName();

    public function getLastName();

    public function getFullName();

    public function getCompanyName();

    public function getEmail();

    public function getAddress1();

    public function getAddress2();

    public function getCity();

    public function getFullState();

    public function getState();

    public function getPostCode();

    public function getCountryCode();

    public function getCountry();

    public function getPhoneNumber();

    public function getCountryName();

    public function getProductID();

    public function getLocationID();

    public function getModelID();

    public function getAutoAccept();

    public function getAcccessLevel();

    public function getSuspendAction();

    public function getSuspendActionTemplate();

    public function getUnsuspendAction();

    public function getUnsuspendActionTemplate();

    public function getTerminateAction();

    public function getTerminateActiontemplate();

    public function getAdminis();

    public function getEasyOrderID();

    public function getEasyServerID();

    public function getTrafficAction();

    public function getPowerUsageAction();

    public function getPowerOutletsAction();
}
