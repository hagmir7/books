<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskPriorityEnum: int implements HasLabel, HasColor
{
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LOW => __("Low"),
            self::MEDIUM => __("Medium"),
            self::HIGH => __("High"),
        };
    }

    public static function toArray()
    {
        return [
            1 => __("Low"),
            2 => __("Medium"),
            3 => __("High"),
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGH => 'success',
        };
    }
}
