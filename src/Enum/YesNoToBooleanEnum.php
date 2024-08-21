<?php

namespace NBorschke\Enum;

enum YesNoToBooleanEnum: string
{
    case YES = 'yes';
    case NO = 'no';

    public static function fromString(string $value): bool
    {
        return match (strtolower($value)) {
            self::YES->value => true,
            default => false
        };
    }
}
