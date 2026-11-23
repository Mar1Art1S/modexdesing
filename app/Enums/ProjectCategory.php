<?php

namespace App\Enums;

enum ProjectCategory: string
{
    case Architecture = 'architecture';
    case Industrial = 'industrial';
    case Robotics = 'robotics';
    case Mechatronics = 'mechatronics';

    public function label(): string
    {
        return match ($this) {
            self::Architecture => 'Архітектура',
            self::Industrial => 'Підстанції 10кВ',
            self::Robotics => 'Робототехніка',
            self::Mechatronics => 'Мехатроніка',
        };
    }
}
