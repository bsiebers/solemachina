<?php

class OrderStatus {
    public static $map = [
        1 => ['label' => 'Bezig met bereiden', 'color' => 'oranje'],
        2 => ['label' => 'Onderweg', 'color' => 'lichtblauw'],
        3 => ['label' => 'Geleverd', 'color' => 'groen'],
    ];

    public static function getLabel(int $code): string {
        return self::$map[$code]['label'] ?? 'Onbekend';
    }

    public static function getColor(int $code): string {
        return self::$map[$code]['color'] ?? 'grijs';
    }

    public static function default(): int {
        return 1; 
    }
}
