<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\Configuration;

use Webmozart\Assert\Assert;

final class SmtpConfiguration
{
    /**
     * @var string
     */
    private $hostname;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $useSsl = false;

    /**
     * @var bool
     */
    private $requiresLogin = false;

    public function __construct(string $hostname, int $port)
    {
        Assert::notEq('', $hostname, 'The hostname of the SMTP server should not be empty, got: %s');
        Assert::greaterThan($port, 0, 'The SMTP port number should be greater than 0');

        $this->hostname = $hostname;
        $this->port = $port;
    }

    public static function create(string $hostname, int $port): self
    {
        return new self($hostname, $port);
    }

    public function withCredentials(string $username, string $password): self
    {
        Assert::notEq('', $username, 'The SMTP username should not be empty, got: %s');
        Assert::notEq('', $password, 'The SMTP password should not be empty, got: %s');

        $copy = clone $this;

        $copy->requiresLogin = true;
        $copy->username = $username;
        $copy->password = $password;

        return $copy;
    }

    public function hostname(): string
    {
        return $this->hostname;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function username(): string
    {
        Assert::true($this->requiresLogin, 'This SMTP configuration does not require login');

        return $this->username;
    }

    public function password(): string
    {
        Assert::true($this->requiresLogin, 'This SMTP configuration does not require login');

        return $this->password;
    }

    public function useSsl(bool $useSsl): self
    {
        $copy = clone $this;

        $copy->useSsl = $useSsl;

        return $copy;
    }

    public function shouldUseSsl(): bool
    {
        return $this->useSsl;
    }

    public function requiresLogin(): bool
    {
        return $this->requiresLogin;
    }
}
