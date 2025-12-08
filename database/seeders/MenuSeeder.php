<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Home Page
        $homePage = Page::where('title', 'Home')->first();
        if ($homePage) {
            Menu::updateOrCreate(
                ['title' => 'Home'],
                [
                    'type' => 'page',
                    'page_id' => $homePage->id,
                    'order' => 1,
                    'parent_id' => -1,
                ]
            );
        }

        // 2. About Us Page
        $aboutPage = Page::where('title', 'About Us')->first();
        if ($aboutPage) {
            Menu::updateOrCreate(
                ['title' => 'About Us'],
                [
                    'type' => 'page',
                    'page_id' => $aboutPage->id,
                    'order' => 2,
                    'parent_id' => -1,
                ]
            );
        }

        // 3. Services (Dropdown with Pages)
        $servicesMenu = Menu::updateOrCreate(
            ['title' => 'Services'],
            [
                'type' => 'custom',
                'url' => '#',
                'has_children' => true,
                'child_type' => 'pages',
                'order' => 3,
                'parent_id' => -1,
            ]
        );

        // Attach specific pages to the Services menu
        // Assuming we want to attach 'Services' page and maybe others if they existed
        // For demonstration, let's just attach the 'Services' page itself as a child item
        $servicesPage = Page::where('title', 'Services')->first();
        if ($servicesPage) {
            $servicesMenu->pages()->syncWithoutDetaching([$servicesPage->id]);
        }

        // 4. Portfolio (Dropdown with Component)
        Menu::updateOrCreate(
            ['title' => 'Portfolio'],
            [
                'type' => 'custom',
                'url' => '#',
                'has_children' => true,
                'child_type' => 'components',
                'component' => 'Projects',
                'order' => 4,
                'parent_id' => -1,
            ]
        );

        // 5. Blog (Dropdown with Component)
        Menu::updateOrCreate(
            ['title' => 'Blog'],
            [
                'type' => 'custom',
                'url' => '#',
                'has_children' => true,
                'child_type' => 'components',
                'component' => 'Blogs',
                'order' => 5,
                'parent_id' => -1,
            ]
        );

        // 6. Contact Us Page
        $contactPage = Page::where('title', 'Contact Us')->first();
        if ($contactPage) {
            Menu::updateOrCreate(
                ['title' => 'Contact Us'],
                [
                    'type' => 'page',
                    'page_id' => $contactPage->id,
                    'order' => 6,
                    'parent_id' => -1,
                ]
            );
        }
    }
}
