<?php


namespace App\Utils;


class Token {
    public static function generateToken(int $length): string {
        return substr(bin2hex(random_bytes($length)), $length);
    }

}