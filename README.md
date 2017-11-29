Streaming Link Generator
========================
![](https://img.shields.io/badge/PHP-7.1.0-green.svg?style=flat)
![](https://img.shields.io/badge/guzzlehttp-6.3-green.svg?style=flat)

Grab video streaming link (for Video.js, jwplayer etc) from Google Drive.

```php
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
```

```bash
Filename: SampleVideo_1280x720_10mb.mp4
Streaming link: https://doc-0c-24-docs.googleusercontent.com/docs/securesc/ha0ro937...
Download link: https://doc-0c-24-docs.googleusercontent.com/docs/securesc/ha0ro937...?e=download
Content type: video/mp4
```

## Installation
The recommended way to install StreamingLinkGenerator is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```
Next, run the Composer command to install the latest stable version of StreamingLinkGenerator:


```bash
php composer.phar require sergeyhartmann/streaming-link-generator
```
See `example/index.php` for getting started.

## How to Find Google Drive File ID
1) Share that video.
2) Get shareable link `https://drive.google.com/open?id=<FILE_ID>`.
