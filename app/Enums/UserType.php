<?php

namespace App\Enums;


final class UserType {
    const NORMAL =   'normal';
    const SILVER =   'silver';
    const GOLD = 'gold';

    public static function all() {
        return [
            self::NORMAL,
            self::SILVER,
            self::GOLD,
        ];
    }
}
