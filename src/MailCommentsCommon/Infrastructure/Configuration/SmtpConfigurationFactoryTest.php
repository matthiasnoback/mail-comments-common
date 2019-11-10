<?php

namespace MailCommentsCommon\Infrastructure\Configuration;

use PHPUnit\Framework\TestCase;

final class SmtpConfigurationFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_copies_hostname_port_and_ssl_setting_from_env_variables(): void
    {
        $factory = new SmtpConfigurationFactory();

        self::assertEquals(
            SmtpConfiguration::create('mailserver', 3025)->useSsl(false),
            $factory->createFromEnvironmentVariables(
                EnvironmentVariables::fromArray(
                    [
                        'MAIL_COMMENTS_SMTP_SERVER_NAME' => 'mailserver',
                        'MAIL_COMMENTS_SMTP_SERVER_PORT' => '3025'
                    ]
                )
            )
        );
    }

    /**
     * @test
     */
    public function it_optionally_copies_hostname_port_and_ssl_setting_from_env_variables(): void
    {
        $factory = new SmtpConfigurationFactory();

        self::assertEquals(
            SmtpConfiguration::create('mailserver', 3025)
                ->useSsl(true)
                ->withCredentials('user', 'pass'),
            $factory->createFromEnvironmentVariables(
                EnvironmentVariables::fromArray(
                    [
                        'MAIL_COMMENTS_SMTP_SERVER_NAME' => 'mailserver',
                        'MAIL_COMMENTS_SMTP_SERVER_PORT' => '3025',
                        'MAIL_COMMENTS_SMTP_USE_SSL' => '1',
                        'MAIL_COMMENTS_SMTP_REQUIRES_LOGIN' => '1',
                        'MAIL_COMMENTS_SMTP_USERNAME' => 'user',
                        'MAIL_COMMENTS_SMTP_PASSWORD' => 'pass'
                    ]
                )
            )
        );
    }
}
