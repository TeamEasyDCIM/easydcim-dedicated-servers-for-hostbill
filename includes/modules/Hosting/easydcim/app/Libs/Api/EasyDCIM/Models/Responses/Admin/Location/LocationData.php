<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Location data structure
 */
class LocationData
{
    public ?int $id;
    public ?string $appId;
    public ?string $name;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $description;
    public ?string $notes;
    public ?string $emergency;
    public ?string $phone;
    public ?string $flag;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $appId, ?string $name, ?string $address, ?string $city, ?string $state, ?string $description, ?string $notes, ?string $emergency, ?string $phone, ?string $flag, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->appId = $appId;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->description = $description;
        $this->notes = $notes;
        $this->emergency = $emergency;
        $this->phone = $phone;
        $this->flag = $flag;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'app_id'),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'address', ''),
            Arr::get($data, 'city', ''),
            Arr::get($data, 'state', ''),
            Arr::get($data, 'description', ''),
            Arr::get($data, 'notes', ''),
            Arr::get($data, 'emergency', ''),
            Arr::get($data, 'phone', ''),
            Arr::get($data, 'flag', ''),
            Arr::get($data, 'created_at', ''),
            Arr::get($data, 'updated_at', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'app_id' => $this->appId,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'description' => $this->description,
            'notes' => $this->notes,
            'emergency' => $this->emergency,
            'phone' => $this->phone,
            'flag' => $this->flag,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
