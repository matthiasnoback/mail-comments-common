<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure;

use MailCommentsCommon\Domain\PostId;
use MailCommentsCommon\Domain\PostIdFactory;
use Ramsey\Uuid\Uuid;

final class PostIdFromUuidFactory implements PostIdFactory
{
    public function nextPostId(): PostId
    {
        return PostId::fromString(
            substr(sha1(Uuid::uuid4()->toString()), 0, 10)
        );
    }
}
