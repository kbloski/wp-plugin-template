<?php 

namespace AstraToolbox\Inc\Utils;

class ColorsHelper 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function hexWithAlphaToRgba(string $hex, float $alpha = 1.0): string
    {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba({$r},{$g},{$b},{$alpha})";
    }
}