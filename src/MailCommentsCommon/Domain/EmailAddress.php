<?php
declare(strict_types=1);

namespace MailCommentsCommon\Domain;

use Webmozart\Assert\Assert;

final class EmailAddress
{
    private string $emailAddress;

    private function __construct(string $emailAddress)
    {
        Assert::email($emailAddress);
        $this->emailAddress = $emailAddress;
    }

    public static function fromString(string $emailAddress): self
    {
        return new self($emailAddress);
    }

    public function asString(): string
    {
        return $this->emailAddress;
    }

    public function equals(self $other): bool
    {
        return $this->emailAddress === $other->emailAddress;
    }
}
