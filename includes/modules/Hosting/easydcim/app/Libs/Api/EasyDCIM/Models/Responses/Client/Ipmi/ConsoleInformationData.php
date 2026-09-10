<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * IPMI Console Information data
 */
class ConsoleInformationData
{
    public ?string $ipmiUsername;
    public ?string $ipmiPassword;
    public ?bool $disableLoginButtons;
    public function __construct(?string $ipmiUsername, ?string $ipmiPassword, ?bool $disableLoginButtons)
    {
        $this->ipmiUsername = $ipmiUsername;
        $this->ipmiPassword = $ipmiPassword;
        $this->disableLoginButtons = $disableLoginButtons;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'ipmi_username', ''),
            Arr::get($data, 'ipmi_password', ''),
            Arr::get($data, 'disable_login_buttons', false)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'ipmi_username' => $this->ipmiUsername,
            'ipmi_password' => $this->ipmiPassword,
            'disable_login_buttons' => $this->disableLoginButtons,
        ];
    }
}
