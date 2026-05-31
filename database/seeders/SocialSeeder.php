<?php

namespace Database\Seeders;

use App\Models\SiteSocial;
use App\Models\Social;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Social::create([
            'name' => "Facebook",
            'color' => "#1877F2",
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.5 10v4h3v7h4v-7h3l1-4h-4V8c0-.545.455-1 1-1h3V3h-3c-2.723 0-5 2.277-5 5v2z"/></svg>'
        ]);

        Social::create([
            'name' => "Pinterest",
            'color' => "#E60023",
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M7.452 13.18c-1.108-2.262.4-6.668 5.472-5.948c5.587.794 4.581 9.478-.077 9.138c-1.474-.107-2.031-1.328-2.177-2.576m0 0c-.11-.946.017-1.907.16-2.41c.244-.857.649-.74.353.393c-.144.552-.32 1.245-.513 2.017m0 0a652 652 0 0 0-1.63 6.708"/><path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0"/></g></svg>'
        ]);

        Social::create([
            'name' => "Instagram",
            'color' => "#E1306C",
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M15.462 11.487a3.5 3.5 0 1 1-6.925 1.026a3.5 3.5 0 0 1 6.925-1.026M17 6.5h.5"/><path d="M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z"/></g></svg>'
        ]);


        Social::create([
            'name' => "LinkedIn",
            'color' => "#0077B5",
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M8 16.375V10.75m4 5.625V13.5m0 0v-2.75m0 2.75c0-1.288 1.222-2 2.4-2c1.6 0 1.6 1.375 1.6 2.875v2m-8-8.75v.5"/><path d="M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z"/></g></svg>'
        ]);




        Social::create([
            'name' => "YouTube",
            'color' => "#FF0000",
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M10.5 9.908v4.184a.41.41 0 0 0 .412.408a.4.4 0 0 0 .228-.068l3.175-2.074a.405.405 0 0 0 .003-.678l-3.175-2.11a.415.415 0 0 0-.573.11a.4.4 0 0 0-.07.228"/><path d="M2 12c0-3.3 0-4.95 1.464-5.975C4.93 5 7.286 5 12 5s7.071 0 8.535 1.025S22 8.7 22 12s0 4.95-1.465 5.975C19.072 19 16.714 19 12 19s-7.071 0-8.536-1.025S2 15.3 2 12"/></g></svg>'
        ]);


        SiteSocial::create([
            'site_id' => 16,
            'social_id' => 1,
            'url' => 'https://facebook.com/kitaboka'
        ]);

        SiteSocial::create([
            'site_id' => 16,
            'social_id' => 2,
            'url' => 'https://instagram.com/kitaboka'
        ]);


        SiteSocial::create([
            'site_id' => 16,
            'social_id' => 3,
            'url' => 'https://linkdin.com/kitaboka'
        ]);

        SiteSocial::create([
            'site_id' => 16,
            'social_id' => 4,
            'url' => 'https://pinterest.com/kitaboka'
        ]);

        SiteSocial::create([
            'site_id' => 16,
            'social_id' => 5,
            'url' => 'https://youtube.com/kitaboka'
        ]);
    }
}
