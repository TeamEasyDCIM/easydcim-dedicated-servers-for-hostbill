<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

class OrderMetadataContainer
{
    private $data = [];

    public function set(string $id, string $value): void
    {
        $this->data[$id]['value'] = $value;
    }

    public function get(string $id): ?string
    {
        return $this->data[$id]['value'] ?? null;
    }

    public function getAll(): array
    {
        return $this->data;
    }
}