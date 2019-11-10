<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\Configuration;

final class SmtpConfigurationFactory
{
    private const SMTP_HOSTNAME_KEY = 'MAIL_COMMENTS_SMTP_SERVER_NAME';
    private const SMTP_PORT_KEY = 'MAIL_COMMENTS_SMTP_SERVER_PORT';
    private const SMTP_USE_SSL_KEY = 'MAIL_COMMENTS_SMTP_USE_SSL';
    private const SMTP_REQUIRES_LOGIN_KEY = 'MAIL_COMMENTS_SMTP_REQUIRES_LOGIN';
    private const SMTP_USERNAME_KEY = 'MAIL_COMMENTS_SMTP_USERNAME';
    private const SMTP_PASSWORD_KEY = 'MAIL_COMMENTS_SMTP_PASSWORD';

    public function createFromEnvironmentVariables(EnvironmentVariables $env): SmtpConfiguration
    {
        $configuration = SmtpConfiguration::create(
            $env->getString(self::SMTP_HOSTNAME_KEY),
            $env->getInt(self::SMTP_PORT_KEY)
        )->useSsl(
            $env->getBoolean(self::SMTP_USE_SSL_KEY, false)
        );

        if ($env->getBoolean(self::SMTP_REQUIRES_LOGIN_KEY, false)) {
            $configuration = $configuration->withCredentials(
                $env->getString(self::SMTP_USERNAME_KEY),
                $env->getString(self::SMTP_PASSWORD_KEY)
            );
        }

        return $configuration;
    }
}
