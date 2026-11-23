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
            self::New => 'Нове',
            self::InReview => 'В обробці',
            self::Quoted => 'Прораховано',
            self::InProduction => 'У виробництві',
            self::Completed => 'Завершено',
            self::Cancelled => 'Скасовано',
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
