<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\DNS\DataContainer;

class DnsManager extends AbstractEasyDCIMAPI
{
    /**
     * EasyDCIM DNS_Management - Get rDNS records
     * @documentation https://www.easydcim.com/api/index.html#api-DNS_Management-GetRDNS
     * @return JSON object
     * @throws string error
     */
    public function getRecords()
    {
        return $this->api->get()->execut('dns-manager/rdns/' . $this->params->getEasyServerID());
    }

    /**
     * EasyDCIM DNS_Management - Create rDNS record
     * @documentation https://www.easydcim.com/api/index.html#api-DNS_Management-CreateRDNS
     * @return JSON object
     * @throws string error
     */
    public function createRecord(DataContainer $model)
    {
        return $this->api->post($model->toArray())->execut('dns-manager/rdns/' . $this->params->getEasyServerID());
    }

    /**
     * EasyDCIM DNS_Management - Delete rDNS record
     * @documentation https://www.easydcim.com/api/index.html#api-DNS_Management-DeleteRDNS
     * @return JSON object
     * @throws string error
     */
    public function deleteRecord($recordID)
    {
        return $this->api->delete()->execut('dns-manager/rdns/' . $recordID);
    }

    /**
     * EasyDCIM DNS_Management - Delete rDNS record
     * @documentation https://www.easydcim.com/api/index.html#api-DNS_Management-DeleteRDNS
     * @return JSON object
     * @throws string error
     */
    public function updateRecord($recordID, DataContainer $model)
    {
        return $this->api->put($model->toArray())->execut('dns-manager/rdns/' . $recordID);
    }
}