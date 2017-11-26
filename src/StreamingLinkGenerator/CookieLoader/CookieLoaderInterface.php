<?php
declare(strict_types=1);

namespace SergeyHartmann\StreamingLinkGenerator\CookieLoader;

interface CookieLoaderInterface
{
    /**
     * Save serialized cookie.
     *
     * @param string $cookie
     */
    public function save(string $cookie): void;

    /**
     * Load serialized cookie.
     *
     * @return null|string
     */
    public function load(): ?string;
}
