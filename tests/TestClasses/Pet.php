<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zhelyazko777\Forms\Abstractions\SelectableModel;

class Pet extends SelectableModel
{
    use SoftDeletes, Timestamp;

    protected $fillable = ['*'];

    protected $table = 'pets';

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class);
    }

    public static function selectTextProperty(): string
    {
        return 'name';
    }
}