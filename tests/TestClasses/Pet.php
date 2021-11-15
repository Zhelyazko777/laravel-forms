<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes, Timestamp;

    protected $fillable = ['*'];

    protected $table = 'pets';
}