<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolio = \App\Models\Portfolio::create([
            'is_use' => true,
            'title' => 'Hi, I\'m Jelvin Krisna Putra',
            'subtitle' => 'Programmer | College Student',
            'scroll_text' => 'Scroll down to see more',
            'bio_title' => '📜 Biography 📜',
            'bio_subtitle' => 'I am Jelvin Krisna Putra, born in 2003 in Palembang. My fascination with coding and technology ignited at a young age, evolving into a lifelong passion. Here, you\'ll find a selection of projects crafted using my primary language, Javascript. Beyond the basics of HTML, CSS, and JavaScript, I\'ve ventured into React, SQL, and more.',
            'skill_title' => 'Skillset 📚',
            'quote' => '"Programming isn\'t about what you know; it\'s about what you can figure out."',
            'quote_author' => 'Chris Pine',
            'contact_links_title' => 'Contact Me',
            'is_using_default_contact_links' => true,
        ]);

        $portfolio->skillSets()->createMany([
                [
                    'title' => 'Laravel',
                    'icon' => 'fab fa-html5',
                ],
                [
                    'title' => 'HapiJS',
                    'icon' => 'fab fa-css3-alt',
                ],
                [
                    'title' => 'NextJS',
                    'icon' => 'fab fa-css3-alt',
                ],
                [
                    'title' => 'ReactJS',
                    'icon' => 'fab fa-css3-alt',
                ],
                [
                    'title' => 'Tailwind',
                    'icon' => 'fab fa-css3-alt',
                ],
            ]);

        $portfolio->contactMeLinks()->createMany([
            [
                'title' => 'Facebook',
                'link' => 'https://www.facebook.com/profile.php?id=100006248929202',
                'icon' => 'fab fa-facebook',
            ],
            [
                'title' => 'Twitter',
                'link' => 'https://twitter.com/',
                'icon' => 'fab fa-twitter',
            ],
            [
                'title' => 'Instagram',
                'link' => 'https://www.instagram.com/',
                'icon' => 'fab fa-instagram',
            ],
            [
                'title' => 'LinkedIn',
                'link' => 'https://www.linkedin.com/',
                'icon' => 'fab fa-linkedin',
            ],
        ]);
    }
}
