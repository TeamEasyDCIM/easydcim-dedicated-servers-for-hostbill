<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for verifying API token ability
 */
class VerifyTokenAbilityRequest
{
    public function __construct(
        public string $ability,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'ability' => $this->ability,
        ];
    }
}
