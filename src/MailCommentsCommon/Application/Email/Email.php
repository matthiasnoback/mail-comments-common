<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

use Webmozart\Assert\Assert;
use function Safe\json_encode;

final class Email
{
    /**
     * @var string|null
     */
    private $subject;

    /**
     * @var string|null
     */
    private $fromAddress;

    /**
     * @var string|null
     */
    private $fromName;

    /**
     * @var string|null
     */
    private $toAddress;

    /**
     * @var string|null
     */
    private $toName;

    /**
     * @var string|null
     */
    private $body;

    /**
     * @var string|null
     */
    private $contentType;

    /**
     * @var array & Attachment[]
     */
    private $attachments = [];

    private function __construct()
    {
    }

    public static function fromScratch(): self
    {
        return new self();
    }

    public function withSubject(?string $subject): self
    {
        $copy = clone $this;

        $copy->subject = $subject;

        return $copy;
    }

    public function withFrom(?string $fromAddress, ?string $fromName = null): self
    {
        $copy = clone $this;

        $copy->fromAddress = $fromAddress;
        $copy->fromName = $fromName;

        return $copy;
    }

    public function withTo(?string $toAddress, ?string $toName = null): self
    {
        $copy = clone $this;

        $copy->toAddress = $toAddress;
        $copy->toName = $toName;

        return $copy;
    }

    public function withBody(?string $body, string $contentType): self
    {
        $copy = clone $this;

        $copy->body = $body;
        $copy->contentType = $contentType;

        return $copy;
    }

    public function withAttachment(string $content, string $filename, string $contentType): self
    {
        $copy = clone $this;

        $copy->attachments[] = new Attachment($content, $filename, $contentType);

        return $copy;
    }

    public function subject(): ?string
    {
        return $this->subject;
    }

    public function fromAddress(): string
    {
        Assert::string($this->fromAddress, 'A "from" address is required');

        return $this->fromAddress;
    }

    public function fromName(): ?string
    {
        return $this->fromName;
    }

    public function toAddress(): string
    {
        Assert::string($this->toAddress, 'A "to" address is required');

        return $this->toAddress;
    }

    public function toName(): ?string
    {
        return $this->toName;
    }

    public function body(): ?string
    {
        return $this->body;
    }

    public function contentType(): ?string
    {
        return $this->contentType;
    }

    /**
     * @return array & Attachment[]
     */
    public function attachments(): array
    {
        return $this->attachments;
    }

    public function asString(): string
    {
        return json_encode(
            [
                'subject' => $this->subject,
                'to' => $this->toAddress,
                'from' => $this->fromAddress,
                'body' => $this->body,
                'attachments' => count($this->attachments())
            ]
        );
    }
}
