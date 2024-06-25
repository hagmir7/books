<?php

namespace App\Observers;

use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver as CO;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

abstract  class CrawlObserver
{
    /*
     * Called when the crawler will crawl the url.
     */
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    abstract public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText,
    ): void;

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    abstract public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void;

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
    }
}
