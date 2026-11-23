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
                'meta_title_ua' => 'Modex - Фулстек 3D Друк та Технічне Проектування',
                'meta_title_en' => 'Modex - Full-Stack 3D Printing & Technical Hardware Engineering',
                'meta_description_ua' => 'Фулстек інженерне проектування, параметричне 3D CAD моделювання та високоточний 3D-друк деталей.',
                'meta_description_en' => 'From concept to physical reality: Full-Stack Hardware Engineering, 3D CAD Prototyping & Precision 3D Printing.',
                'meta_keywords' => '3d print, 3d друк, інженерне проектування, solidworks, fdm, sla, prototyping, швидке прототипування',
                'is_indexed' => true,
            ]
        );
    }
}
