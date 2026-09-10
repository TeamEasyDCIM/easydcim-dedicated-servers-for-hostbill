<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for finding a user by email
 */
class FindUserByEmailRequest
{
    public string $email;
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
