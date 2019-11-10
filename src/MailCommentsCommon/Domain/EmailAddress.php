<?php
declare(strict_types=1);

namespace MailCommentsCommon\Domain;

use Webmozart\Assert\Assert;

final class EmailAddress
{
    /**
     * @var string
     */
    private $emailAddress;

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
}
