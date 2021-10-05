<?php

namespace Zhelyazko777\Forms\Abstractions;

use Illuminate\Database\Eloquent\Model;

/*
 * @property-read string $text
 * @property-read string $values
 */
abstract class SelectableModel extends Model
{
    abstract public static function selectTextProperty(): string;

    public static function selectValueProperty(): string
    {
        return 'id';
    }
}
