<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\GetOrderActionsListRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ServiceAccessLevel\ListServiceAccessLevelsRequest;

class AutomationSettings
{
    /**
     * Order actions are listed per item type; this module provisions servers.
     */
    protected const ITEM_TYPE = 'Server';

    /**
     * Service events an action list can be attached to.
     */
    public const ORDER_ACTION_EVENTS = ['activate', 'suspend', 'unsuspend', 'terminate'];

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel\ServiceAccessLevelData>
     */
    public function getAccessLevelList()
    {
        try {
            return $this->api->admin()->accessLevels()->listAll(new ListServiceAccessLevelsRequest());
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * Provisioning actions EasyDCIM can run for one service event.
     *
     * @param string $event activate|suspend|unsuspend|terminate
     * @return array<string, string> action key => label
     */
    public function getOrderActionsList(string $event): array
    {
        try {
            $response = $this->api->admin()->orders()->getActionsList(
                new GetOrderActionsListRequest(type: self::ITEM_TYPE, action: $event)
            );

            return (array) ($response->allActions ?? []);
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * Every event's action list in one call per event, for the product form.
     *
     * @return array<string, array<string, string>>
     */
    public function getAllOrderActions(): array
    {
        $actions = [];

        foreach (self::ORDER_ACTION_EVENTS as $event) {
            $actions[$event] = $this->getOrderActionsList($event);
        }

        return $actions;
    }
}
