<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph;

/**
 * PHP 7.4 stand-in for a backed enum.
 *
 * Instances are cached per value, so `from()` returns the same object for the
 * same input and `===` behaves the way it did with the native enum.
 */
final class DeviceSelectionEnum
{
    public const ALL    = 'all';
    public const SERVER = 'server';
    public const ORDER  = 'order';

    /** @var array<string, self> */
    private static $instances = [];

    /** @var string */
    public $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return [self::ALL, self::SERVER, self::ORDER];
    }

    /**
     * @return self[]
     */
    public static function cases(): array
    {
        return array_map([self::class, 'from'], self::values());
    }

    public static function tryFrom(string $value): ?self
    {
        if (!in_array($value, self::values(), true)) {
            return null;
        }

        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new self($value);
        }

        return self::$instances[$value];
    }

    public static function from(string $value): self
    {
        $case = self::tryFrom($value);

        if ($case === null) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid backing value for enum %s', $value, self::class)
            );
        }

        return $case;
    }
}
