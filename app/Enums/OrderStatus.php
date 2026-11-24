<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Quoted = 'quoted';
    case InProduction = 'in_production';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::InReview => 'In Review',
            self::Quoted => 'Quoted',
            self::InProduction => 'In Production',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::InReview => 'warning',
            self::Quoted => 'primary',
            self::InProduction => 'purple',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
