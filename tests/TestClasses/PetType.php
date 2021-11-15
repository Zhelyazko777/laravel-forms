<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    public $timestamps = false;

    protected $fillable = ['*'];

    protected $table = 'pet_types';
}