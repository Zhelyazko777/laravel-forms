<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Home extends Model
{
    protected $fillable = ['*'];

    protected $table = 'homes';

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class);
    }
}