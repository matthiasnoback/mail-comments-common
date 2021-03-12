<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application;

use Webmozart\Assert\Assert;

final class AuthorizationToken
{
    private string $id;

    private function __construct(string $id)
    {
        Assert::uuid($id);
        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function asString(): string
    {
        return $this->id;
    }

    public function isValid(string $authorizationToken): bool
    {
        return $this->id === $authorizationToken;
    }
}
