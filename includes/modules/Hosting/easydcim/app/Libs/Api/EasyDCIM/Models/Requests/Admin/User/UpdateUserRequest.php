<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for updating a user
 */
class UpdateUserRequest
{
    public function __construct(
        public ?string $email = null,
        public ?string $password = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $company = null,
        public ?string $phone = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'password' => $this->password,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'company' => $this->company,
            'phone' => $this->phone,
        ], fn($value) => $value !== null);
    }
}
