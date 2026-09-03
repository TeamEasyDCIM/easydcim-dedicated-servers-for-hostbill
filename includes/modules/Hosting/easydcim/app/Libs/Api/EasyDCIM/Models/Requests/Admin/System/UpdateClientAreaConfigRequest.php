<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\System;

/**
 * Request for updating Client Area configuration
 */
class UpdateClientAreaConfigRequest
{
    public function __construct(
        public ?string $url = null,
        public ?string $token = null,
        public ?bool $enabled = null,
        public ?array $additionalConfig = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = array_filter([
            'full_url' => $this->url,
            'token' => $this->token,
            'is_enabled' => $this->enabled,
        ], fn($value) => $value !== null);

        if ($this->additionalConfig !== null) {
            $data = array_merge($data, $this->additionalConfig);
        }

        return $data;
    }
}
