<?php
declare(strict_types=1);

namespace SergeyHartmann\StreamingLinkGenerator;

class StreamingLink
{
    /** @var string */
    private $name;

    /** @var string */
    private $streamingLink;

    /** @var string */
    private $downloadLink;

    /** @var string */
    private $contentType;

    public function setName(string $name): StreamingLink
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setStreamingLink(string $streamingLink): StreamingLink
    {
        $this->streamingLink = $streamingLink;
        return $this;
    }

    public function getStreamingLink(): ?string
    {
        return $this->streamingLink;
    }

    public function setDownloadLink(string $downloadLink): StreamingLink
    {
        $this->downloadLink = $downloadLink;
        return $this;
    }

    public function getDownloadLink(): ?string
    {
        return $this->downloadLink;
    }

    public function setContentType(string $contentType): StreamingLink
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }
}
