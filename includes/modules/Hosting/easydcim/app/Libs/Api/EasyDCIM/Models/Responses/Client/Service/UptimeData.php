<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class UptimeData
{
    public ?bool $isDown;
    public ?string $value;
    public function __construct(?bool $isDown, ?string $value)
    {
        $this->isDown = $isDown;
        $this->value = $value;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'is_down', false),
            Arr::get($data, 'value', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'is_down' => $this->isDown,
            'value' => $this->value,
        ];
    }
}
