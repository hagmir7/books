<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Site::create([
            'domain' => '127.0.0.1',
            'name' => 'Example Site',
            'footer' => 'Footer content',
            'header' => 'Header content',
            'keywords' => 'example, site, keywords',
            'description' => 'This is an example site',
            'email' => 'info@example.com',
            'language_id' => 1
        ]);

        Site::create([
            'domain' => 'localhost',
            'name' => 'Example Site',
            'footer' => 'Footer content',
            'header' => 'Header content',
            'keywords' => 'example, site, keywords',
            'description' => 'This is an example site',
            'email' => 'info@example.com',
            'language_id' => 1
        ]);
    }
}
