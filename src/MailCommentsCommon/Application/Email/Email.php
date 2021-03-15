<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

use Webmozart\Assert\Assert;
use function Safe\json_encode;

final class Email
{
    private ?string $subject = null;

    private ?string $fromAddress = null;

    private ?string $fromName = null;

    private ?string $toAddress = null;

    private ?string $toName = null;

    private ?string $plainTextBody = null;

    private ?string $htmlBody = null;

    /**
     * @var array<Attachment>
     */
    private array $attachments = [];

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

    public function withPlainTextBody(?string $plainTextBody): self
    {
        $copy = clone $this;

        $copy->plainTextBody = $plainTextBody;

        return $copy;
    }

    public function withHtmlBody(?string $htmlBody): self
    {
        $copy = clone $this;

        $copy->htmlBody = $htmlBody;

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

    public function plainTextBody(): ?string
    {
        return $this->plainTextBody;
    }

    public function htmlBody(): ?string
    {
        return $this->htmlBody;
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
                'plain_text_body' => $this->plainTextBody,
                'html_body' => $this->htmlBody,
                'attachments' => count($this->attachments())
            ]
        );
    }
}
