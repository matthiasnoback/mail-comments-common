<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\Mailer;

use MailCommentsCommon\Application\Email\Email;
use MailCommentsCommon\Application\Email\Mailer;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as SymfonyEmail;

final class MailerUsingSymfonyMailer implements Mailer
{
    private SymfonyMailer $symfonyMailer;

    public function __construct(SymfonyMailer $symfonyMailer)
    {
        $this->symfonyMailer = $symfonyMailer;
    }

    public function send(Email $email): void
    {
        $symfonyEmail = (new SymfonyEmail())
            ->subject($email->subject() ?? '')
            ->from(new Address($email->fromAddress(), $email->fromName() ?? ''))
            ->to(new Address($email->toAddress(), $email->toName() ?? ''))
            ->text($email->plainTextBody() ?? '')
            ->html($email->htmlBody());

        foreach ($email->attachments() as $attachment) {
            $symfonyEmail->attach($attachment->content(), $attachment->filename(), $attachment->contentType());
        }

        $this->symfonyMailer->send($symfonyEmail);
    }
}
