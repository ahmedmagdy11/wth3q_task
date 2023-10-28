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
    // discount for each type

    public static function discount($type) {
        switch ($type) {
            case self::NORMAL:
                return 0;
            case self::SILVER:
                return 5;
            case self::GOLD:
                return 10;
            default:
                return 0;
        }
    }
}
