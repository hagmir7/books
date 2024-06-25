<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Crawler\Crawler;
use App\Observers\CrawlObserver;

class WebScraper extends Command
{
    protected $signature = 'scrape:web';
    protected $description = 'Scrape a website using Spatie Crawler';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Instantiate the CrawlObserver class

        // Create the crawler and set the crawl observer
        Crawler::create()
            ->setCrawlObserver([
                'App\Observers\CrawlObserver'
            ])
            ->startCrawling("https://freedaz.com/books/still-beating");

        // Output a message to indicate completion
        $this->info('Crawling initiated.');
    }
}
