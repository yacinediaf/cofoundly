<?php

namespace App\Enums;

enum StartupStage: string
{
    case IDEA = 'Idea';
    case MVP = 'MVP';
    case GROWTH = 'Growth';
    case SCALING = 'Scaling';

    public static function labels(): array
    {
        return [
            self::IDEA->value => 'Idea',
            self::MVP->value => 'MVP',
            self::GROWTH->value => 'Growth',
            self::SCALING->value => 'Scaling',
        ];
    }

    public static function values(): array
    {
        return self::cases();
    }
}
