<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\CreatePost;

use MailCommentsCommon\Application\AuthorizationToken;
use MailCommentsCommon\Application\Email\Email;
use MailCommentsCommon\Domain\EmailAddress;
use MailCommentsCommon\Domain\PostId;
use MailCommentsCommon\Infrastructure\Query;

final class CreatePostEmail
{
    public const CREATE_POST_PARAMETER = 'create_post';
    public const TOKEN_PARAMETER = 'token';
    public const URL_PARAMETER = 'url';

    public static function create(
        PostId $postId,
        string $url,
        AuthorizationToken $authorizationToken,
        EmailAddress $emailAddress
    ) {
        return Email::fromScratch()
            ->withSubject(
                Query::buildFromParameters(
                    [
                        self::CREATE_POST_PARAMETER => $postId->asString(),
                        self::URL_PARAMETER => $url,
                        self::TOKEN_PARAMETER => $authorizationToken->asString()
                    ]
                )
            )
            ->withBody('This is not a spam message', 'text/plain')
            ->withTo($emailAddress->asString())
            ->withFrom($emailAddress->asString());
    }
}
