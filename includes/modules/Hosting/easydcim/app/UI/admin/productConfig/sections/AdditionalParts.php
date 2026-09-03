<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel\ListItemModelsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType\ListItemTypesRequest;

class AdditionalParts
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getTypes($type)
    {
        if ($type != '')
        {
            self::jsonEncode($this->getOptions($type));
        }
        else
        {
            self::jsonEncode([]);
        }
    }

    public function getParts($data)
    {
        if (is_array($data))
        {
            self::jsonEncode($data);
        }else{
            self::jsonEncode([]);
        }
    }

    /**
     * Item models of one part type, as select2 key/value pairs.
     *
     * The page sends the type either as an ID (the part rows) or as a name
     * such as "HDD" (the configurable-option modal), so both are accepted.
     */
    protected function getOptions($type)
    {
        $typeId = $this->resolveTypeId($type);

        if ($typeId === null)
        {
            return [];
        }

        $options = [];

        try {
            $models = $this->api->admin()->itemModels()->listAll(new ListItemModelsRequest(
                searchTerm: (string) $typeId,
                searchOp: 'eq',
                searchFields: 'type_id'
            ));
        } catch (\Exception $ex) {
            return [];
        }

        foreach ($models as $model) {
            $options[] = [
                'key'   => $model->id,
                'value' => $model->name
            ];
        }

        return $options;
    }

    /**
     * @param int|string $type an item type ID or its name
     */
    protected function resolveTypeId($type): ?int
    {
        if (is_numeric($type))
        {
            return (int) $type;
        }

        try {
            $types = $this->api->admin()->itemTypes()->listAll(new ListItemTypesRequest(
                searchTerm: (string) $type,
                searchOp: 'eq',
                searchFields: 'name'
            ));
        } catch (\Exception $ex) {
            return null;
        }

        $first = reset($types);

        return $first ? (int) $first->id : null;
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }
}
