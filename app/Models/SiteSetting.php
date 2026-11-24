<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'google_analytics_id',
        'google_tag_manager_id',
        'google_site_verification',
        'meta_title_ua',
        'meta_title_en',
        'meta_description_ua',
        'meta_description_en',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'instagram_url',
        'facebook_url',
        'whatsapp_url',
        'telegram_url',
        'viber_url',
        'contact_email',
        'contact_phone',
        'is_indexed',
        'custom_head_scripts',
        'custom_body_scripts',
    ];

    protected $casts = [
        'is_indexed' => 'boolean',
    ];

    /**
     * Get or create the singleton site settings instance.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'meta_title_ua' => 'Modex - Full-Stack 3D Printing & Technical Hardware Engineering',
                'meta_title_en' => 'Modex - Full-Stack 3D Printing & Technical Hardware Engineering',
                'meta_description_ua' => 'From concept to physical reality: Full-Stack Hardware Engineering, 3D CAD Prototyping & Precision 3D Printing.',
                'meta_description_en' => 'From concept to physical reality: Full-Stack Hardware Engineering, 3D CAD Prototyping & Precision 3D Printing.',
                'meta_keywords' => '3d printing, 3d print, rapid prototyping, cad design, solidworks, fdm, petg, pla, custom engineering',
                'instagram_url' => 'https://instagram.com/modexdesign',
                'facebook_url' => 'https://facebook.com/modexdesign',
                'whatsapp_url' => 'https://wa.me/',
                'telegram_url' => null,
                'viber_url' => null,
                'contact_email' => 'orders@modexdesign.com',
                'contact_phone' => null,
                'is_indexed' => true,
            ]
        );
    }
}
