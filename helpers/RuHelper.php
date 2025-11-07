<?php

namespace app\helpers;

class RuHelper
{
    /** Склонения постов */
    public static function postsCount(int $count): string
    {
        $forms = ['пост', 'поста', 'постов'];
        return $count . ' ' . self::declension($count, $forms);
    }

    /** Расчет склонения */
    private static function declension(int $number, array $words): string
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $words[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}
