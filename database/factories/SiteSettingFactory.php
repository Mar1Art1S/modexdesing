<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    protected $model = SiteSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'google_analytics_id' => 'G-'.fake()->bothify('##########'),
            'google_tag_manager_id' => 'GTM-'.fake()->bothify('???????'),
            'google_site_verification' => fake()->sha256(),
            'meta_title_ua' => 'Modex - 3D Друк та Інженерія',
            'meta_title_en' => 'Modex - 3D Printing & Engineering',
            'meta_description_ua' => 'Опис українською для пошукових систем.',
            'meta_description_en' => 'English description for search engines.',
            'meta_keywords' => '3d print, engineering, modex',
            'og_image' => 'images/og-preview.jpg',
            'canonical_url' => 'https://modexdesign.com',
            'instagram_url' => 'https://instagram.com/modexdesign',
            'facebook_url' => 'https://facebook.com/modexdesign',
            'whatsapp_url' => 'https://wa.me/',
            'telegram_url' => 'https://t.me/modexdesign',
            'viber_url' => null,
            'contact_email' => 'orders@modexdesign.com',
            'contact_phone' => '+380970000000',
            'is_indexed' => true,
            'custom_head_scripts' => null,
            'custom_body_scripts' => null,
        ];
    }
}
