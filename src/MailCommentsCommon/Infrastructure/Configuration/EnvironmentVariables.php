<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\Configuration;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class EnvironmentVariables
{
    /**
     * @var array<string,mixed>
     */
    private array $env;

    /**
     * @param array<string,mixed> $variables
     */
    private function __construct(array $variables)
    {
        $this->env = $variables;
    }

    public static function fromGlobals(): self
    {
        $env = getenv();
        Assert::isArray($env);

        return self::fromArray($env);
    }

    /**
     * @param array<string,mixed> $env
     */
    public static function fromArray(array $env): self
    {
        return new self($env);
    }

    /**
     * @return array<string,mixed>
     */
    public function all(): array
    {
        return $this->env;
    }

    public function getString(string $key, string $defaultValue = null): string
    {
        return (string)($this->getValue($key, $defaultValue));
    }

    public function getInt(string $key, int $defaultValue = null): int
    {
        return (int)($this->getValue($key, $defaultValue));
    }

    public function getFloat(string $key, float $defaultValue = null): float
    {
        return (float)($this->getValue($key, $defaultValue));
    }

    public function getBoolean(string $key, bool $defaultValue = null): bool
    {
        $value = $this->getValue($key, $defaultValue);

        if ($value === 'false') {
            $value = false;
        }

        return (bool)$value;
    }

    private function getValue(string $key, $defaultValue)
    {
        if (!array_key_exists($key, $this->env)) {
            if ($defaultValue !== null) {
                return $defaultValue;
            }

            throw new InvalidArgumentException(
                sprintf(
                    'Please provide a value for the environment variable "%s"',
                    $key
                )
            );
        }

        return $this->env[$key];
    }
}
