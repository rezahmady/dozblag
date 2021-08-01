<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // modify this to your own needs
        SitemapGenerator::create(config('app.url'))
            ->writeToFile(public_path('sitemap/sitemap.xml'));

            
        // SitemapGenerator::create(url('/mag'))->getSitemap()->writeToFile(public_path('posts_sitemap.xml'));
        // SitemapGenerator::create(url('/doctor'))->getSitemap()->writeToFile(public_path('/sitemap/doctors_sitemap.xml'));
        // SitemapGenerator::create(url('/resource'))->getSitemap()->writeToFile(public_path('/sitemap/resources_sitemap.xml'));
        SitemapGenerator::create(url('/mag'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'mag') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/posts_sitemap.xml'));
    }
}