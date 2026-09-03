<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph;

enum DeviceSelectionEnum: string
{
    case ALL    = 'all';
    case SERVER = 'server';
    case ORDER  = 'order';
}
