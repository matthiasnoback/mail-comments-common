<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\SwiftMailer;

use MailCommentsCommon\Application\Email\Mailer;
use MailCommentsCommon\Application\Email\MailerFactory;
use MailCommentsCommon\Infrastructure\Configuration\SmtpConfiguration;
use Swift_Mailer;
use Swift_SmtpTransport;

final class SwiftMailerFactory implements MailerFactory
{
    /**
     * @var SmtpConfiguration
     */
    private $configuration;

    public function __construct(SmtpConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function createMailer(): Mailer
    {
        $transport = new Swift_SmtpTransport(
            $this->configuration->hostname(),
            $this->configuration->port(),
            $this->configuration->shouldUseSsl() ? 'ssl' : ''
        );
        if ($this->configuration->requiresLogin()) {
            $transport->setAuthMode('LOGIN');
            $transport->setUsername($this->configuration->username());
            $transport->setPassword($this->configuration->password());
        }

        return new SwiftMailer(new Swift_Mailer($transport));
    }
}
