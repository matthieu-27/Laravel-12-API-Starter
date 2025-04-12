<?php

namespace App\Enums;

enum AvailableScripts: string
{
    case Propneu = '07ZR';
    case Alzura = 'T24';
    case Adtyre = 'ADT';
    case Tyresinstock = 'TIS';
    case Gettygo = 'GTG';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
