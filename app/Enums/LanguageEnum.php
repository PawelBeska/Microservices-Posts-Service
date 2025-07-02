<?php

namespace App\Enums;

enum LanguageEnum: string
{
    case PL = 'pl';
    case EN = 'en';

    public static function getWithKeys(): array
    {
        return [
            self::EN->value => 'English',
            self::PL->value => 'Polish',
        ];
    }
}
