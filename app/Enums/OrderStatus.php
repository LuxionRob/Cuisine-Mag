<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class OrderStatus extends Enum
{
    const WAITING = 'WAITING';
    const PACKAGING = 'PACKAGING';
    const PACKAGED = 'PACKAGED';
    const DELIVERING = 'DELIVERING';
    const DELIVERED = 'DELIVERED';
    const CANCELED = 'CANCELED';

    public static $types = [
        self::WAITING,
        self::PACKAGING,
        self::PACKAGED,
        self::DELIVERING,
        self::DELIVERED,
    ];

    public static $available_status = [
        self::WAITING,
        self::PACKAGING,
        self::PACKAGED,
        self::DELIVERING,
        self::DELIVERED,
        self::CANCELED,
    ];
}
