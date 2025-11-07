<?php

namespace app\helpers;

class IpHelper
{
    /**
     * Маскирует IP адрес
     */
    public static function maskIp(string $ip): string
    {
        // IPv4: 208.67.222.222  192.168.0.1
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return self::maskIpv4($ip);
        }
        // IPv6: 2001:0db8:85a3:0000:0000:8a2e:0370:7334  2606:4700:4700::1111
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return self::maskIpv6($ip);
        }
        // Для всех остальных
        return self::mask4LastChars($ip);
    }

    /**
     * Маскирует IPv4 адрес: скрывает 2 последних октета: 255.255.**.**
     */
    private static function maskIpv4(string $ip): string
    {
        $parts = explode('.', $ip);

        if (count($parts) !== 4) {
            return self::mask4LastChars($ip);
        }
        $parts[2] = '**';
        $parts[3] = '**';

        return implode('.', $parts);
    }

    /**
     * Маскирует IPv6 адрес: скрывает 4 последних секции: 2001:0db8:0000:0000:****:****:****:****
     */
    private static function maskIpv6(string $ip): string
    {
        // Нормализуем IPv6 (раскрываем сокращенную запись)
        $fullIp = inet_ntop(inet_pton($ip));
        $parts = explode(':', $fullIp);
        if (count($parts) !== 8) {
            return self::mask4LastChars($ip);
        }

        for ($i = 4; $i < 8; $i++) {
            $parts[$i] = '****';
        }
        return implode(':', $parts);
    }

    /**
     * Заменит последние 4 символа на ****
     */
    private static function mask4LastChars(string $ip): string
    {
        if (strlen($ip) <= 4) {
            return '****';
        }

        $visiblePart = substr($ip, 0, -4);
        return $visiblePart . '****';
    }
}
