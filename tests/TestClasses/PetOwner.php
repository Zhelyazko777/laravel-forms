<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetOwner extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = ['*'];

    protected $table = 'owner_pet';
}