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
            self::Architecture => 'Architecture',
            self::Industrial => '10kV Substations',
            self::Robotics => 'Robotics',
            self::Mechatronics => 'Mechatronics',
        };
    }
}
