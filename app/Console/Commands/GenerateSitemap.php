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
        SitemapGenerator::create(url('/'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'mag') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/posts_sitemap.xml'));

        SitemapGenerator::create(url('/'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'doctor') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/doctors_sitemap.xml'));
        
        SitemapGenerator::create(url('/'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'resource') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/resources_sitemap.xml'));

        SitemapGenerator::create(url('/'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'tag') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/tags_sitemap.xml'));
        
        SitemapGenerator::create(url('/'))
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) !== 'resource' and $url->segment(1) !== 'mag' and $url->segment(1) !== 'doctor' and $url->segment(1) !== 'doctorConsultation' and $url->segment(1) !== 'admin' and $url->segment(1) !== 'auth' and $url->segment(1) !== 'profile' and $url->segment(1) !== 'tag') {
                return $url;
            }
            return;        
        })
        ->writeToFile(public_path('/sitemap/pages_sitemap.xml'));
    }
}