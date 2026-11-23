<?php

namespace App\Models;

use App\Enums\ProjectCategory;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title_ua
 * @property string $title_en
 * @property ProjectCategory $category
 * @property string|null $description_ua
 * @property string|null $description_en
 * @property string|null $image
 * @property array<string>|null $gallery
 * @property int $order_column
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title_ua',
        'title_en',
        'category',
        'description_ua',
        'description_en',
        'image',
        'gallery',
        'order_column',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => ProjectCategory::class,
            'gallery' => 'array',
            'order_column' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
