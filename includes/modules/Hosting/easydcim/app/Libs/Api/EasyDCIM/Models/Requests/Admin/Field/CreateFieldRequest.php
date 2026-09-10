<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Field;

/**
 * Request for creating a custom field
 */
class CreateFieldRequest
{
    public string $element;
    public string $group;
    public string $slug;
    public string $label;
    public ?string $options;
    public ?bool $hidden;
    public ?bool $provisionable;
    public ?bool $combined;
    public ?bool $filterable;
    public ?string $filterableType;
    public ?bool $unique;
    public ?bool $sortable;
    public ?bool $encrypted;
    public ?array $additionalRules;
    public ?int $order;
    public ?array $types;
    /**
     * @param string $element Field element type
     * @param string $group Field group
     * @param string $slug Field slug
     * @param string $label Field label
     * @param string|null $options Field options (comma-separated or JSON)
     * @param bool|null $hidden Is field hidden
     * @param bool|null $provisionable Is field provisionable
     * @param bool|null $combined Is field combined
     * @param bool|null $filterable Is field filterable
     * @param string|null $filterableType Filterable type
     * @param bool|null $unique Is field unique
     * @param bool|null $sortable Is field sortable
     * @param bool|null $encrypted Is field encrypted
     * @param array<string>|null $additionalRules Additional validation rules
     * @param int|null $order Field order
     * @param array<int>|null $types Array of type IDs this field applies to
     */
    public function __construct(string $element, string $group, string $slug, string $label, ?string $options = null, ?bool $hidden = null, ?bool $provisionable = null, ?bool $combined = null, ?bool $filterable = null, ?string $filterableType = null, ?bool $unique = null, ?bool $sortable = null, ?bool $encrypted = null, ?array $additionalRules = null, ?int $order = null, ?array $types = null)
    {
        $this->element = $element;
        $this->group = $group;
        $this->slug = $slug;
        $this->label = $label;
        $this->options = $options;
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
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'element' => $this->element,
            'group' => $this->group,
            'slug' => $this->slug,
            'label' => $this->label,
            'options' => $this->options,
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
        ], fn($value) => $value !== null);
    }
}
