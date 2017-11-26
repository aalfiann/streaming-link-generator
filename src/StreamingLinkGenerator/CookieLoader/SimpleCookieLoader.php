<?php
declare(strict_types=1);

namespace SergeyHartmann\StreamingLinkGenerator\CookieLoader;

class SimpleCookieLoader implements CookieLoaderInterface
{
    /** @var string */
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Save serialized cookie to file.
     *
     * @param string $cookie
     */
    public function save(string $cookie): void
    {
        file_put_contents($this->fileName, $cookie);
    }

    /**
     * Load serialized cookie from file.
     *
     * @return null|string
     */
    public function load(): ?string
    {
        if (!file_exists($this->fileName)) {
            return null;
        }

        return file_get_contents($this->fileName) ?: null;
    }
}

