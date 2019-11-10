<?php

namespace MailCommentsCommon\Infrastructure\Configuration;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SmtpConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function it_requires_a_non_empty_host_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('hostname');

        new SmtpConfiguration('', $this->aPort());
    }

    /**
     * @test
     */
    public function it_requires_a_port_number(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('port');

        new SmtpConfiguration($this->aHostname(), 0);
    }

    /**
     * @test
     */
    public function it_requires_a_non_empty_username(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('username');

        SmtpConfiguration::create($this->aHostname(), $this->aPort())
            ->withCredentials($emptyUsername = '', $this->aPassword());
    }

    /**
     * @test
     */
    public function it_requires_a_non_empty_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('password');

        SmtpConfiguration::create($this->aHostname(), $this->aPort())
            ->withCredentials($this->aUsername(), $emptyPassword = '');
    }

    /**
     * @test
     */
    public function username_can_only_be_retrieved_if_a_login_is_actually_required(): void
    {
        $configuration = SmtpConfiguration::create($this->aHostname(), $this->aPort());
        self::assertFalse($configuration->requiresLogin());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('login');
        $configuration->username();
    }

    /**
     * @test
     */
    public function password_can_only_be_retrieved_if_a_login_is_actually_required(): void
    {
        $configuration = SmtpConfiguration::create($this->aHostname(), $this->aPort());
        self::assertFalse($configuration->requiresLogin());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('login');
        $configuration->password();
    }

    /**
     * @test
     */
    public function it_can_be_configured_to_use_ssl(): void
    {
        $configuration = SmtpConfiguration::create($this->aHostname(), $this->aPort())
            ->useSsl(true);

        self::assertTrue($configuration->shouldUseSsl());
    }

    /**
     * @test
     */
    public function it_does_not_use_ssl_by_default(): void
    {
        $configuration = SmtpConfiguration::create($this->aHostname(), $this->aPort());

        self::assertFalse($configuration->shouldUseSsl());
    }

    private function aPort(): int
    {
        return 465;
    }

    private function aUsername(): string
    {
        return 'user';
    }

    private function aPassword(): string
    {
        return 'pass';
    }

    private function aHostname()
    {
        return 'mailserver';
    }
}
