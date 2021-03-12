<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

final class Attachment
{
    private string $content;

    private string $filename;

    private string $contentType;

    public function __construct(string $content, string $filename, string $contentType)
    {
        $this->content = $content;
        $this->filename = $filename;
        $this->contentType = $contentType;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function contentType(): string
    {
        return $this->contentType;
    }
}
