<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\CreatePost;

use MailCommentsCommon\Application\AuthorizationToken;
use MailCommentsCommon\Application\Email\Mailer;
use MailCommentsCommon\Domain\EmailAddress;
use MailCommentsCommon\Domain\PostId;
use MailCommentsCommon\Domain\PostIdFactory;

final class SendCreatePostEmailService
{
    private AuthorizationToken $authorizationToken;

    private PostIdFactory $postIdFactory;

    private EmailAddress $emailAddress;

    private Mailer $mailer;

    public function __construct(
        AuthorizationToken $authorizationToken,
        PostIdFactory $postIdFactory,
        EmailAddress $emailAddress,
        Mailer $mailer
    ) {
        $this->authorizationToken = $authorizationToken;
        $this->postIdFactory = $postIdFactory;
        $this->emailAddress = $emailAddress;
        $this->mailer = $mailer;
    }

    public function createPost(string $url): PostId
    {
        $nextPostId = $this->postIdFactory->nextPostId();

        $createPostEmail = CreatePostEmail::create(
            $nextPostId,
            $url,
            $this->authorizationToken,
            $this->emailAddress
        );

        $this->mailer->send($createPostEmail);

        return $nextPostId;
    }
}
