<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class PaymentMethod extends Enum
{
    const CASH = 'CASH';
    const VISA_CARD = 'VISA_CARD';
    public static $types = [self::CASH, self::VISA_CARD];
}
