<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure\SwiftMailer;

use Exception;
use MailCommentsCommon\Application\Email\CouldNotSendEmail;
use MailCommentsCommon\Application\Email\Email;
use MailCommentsCommon\Application\Email\Mailer;
use RuntimeException;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;

final class SwiftMailer implements Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $swiftMailer;

    public function __construct(Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    public function send(Email $email): void
    {
        $message = new Swift_Message($email->subject());
        $message->setFrom($email->fromAddress(), $email->fromName());
        $message->setTo($email->toAddress(), $email->toName());
        $message->setBody($email->body(), $email->contentType());

        foreach ($email->attachments() as $attachment) {
            $message->attach(
                new Swift_Attachment(
                    $attachment->content(),
                    $attachment->filename(),
                    $attachment->contentType()
                )
            );
        }

        try {
            $sent = $this->swiftMailer->send($message);
        } catch (Exception $previous) {
            throw CouldNotSendEmail::fromPreviousException($email, $previous);
        }

        if ($sent === 0) {
            throw CouldNotSendEmail::fromPreviousException($email, new RuntimeException('0 messages were sent'));
        }
    }
}
