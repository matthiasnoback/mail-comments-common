<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\Mailer;

use MailCommentsCommon\Application\Email\Mailer;
use MailCommentsCommon\Application\Email\MailerFactory;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;

final class SymfonyMailerFactory implements MailerFactory
{
    private string $mailerDsn;

    public function __construct(string $mailerDsn)
    {
        $this->mailerDsn = $mailerDsn;
    }

    public function createMailer(): Mailer
    {
        $transport = Transport::fromDsn($this->mailerDsn);

        return new MailerUsingSymfonyMailer(new SymfonyMailer($transport));
    }
}
