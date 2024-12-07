<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TaskStatusEnum: int implements HasLabel, HasColor, HasIcon
{
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;
    case CANCELED = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __("Pending"),
            self::IN_PROGRESS => __("In Progress"),
            self::COMPLETED => __("Completed"),
            self::CANCELED => __("Canceled"),
        };
    }

    public static function toArray()
    {
        return [
            1 => __("Pending"),
            2 => __("In Progress"),
            3 => __("Completed"),
            4 => __("Canceled"),
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::CANCELED => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-clock',
            self::IN_PROGRESS => 'heroicon-m-wrench',
            self::COMPLETED => 'check-circle',
            self::CANCELED => 'x-circle',
        };
    }
}
