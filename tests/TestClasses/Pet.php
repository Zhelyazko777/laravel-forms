<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zhelyazko777\Forms\Abstractions\SelectableModel;

class Pet extends SelectableModel
{
    use SoftDeletes, HasTimestamps;

    protected $fillable = ['*'];

    protected $table = 'pets';

    public function toy(): HasOne
    {
        return $this->hasOne(Toy::class);
    }

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class)->wherePivotNull('deleted_at');
    }

    public function ownersWithSoftDeleted(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class);
    }

    public static function selectTextProperty(): string
    {
        return 'name';
    }
}