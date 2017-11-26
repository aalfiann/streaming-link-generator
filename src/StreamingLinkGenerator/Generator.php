<?php
declare(strict_types=1);

namespace SergeyHartmann\StreamingLinkGenerator;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RedirectMiddleware;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use SergeyHartmann\StreamingLinkGenerator\CookieLoader\CookieLoaderInterface;

class Generator
{
    /** @var CookieLoaderInterface */
    private $cookieLoader;

    /** @var Client */
    private $httpClient;

    public function __construct(CookieLoaderInterface $cookieLoader)
    {
        $this->cookieLoader = $cookieLoader;
        $this->httpClient   = new Client();
    }

    /**
     * @param string $googleDriveFileId
     * @return StreamingLink
     * @throws GeneratorException
     */
    public function generate(string $googleDriveFileId): StreamingLink
    {
        $client = new Client();

        $onRedirect = function (
            RequestInterface  $request,
            ResponseInterface $response,
            UriInterface      $uri
        ) {
            if ($cookies = $response->getHeader('set-cookie')) {
                $jar = new CookieJar();
                foreach ($cookies as $cookie) {
                    $jar->setCookie(SetCookie::fromString($cookie));
                }

                $this->cookieLoader->save(serialize($jar));
            }
        };

        $options = [
            RequestOptions::VERIFY          => false,
            RequestOptions::COOKIES         => ($cookie = $this->cookieLoader->load()) ? unserialize($cookie) : [],
            RequestOptions::ALLOW_REDIRECTS => [
                'max'             => 1,
                'track_redirects' => true,
                'on_redirect'     => $onRedirect,
            ]
        ];

        $response = $client->get("https://drive.google.com/uc?export=download&id={$googleDriveFileId}", $options);

        if ($response->getStatusCode() !== 200) {
            throw new GeneratorException(
                'Incorrect HTTP Response ('
                . $response->getStatusCode()
                . ' code) from Google for generate link.'
            );
        }

        return $this->buildLink($response);
    }

    /**
     * @param ResponseInterface $response
     * @return StreamingLink
     * @throws GeneratorException
     */
    private function buildLink(ResponseInterface $response): StreamingLink
    {
        if (!$response->hasHeader(RedirectMiddleware::HISTORY_HEADER)) {
            throw new GeneratorException('Effective URL not found.');
        }

        if (!$response->hasHeader('content-type')) {
            throw new GeneratorException('Content-Type not found.');
        }

        if (!$response->hasHeader('content-disposition')) {
            throw new GeneratorException('Filename not found.');
        }

        $streamingLink = new StreamingLink();
        $streamingLink
            ->setName(
                preg_replace(
                    '/^.*filename="([^"]+).*$/',
                    '$1',
                    $response->getHeader('content-disposition')[0]
                )
            )
            ->setDownloadLink($response->getHeader(RedirectMiddleware::HISTORY_HEADER)[0])
            ->setStreamingLink(str_replace('?e=download', '', $streamingLink->getDownloadLink()))
            ->setContentType($response->getHeader('content-type')[0])
        ;

        return $streamingLink;
    }
}
