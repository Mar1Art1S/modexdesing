<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $service_type
 * @property string|null $material
 * @property string|null $quantity
 * @property string|null $details
 * @property array<string>|null $files
 * @property OrderStatus $status
 * @property float|null $estimated_price
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_type',
        'material',
        'quantity',
        'details',
        'files',
        'status',
        'estimated_price',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'files' => 'array',
            'status' => OrderStatus::class,
            'estimated_price' => 'decimal:2',
        ];
    }
}
