<?php

namespace MailCommentsCommon\Application\Email;

interface MailerFactory
{
    public function createMailer(): Mailer;
}
