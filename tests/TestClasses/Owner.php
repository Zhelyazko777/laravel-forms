<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zhelyazko777\Forms\Abstractions\SelectableModel;

class Owner extends SelectableModel
{
    public $timestamps = false;

    protected $fillable = ['*'];

    protected $table = 'owners';

    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class);
    }

    public static function selectTextProperty(): string
    {
        return 'name';
    }
}