<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\System;

/**
 * Request for updating Client Area configuration
 */
class UpdateClientAreaConfigRequest
{
    public ?string $url;
    public ?string $token;
    public ?bool $enabled;
    public ?array $additionalConfig;
    public function __construct(?string $url = null, ?string $token = null, ?bool $enabled = null, ?array $additionalConfig = null)
    {
        $this->url = $url;
        $this->token = $token;
        $this->enabled = $enabled;
        $this->additionalConfig = $additionalConfig;
    }

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
