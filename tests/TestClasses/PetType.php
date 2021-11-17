<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Zhelyazko777\Forms\Abstractions\SelectableModel;

class PetType extends SelectableModel
{
    public $timestamps = false;

    protected $fillable = ['*'];

    protected $table = 'pet_types';

    public static function selectTextProperty(): string
    {
        return 'name';
    }
}