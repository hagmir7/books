<?php

namespace App\Enums;

enum SubscriberStatus: int implements HasLabel, HasColor
{
    case PENDING = 1;
    case SUBSCRIBED = 2;
    case UNSUBSCRIBED = 3;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __("Pending"),
            self::SUBSCRIBED => __("Subscribed"),
            self::UNSUBSCRIBED => __("Unsubscribed "),
        };
    }

    public static function toArray()
    {
        return [
            1 => __("Pending"),
            2 => __("Subscribed"),
            3 => __("Unsubscribed "),
        ];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'info',
            self::SUBSCRIBED => 'success',
            self::UNSUBSCRIBED => 'warning',
        };
    }
}
