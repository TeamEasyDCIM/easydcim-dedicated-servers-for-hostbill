<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for updating a user
 */
class UpdateUserRequest
{
    public ?string $email;
    public ?string $password;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $company;
    public ?string $phone;
    public function __construct(?string $email = null, ?string $password = null, ?string $firstName = null, ?string $lastName = null, ?string $company = null, ?string $phone = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->phone = $phone;
    }

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
