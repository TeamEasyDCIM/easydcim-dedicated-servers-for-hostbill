<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderCreate;

/**
 * Description of Order
 *
 * @author Mateusz Pawłowski
 */
class Order extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM Order - Suspend Service
     * @documentation https://www.easydcim.com/api/index.html#api-Order-suspendService
     * @return json object
     * @throws string error
     */
    public function suspend()
    {

        return $this->api->post()->execut('order/' . $this->params->getEasyOrderID() . '/service/suspend');
    }

    /**
     * EasyDCIM Order - Un-suspend Service
     * @documentation https://www.easydcim.com/api/index.html#api-Order-unsuspendService
     * @return JSON object
     * @throws string error
     */
    public function unsuspend()
    {
        return $this->api->post()->execut('order/' . $this->params->getEasyOrderID() . '/service/unsuspend');
    }

    /**
     * EasyDCIM Order - Terminate Service
     * @documentation https://www.easydcim.com/api/index.html#api-Order-terminateService
     * @return JSON object
     * @throws string error
     */
    public function terminate()
    {
        return $this->api->post()->execut('order/' . $this->params->getEasyOrderID() . '/service/terminate');
    }

    /**
     * EasyDCIM Order - Creates a new order
     * @documentation https://www.easydcim.com/api/index.html#api-Order-terminateService
     * @return JSON object
     * @throws string error
     */
    public function create(OrderCreate $model)
    {
        return $this->api->post($model->toArray())->execut('order');
    }

    /**
     * EasyDCIM Order - Show specified order
     * @documentation https://www.easydcim.com/api/index.html#api-Order-showOrder
     * @return JSON object
     * @throws string error
     */
    public function getOrder($orderId = null)
    {
        if ($orderId !== null)
        {
            return $this->api->get()->execut('order/' . $orderId);
        }
        return $this->api->get()->execut('order/' . $this->params->getEasyOrderID());
    }

    /**
     * EasyDCIM Order - Related server
     * @documentation https://www.easydcim.com/api/index.html#api-Order-relatedServer
     * @return JSON object
     * @throws string error
     */
    public function getRelatedServer()
    {
        return $this->api->get()->execut('order/' . $this->params->getEasyOrderID() . '/related/device');
    }

}
