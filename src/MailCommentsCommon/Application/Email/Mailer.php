<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

interface Mailer
{
    /**
     * @throws CouldNotSendEmail
     */
    public function send(Email $email): void;
}
