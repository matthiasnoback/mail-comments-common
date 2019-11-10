<?php
declare(strict_types=1);

namespace MailCommentsCommon\Domain;

use Webmozart\Assert\Assert;

final class PostId
{
    /**
     * @var string
     */
    private $id;

    private function __construct(string $id)
    {
        // The length is based on Disqus thread IDs
        Assert::regex($id, '/^[a-f0-9]{10}$/');
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
}
