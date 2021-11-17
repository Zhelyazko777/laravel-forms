<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;

class HomeOwner extends Model
{
    protected $fillable = ['*'];

    protected $table = 'home_owner';
}