<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Field data structure
 */
class FieldData
{
    public ?int $id;
    public ?string $relatedType;
    public ?string $element;
    public ?string $group;
    public ?string $slug;
    public ?string $label;
    public ?array $options;
    public ?int $predefined;
    public ?int $hidden;
    public ?int $provisionable;
    public ?int $combined;
    public ?int $filterable;
    public ?string $filterableType;
    public ?int $unique;
    public ?int $sortable;
    public ?int $encrypted;
    public ?array $additionalRules;
    public ?int $order;
    public ?array $types;
    public ?string $createdAt;
    public ?string $updatedAt;
    public ?array $values;
    public function __construct(?int $id, ?string $relatedType, ?string $element, ?string $group, ?string $slug, ?string $label, ?array $options, ?int $predefined, ?int $hidden, ?int $provisionable, ?int $combined, ?int $filterable, ?string $filterableType, ?int $unique, ?int $sortable, ?int $encrypted, ?array $additionalRules, ?int $order, ?array $types, ?string $createdAt, ?string $updatedAt, ?array $values = null)
    {
        $this->id = $id;
        $this->relatedType = $relatedType;
        $this->element = $element;
        $this->group = $group;
        $this->slug = $slug;
        $this->label = $label;
        $this->options = $options;
        $this->predefined = $predefined;
        $this->hidden = $hidden;
        $this->provisionable = $provisionable;
        $this->combined = $combined;
        $this->filterable = $filterable;
        $this->filterableType = $filterableType;
        $this->unique = $unique;
        $this->sortable = $sortable;
        $this->encrypted = $encrypted;
        $this->additionalRules = $additionalRules;
        $this->order = $order;
        $this->types = $types;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->values = $values;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'related_type'),
            Arr::get($data, 'element', ''),
            Arr::get($data, 'group', ''),
            Arr::get($data, 'slug', ''),
            Arr::get($data, 'label', ''),
            Arr::get($data, 'options', []),
            Arr::get($data, 'predefined', 0),
            Arr::get($data, 'hidden', 0),
            Arr::get($data, 'provisionable', 0),
            Arr::get($data, 'combined', 0),
            Arr::get($data, 'filterable', 0),
            Arr::get($data, 'filterable_type'),
            Arr::get($data, 'unique', 0),
            Arr::get($data, 'sortable', 0),
            Arr::get($data, 'encrypted', 0),
            Arr::get($data, 'additional_rules', []),
            Arr::get($data, 'order', 0),
            Arr::get($data, 'types', []),
            Arr::get($data, 'created_at', ''),
            Arr::get($data, 'updated_at', ''),
            Arr::get($data, 'values')
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
