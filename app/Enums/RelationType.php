<?php

namespace App\Enums;

enum RelationType: string {
    case FATHER = 'Ayah';
    case MOTHER = 'Ibu';
    case WALI = 'Wali';

    public static function getValues(): array 
    {
        return array_column(RelationType::cases(), 'value');
    }
}