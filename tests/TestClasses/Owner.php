<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Owner extends Model
{
    public $timestamps = false;

    protected $fillable = ['*'];

    protected $table = 'owners';

    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class);
    }

    public function homes(): BelongsToMany
    {
        return $this->belongsToMany(Home::class);
    }

    public static function selectTextProperty(): string
    {
        return 'name';
    }
}