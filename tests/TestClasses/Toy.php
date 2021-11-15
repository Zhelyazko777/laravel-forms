<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toy extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = ['*'];

    protected $table = 'toys';
}