<?php
declare(strict_types=1);

namespace MailCommentsCommon\Application\Email;

final class Attachment
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $contentType;

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
