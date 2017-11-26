<?php

include_once dirname(__FILE__) . '/../vendor/autoload.php';

use SergeyHartmann\StreamingLinkGenerator\Generator;
use SergeyHartmann\StreamingLinkGenerator\StreamingLink;
use SergeyHartmann\StreamingLinkGenerator\CookieLoader\SimpleCookieLoader;

$cookieLoader = new SimpleCookieLoader(dirname(__FILE__) . '/g.cookie');
$generator    = new Generator($cookieLoader);

/** @var StreamingLink $streamingLink */
$streamingLink = $generator->generate('<YOUR_GOOGLE_DRIVE_FILE_ID>');

echo 'Filename: '        . $streamingLink->getName()          . PHP_EOL
    . 'Streaming link: ' . $streamingLink->getStreamingLink() . PHP_EOL
    . 'Download link: '  . $streamingLink->getDownloadLink()  . PHP_EOL
    . 'Content type: '   . $streamingLink->getContentType()   . PHP_EOL
;
