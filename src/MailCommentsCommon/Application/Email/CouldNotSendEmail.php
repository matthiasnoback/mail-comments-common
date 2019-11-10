<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

use Exception;
use RuntimeException;

final class CouldNotSendEmail extends RuntimeException
{
    public static function fromPreviousException(Email $email, Exception $previous): self
    {
        return new self(
            sprintf(
                'Could not send email (%s): %s',
                $email->asString(),
                $previous->getMessage()
            ),
            0,
            $previous
        );
    }
}
