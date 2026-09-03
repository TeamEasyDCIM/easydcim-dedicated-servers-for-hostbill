<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Field data structure
 */
class FieldData
{
    public function __construct(
        public ?int $id,
        public ?string $relatedType,
        public ?string $element,
        public ?string $group,
        public ?string $slug,
        public ?string $label,
        public ?array $options,
        public ?int $predefined,
        public ?int $hidden,
        public ?int $provisionable,
        public ?int $combined,
        public ?int $filterable,
        public ?string $filterableType,
        public ?int $unique,
        public ?int $sortable,
        public ?int $encrypted,
        public ?array $additionalRules,
        public ?int $order,
        public ?array $types,
        public ?string $createdAt,
        public ?string $updatedAt,
        public ?array $values = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            relatedType: Arr::get($data, 'related_type'),
            element: Arr::get($data, 'element', ''),
            group: Arr::get($data, 'group', ''),
            slug: Arr::get($data, 'slug', ''),
            label: Arr::get($data, 'label', ''),
            options: Arr::get($data, 'options', []),
            predefined: Arr::get($data, 'predefined', 0),
            hidden: Arr::get($data, 'hidden', 0),
            provisionable: Arr::get($data, 'provisionable', 0),
            combined: Arr::get($data, 'combined', 0),
            filterable: Arr::get($data, 'filterable', 0),
            filterableType: Arr::get($data, 'filterable_type'),
            unique: Arr::get($data, 'unique', 0),
            sortable: Arr::get($data, 'sortable', 0),
            encrypted: Arr::get($data, 'encrypted', 0),
            additionalRules: Arr::get($data, 'additional_rules', []),
            order: Arr::get($data, 'order', 0),
            types: Arr::get($data, 'types', []),
            createdAt: Arr::get($data, 'created_at', ''),
            updatedAt: Arr::get($data, 'updated_at', ''),
            values: Arr::get($data, 'values'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'id' => $this->id,
            'related_type' => $this->relatedType,
            'element' => $this->element,
            'group' => $this->group,
            'slug' => $this->slug,
            'label' => $this->label,
            'options' => $this->options,
            'predefined' => $this->predefined,
            'hidden' => $this->hidden,
            'provisionable' => $this->provisionable,
            'combined' => $this->combined,
            'filterable' => $this->filterable,
            'filterable_type' => $this->filterableType,
            'unique' => $this->unique,
            'sortable' => $this->sortable,
            'encrypted' => $this->encrypted,
            'additional_rules' => $this->additionalRules,
            'order' => $this->order,
            'types' => $this->types,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];

        if ($this->values !== null) {
            $result['values'] = $this->values;
        }

        return $result;
    }
}
